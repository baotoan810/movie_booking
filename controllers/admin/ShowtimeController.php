<?php
require_once MODEL_PATH . 'ShowtimeModel.php';
require_once MODEL_PATH . 'RoomModel.php';
require_once DATABASE_PATH . 'database.php';

class ShowtimeController
{
     private $showtimeModel;
     private $db;

     public function __construct()
     {
          $database = new Database();
          $this->db = $database->getConnection();
          $this->showtimeModel = new ShowtimeModel($this->db);
     }

     public function index()
     {
          $keyword = $_GET['search'] ?? '';
          $showtimes = !empty($keyword) ? $this->showtimeModel->searchShowtime($keyword) : $this->showtimeModel->getAllShowtimes();
          require VIEW_PATH . 'admin/admin_showtime/showtime_list.php';
     }

     public function edit($id = null)
     {
          $id = $_GET['id'] ?? $id;
          $showtime = $id ? $this->showtimeModel->getShowtimeById($id) : null;
          $movies = $this->showtimeModel->getMovies();
          $rooms = $this->showtimeModel->getRooms();
          require VIEW_PATH . 'admin/admin_showtime/showtime_form.php';
     }

     public function save()
     {
          $id = isset($_POST['id']) ? $_POST['id'] : null;
          $movie_id = $_POST['movie_id'] ?? '';
          $room_id = $_POST['room_id'] ?? '';
          $start_time = $_POST['start_time'] ?? '';
          $end_time = $_POST['end_time'] ?? '';
          $price = $_POST['price'] ?? 50000;

          try {
               if ($id) {
                    $result = $this->showtimeModel->updateShowtime($id, $movie_id, $room_id, $start_time, $end_time, $price);
               } else {
                    $result = $this->showtimeModel->addShowtime($movie_id, $room_id, $start_time, $end_time, $price);
               }

               if ($result) {
                    header("Location: index.php?controller=showtime&action=index");
                    exit();
               } else {
                    echo "Lỗi khi lưu suất chiếu!";
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
               $result = $this->showtimeModel->deleteShowtime($id);
               if ($result) {
                    header("Location: index.php?controller=showtime&action=index");
               } else {
                    die("Xóa thất bại");
               }
          } else {
               die("Phương thức không hợp lệ");
          }
     }

     public function viewSeats()
     {
          $showtime_id = $_GET['showtime_id'] ?? null;
          if (!$showtime_id) {
               die("Showtime ID không hợp lệ!");
          }

          $showtime = $this->showtimeModel->getShowtimeById($showtime_id);
          if (!$showtime) {
               die("Suất chiếu không tồn tại!");
          }

          $roomModel = new RoomModel($this->db);
          $room = $roomModel->getRoomById($showtime['room_id']);
          $seats = $roomModel->getSeatsByRoom($showtime['room_id']);

          $query = "SELECT theater_seat_id, status FROM showtime_seats WHERE showtime_id = ?";
          $stmt = $this->db->prepare($query);
          $stmt->execute([$showtime_id]);
          $showtimeSeats = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $seatStatusMap = [];
          foreach ($showtimeSeats as $seat) {
               $seatStatusMap[$seat['theater_seat_id']] = $seat['status'];
          }

          $seatMap = array_fill(1, $room['rows'], array_fill(1, $room['columns'], null));
          foreach ($seats as $seat) {
               $seat['showtime_status'] = $seatStatusMap[$seat['id']] ?? 'available';
               $seatMap[$seat['row']][$seat['column']] = $seat;
          }

          require VIEW_PATH . 'admin/admin_showtime/showtime_seat_map.php';
     }
     // Thêm action toggleSeatStatus để đặt hoặc hủy đặt ghế
     public function toggleSeatStatus()
     {
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               die("Phương thức không hợp lệ!");
          }

          $showtime_id = $_POST['showtime_id'] ?? null;
          $seat_id = $_POST['seat_id'] ?? null;
          $current_status = $_POST['current_status'] ?? null;

          if (!$showtime_id || !$seat_id || !$current_status) {
               die("Dữ liệu không hợp lệ! showtime_id: $showtime_id, seat_id: $seat_id, current_status: $current_status");
          }

          // Kiểm tra trạng thái ghế hiện tại trong cơ sở dữ liệu
          $query = "SELECT status FROM showtime_seats WHERE showtime_id = ? AND theater_seat_id = ?";
          $stmt = $this->db->prepare($query);
          $stmt->execute([$showtime_id, $seat_id]);
          $actual_status = $stmt->fetchColumn();

          if ($actual_status === false) {
               die("Ghế không tồn tại trong suất chiếu này! showtime_id: $showtime_id, seat_id: $seat_id");
          }

          if ($actual_status !== $current_status) {
               die("Trạng thái ghế không khớp! Trạng thái thực tế: $actual_status, Trạng thái gửi: $current_status. Vui lòng làm mới trang.");
          }

          $this->db->beginTransaction();

          try {
               if ($current_status === 'available') {
                    $bookingModel = new BookingModel($this->db);
                    $user_id = 1; // Thay bằng user_id của admin hoặc người dùng thực tế

                    // Lấy giá vé và loại ghế
                    $query = "SELECT s.price, ts.type_seat 
                           FROM showtimes s 
                           JOIN showtime_seats ss ON s.id = ss.showtime_id 
                           JOIN theater_seats ts ON ss.theater_seat_id = ts.id 
                           WHERE s.id = ? AND ss.theater_seat_id = ?";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([$showtime_id, $seat_id]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$result) {
                         throw new Exception("Không thể lấy thông tin giá vé! showtime_id: $showtime_id, seat_id: $seat_id");
                    }

                    $base_price = $result['price'];
                    $price_multiplier = ($result['type_seat'] === 'vip') ? 1.5 : 1;
                    $total_price = $base_price * $price_multiplier;

                    // Tạo bản ghi đặt vé
                    $query = "INSERT INTO bookings (user_id, showtime_id, booking_time, total_price, status) 
                           VALUES (?, ?, ?, ?, 'confirmed')";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([$user_id, $showtime_id, date('Y-m-d H:i:s'), $total_price]);
                    $booking_id = $this->db->lastInsertId();

                    // Tạo bản ghi trong booking_seats
                    $query = "INSERT INTO booking_seats (booking_id, theater_seat_id, price, status) 
                           VALUES (?, ?, ?, 'confirmed')";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([$booking_id, $seat_id, $total_price]);

                    // Cập nhật trạng thái ghế
                    $query = "UPDATE showtime_seats SET status = 'booked' WHERE showtime_id = ? AND theater_seat_id = ?";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([$showtime_id, $seat_id]);
               } else {
                    $bookingModel = new BookingModel($this->db);
                    $bookingModel->cancelBookingBySeat($showtime_id, $seat_id);

                    $query = "UPDATE showtime_seats SET status = 'available' WHERE showtime_id = ? AND theater_seat_id = ?";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([$showtime_id, $seat_id]);
               }

               // Cập nhật available_seats trong showtimes
               $query = "SELECT COUNT(*) FROM showtime_seats WHERE showtime_id = ? AND status = 'available'";
               $stmt = $this->db->prepare($query);
               $stmt->execute([$showtime_id]);
               $available_seats = $stmt->fetchColumn();

               $query = "UPDATE showtimes SET available_seats = ? WHERE id = ?";
               $stmt = $this->db->prepare($query);
               $stmt->execute([$available_seats, $showtime_id]);

               $this->db->commit();
               header("Location: index.php?controller=showtime&action=viewSeats&showtime_id=$showtime_id");
               exit();
          } catch (Exception $e) {
               $this->db->rollBack();
               echo "Lỗi: " . $e->getMessage();
          }
     }
}

$controller = new ShowtimeController();
$action = $_GET['action'] ?? 'index';

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
     case 'viewSeats':
          $controller->viewSeats();
          break;
     case 'toggleSeatStatus': // Thêm case cho toggleSeatStatus
          $controller->toggleSeatStatus();
          break;
}
?>