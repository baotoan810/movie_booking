<?php
require_once MODEL_PATH . 'NewsModel.php';
require_once DATABASE_PATH . 'database.php';

class NewsController
{
     private $newsModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->newsModel = new NewsModel($db);
     }

     // Hiển thị danh sách tin tức
     public function index()
     {
          $news = $this->newsModel->getAllNews();
          require VIEW_PATH . 'admin/admin_news/news_list.php';
     }

     // Hiển thị form thêm/sửa tin tức
     public function edit()
     {
          $id = $_GET['id'] ?? null;
          $newsItem = $id ? $this->newsModel->getNewsById($id) : null;
          require VIEW_PATH . 'admin/admin_news/news_form.php';
     }

     // Xử lý thêm/sửa tin tức
     public function save()
     {
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               die("Phương thức không hợp lệ");
          }

          $id = $_POST['id'] ?? null;
          $title = $_POST['title'] ?? '';
          $content = $_POST['content'] ?? '';
          $image = $this->uploadImage();

          // Nếu không upload hình ảnh mới, giữ nguyên hình ảnh cũ (khi sửa)
          if ($id && !$image) {
               $currentNews = $this->newsModel->getNewsById($id);
               $image = $currentNews['image'];
          }

          if (!$title || !$content) {
               die("Dữ liệu không hợp lệ");
          }

          if ($id) {
               $result = $this->newsModel->updateNews($id, $title, $content, $image);
          } else {
               $result = $this->newsModel->addNews($title, $content, $image);
          }

          if ($result) {
               header("Location: admin.php?controller=news&action=index");
               exit;
          } else {
               die("Lưu tin tức thất bại");
          }
     }

     // Xóa tin tức
     public function delete()
     {
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               die("Phương thức không hợp lệ");
          }
          $id = $_POST['id'] ?? null;
          if (!$id || !is_numeric($id)) {
               die("ID không hợp lệ");
          }
          $result = $this->newsModel->deleteNews($id);
          if ($result) {
               header("Location: admin.php?controller=news&action=index");
               exit;
          } else {
               die("Xóa thất bại");
          }
     }

     // Xử lý upload hình ảnh
     private function uploadImage()
     {
          if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
               $target_dir = "public/images/news/";
               if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
               }
               $image_name = time() . '_' . basename($_FILES["image"]["name"]);
               $target_file = $target_dir . $image_name;
               if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    return $target_file;
               }
          }
          return null;
     }
}

// Khởi tạo controller và xử lý action
$controller = new NewsController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'edit':
          $controller->edit();
          break;
     case 'save':
          $controller->save();
          break;
     case 'delete':
          $controller->delete();
          break;
     default:
          $controller->index();
          break;
}
?>