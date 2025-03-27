<?php
require_once MODEL_PATH . 'MovieModel.php';
require_once MODEL_PATH . 'ReviewModel.php'; // Thêm ReviewModel
require_once DATABASE_PATH . 'database.php';

class HomeController
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
          $keyword = $_GET['search'] ?? '';
          $movies = !empty($keyword) ? $this->movieModel->searchMovie($keyword) : $this->movieModel->getAllMoviesWithGenres();
          $topMovie = $this->movieModel->getTopMoviesByViews(4);
          require VIEW_PATH . 'user/detail/detail_movie.php';
     }

     public function detail()
     {
          $movie_id = $_GET['movie_id'] ?? null;
          if (!$movie_id) {
               header('Location: index.php');
               exit;
          }
          $movie = $this->movieModel->getMovieById($movie_id);
          if (!$movie) {
               header('Location: index.php');
               exit;
          }
          // Lấy danh sách bình luận của phim
          $reviews = $this->reviewModel->getReviewsByMovieId($movie_id);
          require VIEW_PATH . 'user/detail/detail_movie.php';
     }

     // Thêm bình luận (AJAX)
     public function addReview()
     {
          if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
               http_response_code(403);
               echo json_encode(['error' => 'Yêu cầu không hợp lệ']);
               exit;
          }

          if (!isset($_SESSION['user_id'])) {
               http_response_code(403);
               echo json_encode(['error' => 'Bạn cần đăng nhập để bình luận']);
               exit;
          }

          $movie_id = $_POST['movie_id'] ?? null;
          $content = $_POST['content'] ?? '';
          if (!$movie_id || !$content) {
               http_response_code(400);
               echo json_encode(['error' => 'Dữ liệu không hợp lệ']);
               exit;
          }

          $user_id = $_SESSION['user_id'];
          $review_id = $this->reviewModel->addReview($user_id, $movie_id, $content);
          if ($review_id) {
               $review = $this->reviewModel->getReviewById($review_id);
               echo json_encode([
                    'success' => true,
                    'review' => [
                         'id' => $review['id'],
                         'username' => $review['username'],
                         'content' => $review['content'],
                         'created_at' => $review['created_at'],
                         'user_id' => $review['user_id']
                    ]
               ]);
          } else {
               http_response_code(500);
               echo json_encode(['error' => 'Thêm bình luận thất bại']);
          }
          exit;
     }

     // Sửa bình luận (AJAX)
     public function updateReview()
     {
          if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
               http_response_code(403);
               echo json_encode(['error' => 'Yêu cầu không hợp lệ']);
               exit;
          }

          if (!isset($_SESSION['user_id'])) {
               http_response_code(403);
               echo json_encode(['error' => 'Bạn cần đăng nhập để sửa bình luận']);
               exit;
          }

          $review_id = $_POST['review_id'] ?? null;
          $content = $_POST['content'] ?? '';
          if (!$review_id || !$content) {
               http_response_code(400);
               echo json_encode(['error' => 'Dữ liệu không hợp lệ']);
               exit;
          }

          // Kiểm tra quyền sở hữu
          if (!$this->reviewModel->isReviewOwner($review_id, $_SESSION['user_id'])) {
               http_response_code(403);
               echo json_encode(['error' => 'Bạn không có quyền sửa bình luận này']);
               exit;
          }

          $result = $this->reviewModel->updateReview($review_id, $content);
          if ($result) {
               echo json_encode(['success' => true]);
          } else {
               http_response_code(500);
               echo json_encode(['error' => 'Sửa bình luận thất bại']);
          }
          exit;
     }

     // Xóa bình luận (AJAX)
     public function deleteReview()
     {
          if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
               http_response_code(403);
               echo json_encode(['error' => 'Yêu cầu không hợp lệ']);
               exit;
          }

          if (!isset($_SESSION['user_id'])) {
               http_response_code(403);
               echo json_encode(['error' => 'Bạn cần đăng nhập để xóa bình luận']);
               exit;
          }

          $review_id = $_POST['review_id'] ?? null;
          if (!$review_id) {
               http_response_code(400);
               echo json_encode(['error' => 'Dữ liệu không hợp lệ']);
               exit;
          }

          // Kiểm tra quyền sở hữu
          if (!$this->reviewModel->isReviewOwner($review_id, $_SESSION['user_id'])) {
               http_response_code(403);
               echo json_encode(['error' => 'Bạn không có quyền xóa bình luận này']);
               exit;
          }

          $result = $this->reviewModel->deleteReview($review_id);
          if ($result) {
               echo json_encode(['success' => true]);
          } else {
               http_response_code(500);
               echo json_encode(['error' => 'Xóa bình luận thất bại']);
          }
          exit;
     }

}

// Khởi tạo controller và xử lý action
$controller = new HomeController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'detail':
          $controller->detail();
          break;
     case 'addReview':
          $controller->addReview();
          break;
     case 'updateReview':
          $controller->updateReview();
          break;
     case 'deleteReview':
          $controller->deleteReview();
          break;
}
?>