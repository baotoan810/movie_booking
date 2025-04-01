<?php
require_once 'config/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "login");
    exit;
}

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

require_once VIEW_PATH . 'admin/layout/sidebar.php';
switch ($controller) {
     case 'home':
          require_once VIEW_PATH . 'admin/layout/home.php';
          break;
     case 'user':
          require_once CONTROLLER_PATH . 'admin/UserController.php';
          break;
     case 'movie':
          require_once CONTROLLER_PATH . 'admin/MovieController.php';
          break;
     case 'genres':
          require_once CONTROLLER_PATH . 'admin/GenresController.php';
          break;
     case 'theater':
          require_once CONTROLLER_PATH . 'admin/TheaterController.php';
          break;
     case 'room':
          require_once CONTROLLER_PATH . 'admin/RoomController.php';
          break;
     case 'booking':
          require_once CONTROLLER_PATH . 'admin/BookingController.php';
          break;
     case 'showtime':
          require_once CONTROLLER_PATH . 'admin/ShowtimeController.php';
          break;
     case 'review':
          require_once CONTROLLER_PATH . 'admin/ReviewController.php';
          break;
     case 'news':
          require_once CONTROLLER_PATH . 'admin/NewsController.php';
          break;
     default:
          require_once VIEW_PATH . 'layout/error.php';
          break;
}

require_once VIEW_PATH . 'admin/layout/footer.php';