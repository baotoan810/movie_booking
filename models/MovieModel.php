<?php
class MovieModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getALLMovie()
    {
        $query = "SELECT * FROM movies";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMovieById($id)
    {
        $query = "SELECT * FROM movies WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addMovie($title, $description, $duration, $release_date, $trailer_path, $view, $created_at)
    {
        $query = "INSERT INTO movies (title, description, duration, release_date, trailer_path, view, created_at)
              VALUES (:title, :description, :duration, :release_date, :trailer_path, :view, :created_at)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':release_date', $release_date);
        $stmt->bindParam(':trailer_path', $trailer_path);
        $stmt->bindParam(':view', $view);
        $stmt->bindParam(':created_at', $created_at);
        return $stmt->execute();

    }
    public function updateMovie($id, $title, $description, $duration, $release_date, $trailer_path, $view, $created_at)
    {
        $query = "UPDATE movies SET title = :title, description = :description, duration = :duration, 
                release_date = :release_date, trailer_path = :trailer_path, view = :view, created_at = :created_at";

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':release_date', $release_date);
        $stmt->bindParam(':trailer_path', $trailer_path);
        $stmt->bindParam(':view', $view);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteMovie($id)
    {
        $query = "DELETE FROM movies WHERE id = :id";
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