<?php
require MODEL_PATH . 'BaseModel.php';

class SeatModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'theater_seats');
     }

     public function getAllSeatsWithTheater()
     {
          $query = "SELECT ts.*, t.name AS theater_name, t.capacity 
                  FROM theater_seats ts
                  LEFT JOIN theaters t ON ts.theater_id = t.id";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getSeatById($id)
     {
          $query = "SELECT ts.*, t.name AS theater_name, t.capacity 
                  FROM theater_seats ts
                  LEFT JOIN theaters t ON ts.theater_id = t.id
                  WHERE ts.id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public function addSeat($theater_id, $row, $column, $price)
     {
          $query = "INSERT INTO theater_seats (`theater_id`, `row`, `column`, `price`) 
                  VALUES (:theater_id, :row, :column, :price)";
          $stmt = $this->conn->prepare($query);
          return $stmt->execute([
               ':theater_id' => $theater_id,
               ':row' => $row,
               ':column' => $column,
               ':price' => $price
          ]);
     }

     public function updateSeat($id, $theater_id, $row, $column, $price)
     {
          $query = "UPDATE theater_seats SET 
                  `theater_id` = :theater_id, 
                  `row` = :row, 
                  `column` = :column, 
                  `price` = :price
                  WHERE `id` = :id";
          $stmt = $this->conn->prepare($query);
          return $stmt->execute([
               ':id' => $id,
               ':theater_id' => $theater_id,
               ':row' => $row,
               ':column' => $column,
               ':price' => $price
          ]);
     }

     public function getAllTheaters()
     {
          $query = "SELECT * FROM theaters";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function deleteSeat($id)
     {
          $query = "DELETE FROM theater_seats WHERE id = :id";
          $stmt = $this->conn->prepare($query);
          return $stmt->execute([':id' => $id]);
     }

     public function checkDuplicateTheaterInSeats($theater_id)
     {
          $query = "SELECT COUNT(*) FROM theater_seats WHERE theater_id = :theater_id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':theater_id', $theater_id, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetchColumn() > 0;
     }

     public function getTheaterById($theater_id)
     {
          $query = "SELECT * FROM theaters WHERE id = :theater_id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':theater_id', $theater_id, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public function getSeatsByTheater($theater_id)
     {
          $query = "SELECT * FROM theater_seats WHERE theater_id = :theater_id ORDER BY `row`, `column`";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':theater_id', $theater_id, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // public function getTheaterById($theater_id)
     // {
     //      $query = "SELECT * FROM theaters WHERE id = :theater_id";
     //      $stmt = $this->conn->prepare($query);
     //      $stmt->bindParam(':theater_id', $theater_id, PDO::PARAM_INT);
     //      $stmt->execute();
     //      return $stmt->fetch(PDO::FETCH_ASSOC);
     // }

     public function getMaxRowsAndColumns($theater_id)
     {
          $query = "SELECT MAX(`row`) as max_row, 7 as max_column FROM theater_rows WHERE theater_id = :theater_id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':theater_id', $theater_id, PDO::PARAM_INT);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          if (!$result['max_row']) {
               return ['max_row' => 10, 'max_column' => 7]; // Giá trị mặc định: 10 hàng, 7 cột
          }

          return $result;
     }

     public function getRowType($theater_id, $row)
     {
          $query = "SELECT type_seat FROM theater_rows WHERE theater_id = :theater_id AND `row` = :row";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':theater_id', $theater_id, PDO::PARAM_INT);
          $stmt->bindParam(':row', $row, PDO::PARAM_INT);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          return $result ? $result['type_seat'] : 'normal';
     }

     public function addSeatType($theater_id, $row, $column, $type_seat, $status = 'available', $price = 50000)
     {
          try {
               $query = "INSERT INTO theater_seats (theater_id, `row`, `column`, type_seat, status, price) 
                      VALUES (:theater_id, :row, :column, :type_seat, :status, :price)";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([
                    ':theater_id' => (int) $theater_id,
                    ':row' => (int) $row,
                    ':column' => (int) $column,
                    ':type_seat' => $type_seat,
                    ':status' => $status,
                    ':price' => (int) $price
               ]);
               return $this->conn->lastInsertId();
          } catch (PDOException $e) {
               error_log("Lỗi cơ sở dữ liệu: " . $e->getMessage());
               return false;
          }
     }

     public function updateSeatType($id, $type_seat)
     {
          try {
               $query = "UPDATE theater_seats SET type_seat = :type_seat WHERE id = :id";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([
                    ':id' => (int) $id,
                    ':type_seat' => $type_seat
               ]);
               return $stmt->rowCount() > 0;
          } catch (PDOException $e) {
               error_log("Lỗi cơ sở dữ liệu: " . $e->getMessage());
               return false;
          }
     }

     public function updateSeatStatus($id, $status)
     {
          try {
               $query = "UPDATE theater_seats SET status = :status WHERE id = :id";
               $stmt = $this->conn->prepare($query);
               $stmt->execute([
                    ':id' => (int) $id,
                    ':status' => $status
               ]);
               return $stmt->rowCount() > 0;
          } catch (PDOException $e) {
               error_log("Lỗi cơ sở dữ liệu: " . $e->getMessage());
               return false;
          }
     }
}
?>