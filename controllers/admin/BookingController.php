<?php
require_once MODEL_PATH . 'BookingModel.php';
require_once DATABASE_PATH . 'database.php';

class BookingController
{
    private $bookingModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->bookingModel = new BookingModel($db);
    }

    public function index()
    {
        // Lấy danh sách tất cả đặt vé
        $bookings = $this->bookingModel->getAllBookings();
        require VIEW_PATH . 'admin/admin_history/history_list.php';
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking_id = $_POST['booking_id'] ?? null;

            if ($booking_id) {
                $result = $this->bookingModel->deleteBooking($booking_id);
                if ($result) {
                    header("Location: admin.php?controller=booking&action=index");
                    exit();
                } else {
                    die("Lỗi khi xóa đặt vé!");
                }
            } else {
                die("ID đặt vé không hợp lệ!");
            }
        }
    }
}

$controller = new BookingController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'delete':
        $controller->delete();
        break;
}
?>