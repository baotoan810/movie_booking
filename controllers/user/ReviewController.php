<?php
require_once MODEL_PATH . 'ReviewModel.php';
require_once DATABASE_PATH . 'database.php';

class ReviewController
{
     private $db;
     private $reviewModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->reviewModel = new ReviewModel($db);
     }

     public function index()
     {
          $movie_id = $_GET['movie_id'] ?? null;
          if (!$movie_id) {
               die("Lỗi: Vui lòng chọn phim để xem đánh giá (movie_id không được để trống).");
          }

          $reviews = $this->reviewModel->getReviewsByMovieId($movie_id);
          require VIEW_PATH . 'user/movie/reviews.php';
     }

     public function add()
     {
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               $movie_id = $_GET['movie_id'] ?? '';
               header("Location: index.php?controller=detail&action=index&movie_id=$movie_id");
               exit;
          }

          $movie_id = $_GET['movie_id'] ?? null;
          $user_id = $_SESSION['user_id'] ?? null; // user_id có thể là NULL nếu chưa đăng nhập
          $content = trim($_POST['content'] ?? '');

          if (!$movie_id) {
               die("Lỗi: Movie ID không hợp lệ.");
          }

          if (empty($content)) {
               die("Lỗi: Nội dung đánh giá không được để trống.");
          }

          $result = $this->reviewModel->addReview($user_id, $movie_id, $content);
          if ($result) {
               header("Location: index.php?controller=detail&action=index&movie_id=$movie_id");
               exit;
          } else {
               die("Lỗi: Không thể thêm đánh giá. Vui lòng kiểm tra lại dữ liệu hoặc kết nối cơ sở dữ liệu.");
          }
     }

     public function edit()
     {
          $review_id = $_GET['review_id'] ?? null;
          $movie_id = $_GET['movie_id'] ?? null;
          $user_id = $_SESSION['user_id'] ?? null;

          if (!$review_id || !$movie_id || !$user_id) {
               die("Lỗi: Dữ liệu không hợp lệ hoặc bạn chưa đăng nhập.");
          }

          $review = $this->reviewModel->getReviewById($review_id);
          if (!$review || !$this->reviewModel->isReviewOwner($review_id, $user_id)) {
               die("Lỗi: Bạn không có quyền chỉnh sửa đánh giá này.");
          }

          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $content = trim($_POST['content'] ?? '');
               if (empty($content)) {
                    die("Lỗi: Nội dung đánh giá không được để trống.");
               }

               $result = $this->reviewModel->updateReview($review_id, $content);
               if ($result) {
                    header("Location: index.php?controller=detail&action=index&movie_id=$movie_id");
                    exit;
               } else {
                    die("Lỗi: Không thể cập nhật đánh giá. Vui lòng thử lại.");
               }
          }

          require VIEW_PATH . 'user/movie/edit_review.php';
     }

     public function delete()
     {
          $review_id = $_GET['review_id'] ?? null;
          $movie_id = $_GET['movie_id'] ?? null;
          $user_id = $_SESSION['user_id'] ?? null;

          if (!$review_id || !$movie_id || !$user_id) {
               die("Lỗi: Dữ liệu không hợp lệ hoặc bạn chưa đăng nhập.");
          }

          if (!$this->reviewModel->isReviewOwner($review_id, $user_id)) {
               die("Lỗi: Bạn không có quyền xóa đánh giá này.");
          }

          $result = $this->reviewModel->deleteReview($review_id);
          if ($result) {
               header("Location: index.php?controller=detail&action=index&movie_id=$movie_id");
               exit;
          } else {
               die("Lỗi: Không thể xóa đánh giá. Vui lòng thử lại.");
          }
     }
}

// Xử lý các action
$controller = new ReviewController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'add':
          $controller->add();
          break;
     case 'edit':
          $controller->edit($_GET['id'] ?? null); // Không cần truyền tham số vì đã lấy từ $_GET trong phương thức
          break;
     case 'delete':
          $controller->delete();
          break;
     default:
          $controller->index();
          break;
}