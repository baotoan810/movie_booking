<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
require_once 'config/config.php';

$controller = $_GET['controller'] ?? 'homepage';
$action = $_GET['action'] ?? 'index';

require_once VIEW_PATH . 'user/home/header.php';

switch ($controller) {
     case 'homepage':
          require_once CONTROLLER_PATH . 'user/HomeController.php';
          require_once VIEW_PATH . 'user/home/main.php';
          break;

     case 'detail':
          require_once CONTROLLER_PATH . 'user/DetailController.php';
          break;

     case 'theater':
          require_once CONTROLLER_PATH . 'user/TheaterController.php';
          break;

     case 'booking':
          //  Chỉ cho người đã đăng nhập booking
          if (!isset($_SESSION['user_id'])) {
               echo "<script>alert('Vui lòng đăng nhập để đặt vé'); window.location.href='" . BASE_URL . "login';</script>";
               exit;
          }
          require_once CONTROLLER_PATH . 'user/BookingController.php';
          break;

     case 'review':
          if (!isset($_SESSION['user_id'])) {
               echo "<script>alert('Bạn cần đăng nhập để đánh giá phim'); window.location.href='" . BASE_URL . "login';</script>";
               exit;
          }
          require_once CONTROLLER_PATH . 'user/ReviewController.php';
          break;

     case 'news':
          require_once CONTROLLER_PATH . 'user/NewController.php';
          break;
}

require_once VIEW_PATH . 'user/home/footer.php';
