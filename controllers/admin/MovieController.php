<?php
require_once MODEL_PATH . 'MovieModel.php';
require_once DATABASE_PATH . 'database.php';

class MovieController
{
     private $movieModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->movieModel = new MovieModel($db);
     }

     public function index()
     {
          $keyword = $_GET['search'] ?? '';
          $movies = !empty($keyword) ? $this->movieModel->searchMovie($keyword) : $this->movieModel->getAllMoviesWithGenres();
          require VIEW_PATH . 'admin/admin_movie/movie_list.php';
     }

     public function edit($id = null)
     {
          $id = $_GET['id'] ?? $id;
          $movie = $id ? $this->movieModel->getMovieById($id) : null;
          $selectedGenres = $id ? $this->movieModel->getGenresId($id) : [];
          $allGenres = $this->movieModel->getGenres();
          require VIEW_PATH . 'admin/admin_movie/movie_form.php';
     }

     public function view($id = null)
     {
          $movie = $id ? $this->movieModel->getMovieById($id) : null;
          $genres = $id ? $this->movieModel->getGenresId($id) : [];
          require VIEW_PATH . 'admin/admin_movie/movie_detail.php';
     }

     public function save()
     {
          $id = isset($_POST['id']) ? $_POST['id'] : null;
          $title = $_POST['title'] ?? '';
          $description = $_POST['description'] ?? '';
          $duration = $_POST['duration'] ?? '';
          $director = $_POST['director'] ?? '';
          $release_date = $_POST['release_date'] ?? '';
          $view = intval($_POST['view'] ?? 0);
          $genres = $_POST['genres'] ?? [];

          // Xử lý poster image
          $poster_path = $id && empty($_FILES['poster_image']['name']) ? ($_POST['poster_path'] ?? null) : ($this->uploadImage() ?? null);

          // Xử lý upload video trailer
          $trailer_path = $this->uploadTrailerVideo();
          if ($id && !$trailer_path) {
               $current_movie = $this->movieModel->getMovieById($id);
               $trailer_path = $current_movie['trailer_path'];
          }

          if ($id) {
               $result = $this->movieModel->updateMovie($id, $title, $description, $duration, $director, $release_date, $trailer_path, $poster_path, $view);
               if ($result) {
                    $this->movieModel->saveGenres($id, $genres);
               }
          } else {
               $movie_id = $this->movieModel->addMovie($title, $description, $duration, $director, $release_date, $trailer_path, $poster_path, $view);
               if ($movie_id) {
                    $this->movieModel->saveGenres($movie_id, $genres);
               }
               $result = $movie_id;
          }

          if ($result) {
               header("Location: admin.php?controller=movie&action=index");
               exit();
          } else {
               echo "Lỗi khi lưu phim!";
          }
     }

     private function uploadTrailerVideo()
     {
          if (isset($_FILES['trailer_video']) && $_FILES['trailer_video']['error'] === UPLOAD_ERR_OK) {
               $target_dir = "public/video/";
               $video_name = time() . '_' . basename($_FILES["trailer_video"]["name"]);
               $target_file = $target_dir . $video_name;
               if (move_uploaded_file($_FILES["trailer_video"]["tmp_name"], $target_file)) {
                    return $target_file;
               }
          }
          return null;
     }

     private function uploadImage()
     {
          if (isset($_FILES['poster_image']) && $_FILES['poster_image']['error'] === UPLOAD_ERR_OK) {
               $target_dir = "public/images/";
               $image_name = time() . '_' . basename($_FILES["poster_image"]["name"]);
               $target_file = $target_dir . $image_name;
               if (move_uploaded_file($_FILES["poster_image"]["tmp_name"], $target_file)) {
                    return $target_file;
               }
          }
          return null;
     }

     public function delete()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $id = $_POST['id'] ?? null;
               if ($id === null) {
                    die("ID không hợp lệ");
               }
               $result = $this->movieModel->deleteMovie($id);
               if ($result) {
                    header("Location: admin.php?controller=movie&action=index");
               } else {
                    die("Xóa thất bại");
               }
          } else {
               die("Phương thức không hợp lệ");
          }
     }
}

$controller = new MovieController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'edit':
          $controller->edit($_GET['id'] ?? null);
          break;
     case 'view':
          $controller->view($_GET['id'] ?? null);
          break;
     case 'save':
          $controller->save();
          break;
     case 'delete':
          $controller->delete();
          break;
}
?>