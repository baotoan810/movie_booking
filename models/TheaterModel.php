<?php
class TheaterModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllTheater()
    {
        $query = "SELECT * FROM theaters";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTheaterById($id)
    {
        $query = "SELECT * FROM theaters WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTheater($name, $address, $capacity)
    {
        $query = "INSERT INTO theaters (name, address, capacity) 
                VALUES (:name, :address, :capacity)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':capacity', $capacity);
        return $stmt->execute();
    }

    // public function updateTheater($id, $name, $address, $capacity)
    // {
    //     $query = "UPDATE theaters SET name = :name, address = :address, capacity = :capacity,";

    //     $query .= " WHERE id = :id";

    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':name', $name);
    //     $stmt->bindParam(':address', $address);
    //     $stmt->bindParam(':capacity', $capacity);
    //     $stmt->bindParam(':id', $id);
    //     return $stmt->execute();
    // }
    public function updateTheater($id, $name, $address, $capacity)
    {
        $query = "UPDATE theaters 
                  SET name = :name, address = :address, capacity = :capacity 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':capacity', $capacity, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteTheater($id)
    {
        $query = "DELETE FROM theaters WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        if (!$result) {
            error_log('Lỗi xóa user ID: ' . $id . ' - ' . print_r($stmt->errorInfo(), true));
        }
        return $result;
    }
}
?>