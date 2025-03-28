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
          $theaters = $this->theaterModel->getAll();
          require VIEW_PATH . 'user/theater/theater.php';
     }


     // public function edit($id = null)
     // {
     //      $theater = $id ? $this->theaterModel->getById($id) : null;
     //      $controller = 'theater';
     //      $action = 'edit';
     //      require VIEW_PATH . 'user/theater/theater_detail.php';
     // }
     public function edit($theaterId)
     {
          // Lấy thông tin rạp phim
          $theaters = $this->theaterModel->getAll();
          $theater = array_filter($theaters, function ($t) use ($theaterId) {
               return $t['id'] == $theaterId;
          });
          $theater = reset($theater); // Lấy rạp đầu tiên khớp

          // Lấy danh sách phòng chiếu
          $rooms = $this->theaterModel->getRoomsByTheater($theaterId);

          $data = [
               'theater' => $theater,
               'rooms' => $rooms
          ];

          require VIEW_PATH . 'user/theater/theater_detail.php';
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
}

?>