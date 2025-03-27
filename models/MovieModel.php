<?php
require_once MODEL_PATH . 'BaseModel.php';

class MovieModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'movies');
     }

     public function getAllMoviesWithGenres()
     {
          $query = "SELECT movies.*, GROUP_CONCAT(genres.name SEPARATOR ', ') AS genres 
                              FROM movies 
                              LEFT JOIN movie_genres ON movies.id = movie_genres.movie_id 
                              LEFT JOIN genres ON movie_genres.genre_id = genres.id 
                              GROUP BY movies.id";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getMovieById($id)
     {
          $query = "SELECT movies.*, 
                                   GROUP_CONCAT(genres.name SEPARATOR ', ') AS genres
                                   FROM movies
                                   LEFT JOIN movie_genres ON movies.id = movie_genres.movie_id
                                   LEFT JOIN genres ON movie_genres.genre_id = genres.id
                                   WHERE movies.id = :id
                                   GROUP BY movies.id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $id);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public function addMovie($title, $description, $duration, $director, $release_date, $trailer_path, $poster_path, $view)
     {
          $data = [
               'title' => $title,
               'description' => $description,
               'duration' => $duration,
               'director' => $director,
               'release_date' => $release_date,
               'trailer_path' => $trailer_path,
               'poster_path' => $poster_path,
               'view' => $view
          ];
          $result = $this->add($data);
          if ($result) {
               return $this->conn->lastInsertId(); // Trả về ID của phim vừa thêm
          }
          return false;
     }

     public function updateMovie($id, $title, $description, $duration, $director, $release_date, $trailer_path, $poster_path, $view)
     {
          $currentMovie = $this->getById($id);
          if (empty($trailer_path)) {
               $trailer_path = $currentMovie['trailer_path'];
          }
          if (empty($poster_path)) {
               $poster_path = $currentMovie['poster_path'];
          }
          $data = [
               'title' => $title,
               'description' => $description,
               'duration' => $duration,
               'director' => $director,
               'release_date' => $release_date,
               'trailer_path' => $trailer_path,
               'poster_path' => $poster_path,
               'view' => $view
          ];
          return $this->update($id, $data);
     }

     public function deleteMovie($id)
     {
          return $this->delete($id);
     }

     // Thể loại phim
     public function getGenres()
     {
          $query = "SELECT * FROM genres";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getGenresId($movie_id)
     {
          $query = "SELECT genre_id FROM movie_genres WHERE movie_id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$movie_id]);
          return $stmt->fetchAll(PDO::FETCH_COLUMN);
     }

     public function saveGenres($movie_id, $genres)
     {
          if (!$movie_id)
               return false;

          // Xóa các thể loại cũ của phim
          $query = "DELETE FROM movie_genres WHERE movie_id = ?";
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$movie_id]);

          // Thêm các thể loại mới
          if (!empty($genres)) {
               $query = "INSERT INTO movie_genres (movie_id, genre_id) VALUES (?, ?)";
               $stmt = $this->conn->prepare($query);
               foreach ($genres as $genre_id) {
                    $stmt->execute([$movie_id, $genre_id]);
               }
          }
          return true;
     }

     public function searchMovie($keyword)
     {
          $query = "SELECT movies.*, 
                              GROUP_CONCAT(genres.name SEPARATOR ', ') AS genres 
                              FROM movies 
                              LEFT JOIN movie_genres ON movies.id = movie_genres.movie_id 
                              LEFT JOIN genres ON movie_genres.genre_id = genres.id 
                              WHERE movies.title LIKE :keyword
                              GROUP BY movies.id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }


     // note:  User-----------------------------
     // Phương thức mới: Lấy 4 phim có lượt xem cao nhất
     public function getTopMoviesByViews($limit = 4)
     {
          $query = "SELECT movies.*, 
                              GROUP_CONCAT(genres.name SEPARATOR ', ') AS genres 
                              FROM movies 
                              LEFT JOIN movie_genres ON movies.id = movie_genres.movie_id 
                              LEFT JOIN genres ON movie_genres.genre_id = genres.id 
                              GROUP BY movies.id 
                              ORDER BY movies.view DESC 
                              LIMIT :limit";
          $stmt = $this->conn->prepare($query);
          $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
}
?>