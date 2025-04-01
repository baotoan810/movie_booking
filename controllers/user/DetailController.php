<?php
require_once MODEL_PATH . 'MovieModel.php';
require_once MODEL_PATH . 'ReviewModel.php'; // Thêm ReviewModel
require_once DATABASE_PATH . 'database.php';

class DetailController
{
     private $movieModel;
     private $reviewModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->movieModel = new MovieModel($db);
          $this->reviewModel = new ReviewModel($db); // Khởi tạo ReviewModel
     }

     public function index()
     {
          $controller = 'detail';
          $action = 'index';
          $movies = $this->movieModel->getUpcomingMovies();
          $getMovieToday = $this->movieModel->getMoviesShowingToday();
          require VIEW_PATH . 'user/movie/movie.php';
     }

     public function detail($id = null)
     {
          if (!$id) {
               die("Không tìm thấy ID phim!");
          }

          $movie = $this->movieModel->getMovieById($id);
          if (!$movie) {
               die("Phim không tồn tại!");
          }

          $genres = $this->movieModel->getGenresId($id);
          $reviews = $this->reviewModel->getReviewsByMovieId($id); // Lấy danh sách bình luận
          $movie_id = $id; // Truyền movie_id vào giao diện

          require VIEW_PATH . 'user/movie/detail_movie.php';
     }
}

$controller = new DetailController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'detail':
          $controller->detail($_GET['id'] ?? null);
          break;
}
?>