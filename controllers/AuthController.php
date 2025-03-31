<?php
require_once MODEL_PATH . 'AuthModel.php';
require_once DATABASE_PATH . 'database.php';

class AuthController
{
     private $authModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->authModel = new AuthModel($db);
     }

     public function login()
     {
          $message = $_SESSION['message'] ?? '';
          unset($_SESSION['message']);
          require VIEW_PATH . 'auth/login.php';
     }
     public function home()
     {
          if (!isset($_SESSION['user_id'])) {
               header('Location: index.php?action=login');
               exit();
          }

          $user = $this->authModel->findById($_SESSION['user_id']); // Lấy dữ liệu user từ DB

          require VIEW_PATH . 'user/home/header.php';
     }


     public function handleLogin()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $email = $_POST['email'] ?? '';
               $password = $_POST['password'] ?? '';

               $user = $this->authModel->findByEmail($email);
               if ($user && password_verify($password, $user['password'])) {
                    // Lưu thông tin vào session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_image'] = $user['image']; // Thêm hình ảnh vào session

                    if ($user['role'] === 'admin') {
                         header('Location: ' . BASE_URL . 'admin.php');
                    } else {
                         header('Location: ' . BASE_URL . 'user.php');
                    }
                    exit();
               } else {
                    $_SESSION['message'] = "Email hoặc mật khẩu không đúng!";
                    header('Location: ' . BASE_URL . 'index.php?action=login');
                    exit();
               }
          }
     }


     public function register()
     {
          $message = $_SESSION['message'] ?? '';
          unset($_SESSION['message']);
          require VIEW_PATH . 'auth/register.php';
     }

     public function handleRegister()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $data = [
                    'username' => $_POST['username'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'password' => password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT),
                    'phone' => $_POST['phone'] ?? '',
                    'address' => $_POST['address'] ?? '',
                    'image' => null,
                    'role' => 'user'
               ];

               if (!empty($_FILES['image']['name'])) {
                    $imageExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                    if (in_array($imageExt, $allowedExts) && $_FILES['image']['size'] < 5 * 1024 * 1024) {
                         $newFileName = uniqid() . '.' . $imageExt;
                         move_uploaded_file($_FILES['image']['tmp_name'], PUBLIC_PATH . 'images/' . $newFileName);
                         $data['image'] = 'public/images/' . $newFileName;
                    }
               }

               if ($this->authModel->create($data)) {
                    $_SESSION['message'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                    header('Location: ' . BASE_URL . 'index.php?action=login');
               } else {
                    $_SESSION['message'] = "Đăng ký thất bại! Email có thể đã tồn tại.";
                    header('Location: ' . BASE_URL . 'index.php?action=register');
               }
               exit();
          }
     }
}

$controller = new AuthController();
$action = $_GET['action'] ?? 'login';

switch ($action) {
     case 'login':
          $controller->login();
          break;
     case 'handleLogin':
          $controller->handleLogin();
          break;
     case 'register':
          $controller->register();
          break;
     case 'handleRegister':
          $controller->handleRegister();
          break;
     default:
          $controller->login();
          break;
}
?>