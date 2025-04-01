<?php
require_once MODEL_PATH . 'BookingUser.php';
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
          $this->roomModel = new RoomModel($this->db);
     }

     // Bước 1: Hiển thị rạp, phòng và suất chiếu theo phim
     public function selectTheaterAndRoom()
     {
          $movieId = $_GET['movie_id'] ?? null;
          $date = isset($_GET['date']) ? $_GET['date'] : null;

          if (!$movieId) {
               die("Vui lòng chọn phim để đặt vé.");
          }

          // Nếu không có ngày được chọn, lấy ngày sớm nhất có suất chiếu
          if (!$date) {
               $query = "
                                   SELECT MIN(DATE(start_time)) as earliest_date
                                   FROM showtimes
                                   WHERE movie_id = :movie_id
                                   AND available_seats > 0
                              ";
               $stmt = $this->db->prepare($query);
               $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
               $stmt->execute();
               $result = $stmt->fetch(PDO::FETCH_ASSOC);
               $date = $result['earliest_date'] ?? date('Y-m-d');
          }

          // Lấy danh sách rạp, phòng và suất chiếu theo phim
          $theaters = $this->bookingModel->getTheatersRoomsAndShowtimesByMovie($movieId, $date);
          if (empty($theaters)) {
               // Không có suất chiếu, nhưng vẫn hiển thị giao diện để người dùng chọn ngày
          }

          // Lấy thông tin phim để hiển thị tiêu đề
          $movieQuery = "SELECT title FROM movies WHERE id = ?";
          $stmt = $this->db->prepare($movieQuery);
          $stmt->execute([$movieId]);
          $movie = $stmt->fetch(PDO::FETCH_ASSOC);
          $movieTitle = $movie['title'] ?? 'Không xác định';

          require VIEW_PATH . 'user/booking/select_theater_and_room.php';
     }

     // Bước 2: Hiển thị sơ đồ ghế để chọn
     public function selectSeats()
     {
          $showtimeId = $_POST['showtime_id'] ?? null;
          $date = $_POST['date'] ?? date('Y-m-d');
          $movieId = $_POST['movie_id'] ?? null;

          if (!$showtimeId || !$movieId) {
               header('Location: user.php?controller=booking&action=selectTheaterAndRoom&movie_id=' . $movieId);
               exit;
          }

          // Lấy thông tin suất chiếu, phim, phòng và rạp
          $showtimeQuery = "
                                   SELECT s.*, m.title, r.id AS room_id, r.name AS room_name, t.name AS theater_name
                                   FROM showtimes s
                                   INNER JOIN movies m ON s.movie_id = m.id
                                   INNER JOIN rooms r ON s.room_id = r.id
                                   INNER JOIN theaters t ON r.theater_id = t.id
                                   WHERE s.id = ?
                              ";
          $stmt = $this->db->prepare($showtimeQuery);
          $stmt->execute([$showtimeId]);
          $selectedShowtime = $stmt->fetch(PDO::FETCH_ASSOC);

          if (!$selectedShowtime) {
               die("Suất chiếu không tồn tại!");
          }

          // Kiểm tra ngày của suất chiếu có khớp với ngày được chọn không
          $showtimeDate = date('Y-m-d', strtotime($selectedShowtime['start_time']));
          if ($showtimeDate !== $date) {
               die("Ngày của suất chiếu không khớp với ngày được chọn! Ngày chọn: $date, Ngày suất chiếu: $showtimeDate");
          }

          $room = $this->roomModel->getRoomById($selectedShowtime['room_id']);
          if (!$room) {
               die("Phòng không tồn tại!");
          }

          $seats = $this->roomModel->getSeatsByRoom($selectedShowtime['room_id']);

          // Lấy trạng thái ghế từ showtime_seats
          $query = "SELECT theater_seat_id, status FROM showtime_seats WHERE showtime_id = ?";
          $stmt = $this->db->prepare($query);
          $stmt->execute([$showtimeId]);
          $showtimeSeats = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $seatStatusMap = [];
          foreach ($showtimeSeats as $seat) {
               $seatStatusMap[$seat['theater_seat_id']] = $seat['status'];
          }

          // Lấy trạng thái ghế từ booking_seats (pending hoặc confirmed)
          $query = "
                                   SELECT bs.theater_seat_id
                                   FROM booking_seats bs
                                   INNER JOIN bookings b ON bs.booking_id = b.id
                                   WHERE b.showtime_id = ? AND bs.status IN ('pending', 'confirmed')
                              ";
          $stmt = $this->db->prepare($query);
          $stmt->execute([$showtimeId]);
          $bookedSeats = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $bookedSeatMap = [];
          foreach ($bookedSeats as $seat) {
               $bookedSeatMap[$seat['theater_seat_id']] = true;
          }

          // Tạo sơ đồ ghế
          $seatMap = array_fill(1, $room['rows'], array_fill(1, $room['columns'], null));
          foreach ($seats as $seat) {
               $seatId = $seat['id'];
               $isBooked = ($seatStatusMap[$seatId] ?? 'available') === 'booked' || isset($bookedSeatMap[$seatId]);
               $seat['showtime_status'] = $isBooked ? 'booked' : 'available';
               $seatMap[$seat['row']][$seat['column']] = $seat;
          }

          require VIEW_PATH . 'user/booking/select_seat.php';
     }

     // Bước 3: Xử lý thanh toán
     public function payment()
     {
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               header('Location: user.php?controller=booking&action=selectTheaterAndRoom');
               exit;
          }

          $showtimeId = $_POST['showtime_id'] ?? null;
          $selectedSeats = $_POST['seats'] ?? [];
          $totalPrice = $_POST['total_price'] ?? 0;
          $userId = $_SESSION['user_id'] ?? 51; // Giả lập user_id
          $promotionId = $_POST['promotion_id'] ?? null;

          if (empty($showtimeId) || empty($selectedSeats)) {
               echo "Vui lòng chọn suất chiếu và ghế.";
               return;
          }

          $bookingId = $this->bookingModel->createBooking($userId, $showtimeId, $selectedSeats, $totalPrice, $promotionId);
          if ($bookingId) {
               $this->bookingModel->confirmBooking($bookingId);
               header("Location: user.php?controller=booking&action=success&booking_id=$bookingId");
               exit;
          } else {
               echo "Đặt vé thất bại. Vui lòng thử lại.";
          }
     }

     // Bước 4: Hiển thị thông báo thành công
     public function success()
     {
          $bookingId = $_GET['booking_id'] ?? null;
          if (!$bookingId) {
               header('Location: user.php?controller=booking&action=selectTheaterAndRoom');
               exit;
          }
          require VIEW_PATH . 'user/booking/success.php';
     }

     // Lich sử 
     public function bookingHistory()
     {
          $userId = $_SESSION['user_id'] ?? 51;

          $query = "
                    SELECT 
                         b.id AS booking_id,
                         b.total_price,
                         b.status AS booking_status,
                         b.booking_time,
                         m.title AS movie_title,
                         t.name AS theater_name,
                         r.name AS room_name,
                         s.start_time,
                         COUNT(bs.theater_seat_id) AS seat_count  -- Đếm số ghế đã đặt
                    FROM bookings b
                    INNER JOIN showtimes s ON b.showtime_id = s.id
                    INNER JOIN movies m ON s.movie_id = m.id
                    INNER JOIN rooms r ON s.room_id = r.id
                    INNER JOIN theaters t ON r.theater_id = t.id
                    INNER JOIN booking_seats bs ON b.id = bs.booking_id
                    WHERE b.user_id = :user_id
                    GROUP BY b.id
                    ORDER BY b.booking_time DESC
               ";
          $stmt = $this->db->prepare($query);
          $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
          $stmt->execute();
          $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

          require VIEW_PATH . 'user/booking/booking_history.php';
     }

     public function userProfile()
     {
          // Lấy user_id từ session (giả lập user_id nếu chưa có hệ thống đăng nhập)
          $userId = $_SESSION['user_id'] ?? 51;

          // Lấy thông tin người dùng
          $userQuery = "
          SELECT 
               username,
               phone,
               email,
               address,
               image,
               role,
               created_at
          FROM users
          WHERE id = :user_id
     ";
          $stmt = $this->db->prepare($userQuery);
          $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
          $stmt->execute();
          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if (!$user) {
               die("Người dùng không tồn tại!");
          }

          // Lấy lịch sử đặt vé (tái sử dụng logic từ bookingHistory)
          $bookingQuery = "
          SELECT 
               b.id AS booking_id,
               b.total_price,
               b.status AS booking_status,
               b.booking_time,
               m.title AS movie_title,
               t.name AS theater_name,
               r.name AS room_name,
               s.start_time,
               GROUP_CONCAT(CONCAT(CHAR(64 + ts.row), ts.column)) AS seats
          FROM bookings b
          INNER JOIN showtimes s ON b.showtime_id = s.id
          INNER JOIN movies m ON s.movie_id = m.id
          INNER JOIN rooms r ON s.room_id = r.id
          INNER JOIN theaters t ON r.theater_id = t.id
          INNER JOIN booking_seats bs ON b.id = bs.booking_id
          INNER JOIN theater_seats ts ON bs.theater_seat_id = ts.id
          WHERE b.user_id = :user_id
          GROUP BY b.id
          ORDER BY b.booking_time DESC
     ";
          $stmt = $this->db->prepare($bookingQuery);
          $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
          $stmt->execute();
          $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Hiển thị giao diện thông tin người dùng
          require VIEW_PATH . 'user/home/user_profile.php';
     }
}

// Khởi tạo controller và xử lý action
$controller = new BookingController();
$action = isset($_GET['action']) ? $_GET['action'] : 'selectTheaterAndRoom';

switch ($action) {
     case 'selectTheaterAndRoom':
          $controller->selectTheaterAndRoom();
          break;
     case 'selectSeats':
          $controller->selectSeats();
          break;
     case 'payment':
          $controller->payment();
          break;
     case 'success':
          $controller->success();
          break;
     case 'bookingHistory': // Thêm case mới
          $controller->bookingHistory();
          break;
     case 'userProfile':  // Thêm case mới
          $controller->userProfile();
          break;
     default:
          $controller->selectTheaterAndRoom();
          break;
}