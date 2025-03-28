<?php
require_once MODEL_PATH . 'MovieModel.php';
require_once DATABASE_PATH . 'database.php';

class DetailController
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
          $controller = 'detail';
          $action = 'index';
          $movies = $this->movieModel->getAllMoviesWithGenres();
          $getMovieToday = $this->movieModel->getMoviesShowingToday();
          require VIEW_PATH . 'user/movie/movie.php';
     }

     public function detail($id = null)
     {
          $movie = $id ? $this->movieModel->getMovieById($id) : null;
          $genres = $id ? $this->movieModel->getGenresId($id) : [];
          require VIEW_PATH . 'user/movie/detail_movie.php';
     }




}

$controller = new DetailController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'detail':
          $controller->detail($_GET['id'] ?? null);
          break;
}
?>