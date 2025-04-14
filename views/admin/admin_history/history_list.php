<div class="main-content">
    <div class="header">
        <h1>Danh sách đặt vé</h1>
        <div class="user-info">
            <span>Xin chào, ADMIN</span>
        </div>
    </div>
    <?php if (empty($bookings)): ?>
        <p>Không có đặt vé nào.</p>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Phim</th>
                        <th>Rạp</th>
                        <th>Phòng</th>
                        <th>Ghế</th>
                        <th>Ngày chiếu</th>
                        <th>Giờ chiếu</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                            <td><?= htmlspecialchars($booking['username']) ?></td>
                            <td><?= htmlspecialchars($booking['movie_title']) ?></td>
                            <td><?= htmlspecialchars($booking['theater_name']) ?></td>
                            <td><?= htmlspecialchars($booking['room_name']) ?></td>
                            <td><?= htmlspecialchars($booking['seats']) ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($booking['start_time']))) ?></td>
                            <td><?= htmlspecialchars(date('H:i', strtotime($booking['start_time']))) ?></td>
                            <td><?php echo htmlspecialchars($booking['total_price']); ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($booking['booking_time']))) ?></td>
                            <td><?= htmlspecialchars(ucfirst($booking['booking_status'])) ?></td>
                            <td class="action-buttons">
                                <form action="admin.php?controller=booking&action=delete" method="post"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa đặt vé này?');">
                                    <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                                    <button type="submit" class="delete-btn">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
    .table-container{
        height: 600px;
    }
</style>