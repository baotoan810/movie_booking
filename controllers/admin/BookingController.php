<?php

require_once MODEL_PATH . 'BookingModel.php';
require_once MODEL_PATH . 'RoomModel.php';
require_once DATABASE_PATH . 'database.php';

class BookingController
{
     private $db;
     private $bookingModel;
     private $roomModel;

     public function __construct()
     {
          // Khởi tạo kết nối cơ sở dữ liệu
          $database = new Database();
          $this->db = $database->getConnection();

          // Khởi tạo các model
          $this->bookingModel = new BookingModel($this->db);
          $this->roomModel = new RoomModel($this->db); // Khởi tạo $roomModel
     }

     public function index()
     {
    

          $bookings = $this->bookingModel->getAllBookings();
          require VIEW_PATH . 'admin/admin_booking/booking_list.php';
     }

     public function viewDetails()
     {
          // Kiểm tra quyền truy cập (chỉ admin)
          if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
               die("Bạn không có quyền truy cập!");
          }

          $booking_id = $_GET['id'] ?? null;
          if (!$booking_id) {
               die("Booking ID không hợp lệ!");
          }

          $booking = $this->bookingModel->getBookingDetails($booking_id);
          if (!$booking) {
               die("Đặt vé không tồn tại!");
          }

          // Lấy thông tin phòng và sơ đồ ghế
          $showtime_id = $booking['showtime_id'];
          $query = "SELECT room_id FROM showtimes WHERE id = ?";
          $stmt = $this->db->prepare($query);
          $stmt->execute([$showtime_id]);
          $room_id = $stmt->fetchColumn();

          // Sử dụng $this->roomModel thay vì $roomModel
          $room = $this->roomModel->getRoomById($room_id);
          if (!$room) {
               die("Phòng không tồn tại!");
          }

          $seats = $this->roomModel->getSeatsByRoom($room_id);

          // Lấy trạng thái ghế từ showtime_seats
          $query = "SELECT theater_seat_id, status FROM showtime_seats WHERE showtime_id = ?";
          $stmt = $this->db->prepare($query);
          $stmt->execute([$showtime_id]);
          $showtimeSeats = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $seatStatusMap = [];
          foreach ($showtimeSeats as $seat) {
               $seatStatusMap[$seat['theater_seat_id']] = $seat['status'];
          }

          // Lấy danh sách ghế thuộc đặt vé này
          $bookingSeatIds = array_column($booking['seats'], 'theater_seat_id');

          // Tạo sơ đồ ghế
          $seatMap = array_fill(1, $room['rows'], array_fill(1, $room['columns'], null));
          foreach ($seats as $seat) {
               $seat['showtime_status'] = $seatStatusMap[$seat['id']] ?? 'available';
               $seat['is_booked_by_this_booking'] = in_array($seat['id'], $bookingSeatIds);
               $seatMap[$seat['row']][$seat['column']] = $seat;
          }

          require VIEW_PATH . 'admin/admin_booking/booking_details.php';
     }

     public function cancel()
     {
          // Kiểm tra quyền truy cập (chỉ admin)
          if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
               die("Bạn không có quyền truy cập!");
          }

          $booking_id = $_GET['id'] ?? null;
          if (!$booking_id) {
               die("Booking ID không hợp lệ!");
          }

          try {
               $this->bookingModel->cancelBooking($booking_id);
               header("Location: index.php?controller=booking&action=index");
               exit();
          } catch (Exception $e) {
               echo "Lỗi: " . $e->getMessage();
          }
     }
}

// Khởi tạo controller và xử lý action
$controller = new BookingController();
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
     case 'index':
          $controller->index();
          break;
     case 'viewDetails':
          $controller->viewDetails();
          break;
     case 'cancel':
          $controller->cancel();
          break;
     default:
          $controller->index();
          break;
}
?>