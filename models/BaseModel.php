<?php
class BaseModel
{
     protected $conn;
     protected $table;

     public function __construct($db, $table)
     {
          $this->conn = $db;
          $this->table = $table;
     }

     // Lấy tất cả dữ liệu
     public function getAll()
     {
          $query = "SELECT * FROM " . $this->table;
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Lấy dữ liệu theo ID
     public function getById($id)
     {
          $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     // Thêm dữ liệu
     public function add($data)
     {
          $fields = implode(", ", array_keys($data));
          $values = ":" . implode(", :", array_keys($data));

          $query = "INSERT INTO " . $this->table . " ($fields) VALUES ($values)";
          $stmt = $this->conn->prepare($query);

          foreach ($data as $key => $value) {
               $stmt->bindValue(":$key", $value);
          }

          return $stmt->execute();
     }
     // Update dữ liệu
     public function update($id, $data)
     {
          $setClause = "";
          foreach ($data as $key => $value) {
               $setClause .= "$key = :$key, ";
          }
          $setClause = rtrim($setClause, ", ");

          $query = "UPDATE " . $this->table . " SET $setClause WHERE id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);

          foreach ($data as $key => $value) {
               $stmt->bindValue(":$key", $value);
          }

          return $stmt->execute();
     }


     // Xóa dữ liệu
     public function delete($id)
     {
          $query = "DELETE FROM " . $this->table . " WHERE id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $result = $stmt->execute();

          if (!$result) {
               error_log('Lỗi xóa ID: ' . $id . ' - ' . print_r($stmt->errorInfo(), true));
          }

          return $result;
     }

     // Tìm kiếm dữ liêu
     public function search($column, $keyword)
     {
          $query = "SELECT * FROM " . $this->table . " WHERE $column LIKE :keyword";
          $stmt = $this->conn->prepare($query);
          $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
}
?>