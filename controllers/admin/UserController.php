<?php
require_once MODEL_PATH . 'UserModel.php';
require_once DATABASE_PATH . 'database.php';


class UserController
{
     private $userModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->userModel = new UserModel($db);
     }
     public function index()
     {
          $controller = 'user';
          $action = 'index';
          $keyword = isset($_GET['search']) ? $_GET['search'] : '';
          if (!empty($keyword)) {
               $users = $this->userModel->searchUsers($keyword);
          } else {
               $users = $this->userModel->getAll();
          }

          require VIEW_PATH . 'admin/admin_user/user_list.php';
     }

     public function edit($id = null)
     {
          $user = $id ? $this->userModel->getById($id) : null;
          $controller = 'user';
          $action = 'edit';
          require VIEW_PATH . 'admin/admin_user/user_form.php';
     }

     public function save()
     {
          $id = $_POST['id'] ?? null;
          $username = $_POST['username'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $phone = $_POST['phone'];
          $address = $_POST['address'];
          $image = $id && empty($_FILES['image']['name']) ? $_POST['current_image'] ?? null : ($this->uploadImage() ?? null);
          $role = $_POST['role'];

          // Kiểm tra email đã tồn tại chưa
          if ($this->userModel->emailExists($email, $id)) {
               echo "<script>alert('Email đã tồn tại. Vui lòng chọn email khác!'); window.history.back();</script>";
               exit;
          }

          if ($id) {
               $result = $this->userModel->updateUser($id, $username, $email, $password, $phone, $address, $image, $role);
          } else {
               $result = $this->userModel->addUser($username, $email, $password, $phone, $address, $image, $role);
          }

          if ($result) {
               header("Location: index.php?controller=user&action=index");
               exit;
          } else {
               echo "Lỗi khi lưu người dùng!";
          }
     }


     public function delete()
     {
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               die("Phương thức không hợp lệ");
          }
          $id = $_POST['id'] ?? null;
          if (!$id || !is_numeric($id)) {
               die("ID không hợp lệ");
          }

          if ($this->userModel->deleteUser($id)) {
               header("Location: index.php?controller=user&action=index");
               exit;
          } else {
               die("Xóa thất bại, vui lòng thử lại");
          }
     }


     // Upload image
     private function uploadImage()
     {
          if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
               $target_dir = "public/images/";
               $target_file = $target_dir . basename($_FILES["image"]["name"]);
               if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    return $target_dir . basename($_FILES["image"]["name"]);
               } else {
                    $image = '';
               }
          }
          return null;
     }



}

$controller = new UserController();
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'edit':
          $controller->edit($_GET['id'] ?? null);
          break;
     case 'save':
          $controller->save();
          break;
     case 'delete':
          $controller->delete();
          break;


}
?>