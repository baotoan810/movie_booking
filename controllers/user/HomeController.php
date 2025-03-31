<?php
require_once MODEL_PATH . 'MovieModel.php';
require_once MODEL_PATH . 'ReviewModel.php';
require_once MODEL_PATH . 'NewsModel.php';
require_once MODEL_PATH . 'AuthModel.php';
require_once DATABASE_PATH . 'database.php';

class HomeController
{
     private $movieModel;
     private $reviewModel;
     private $newsModel;
     private $authModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->movieModel = new MovieModel($db);
          $this->reviewModel = new ReviewModel($db);
          $this->newsModel = new NewsModel($db);
          $this->authModel = new AuthModel($db);
     }

     public function index()
     {
          $keyword = $_GET['search'] ?? '';
          $movies = !empty($keyword) ? $this->movieModel->searchMovie($keyword) :
               $this->movieModel->getTopMoviesByViews(4);


          $news = $this->newsModel->getAllNewsLimit(3);
          require VIEW_PATH . 'user/home/main.php';
     }

     public function newsDetail()
     {
          $news_id = $_GET['news_id'] ?? null;
          if (!$news_id || !is_numeric($news_id)) {
               header('Location: index.php?controller=homepage&action=news');
               exit;
          }
          $newsItem = $this->newsModel->getNewsById($news_id);
          if (!$newsItem) {
               header('Location: index.php?controller=homepage&action=news');
               exit;
          }
          require VIEW_PATH . 'user/news/news_detail.php';
     }

     public function detail()
     {
          $movie_id = $_GET['movie_id'] ?? null;
          if (!$movie_id) {
               header('Location: index.php');
               exit;
          }
          $movie = $this->movieModel->getMovieById($movie_id);
          if (!$movie) {
               header('Location: index.php');
               exit;
          }
          $reviews = $this->reviewModel->getReviewsByMovieId($movie_id);
          require VIEW_PATH . 'user/detail_movie/detail_movie.php';
     }



}

// Khởi tạo controller và xử lý action
$controller = new HomeController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'detail':
          $controller->detail();
          break;
} ?>