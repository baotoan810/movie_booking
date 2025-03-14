<?php
require_once 'models/Showtime.php';
require_once 'config/database.php';

class ShowtimeController
{
     private $showtimeModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->showtimeModel = new ShowtimeModel($db);
     }

     /**
      * Hiển thị danh sách lịch chiếu
      */
     public function index()
     {
          $showtimes = $this->showtimeModel->getAllShowtimes();
          $controller = 'showtime';
          $action = 'index';
          include 'views/showtime/showtime_list.php';
     }

     /**
      * Hiển thị form chỉnh sửa hoặc thêm mới lịch chiếu
      */
     public function edit($id = null)
     {
          $showtime = $id ? $this->showtimeModel->getShowtimeById($id) : null;
          $movies = $this->showtimeModel->getAllMovies();
          $theaters = $this->showtimeModel->getAllTheaters();

          $controller = 'showtime';
          $action = 'index';
          include 'views/showtime/showtime_form.php';
     }


     public function save()
     {
          $id = $_POST['id'] ?? null;
          $movie_id = $_POST['movie_id'];
          $theater_id = $_POST['theater_id'];
          $show_time = $_POST['show_time'];
          $price = $_POST['price'];

          if ($id) {
               $result = $this->showtimeModel->updateShowtime($id, $movie_id, $theater_id, $show_time, $price);
          } else {
               $result = $this->showtimeModel->addShowtime($movie_id, $theater_id, $show_time, $price);
          }

          if ($result) {
               header("Location: index.php?controller=showtime&action=index");
          } else {
               echo "Lỗi khi lưu lịch chiếu!";
          }
     }

     /**
      * Xóa lịch chiếu
      */
     public function delete()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $id = $_POST['id'] ?? null;
               if ($id === null) {
                    die("ID không hợp lệ");
               }
               $result = $this->showtimeModel->deleteShowtime($id);
               if ($result) {
                    header("Location: index.php?controller=showtime&action=index");
               } else {
                    die("Xóa thất bại");
               }
          } else {
               die("Phương thức không hợp lệ");
          }
     }
}

// Điều hướng controller dựa trên action
$controller = new ShowtimeController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'edit':
          $controller->edit($_GET['id'] ?? null);
          break;
     case 'save':
          $controller->save();
          break;
     case 'delete':
          $controller->delete();
          break;
}
?>