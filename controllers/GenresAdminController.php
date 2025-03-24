<?php
require_once MODEL_PATH . 'GenresModel.php';
require_once DATABASE_PATH . 'database.php';

class GenresAdminController
{

     private $genresModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->genresModel = new GenresModel($db);
     }
     public function index()
     {
          $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
          if (!empty($keyword)) {
               $genres = $this->genresModel->searchGenres($keyword);
          } else {
               $genres = $this->genresModel->getAll();
          }
          require VIEW_PATH . 'genres/genres_list.php';
     }



     public function edit($id = null)
     {
          $genre = $id ? $this->genresModel->getById($id) : null;
          $controller = 'genres';
          $action = 'edit';
          require VIEW_PATH . 'genres/genres_form.php';
     }

     public function save()
     {
          $id = isset($_POST['id']) ? $_POST['id'] : null;
          $name = $_POST['name'];

          if ($id) {
               $result = $this->genresModel->updateGenres($id, $name);
          } else {
               $result = $this->genresModel->addGenres($name);
          }
          if ($result) {
               header("Location: index.php?controller=genres&action=index");
               exit();
          } else {
               die("Xóa thất bại");
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

          if ($this->genresModel->deleteGenres($id)) {
               header("Location: index.php?controller=genres&action=index");
               exit;
          } else {
               die("Xóa thất bại, vui lòng thử lại");
          }
     }
}

$controller = new GenresAdminController();
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