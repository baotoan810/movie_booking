<?php
require_once MODEL_PATH . 'SeatModel.php';
require_once DATABASE_PATH . 'database.php';

class SeatAdminController
{
     private $seatModel;

     public function __construct()
     {
          $database = new Database();
          $db = $database->getConnection();
          $this->seatModel = new SeatModel($db);
     }

     public function index()
     {
          $seats = $this->seatModel->getAllSeatsWithTheater();
          require VIEW_PATH . 'seat/seat_list.php';
     }

     public function edit()
     {
          $id = $_GET['id'] ?? null;
          $seat = $id ? $this->seatModel->getSeatById($id) : null;
          $allTheaters = $this->seatModel->getAllTheaters();

          if ($seat && !isset($seat['type_seat'])) {
               $seat['type_seat'] = 'normal';
          }

          require VIEW_PATH . 'seat/seat_form.php';
     }

     public function save()
     {
          $id = $_POST['id'] ?? null;
          $theater_id = $_POST['theater_id'] ?? null;
          $row = $_POST['row'] ?? null;
          $column = $_POST['column'] ?? null;
          $price = $_POST['price'] ?? null;

          if (!$id && $this->seatModel->checkDuplicateTheaterInSeats($theater_id)) {
               die("Lỗi: Rạp này đã tồn tại trong danh sách ghế. Vui lòng chọn rạp khác!");
          }

          if (!$theater_id || !$row || !$column || !$price) {
               die("Lỗi: Vui lòng nhập đầy đủ thông tin.");
          }

          if ($id) {
               $result = $this->seatModel->updateSeat($id, $theater_id, $row, $column, $price);
          } else {
               $result = $this->seatModel->addSeat($theater_id, $row, $column, $price);
          }

          if ($result) {
               header("Location: index.php?controller=seat&action=index");
               exit();
          } else {
               echo "Lỗi khi lưu ghế!";
          }
     }

     public function delete()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $id = $_POST['id'] ?? null;
               if ($id === null) {
                    die("ID không hợp lệ");
               }
               $result = $this->seatModel->deleteSeat($id);
               if ($result) {
                    header("Location: index.php?controller=seat&action=index");
               } else {
                    die("Xóa thất bại");
               }
          } else {
               die("Phương thức không hợp lệ");
          }
     }

     public function showSeatMap()
     {
          $theater_id = $_GET['theater_id'] ?? null;

          if (!$theater_id) {
               die("Lỗi: Không tìm thấy rạp.");
          }

          $seats = $this->seatModel->getSeatsByTheater($theater_id);
          $theater = $this->seatModel->getTheaterById($theater_id);
          $maxValues = $this->seatModel->getMaxRowsAndColumns($theater_id);

          $max_row = $maxValues['max_row'] ?? 0;
          $max_column = $maxValues['max_column'] ?? 0;

          if ($max_row == 0 || $max_column == 0) {
               die("Lỗi: Chưa thiết lập hàng ghế cho rạp này. Vui lòng thêm dữ liệu vào bảng theater_rows.");
          }

          require VIEW_PATH . 'seat/seat_map.php';
     }

     public function addSeat()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $theater_id = $_POST['theater_id'] ?? null;
               $row = $_POST['row'] ?? null;
               $column = $_POST['column'] ?? null;

               if (!$theater_id || !$row || !$column) {
                    die("Lỗi: Thiếu dữ liệu");
               }

               $type_seat = $this->seatModel->getRowType($theater_id, $row);
               $seatId = $this->seatModel->addSeatType($theater_id, $row, $column, $type_seat);

               if ($seatId) {
                    header("Location: index.php?controller=seat&action=showSeatMap&theater_id=$theater_id");
                    exit();
               } else {
                    die("Lỗi: Thêm ghế thất bại");
               }
          } else {
               die("Lỗi: Yêu cầu không hợp lệ");
          }
     }

     public function updateSeatType()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $id = $_POST['id'] ?? null;
               $type_seat = $_POST['type_seat'] ?? null;
               $theater_id = $_POST['theater_id'] ?? null;

               if (!$id || !$type_seat || !$theater_id) {
                    die("Lỗi: Thiếu dữ liệu");
               }

               $result = $this->seatModel->updateSeatType($id, $type_seat);

               if ($result) {
                    header("Location: index.php?controller=seat&action=showSeatMap&theater_id=$theater_id");
                    exit();
               } else {
                    die("Lỗi: Cập nhật loại ghế thất bại");
               }
          } else {
               die("Lỗi: Yêu cầu không hợp lệ");
          }
     }

     public function updateSeatStatus()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $id = $_POST['id'] ?? null;
               $status = $_POST['status'] ?? null;
               $theater_id = $_POST['theater_id'] ?? null;

               if (!$id || !$status || !$theater_id) {
                    die("Lỗi: Thiếu dữ liệu");
               }

               $result = $this->seatModel->updateSeatStatus($id, $status);

               if ($result) {
                    header("Location: index.php?controller=seat&action=showSeatMap&theater_id=$theater_id");
                    exit();
               } else {
                    die("Lỗi: Cập nhật trạng thái ghế thất bại");
               }
          } else {
               die("Lỗi: Yêu cầu không hợp lệ");
          }
     }
}

$controller = new SeatAdminController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'edit':
          $controller->edit();
          break;
     case 'save':
          $controller->save();
          break;
     case 'showSeatMap':
          $controller->showSeatMap();
          break;
     case 'delete':
          $controller->delete();
          break;
     case 'addSeat':
          $controller->addSeat();
          break;
     case 'updateSeatType':
          $controller->updateSeatType();
          break;
     case 'updateSeatStatus':
          $controller->updateSeatStatus();
          break;
}
?>