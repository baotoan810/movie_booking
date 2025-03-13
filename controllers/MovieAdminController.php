<?php
require_once 'models/MovieModel.php';
require_once 'config/database.php';

class MovieController
{
    private $movieModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->movieModel = new MovieModel($db);
    }

    public function index()
    {
        $movies = $this->movieModel->getALLMovie();
        $controller = 'movie';
        $action = 'index';
        include 'views/movie/movie_list.php';
    }

    public function edit($id = null)
    {
        $movie = $id ? $this->movieModel->getMovieById($id) : null;
        $controller = 'movie';
        $action = 'edit';
        include 'views/movie/movie_form.php';
    }

    public function save()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $title = $_POST['title'];
        $description = $_POST['description'];
        $duration = intval($_POST['duration']);
        $release_date = $_POST['release_date'];
        $trailer_path = $id && empty($_FILES['trailer_path']['name']) ? $_POST['current_image'] ?? null : ($this->uploadImage() ?? null);
        $view = intval($_POST['view']);
        $created_at = $_POST['created_at'];

        if ($id) {
            $result = $this->movieModel->updateMovie($id, $title, $description, $duration, $release_date, $trailer_path, $view, $created_at);
        } else {
            $result = $this->movieModel->addMovie($title, $description, $duration, $release_date, $trailer_path, $view, $created_at);
        }

        if ($result) {
            header("Location: index.php?controller=movie&action=index");
        } else {
            echo "Lỗi khi lưu phim!";
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id === null) {
                die("ID không hợp lệ");
            }
            $result = $this->movieModel->deleteMovie($id);
            if ($result) {
                header("Location: index.php?controller=movie&action=index");
            } else {
                die("Xóa thất bại");
            }
        } else {
            die("Phương thức không hợp lệ");
        }
    }

    private function uploadImage()
    {
        if (isset($_FILES['trailer_path']) && $_FILES['trailer_path']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "public/images/";
            $target_file = $target_dir . basename($_FILES["trailer_path"]["name"]);
            if (move_uploaded_file($_FILES["trailer_path"]["tmp_name"], $target_file)) {
                return $target_dir . basename($_FILES["trailer_path"]["name"]);
            }
        }
        return null;
    }
}

$controller = new MovieController();
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