<?php
require_once 'BaseModel.php';

class BookingModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'bookings');
     }

     // Lấy danh sách rạp, phòng và suất chiếu theo movie_id và ngày
     public function getTheatersRoomsAndShowtimesByMovie($movieId, $date = null)
     {
          $date = $date ?? date('Y-m-d');

          $query = "
               SELECT 
                    t.id AS theater_id,
                    t.name AS theater_name,
                    t.address AS theater_address,
                    r.id AS room_id,
                    r.name AS room_name,
                    r.capacity AS room_capacity,
                    s.id AS showtime_id,
                    s.start_time,
                    s.end_time,
                    s.price,
                    s.available_seats
               FROM theaters t
               LEFT JOIN rooms r ON t.id = r.theater_id
               LEFT JOIN showtimes s ON r.id = s.room_id
               WHERE s.movie_id = :movie_id
               AND DATE(s.start_time) = :date
               AND s.available_seats > 0
               ORDER BY t.name, r.name, s.start_time
          ";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
          $stmt->bindParam(':date', $date);
          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Tổ chức dữ liệu: rạp -> phòng -> suất chiếu
          $theaters = [];
          foreach ($results as $row) {
               $theaterId = $row['theater_id'];
               $roomId = $row['room_id'];

               if (!isset($theaters[$theaterId])) {
                    $theaters[$theaterId] = [
                         'id' => $theaterId,
                         'name' => $row['theater_name'],
                         'address' => $row['theater_address'],
                         'rooms' => []
                    ];
               }

               if ($row['room_id'] && !isset($theaters[$theaterId]['rooms'][$roomId])) {
                    $theaters[$theaterId]['rooms'][$roomId] = [
                         'id' => $roomId,
                         'name' => $row['room_name'],
                         'capacity' => $row['room_capacity'],
                         'showtimes' => []
                    ];
               }

               if ($row['showtime_id']) {
                    $theaters[$theaterId]['rooms'][$roomId]['showtimes'][] = [
                         'id' => $row['showtime_id'],
                         'start_time' => $row['start_time'],
                         'end_time' => $row['end_time'],
                         'price' => $row['price'],
                         'available_seats' => $row['available_seats']
                    ];
               }
          }

          // Chỉ giữ lại các rạp có phòng và suất chiếu
          $theaters = array_filter($theaters, function ($theater) {
               $theater['rooms'] = array_filter($theater['rooms'], function ($room) {
                    return !empty($room['showtimes']);
               });
               return !empty($theater['rooms']);
          });

          return array_values($theaters);
     }

     // Các phương thức khác giữ nguyên
     public function getSeatsByShowtime($showtimeId)
     {
          $query = "
               SELECT ts.*, sts.status as status
               FROM showtime_seats sts
               INNER JOIN theater_seats ts ON sts.theater_seat_id = ts.id
               WHERE sts.showtime_id = :showtime_id
               ORDER BY ts.row, ts.column
          ";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':showtime_id', $showtimeId, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function createBooking($userId, $showtimeId, $selectedSeats, $totalPrice, $promotionId = null)
     {
          try {
               $this->conn->beginTransaction();

               // Kiểm tra total_price
               if ($totalPrice <= 0) {
                    // Tính lại total_price
                    $query = "
                     SELECT s.price AS base_price, ts.id AS seat_id, ts.type_seat 
                     FROM showtimes s 
                     LEFT JOIN theater_seats ts ON ts.id IN (" . implode(',', array_fill(0, count($selectedSeats), '?')) . ")
                     WHERE s.id = ?
                 ";
                    $stmt = $this->conn->prepare($query);
                    $params = array_merge($selectedSeats, [$showtimeId]);
                    $stmt->execute($params);
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $totalPrice = 0;
                    $basePrice = $results[0]['base_price'] ?? 0;
                    foreach ($results as $result) {
                         $priceMultiplier = ($result['type_seat'] === 'vip') ? 1.5 : 1;
                         $totalPrice += $basePrice * $priceMultiplier;
                    }

                    if ($totalPrice <= 0) {
                         throw new Exception("Giá vé không hợp lệ! Total price: $totalPrice, Base price: $basePrice");
                    }
               }

               $bookingData = [
                    'user_id' => $userId,
                    'showtime_id' => $showtimeId,
                    'total_price' => $totalPrice,
                    'promotion_id' => $promotionId,
                    'status' => 'pending'
               ];
               if (!$this->add($bookingData)) {
                    throw new Exception("Không thể tạo booking");
               }
               $bookingId = $this->conn->lastInsertId();

               foreach ($selectedSeats as $seatId) {
                    // Lấy giá từ showtimes và tính lại dựa trên type_seat
                    $seatQuery = "
                     SELECT ts.type_seat, s.price AS base_price 
                     FROM theater_seats ts 
                     CROSS JOIN showtimes s 
                     WHERE ts.id = :seat_id AND s.id = :showtime_id
                 ";
                    $stmt = $this->conn->prepare($seatQuery);
                    $stmt->bindParam(':seat_id', $seatId, PDO::PARAM_INT);
                    $stmt->bindParam(':showtime_id', $showtimeId, PDO::PARAM_INT);
                    $stmt->execute();
                    $seat = $stmt->fetch(PDO::FETCH_ASSOC);

                    $seatPrice = $seat['base_price'] * ($seat['type_seat'] === 'vip' ? 1.5 : 1);

                    $bookingSeatData = [
                         'booking_id' => $bookingId,
                         'theater_seat_id' => $seatId,
                         'price' => $seatPrice,
                         'status' => 'pending'
                    ];
                    $seatStmt = $this->conn->prepare("
                     INSERT INTO booking_seats (booking_id, theater_seat_id, price, status)
                     VALUES (:booking_id, :theater_seat_id, :price, :status)
                 ");
                    $seatStmt->execute($bookingSeatData);

                    $updateSeatQuery = "
                     UPDATE showtime_seats 
                     SET status = 'booked'
                     WHERE showtime_id = :showtime_id AND theater_seat_id = :seat_id
                 ";
                    $updateStmt = $this->conn->prepare($updateSeatQuery);
                    $updateStmt->execute([
                         ':showtime_id' => $showtimeId,
                         ':seat_id' => $seatId
                    ]);
               }

               $seatCount = count($selectedSeats);
               $updateShowtimeQuery = "
                 UPDATE showtimes 
                 SET available_seats = available_seats - :seat_count
                 WHERE id = :showtime_id
                 AND available_seats >= :seat_count
             ";
               $updateShowtimeStmt = $this->conn->prepare($updateShowtimeQuery);
               $updateShowtimeStmt->execute([
                    ':seat_count' => $seatCount,
                    ':showtime_id' => $showtimeId
               ]);

               if ($updateShowtimeStmt->rowCount() == 0) {
                    throw new Exception("Không đủ ghế trống để đặt");
               }

               $this->conn->commit();
               return $bookingId;
          } catch (Exception $e) {
               $this->conn->rollBack();
               error_log("Lỗi tạo booking: " . $e->getMessage());
               return false;
          }
     }

     public function confirmBooking($bookingId)
     {
          $data = ['status' => 'confirmed'];
          return $this->update($bookingId, $data);
     }
}