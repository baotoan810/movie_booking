<?php
require_once 'BaseModel.php';

class RevenueModel extends BaseModel
{
        public function __construct($db)
        {
                parent::__construct($db, 'bookings');
        }

        // Lấy doanh thu theo ngày
        public function getRevenueByDay($startDate = null, $endDate = null)
        {
                $query = "
                SELECT 
                        DATE(b.created_at) AS revenue_date,
                        SUM(b.total_price) AS total_revenue
                FROM bookings b
                WHERE b.status = 'confirmed'
                ";

                $params = [];
                if ($startDate && $endDate) {
                        $query .= " AND DATE(b.created_at) BETWEEN :start_date AND :end_date";
                        $params[':start_date'] = $startDate;
                        $params[':end_date'] = $endDate;
                }

                $query .= " GROUP BY DATE(b.created_at) ORDER BY revenue_date ASC";

                $stmt = $this->conn->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Lấy doanh thu theo tháng
        public function getRevenueByMonth($startYear = null, $endYear = null)
        {
                $query = "
                SELECT 
                        DATE_FORMAT(b.created_at, '%Y-%m') AS revenue_month,
                        SUM(b.total_price) AS total_revenue
                FROM bookings b
                WHERE b.status = 'confirmed'
                ";

                $params = [];
                if ($startYear && $endYear) {
                        $query .= " AND YEAR(b.created_at) BETWEEN :start_year AND :end_year";
                        $params[':start_year'] = $startYear;
                        $params[':end_year'] = $endYear;
                }

                $query .= " GROUP BY DATE_FORMAT(b.created_at, '%Y-%m') ORDER BY revenue_month ASC";

                $stmt = $this->conn->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Lấy doanh thu theo rạp (theater)
        public function getRevenueByTheater($startDate = null, $endDate = null)
        {
                $query = "
                SELECT 
                        t.name AS theater_name,
                        DATE(b.created_at) AS revenue_date,
                        SUM(b.total_price) AS total_revenue
                FROM bookings b
                INNER JOIN showtimes s ON b.showtime_id = s.id
                INNER JOIN rooms r ON s.room_id = r.id
                INNER JOIN theaters t ON r.theater_id = t.id
                WHERE b.status = 'confirmed'
                ";

                $params = [];
                if ($startDate && $endDate) {
                        $query .= " AND DATE(b.created_at) BETWEEN :start_date AND :end_date";
                        $params[':start_date'] = $startDate;
                        $params[':end_date'] = $endDate;
                }

                $query .= " GROUP BY t.name, DATE(b.created_at) ORDER BY revenue_date ASC, t.name";

                $stmt = $this->conn->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}
?>