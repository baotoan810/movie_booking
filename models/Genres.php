<?php
class GenresModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllGenres()
    {
        $query = "SELECT * FROM genres";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGenresById($id)
    {
        $query = "SELECT * FROM genres WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addGenres($name)
    {
        $query = "INSERT INTO genres (name) 
                VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }


    public function updateGenres($id, $name)
    {
        $query = "UPDATE genres 
                SET name = :name
                WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteGenres($id)
    {
        $query = "DELETE FROM genres WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        if (!$result) {
            error_log('Lỗi xóa genres: ' . $id . ' - ' . print_r($stmt->errorInfo(), true));
        }
        return $result;
    }
}
?>