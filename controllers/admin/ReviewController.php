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

    public function index()
    {
        // Lấy danh sách tất cả bình luận
        $reviews = $this->reviewModel->getAllReviews();
        require VIEW_PATH . 'admin/admin_review/review_list.php';
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $review_id = $_POST['review_id'] ?? null;

            if ($review_id) {
                $result = $this->reviewModel->deleteReview($review_id);
                if ($result) {
                    header("Location: admin.php?controller=review&action=index");
                    exit();
                } else {
                    die("Lỗi khi xóa bình luận!");
                }
            } else {
                die("ID bình luận không hợp lệ!");
            }
        }
    }
}

$controller = new ReviewController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'delete':
        $controller->delete();
        break;
}
?>