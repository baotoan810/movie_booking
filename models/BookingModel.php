<?php
require_once MODEL_PATH . 'BaseModel.php';

class BookingModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'bookings');
     }

     public function getAllBookings()
     {
          $query = "SELECT b.id, b.user_id, b.showtime_id, b.booking_time, b.total_price, b.status, 
                              u.username, 
                              s.movie_title, s.start_time, s.room_name, s.theater_name
                    FROM bookings b
                    JOIN users u ON b.user_id = u.id
                    JOIN (
                         SELECT s.id, m.title AS movie_title, s.start_time, r.name AS room_name, t.name AS theater_name
                         FROM showtimes s
                         JOIN movies m ON s.movie_id = m.id
                         JOIN rooms r ON s.room_id = r.id
                         JOIN theaters t ON s.theater_id = t.id
                    ) s ON b.showtime_id = s.id
                    ORDER BY b.booking_time DESC";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getBookingDetails($booking_id)
     {
          $query = "SELECT b.id, b.user_id, b.showtime_id, b.booking_time, b.total_price, b.status, 
                              u.username, s.movie_title, s.start_time, s.room_name
                    FROM bookings b
                    JOIN users u ON b.user_id = u.id
                    JOIN (
                         SELECT s.id, m.title AS movie_title, s.start_time, r.name AS room_name
                         FROM showtimes s
                         JOIN movies m ON s.movie_id = m.id
                         JOIN rooms r ON s.room_id = r.id
                    ) s ON b.showtime_id = s.id
                    WHERE b.id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$booking_id]);
          $booking = $stmt->fetch(PDO::FETCH_ASSOC);

          if (!$booking) {
               return null;
          }

          $query = "SELECT bs.theater_seat_id, bs.price, bs.status, ts.row, ts.column, ts.type_seat
                    FROM booking_seats bs
                    JOIN theater_seats ts ON bs.theater_seat_id = ts.id
                    WHERE bs.booking_id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$booking_id]);
          $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $booking['seats'] = $seats;
          return $booking;
     }

     public function cancelBooking($booking_id)
     {
          $this->conn->beginTransaction();

          try {
               $query = "SELECT showtime_id FROM bookings WHERE id = ?";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([$booking_id]);
               $booking = $stmt->fetch(PDO::FETCH_ASSOC);
               if (!$booking) {
                    throw new Exception("Đặt vé không tồn tại!");
               }
               $showtime_id = $booking['showtime_id'];

               $query = "SELECT theater_seat_id FROM booking_seats WHERE booking_id = ?";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([$booking_id]);
               $seat_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

               if (empty($seat_ids)) {
                    throw new Exception("Không tìm thấy ghế nào trong đặt vé này!");
               }

               $placeholders = implode(',', array_fill(0, count($seat_ids), '?'));
               $query = "UPDATE showtime_seats SET status = 'available' WHERE showtime_id = ? AND theater_seat_id IN ($placeholders)";
               $stmt = $this->conn->prepare($query);
               $stmt->execute(array_merge([$showtime_id], $seat_ids));

               $query = "SELECT COUNT(*) FROM showtime_seats WHERE showtime_id = ? AND status = 'available'";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([$showtime_id]);
               $available_seats = $stmt->fetchColumn();

               $query = "UPDATE showtimes SET available_seats = ? WHERE id = ?";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([$available_seats, $showtime_id]);

               $query = "UPDATE booking_seats SET status = 'cancelled', archived = 1 WHERE booking_id = ?";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([$booking_id]);

               $query = "UPDATE bookings SET status = 'cancelled' WHERE id = ?";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([$booking_id]);

               $this->conn->commit();
               return true;
          } catch (Exception $e) {
               $this->conn->rollBack();
               throw $e;
          }
     }

     public function cancelBookingBySeat($showtime_id, $theater_seat_id)
     {
          $this->conn->beginTransaction();

          try {
               $query = "SELECT bs.booking_id 
                         FROM booking_seats bs 
                         JOIN bookings b ON bs.booking_id = b.id 
                         WHERE b.showtime_id = ? AND bs.theater_seat_id = ? AND bs.status != 'cancelled'";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([$showtime_id, $theater_seat_id]);
               $booking_id = $stmt->fetchColumn();

               if (!$booking_id) {
                    throw new Exception("Không tìm thấy đặt vé cho ghế này!");
               }

               $this->cancelBooking($booking_id);
               $this->conn->commit();
               return true;
          } catch (Exception $e) {
               $this->conn->rollBack();
               throw $e;
          }
     }
}
?>