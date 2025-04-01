<?php
require_once MODEL_PATH . 'ReviewModel.php';
require_once DATABASE_PATH . 'database.php';

class ReviewController
{
     private $reviewModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->reviewModel = new ReviewModel($db);
     }

     public function add()
     {
          if (!isset($_SESSION['user_id'])) {
               header("Location: login.php");
               exit();
          }

          $movie_id = $_GET['movie_id'] ?? null;
          $user_id = $_SESSION['user_id'];

          // Kiểm tra xem người dùng đã bình luận cho phim này chưa
          if ($this->reviewModel->hasUserReviewed($user_id, $movie_id)) {
               // Nếu đã bình luận, chuyển hướng về trang chi tiết phim với thông báo lỗi
               header("Location: user.php?controller=detail&action=detail&id=$movie_id&error=" . urlencode("Bạn chỉ được bình luận một lần cho mỗi phim!"));
               exit();
          }

          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $content = trim($_POST['content'] ?? '');

               if ($movie_id && $content) {
                    $result = $this->reviewModel->addReview($user_id, $movie_id, $content);
                    if ($result) {
                         header("Location: user.php?controller=detail&action=detail&id=$movie_id");
                         exit();
                    } else {
                         die("Lỗi khi thêm bình luận!");
                    }
               } else {
                    die("Dữ liệu không hợp lệ! Vui lòng nhập nội dung bình luận.");
               }
          }
     }

     public function edit()
     {
          if (!isset($_SESSION['user_id'])) {
               header("Location: login.php");
               exit();
          }

          $review_id = $_GET['review_id'] ?? null;
          $movie_id = $_GET['movie_id'] ?? null;

          if (!$review_id || !$movie_id) {
               die("Dữ liệu không hợp lệ!");
          }

          $review = $this->reviewModel->getReviewById($review_id);
          if (!$review || $review['user_id'] != $_SESSION['user_id']) {
               die("Bạn không có quyền chỉnh sửa bình luận này!");
          }

          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $content = trim($_POST['content'] ?? '');
               if ($content) {
                    $result = $this->reviewModel->updateReview($review_id, $content);
                    if ($result) {
                         header("Location: user.php?controller=detail&action=detail&id=$movie_id");
                         exit();
                    } else {
                         die("Lỗi khi cập nhật bình luận!");
                    }
               } else {
                    die("Nội dung không hợp lệ! Vui lòng nhập nội dung bình luận.");
               }
          }

          require VIEW_PATH . 'user/review/edit_review.php';
     }

     public function delete()
     {
          if (!isset($_SESSION['user_id'])) {
               header("Location: login.php");
               exit();
          }

          $review_id = $_GET['review_id'] ?? null;
          $movie_id = $_GET['movie_id'] ?? null;

          if (!$review_id || !$movie_id) {
               die("Dữ liệu không hợp lệ!");
          }

          $review = $this->reviewModel->getReviewById($review_id);
          if (!$review || $review['user_id'] != $_SESSION['user_id']) {
               die("Bạn không có quyền xóa bình luận này!");
          }

          $result = $this->reviewModel->deleteReview($review_id);
          if ($result) {
               header("Location: user.php?controller=detail&action=detail&id=$movie_id");
               exit();
          } else {
               die("Lỗi khi xóa bình luận!");
          }
     }
}

$controller = new ReviewController();
$action = $_GET['action'] ?? 'add';

switch ($action) {
     case 'add':
          $controller->add();
          break;
     case 'edit':
          $controller->edit();
          break;
     case 'delete':
          $controller->delete();
          break;
}
?>