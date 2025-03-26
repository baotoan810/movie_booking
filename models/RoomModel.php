<?php
require_once MODEL_PATH . 'BaseModel.php';

class RoomModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'rooms');
     }

     // Lấy tất cả phòng với thông tin rạp
     public function getAllRoomsWithTheater()
     {
          $query = "SELECT rooms.*, theaters.name AS theater_name 
                    FROM rooms 
                    JOIN theaters ON rooms.theater_id = theaters.id";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Lấy phòng theo ID
     public function getRoomById($id)
     {
          $query = "SELECT rooms.*, theaters.name AS theater_name 
                    FROM rooms 
                    JOIN theaters ON rooms.theater_id = theaters.id 
                    WHERE rooms.id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     // Tính tổng capacity của các phòng trong rạp
     public function getTotalRoomCapacity($theater_id)
     {
          $query = "SELECT SUM(capacity) AS total 
                    FROM rooms 
                    WHERE theater_id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$theater_id]);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result['total'] ?? 0;
     }

     // Lấy capacity của rạp
     public function getTheaterCapacity($theater_id)
     {
          $query = "SELECT capacity FROM theaters WHERE id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$theater_id]);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result['capacity'] ?? 0;
     }

     // Thêm phòng mới
     public function addRoom($theater_id, $name, $capacity, $rows, $columns)
     {
          $expected_capacity = $rows * $columns;
          if ($capacity != $expected_capacity) {
               throw new Exception("Sức chứa ($capacity) không khớp với số hàng × số cột ($rows × $columns = $expected_capacity)!");
          }

          $current_total = $this->getTotalRoomCapacity($theater_id);
          $theater_capacity = $this->getTheaterCapacity($theater_id);

          if (($current_total + $capacity) > $theater_capacity) {
               throw new Exception("Tổng số ghế của các phòng vượt quá sức chứa của rạp ($current_total + $capacity > $theater_capacity)!");
          }

          $data = [
               'theater_id' => $theater_id,
               'name' => $name,
               'capacity' => $capacity,
               'rows' => $rows,
               'columns' => $columns
          ];
          $result = $this->add($data);
          if ($result) {
               $room_id = $this->conn->lastInsertId();
               $this->initializeSeats($room_id, $rows, $columns);
               return $room_id;
          }
          return false;
     }

     // Cập nhật phòng
     public function updateRoom($id, $theater_id, $name, $capacity, $rows, $columns)
     {
          $expected_capacity = $rows * $columns;
          if ($capacity != $expected_capacity) {
               throw new Exception("Sức chứa ($capacity) không khớp với số hàng × số cột ($rows × $columns = $expected_capacity)!");
          }

          $query = "SELECT SUM(capacity) AS total 
                    FROM rooms 
                    WHERE theater_id = ? AND id != ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$theater_id, $id]);
          $current_total = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

          $theater_capacity = $this->getTheaterCapacity($theater_id);

          if (($current_total + $capacity) > $theater_capacity) {
               throw new Exception("Tổng số ghế của các phòng vượt quá sức chứa của rạp ($current_total + $capacity > $theater_capacity)!");
          }

          $data = [
               'theater_id' => $theater_id,
               'name' => $name,
               'capacity' => $capacity,
               'rows' => $rows,
               'columns' => $columns
          ];
          return $this->update($id, $data);
     }

     // Xóa phòng
     public function deleteRoom($id)
     {
          return $this->delete($id);
     }

     // Tìm kiếm phòng theo tên
     public function searchRoom($keyword)
     {
          $query = "SELECT rooms.*, theaters.name AS theater_name 
                    FROM rooms 
                    JOIN theaters ON rooms.theater_id = theaters.id 
                    WHERE rooms.name LIKE :keyword";
          $stmt = $this->conn->prepare($query);
          $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Lấy tất cả rạp để hiển thị trong form
     public function getTheaters()
     {
          $query = "SELECT id, name FROM theaters";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Lấy sơ đồ ghế của một phòng
     public function getSeatsByRoom($room_id)
     {
          $query = "SELECT * FROM theater_seats WHERE room_id = ? ORDER BY `row`, `column`";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$room_id]);
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Tự động thêm ghế khi tạo phòng mới
     public function initializeSeats($room_id, $rows, $columns)
     {
          $query = "DELETE FROM theater_seats WHERE room_id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$room_id]);

          for ($r = 1; $r <= $rows; $r++) {
               for ($c = 1; $c <= $columns; $c++) {
                    $data = [
                         'room_id' => $room_id,
                         'row' => $r,
                         'column' => $c,
                         'type_seat' => 'normal',
                         'status' => 'available',
                         'price' => 50000
                    ];
                    $query = "INSERT INTO theater_seats (room_id, `row`, `column`, type_seat, status, price) 
                              VALUES (:room_id, :row, :column, :type_seat, :status, :price)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute($data);
               }
          }
     }

     // Cập nhật thông tin ghế
     public function updateSeat($seat_id, $type_seat, $status, $price)
     {
          $query = "UPDATE theater_seats 
                    SET type_seat = :type_seat, status = :status, price = :price 
                    WHERE id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([
               ':type_seat' => $type_seat,
               ':status' => $status,
               ':price' => $price,
               ':id' => $seat_id
          ]);
          return $stmt->rowCount() > 0;
     }

     // Xóa ghế
     public function deleteSeat($seat_id)
     {
          $query = "DELETE FROM theater_seats WHERE id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$seat_id]);
          return $stmt->rowCount() > 0;
     }

     // Thêm ghế mới
     public function addSeat($room_id, $row, $column, $type_seat, $status, $price)
     {
          // Kiểm tra xem ghế đã tồn tại tại vị trí này chưa
          $query = "SELECT COUNT(*) FROM theater_seats WHERE room_id = ? AND `row` = ? AND `column` = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$room_id, $row, $column]);
          if ($stmt->fetchColumn() > 0) {
               throw new Exception("Ghế tại vị trí R{$row}C{$column} đã tồn tại!");
          }

          $data = [
               'room_id' => $room_id,
               'row' => $row,
               'column' => $column,
               'type_seat' => $type_seat,
               'status' => $status,
               'price' => $price
          ];
          $query = "INSERT INTO theater_seats (room_id, `row`, `column`, type_seat, status, price) 
                    VALUES (:room_id, :row, :column, :type_seat, :status, :price)";
          $stmt = $this->conn->prepare($query);
          $stmt->execute($data);
          return $stmt->rowCount() > 0;
     }
}
?>