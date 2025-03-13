<?php
require_once 'models/UserModel.php';
require_once 'config/database.php';

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
        $users = $this->userModel->getAllUsers();
        $controller = 'user';
        $action = 'index';
        include 'views/user/user_list.php';
    }

    public function edit($id = null)
    {
        $user = $id ? $this->userModel->getUserById($id) : null;
        $controller = 'user';
        $action = 'edit';
        include 'views/user/user_form.php';
    }

    public function save()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $image = $id && empty($_FILES['image']['name']) ? $_POST['current_image'] ?? null : ($this->uploadImage() ?? null);
        $role = $_POST['role'];

        if ($id) {
            $result = $this->userModel->updateUser($id, $username, $email, $password, $phone, $address, $image, $role);
        } else {
            $result = $this->userModel->addUser($username, $email, $password, $phone, $address, $image, $role);
        }

        if ($result) {
            header("Location: index.php?controller=user&action=index");
        } else {
            echo "Lỗi khi lưu người dùng!";
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id === null) {
                die("ID không hợp lệ");
            }
            $result = $this->userModel->deleteUser($id);
            if ($result) {
                header("Location: index.php?controller=user&action=index");
            } else {
                die("Xóa thất bại");
            }
        } else {
            die("Phương thức không hợp lệ");
        }
    }

    private function uploadImage()
    {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "public/images/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                return $target_dir . basename($_FILES["image"]["name"]);
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