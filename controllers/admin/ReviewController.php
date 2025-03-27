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

     // Hiển thị danh sách bình luận
     public function index()
     {
          $reviews = $this->reviewModel->getAllReviews();
          require VIEW_PATH . 'admin/admin_review/review_list.php';
     }

     // Xóa bình luận
     public function delete()
     {
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               die("Phương thức không hợp lệ");
          }
          $review_id = $_POST['review_id'] ?? null;
          if (!$review_id || !is_numeric($review_id)) {
               die("ID bình luận không hợp lệ");
          }
          $result = $this->reviewModel->deleteReview($review_id);
          if ($result) {
               header("Location: admin.php?controller=review&action=index");
               exit;
          } else {
               die("Xóa thất bại, vui lòng thử lại");
          }
     }
}

// Khởi tạo controller và xử lý action
$controller = new ReviewController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'delete':
          $controller->delete();
          break;
     default:
          $controller->index();
          break;
}
?>