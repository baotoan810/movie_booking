<?php
require MODEL_PATH . 'TheaterModel.php';
require DATABASE_PATH . 'database.php';

class TheaterAdminController
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
          $keyword = isset($_GET['search']) ? $_GET['search'] : '';
          if (!empty($keyword)) {
               $theaters = $this->theaterModel->searchTheater($keyword);
          } else {
               $theaters = $this->theaterModel->getAll();
          }
          require VIEW_PATH . 'admin/admin_theater/theater_list.php';
     }


     public function edit($id = null)
     {
          $theater = $id ? $this->theaterModel->getById($id) : null;
          $controller = 'theater';
          $action = 'edit';
          require VIEW_PATH . 'admin/admin_theater/theater_form.php';
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
               header("Location: admin.php?controller=theater&action=index");
               exit();
          } else {
               echo "Lỗi khi lưu rạp!";
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
                    header("Location: admin.php?controller=theater&action=index");
               } else {
                    die("Xóa thất bại");
               }
          } else {
               die("Phương thức không hợp lệ");
          }
     }

}

$controller = new TheaterAdminController();
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