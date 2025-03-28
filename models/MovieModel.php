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
     // Lấy ds phim hiện tại
     public function getMoviesShowingToday()
     {
          // Lấy ngày hiện tại (theo múi giờ UTC+0 như trong database)
          $today = date('Y-m-d'); // Ví dụ: 2025-03-27

          // Query SQL để lấy phim đang chiếu trong ngày
          $query = "
               SELECT DISTINCT m.*, 
                    GROUP_CONCAT(g.name) as genres
               FROM movies m
               INNER JOIN showtimes s ON m.id = s.movie_id
               LEFT JOIN movie_genres mg ON m.id = mg.movie_id
               LEFT JOIN genres g ON mg.genre_id = g.id
               WHERE DATE(s.start_time) = :today
               GROUP BY m.id
               ";

          try {
               // Nếu dùng PDO
               $stmt = $this->conn->prepare($query);
               $stmt->bindParam(':today', $today);
               $stmt->execute();
               $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

               return $movies;

               // Nếu dùng MySQLi
               /*
               $stmt = $this->db->prepare($query);
               $stmt->bind_param('s', $today);
               $stmt->execute();
               $result = $stmt->get_result();
               $movies = $result->fetch_all(MYSQLI_ASSOC);
               $stmt->close();
               return $movies;
               */

          } catch (Exception $e) {
               // Xử lý lỗi (có thể log lỗi)
               return [];
          }
     }

     /**
      * Lấy thông tin chi tiết suất chiếu của một phim trong ngày
      * @param int $movieId ID của phim
      * @return array Danh sách suất chiếu
      */
     public function getShowtimesForMovieToday($movieId)
     {
          $today = date('Y-m-d');

          $query = "
               SELECT s.*, 
                    t.name as theater_name,
                    t.address as theater_address,
                    r.name as room_name
               FROM showtimes s
               INNER JOIN theaters t ON s.theater_id = t.id
               INNER JOIN rooms r ON s.room_id = r.id
               WHERE s.movie_id = :movie_id
               AND DATE(s.start_time) = :today
               ORDER BY s.start_time ASC
               ";

          try {
               $stmt = $this->conn->prepare($query);
               $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
               $stmt->bindParam(':today', $today);
               $stmt->execute();
               $showtimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

               return $showtimes;

          } catch (Exception $e) {
               return [];
          }
     }

}
?>