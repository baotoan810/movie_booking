<?php
require_once 'models/Genres.php';
require_once 'config/database.php';

class GenresController
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
        $genres = $this->genresModel->getAllGenres();
        $controller = 'genres';
        $action = 'index';
        include 'views/genres/genres_list.php';
    }

    public function edit($id = null)
    {
        $genre = $id ? $this->genresModel->getGenresById($id) : null;
        $controller = 'genres';
        $action = 'index';
        include 'views/genres/genres_form.php';
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
        } else {
            echo "Lỗi khi lưu Thể loại!";
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id === null) {
                die("ID không hợp lệ");
            }
            $result = $this->genresModel->deleteGenres($id);
            if ($result) {
                header("Location: index.php?controller=genres&action=index");
            } else {
                die("Xóa thất bại");
            }
        } else {
            die("Phương thức không hợp lệ");
        }
    }
}

$controller = new GenresController();
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