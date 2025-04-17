<?php
require_once 'BaseModel.php';

class RevenueModel extends BaseModel
{
        public function __construct($db)
        {
                parent::__construct($db, 'bookings');
        }
        public function getAllTheaters()
        {
                $query = "SELECT name FROM theaters";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // Lấy doanh thu theo ngày
        // public function getRevenueByDay($startDate = null, $endDate = null)
        // {
        //         $query = "
        //         SELECT 
        //                 DATE(b.booking_time) AS revenue_date,
        //                 SUM(b.total_price) AS total_revenue
        //         FROM bookings b
        //         WHERE b.status = 'confirmed'
        //         ";

        //         $params = [];
        //         if ($startDate && $endDate) {
        //                 $query .= " AND DATE(b.booking_time) BETWEEN :start_date AND :end_date";
        //                 $params[':start_date'] = $startDate;
        //                 $params[':end_date'] = $endDate;
        //         }

        //         $query .= " GROUP BY DATE(b.booking_time) ORDER BY revenue_date ASC";

        //         $stmt = $this->conn->prepare($query);
        //         $stmt->execute($params);
        //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // }

        // Lấy doanh thu theo tháng
        public function getRevenueByMonth($startYear = null, $endYear = null)
        {
                $query = "
                SELECT 
                        DATE_FORMAT(b.booking_time, '%Y-%m') AS revenue_month,
                        SUM(b.total_price) AS total_revenue
                FROM bookings b
                WHERE b.status = 'confirmed'
                ";

                $params = [];
                if ($startYear && $endYear) {
                        $query .= " AND YEAR(b.booking_time) BETWEEN :start_year AND :end_year";
                        $params[':start_year'] = $startYear;
                        $params[':end_year'] = $endYear;
                }

                $query .= " GROUP BY DATE_FORMAT(b.booking_time, '%Y-%m') ORDER BY revenue_month ASC";

                $stmt = $this->conn->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Lấy doanh thu theo rạp (theater)


        public function getRevenueByDay($startDate, $endDate)
        {
                $query = "SELECT DATE(booking_time) as revenue_date, SUM(total_price) as total_revenue 
                        FROM bookings 
                        WHERE booking_time BETWEEN :start_date AND :end_date 
                        GROUP BY DATE(booking_time)";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([
                        ':start_date' => $startDate . ' 00:00:00',
                        ':end_date' => $endDate . ' 23:59:59'
                ]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getRevenueByTheater($startDate, $endDate)
        {
                $query = "SELECT t.name as theater_name, DATE(b.booking_time) as revenue_date, SUM(b.total_price) as total_revenue 
                        FROM bookings b 
                        JOIN showtimes s ON b.showtime_id = s.id 
                        JOIN theaters t ON s.theater_id = t.id 
                        WHERE b.booking_time BETWEEN :start_date AND :end_date 
                        GROUP BY t.name, DATE(b.booking_time)";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([
                        ':start_date' => $startDate . ' 00:00:00',
                        ':end_date' => $endDate . ' 23:59:59'
                ]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}
