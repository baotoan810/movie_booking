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
        // Lấy dữ liệu doanh thu theo ngày
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;

        $revenueData = $this->revenueModel->getRevenueByDay($startDate, $endDate);

        // Chuẩn bị dữ liệu cho Chart.js
        $labels = [];
        $data = [];
        foreach ($revenueData as $row) {
            $labels[] = $row['revenue_date'];
            $data[] = $row['total_revenue'];
        }

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

        $allDates = array_unique(array_column($revenueByTheater, 'revenue_date'));
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
        include_once VIEW_PATH . 'admin/admin_chart/chart.php';
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
?>