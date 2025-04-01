<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
require_once 'config/config.php';

if (!isset($_SESSION['user_id'])) {
     header("Location: " . BASE_URL . "login");
     exit;
}

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'homepage';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

require_once VIEW_PATH . 'user/home/header.php';

switch ($controller) {
     case 'homepage':
          require_once CONTROLLER_PATH . 'user/HomeController.php';
          require_once VIEW_PATH . 'user/home/main.php';
          break;
     // Xem phim and chi tiết phim
     case 'detail':
          require_once CONTROLLER_PATH . 'user/DetailController.php';
          break;
     case 'theater':
          require_once CONTROLLER_PATH . 'user/TheaterController.php';
          break;
     case 'booking':
          require_once CONTROLLER_PATH . 'user/BookingController.php';
          break;
     // Đánh giá phim
     case 'review':
          require_once CONTROLLER_PATH . 'user/ReviewController.php';
          break;
     // Tin tức 
     case 'news':
          require_once CONTROLLER_PATH . 'user/NewController.php';
          break;


}

require_once VIEW_PATH . 'user/home/footer.php';

