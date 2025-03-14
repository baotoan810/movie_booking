<?php
class ShowtimeModel
{
     private $conn;

     public function __construct($db)
     {
          $this->conn = $db;
     }

     public function getAllShowtimes()
     {
          $query = "SELECT s.id, s.show_time, s.price, s.available_seats, 
                          m.title AS movie_name, 
                          t.name AS theater_name 
                   FROM showtimes s
                   JOIN movies m ON s.movie_id = m.id
                   JOIN theaters t ON s.theater_id = t.id";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }


     public function getShowtimeById($id)
     {
          $query = "SELECT * FROM showtimes WHERE id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }


     // Thêm suất chiếu mới với số ghế = sức chứa của rạp
     public function addShowtime($movie_id, $theater_id, $show_time, $price)
     {
          $capacity = $this->getTheaterCapacity($theater_id); // Lấy số ghế từ bảng theaters

          $query = "INSERT INTO showtimes (movie_id, theater_id, show_time, price, available_seats) 
               VALUES (:movie_id, :theater_id, :show_time, :price, :available_seats)";
          $stmt = $this->conn->prepare($query);

          $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
          $stmt->bindParam(':theater_id', $theater_id, PDO::PARAM_INT);
          $stmt->bindParam(':show_time', $show_time);
          $stmt->bindParam(':price', $price);
          $stmt->bindParam(':available_seats', $capacity, PDO::PARAM_INT); // Gán số ghế theo capacity

          return $stmt->execute();
     }

     // Cập nhật suất chiếu, đảm bảo số ghế = sức chứa rạp
     public function updateShowtime($id, $movie_id, $theater_id, $show_time, $price)
     {
          $capacity = $this->getTheaterCapacity($theater_id); // Cập nhật theo số ghế mới của rạp

          $query = "UPDATE showtimes 
               SET movie_id = :movie_id, theater_id = :theater_id, show_time = :show_time, 
                   price = :price, available_seats = :available_seats
               WHERE id = :id";
          $stmt = $this->conn->prepare($query);

          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
          $stmt->bindParam(':theater_id', $theater_id, PDO::PARAM_INT);
          $stmt->bindParam(':show_time', $show_time);
          $stmt->bindParam(':price', $price);
          $stmt->bindParam(':available_seats', $capacity, PDO::PARAM_INT); // Gán số ghế theo capacity

          return $stmt->execute();
     }
     public function deleteShowtime($id)
     {
          $query = "DELETE FROM showtimes WHERE id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          return $stmt->execute();
     }

     // Thêm phương thức lấy danh sách phim
     public function getAllMovies()
     {
          $query = "SELECT id, title FROM movies";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Thêm phương thức lấy danh sách rạp
     public function getAllTheaters()
     {
          $query = "SELECT id, name FROM theaters";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
     // Thêm số lượng ghế
     public function getTheaterCapacity($theater_id)
     {
          $query = "SELECT capacity FROM theaters WHERE id = :theater_id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':theater_id', $theater_id, PDO::PARAM_INT);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result ? $result['capacity'] : 0;
     }

}
?>