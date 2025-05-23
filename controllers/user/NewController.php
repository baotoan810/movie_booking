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
          require VIEW_PATH . 'user/news/news_list.php';
     }
     public function newDetail($id = null)
     {
          $new = $id ? $this->newsModel->getById($id) : [];
          require VIEW_PATH . 'user/news/news_detail.php';
     }

}

// Khởi tạo controller và xử lý action
$controller = new NewsController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'detail':
          $controller->newDetail($_GET['id'] ?? null);
          break;
     default:
          $controller->index();
          break;
}
?>