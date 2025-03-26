<?php
require_once MODEL_PATH . 'BaseModel.php';

class ShowtimeModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'showtimes');
     }

     // Lấy tất cả suất chiếu với thông tin phim và phòng
     public function getAllShowtimes()
     {
          $query = "SELECT showtimes.*, movies.title AS movie_title, rooms.name AS room_name, theaters.name AS theater_name
                                   FROM showtimes
                                   JOIN movies ON showtimes.movie_id = movies.id
                                   JOIN rooms ON showtimes.room_id = rooms.id
                                   JOIN theaters ON rooms.theater_id = theaters.id
                                   ORDER BY showtimes.start_time DESC";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Lấy suất chiếu theo ID
     public function getShowtimeById($id)
     {
          $query = "SELECT showtimes.*, movies.title AS movie_title, rooms.name AS room_name
                                   FROM showtimes
                                   JOIN movies ON showtimes.movie_id = movies.id
                                   JOIN rooms ON showtimes.room_id = rooms.id
                                   WHERE showtimes.id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     // Thêm suất chiếu mới
     public function addShowtime($movie_id, $room_id, $start_time, $end_time, $price)
     {
          $data = [
               'movie_id' => $movie_id,
               'room_id' => $room_id,
               'start_time' => $start_time,
               'end_time' => $end_time,
               'price' => $price
          ];

          $this->conn->beginTransaction();
          try {
               $showtime_id = $this->add($data);
               $this->initializeShowtimeSeats($showtime_id, $room_id);

               // Cập nhật available_seats
               $query = "SELECT COUNT(*) FROM theater_seats WHERE room_id = ?";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([$room_id]);
               $available_seats = $stmt->fetchColumn();

               $query = "UPDATE showtimes SET available_seats = ? WHERE id = ?";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([$available_seats, $showtime_id]);

               $this->conn->commit();
               return $showtime_id;
          } catch (Exception $e) {
               $this->conn->rollBack();
               throw $e;
          }
     }


     // Cập nhật suất chiếu
     public function updateShowtime($id, $movie_id, $room_id, $start_time, $end_time, $price)
     {
          // Kiểm tra trùng lịch chiếu (trừ suất chiếu hiện tại)
          $query = "SELECT COUNT(*) FROM showtimes 
                    WHERE room_id = :room_id 
                    AND id != :id
                    AND (
                         (start_time <= :start_time AND end_time >= :start_time) OR 
                         (start_time <= :end_time AND end_time >= :end_time) OR 
                         (start_time >= :start_time AND end_time <= :end_time)
                    )";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':room_id', $room_id);
          $stmt->bindParam(':id', $id);
          $stmt->bindParam(':start_time', $start_time);
          $stmt->bindParam(':end_time', $end_time);
          $stmt->execute();
          if ($stmt->fetchColumn() > 0) {
               throw new Exception("Phòng đã có suất chiếu trong khoảng thời gian này!");
          }

          // Lấy theater_id từ bảng rooms
          $query = "SELECT theater_id, capacity FROM rooms WHERE id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$room_id]);
          $room = $stmt->fetch(PDO::FETCH_ASSOC);
          if (!$room) {
               throw new Exception("Phòng không tồn tại!");
          }
          $theater_id = $room['theater_id'];

          // Lấy available_seats hiện tại
          $currentShowtime = $this->getShowtimeById($id);
          $available_seats = $currentShowtime['available_seats'];

          $data = [
               'movie_id' => $movie_id,
               'theater_id' => $theater_id,
               'room_id' => $room_id,
               'start_time' => $start_time,
               'end_time' => $end_time,
               'price' => $price, // Thêm price vào mảng $data
               'available_seats' => $available_seats
          ];
          return $this->update($id, $data);
     }

     // Xóa suất chiếu
     public function deleteShowtime($id)
     {
          return $this->delete($id);
     }

     // Tìm kiếm suất chiếu theo phim hoặc phòng
     public function searchShowtime($keyword)
     {
          $query = "SELECT showtimes.*, movies.title AS movie_title, rooms.name AS room_name, theaters.name AS theater_name
                                   FROM showtimes
                                   JOIN movies ON showtimes.movie_id = movies.id
                                   JOIN rooms ON showtimes.room_id = rooms.id
                                   JOIN theaters ON rooms.theater_id = theaters.id
                                   WHERE movies.title LIKE :keyword OR rooms.name LIKE :keyword";
          $stmt = $this->conn->prepare($query);
          $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Lấy danh sách phim để hiển thị trong form
     public function getMovies()
     {
          $query = "SELECT id, title FROM movies";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Lấy danh sách phòng để hiển thị trong form
     public function getRooms()
     {
          $query = "SELECT rooms.id, rooms.name, theaters.name AS theater_name 
                                   FROM rooms 
                                   JOIN theaters ON rooms.theater_id = theaters.id";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Khởi tạo trạng thái ghế cho suất chiếu
     private function initializeShowtimeSeats($showtime_id, $room_id)
     {
          $query = "SELECT id FROM theater_seats WHERE room_id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$room_id]);
          $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (empty($seats)) {
               throw new Exception("Phòng không có ghế nào để khởi tạo suất chiếu!");
          }

          foreach ($seats as $seat) {
               $query = "INSERT INTO showtime_seats (showtime_id, theater_seat_id, status) 
                      VALUES (:showtime_id, :theater_seat_id, 'available')";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([
                    ':showtime_id' => $showtime_id,
                    ':theater_seat_id' => $seat['id']
               ]);
          }
     }
     public function getRoomById($id)
     {
          $query = "SELECT * FROM rooms WHERE id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public function getSeatsByRoom($room_id)
     {
          $query = "SELECT * FROM theater_seats WHERE room_id = :room_id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':room_id', $room_id);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
}
?>