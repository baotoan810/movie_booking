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
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Debug dữ liệu trả về
        error_log("getAllBookings result: " . print_r($bookings, true));

        // Định dạng total_price trước khi trả về
        foreach ($bookings as &$booking) {
            $booking['total_price'] = number_format($booking['total_price'], 0, ',', '.') . ' VND';
        }

        return $bookings;
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

    public function cancelBookingBySeat($showtime_id, $seat_id)
    {
        $this->conn->beginTransaction();

        try {
            // Tìm booking_id dựa trên showtime_id và seat_id
            $query = "
            SELECT bs.booking_id 
            FROM booking_seats bs
            INNER JOIN bookings b ON bs.booking_id = b.id
            WHERE b.showtime_id = :showtime_id AND bs.theater_seat_id = :seat_id
        ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':showtime_id', $showtime_id, PDO::PARAM_INT);
            $stmt->bindParam(':seat_id', $seat_id, PDO::PARAM_INT);
            $stmt->execute();
            $booking = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$booking) {
                throw new Exception("Không tìm thấy đặt vé cho ghế này! showtime_id: $showtime_id, seat_id: $seat_id");
            }

            $booking_id = $booking['booking_id'];

            // Xóa các bản ghi trong booking_seats liên quan đến booking_id
            $query = "DELETE FROM booking_seats WHERE booking_id = :booking_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
            $stmt->execute();

            // Xóa bản ghi trong bookings
            $query = "DELETE FROM bookings WHERE id = :booking_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw new Exception("Lỗi khi hủy đặt vé: " . $e->getMessage());
        }
    }
}
?>