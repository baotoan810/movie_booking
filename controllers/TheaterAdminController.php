<?php
require_once 'models/TheaterModel.php';
require_once 'config/database.php';

class TheaterController
{
    private $theaterModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->theaterModel = new TheaterModel($db);
    }

    public function index()
    {
        $theaters = $this->theaterModel->getAllTheater();
        $controller = 'theater';
        $action = 'index';
        include 'views/theater/theater_list.php';
    }

    public function edit($id = null)
    {
        $theater = $id ? $this->theaterModel->getTheaterById($id) : null;
        $controller = 'theater';
        $action = 'index';
        include 'views/theater/theater_form.php';
    }

    public function save()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $name = $_POST['name'];
        $address = $_POST['address'];
        $capacity = intval($_POST['capacity']);

        if ($id) {
            $result = $this->theaterModel->updateTheater($id, $name, $address, $capacity);
        } else {
            $result = $this->theaterModel->addTheater($name, $address, $capacity);
        }

        if ($result) {
            header("Location: index.php?controller=theater&action=index");
        } else {
            echo "Lỗi khi lưu Rạp!";
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id === null) {
                die("ID không hợp lệ");
            }
            $result = $this->theaterModel->deleteTheater($id);
            if ($result) {
                header("Location: index.php?controller=theater&action=index");
            } else {
                die("Xóa thất bại");
            }
        } else {
            die("Phương thức không hợp lệ");
        }
    }
}

$controller = new TheaterController();
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