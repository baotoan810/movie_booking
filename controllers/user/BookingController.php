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
          $database = new Database();
          $this->db = $database->getConnection();
          $this->bookingModel = new BookingModel($this->db);
          $this->roomModel = new RoomModel($this->db);
     }

     public function selectTheaterAndRoom()
     {
          $movieId = $_GET['movie_id'] ?? null;
          $date = isset($_GET['date']) ? $_GET['date'] : null;

          if (!$movieId) {
               die("Vui lòng chọn phim để đặt vé.");
          }

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

          $theaters = $this->bookingModel->getTheatersRoomsAndShowtimesByMovie($movieId, $date);
          if (empty($theaters)) {
          }

          $movieQuery = "SELECT title FROM movies WHERE id = ?";
          $stmt = $this->db->prepare($movieQuery);
          $stmt->execute([$movieId]);
          $movie = $stmt->fetch(PDO::FETCH_ASSOC);
          $movieTitle = $movie['title'] ?? 'Không xác định';

          require VIEW_PATH . 'user/booking/select_theater_and_room.php';
     }

     public function selectSeats()
     {
          $showtimeId = $_POST['showtime_id'] ?? null;
          $date = $_POST['date'] ?? date('Y-m-d');
          $movieId = $_POST['movie_id'] ?? null;

          if (!$showtimeId || !$movieId) {
               header('Location: user.php?controller=booking&action=selectTheaterAndRoom&movie_id=' . $movieId);
               exit;
          }

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

          $showtimeDate = date('Y-m-d', strtotime($selectedShowtime['start_time']));
          if ($showtimeDate !== $date) {
               die("Ngày của suất chiếu không khớp với ngày được chọn! Ngày chọn: $date, Ngày suất chiếu: $showtimeDate");
          }

          $room = $this->roomModel->getRoomById($selectedShowtime['room_id']);
          if (!$room) {
               die("Phòng không tồn tại!");
          }

          $seats = $this->roomModel->getSeatsByRoom($selectedShowtime['room_id']);

          $query = "SELECT theater_seat_id, status FROM showtime_seats WHERE showtime_id = ?";
          $stmt = $this->db->prepare($query);
          $stmt->execute([$showtimeId]);
          $showtimeSeats = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $seatStatusMap = [];
          foreach ($showtimeSeats as $seat) {
               $seatStatusMap[$seat['theater_seat_id']] = $seat['status'];
          }

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

          $seatMap = array_fill(1, $room['rows'], array_fill(1, $room['columns'], null));
          foreach ($seats as $seat) {
               $seatId = $seat['id'];
               $isBooked = ($seatStatusMap[$seatId] ?? 'available') === 'booked' || isset($bookedSeatMap[$seatId]);
               $seat['showtime_status'] = $isBooked ? 'booked' : 'available';
               $seatMap[$seat['row']][$seat['column']] = $seat;
          }

          require VIEW_PATH . 'user/booking/select_seat.php';
     }

     public function payment()
     {
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               header('Location: user.php?controller=booking&action=selectTheaterAndRoom');
               exit;
          }

          $showtimeId = $_POST['showtime_id'] ?? null;
          $selectedSeats = $_POST['seats'] ?? [];
          $totalPrice = $_POST['total_price'] ?? 0;
          $userId = $_SESSION['user_id'] ?? 51;
          $promotionId = $_POST['promotion_id'] ?? null;

          if (empty($showtimeId) || empty($selectedSeats)) {
               echo "Vui lòng chọn suất chiếu và ghế.";
               return;
          }

          if ($totalPrice <= 0) {
               $query = "
                SELECT s.price AS base_price, ts.id AS seat_id, ts.type_seat 
                FROM showtimes s 
                LEFT JOIN theater_seats ts ON ts.id IN (" . implode(',', array_fill(0, count($selectedSeats), '?')) . ")
                WHERE s.id = ?
            ";
               $stmt = $this->db->prepare($query);
               $params = array_merge($selectedSeats, [$showtimeId]);
               $stmt->execute($params);
               $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

               $totalPrice = 0;
               $basePrice = $results[0]['base_price'] ?? 0;
               foreach ($results as $result) {
                    $priceMultiplier = ($result['type_seat'] === 'vip') ? 1.5 : 1;
                    $totalPrice += $basePrice * $priceMultiplier;
               }

               if ($totalPrice <= 0) {
                    echo "Giá vé không hợp lệ! Total price: $totalPrice";
                    return;
               }
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

     public function success()
     {
          $bookingId = $_GET['booking_id'] ?? null;
          if (!$bookingId) {
               header('Location: user.php?controller=booking&action=selectTheaterAndRoom');
               exit;
          }
          require VIEW_PATH . 'user/booking/success.php';
     }

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
          $stmt = $this->db->prepare($query);
          $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
          $stmt->execute();
          $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

          require VIEW_PATH . 'user/booking/booking_history.php';
     }

     public function userProfile()
     {
          $userId = $_SESSION['user_id'] ?? 51;

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

          require VIEW_PATH . 'user/home/user_profile.php';
     }

     // Phương thức mới để xóa đặt vé
     public function deleteBooking()
     {
          $bookingId = $_GET['booking_id'] ?? null;
          if (!$bookingId) {
               header('Location: user.php?controller=booking&action=bookingHistory');
               exit;
          }

          // Gọi phương thức xóa từ BookingModel
          $result = $this->bookingModel->deleteBooking($bookingId);
          if ($result) {
               header('Location: user.php?controller=booking&action=bookingHistory');
               exit;
          } else {
               echo "Xóa đặt vé thất bại. Vui lòng thử lại.";
          }
     }
}

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
     case 'bookingHistory':
          $controller->bookingHistory();
          break;
     case 'userProfile':
          $controller->userProfile();
          break;
     case 'deleteBooking': // Thêm case mới để xử lý xóa
          $controller->deleteBooking();
          break;
     default:
          $controller->selectTheaterAndRoom();
          break;
}
