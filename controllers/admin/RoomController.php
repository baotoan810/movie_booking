<?php
require_once MODEL_PATH . 'RoomModel.php';
require_once DATABASE_PATH . 'database.php';

class RoomController
{
     private $roomModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->roomModel = new RoomModel($db);
     }

     public function index()
     {
          $keyword = $_GET['search'] ?? '';
          $rooms = !empty($keyword) ? $this->roomModel->searchRoom($keyword) : $this->roomModel->getAllRoomsWithTheater();
          require VIEW_PATH . 'admin/admin_room/room_list.php';
     }

     public function edit($id = null)
     {
          $id = $_GET['id'] ?? $id;
          $room = $id ? $this->roomModel->getRoomById($id) : null;
          $theaters = $this->roomModel->getTheaters();
          require VIEW_PATH . 'admin/admin_room/room_form.php';
     }

     public function view($id = null)
     {
          $room = $id ? $this->roomModel->getRoomById($id) : null;
          require VIEW_PATH . 'admin/admin_room/room_detail.php';
     }

     public function save()
     {
          $id = isset($_POST['id']) ? $_POST['id'] : null;
          $theater_id = $_POST['theater_id'] ?? '';
          $name = $_POST['name'] ?? '';
          $capacity = $_POST['capacity'] ?? '';
          $rows = $_POST['rows'] ?? '';
          $columns = $_POST['columns'] ?? '';

          try {
               if ($id) {
                    $result = $this->roomModel->updateRoom($id, $theater_id, $name, $capacity, $rows, $columns);
               } else {
                    $room_id = $this->roomModel->addRoom($theater_id, $name, $capacity, $rows, $columns);
                    $result = $room_id !== false;
               }

               if ($result) {
                    header("Location: index.php?controller=room&action=index");
                    exit();
               } else {
                    echo "Lỗi khi lưu phòng!";
               }
          } catch (Exception $e) {
               echo "Lỗi: " . $e->getMessage();
          }
     }

     public function delete()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $id = $_POST['id'] ?? null;
               if ($id === null) {
                    die("ID không hợp lệ");
               }
               $result = $this->roomModel->deleteRoom($id);
               if ($result) {
                    header("Location: index.php?controller=room&action=index");
               } else {
                    die("Xóa thất bại");
               }
          } else {
               die("Phương thức không hợp lệ");
          }
     }

     public function viewSeats()
     {
          $room_id = $_GET['room_id'] ?? null;
          if (!$room_id) {
               die("Room ID không hợp lệ!");
          }

          $room = $this->roomModel->getRoomById($room_id);
          if (!$room) {
               die("Phòng không tồn tại!");
          }

          $seats = $this->roomModel->getSeatsByRoom($room_id);

          $seatMap = array_fill(1, $room['rows'], array_fill(1, $room['columns'], null));
          foreach ($seats as $seat) {
               $seatMap[$seat['row']][$seat['column']] = $seat;
          }

          require VIEW_PATH . 'admin/admin_room/room_seat_map.php';
     }

     public function updateSeat()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $seat_id = $_POST['seat_id'] ?? null;
               $type_seat = $_POST['type_seat'] ?? 'normal';
               $status = $_POST['status'] ?? 'available';
               $price = $_POST['price'] ?? 0;
               $room_id = $_POST['room_id'] ?? null;

               if (!$seat_id || !$room_id) {
                    die("Seat ID hoặc Room ID không hợp lệ!");
               }

               $result = $this->roomModel->updateSeat($seat_id, $type_seat, $status, $price);
               if ($result) {
                    header("Location: index.php?controller=room&action=viewSeats&room_id=$room_id");
                    exit();
               } else {
                    die("Cập nhật ghế thất bại!");
               }
          }
     }

     public function deleteSeat()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $seat_id = $_POST['seat_id'] ?? null;
               $room_id = $_POST['room_id'] ?? null;

               if (!$seat_id || !$room_id) {
                    die("Seat ID hoặc Room ID không hợp lệ!");
               }

               $result = $this->roomModel->deleteSeat($seat_id);
               if ($result) {
                    header("Location: index.php?controller=room&action=viewSeats&room_id=$room_id");
                    exit();
               } else {
                    die("Xóa ghế thất bại!");
               }
          }
     }

     // Thêm ghế mới
     public function addSeat()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $room_id = $_POST['room_id'] ?? null;
               $row = $_POST['row'] ?? null;
               $column = $_POST['column'] ?? null;
               $type_seat = $_POST['type_seat'] ?? 'normal';
               $status = $_POST['status'] ?? 'available';
               $price = $_POST['price'] ?? 0;

               if (!$room_id || !$row || !$column) {
                    die("Thông tin ghế không hợp lệ!");
               }

               try {
                    $result = $this->roomModel->addSeat($room_id, $row, $column, $type_seat, $status, $price);
                    if ($result) {
                         header("Location: index.php?controller=room&action=viewSeats&room_id=$room_id");
                         exit();
                    } else {
                         die("Thêm ghế thất bại!");
                    }
               } catch (Exception $e) {
                    die("Lỗi: " . $e->getMessage());
               }
          }
     }
}

$controller = new RoomController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'edit':
          $controller->edit($_GET['id'] ?? null);
          break;
     case 'view':
          $controller->view($_GET['id'] ?? null);
          break;
     case 'save':
          $controller->save();
          break;
     case 'delete':
          $controller->delete();
          break;
     case 'viewSeats':
          $controller->viewSeats();
          break;
     case 'updateSeat':
          $controller->updateSeat();
          break;
     case 'deleteSeat':
          $controller->deleteSeat();
          break;
     case 'addSeat':
          $controller->addSeat();
          break;
}
?>