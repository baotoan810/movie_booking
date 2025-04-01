<?php
require_once MODEL_PATH . 'BaseModel.php';

class BookingModel extends BaseModel
{
    public function __construct($db)
    {
        parent::__construct($db, 'bookings');
    }

    // Lấy tất cả đặt vé, bao gồm thông tin người dùng, phim, rạp, phòng, ghế
    public function getAllBookings()
    {
        $query = "
            SELECT 
                b.id AS booking_id,
                b.total_price,
                b.status AS booking_status,
                b.booking_time,
                u.username,
                m.title AS movie_title,
                t.name AS theater_name,
                r.name AS room_name,
                s.start_time,
                GROUP_CONCAT(CONCAT(CHAR(64 + ts.row), ts.column)) AS seats
            FROM bookings b
            INNER JOIN users u ON b.user_id = u.id
            INNER JOIN showtimes s ON b.showtime_id = s.id
            INNER JOIN movies m ON s.movie_id = m.id
            INNER JOIN rooms r ON s.room_id = r.id
            INNER JOIN theaters t ON r.theater_id = t.id
            INNER JOIN booking_seats bs ON b.id = bs.booking_id
            INNER JOIN theater_seats ts ON bs.theater_seat_id = ts.id
            GROUP BY b.id
            ORDER BY b.booking_time DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xóa đặt vé
    public function deleteBooking($id)
    {
        // Xóa các ghế liên quan trong bảng booking_seats trước
        $query = "DELETE FROM booking_seats WHERE booking_id = :booking_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Sau đó xóa đặt vé trong bảng bookings
        return $this->delete($id);
    }
}
?>