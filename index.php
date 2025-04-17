<?php
require_once 'config/config.php';
require_once DATABASE_PATH . 'database.php';
require_once CONTROLLER_PATH . 'AuthController.php';
ob_start();
session_start();
// Khởi tạo kết nối database
$db = new Database();
$pdo = $db->getConnection();

if (!$pdo) {
    die("Không thể kết nối đến database.");
}

// Khởi tạo controller
$controller = new AuthController($pdo);

// Lấy URI và loại bỏ phần BASE_URL
// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $uri = str_replace('/thuctap/movie_booking/', '/', $uri);
// Lấy base path tự động (VD: /thuctap/movie_booking)
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$scriptName = str_replace('\\', '/', $scriptName); // Fix cho Windows

// Lấy URI path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Loại bỏ base path khỏi URI
if (strpos($uri, $scriptName) === 0) {
    $uri = substr($uri, strlen($scriptName));
}

// Chuẩn hóa lại URI
$uri = '/' . trim($uri, '/');


switch ($uri) {
    case '/register':
        $controller->register();
        break;
    case '/login':
        $controller->login();
        break;
    case '/logout':
        $controller->logout();
        break;
    case '/forgot':
        $controller->forgotPassword();
        break;
    case '/reset':
        $controller->resetPassword();
        break;
    case '/admin':
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            require_once BASH_PATH . '/admin.php';
        } else {
            header("Location: " . BASE_URL . "login");
        }
        break;
    case '/user':
        if (isset($_SESSION['user_id'])) {
            require_once BASH_PATH . '/user.php';
        } else {
            header("Location: " . BASE_URL . "login");
        }
        break;
    default:
        header("Location: " . BASE_URL . "login");
        exit;
}
