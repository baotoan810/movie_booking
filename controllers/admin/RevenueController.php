<?php
require_once MODEL_PATH . 'RevenueModel.php';
require_once DATABASE_PATH . 'database.php';

class RevenueController
{
    private $revenueModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->revenueModel = new RevenueModel($db);
    }

    public function index()
    {
        // Đặt ngày mặc định để bao gồm dữ liệu có sẵn
        $startDate = $_GET['start_date'] ?? date('Y-m-d'); // Lấy ngày hôm nay
        $endDate = $_GET['end_date'] ?? date('Y-m-d', strtotime('+30 days')); // 30 ngày sau hôm nay

        // Lấy danh sách all rạp
        $theater = $this->revenueModel->getAllTheaters();

        // Lấy dữ liệu doanh thu theo ngày
        $revenueData = $this->revenueModel->getRevenueByDay($startDate, $endDate);
        // Chuẩn bị dữ liệu cho biểu đồ Tổng doanh thu
        $labels = [];
        $data = [];
        $dateRange = [];

        // Tạo danh sách tất cả các ngày trong khoảng thời gian
        $currentDate = $startDate;
        while (strtotime($currentDate) <= strtotime($endDate)) {
            $dateRange[$currentDate] = 0; // Khởi tạo doanh thu bằng 0 cho mỗi ngày
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        // Điền dữ liệu doanh thu vào các ngày tương ứng
        foreach ($revenueData as $row) {
            $dateRange[$row['revenue_date']] = $row['total_revenue'];
        }

        // Tạo mảng labels và data cho Chart.js
        foreach ($dateRange as $date => $revenue) {
            $labels[] = $date;
            $data[] = $revenue;
        }
        $jsonData = json_encode($data, JSON_NUMERIC_CHECK);
        // Lấy doanh thu theo rạp
        $revenueByTheater = $this->revenueModel->getRevenueByTheater($startDate, $endDate);

        // Chuẩn bị dữ liệu cho biểu đồ theo rạp
        $theaterData = [];
        foreach ($revenueByTheater as $row) {
            $theater = $row['theater_name'];
            $date = $row['revenue_date'];
            if (!isset($theaterData[$theater])) {
                $theaterData[$theater] = [];
            }
            $theaterData[$theater][$date] = $row['total_revenue'];
        }

        $allDates = array_keys($dateRange);
        sort($allDates);

        $datasets = [];
        $colors = ['#fdd835', '#4caf50', '#f44336', '#2196f3', '#ff9800'];
        $i = 0;
        foreach ($theaterData as $theater => $data) {
            $datasetData = [];
            foreach ($allDates as $date) {
                $datasetData[] = isset($data[$date]) ? $data[$date] : 0;
            }
            $datasets[] = [
                'label' => $theater,
                'data' => $datasetData,
                'borderColor' => $colors[$i % count($colors)],
                'backgroundColor' => $colors[$i % count($colors)] . '33',
                'fill' => true
            ];
            $i++;
        }

        // Truyền dữ liệu vào view
        require_once VIEW_PATH . 'admin/admin_chart/chart.php';
    }
}

// Khởi tạo controller và xử lý action
$controller = new RevenueController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $controller->index();
        break;
    default:
        $controller->index();
        break;
}
