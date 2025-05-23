<!DOCTYPE html>
<html>

<head>
        <title>Lịch sử đặt vé</title>
        <style>
                body {
                        background-color: #121212;
                        color: #fff;
                        font-family: Arial, sans-serif;
                        padding: 20px;
                        margin: 0;
                }

                h1 {
                        font-size: 28px;
                        font-weight: bold;
                        color: #fdd835;
                        text-align: center;
                        margin-top: 20px;
                        margin-bottom: 20px;
                }

                p {
                        font-size: 16px;
                        color: #ddd;
                        text-align: center;
                }

                .booking {
                        background: #1a1a1a;
                        padding: 20px;
                        border-radius: 10px;
                        margin-bottom: 20px;
                        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.5);
                        transition: transform 0.2s;
                }

                .booking:hover {
                        transform: translateY(-5px);
                }

                .booking h2 {
                        font-size: 22px;
                        font-weight: bold;
                        color: #fdd835;
                        margin-bottom: 10px;
                }

                .booking p {
                        font-size: 14px;
                        color: #bbb;
                        margin: 5px 0;
                        text-align: left;
                }

                .booking .status {
                        font-weight: bold;
                        padding: 5px 10px;
                        border-radius: 5px;
                        display: inline-block;
                }

                .booking .status.pending {
                        background-color: #ff9800;
                        color: #fff;
                }

                .booking .status.confirmed {
                        background-color: #4caf50;
                        color: #fff;
                }

                .booking .status.canceled {
                        background-color: #f44336;
                        color: #fff;
                }

                .delete-btn {
                        background-color: #f44336;
                        color: #fff;
                        padding: 5px 10px;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 14px;
                        margin-top: 10px;
                        display: inline-block;
                        text-decoration: none;
                }

                .delete-btn:hover {
                        background-color: #d32f2f;
                }

                @media (max-width: 768px) {
                        h1 {
                                font-size: 24px;
                        }

                        .booking h2 {
                                font-size: 20px;
                        }

                        .booking p {
                                font-size: 12px;
                        }
                }
        </style>
</head>

<body>
        <h1>Lịch sử đặt vé</h1>

        <?php if (empty($bookings)): ?>
                <p>Bạn chưa có lịch sử đặt vé nào.</p>
        <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                        <div class="booking">
                                <h2>Đặt vé #<?php echo htmlspecialchars($booking['booking_id']); ?></h2>
                                <p><strong>Phim:</strong> <?php echo htmlspecialchars($booking['movie_title']); ?></p>
                                <p><strong>Rạp:</strong> <?php echo htmlspecialchars($booking['theater_name']); ?></p>
                                <p><strong>Phòng:</strong> <?php echo htmlspecialchars($booking['room_name']); ?></p>
                                <p><strong>Ngày chiếu:</strong> <?php echo date('d/m/Y', strtotime($booking['start_time'])); ?></p>
                                <p><strong>Giờ chiếu:</strong> <?php echo date('H:i', strtotime($booking['start_time'])); ?></p>
                                <p><strong>Số ghế đã đặt:</strong> <?php echo htmlspecialchars($booking['seats']); ?></p>
                                <p><strong>Tổng tiền:</strong> <?php echo number_format($booking['total_price'], 0, ',', '.'); ?> VND</p>
                                <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($booking['booking_time'])); ?></p>
                                <p><strong>Trạng thái:</strong>
                                        <span class="status <?php echo htmlspecialchars($booking['booking_status']); ?>">
                                                <?php echo htmlspecialchars(ucfirst($booking['booking_status'])); ?>
                                        </span>
                                </p>
                                <a href="user.php?controller=booking&action=deleteBooking&booking_id=<?php echo $booking['booking_id']; ?>"
                                        class="delete-btn"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa đặt vé #<?php echo $booking['booking_id']; ?> không?');">
                                        Xóa
                                </a>
                        </div>
                <?php endforeach; ?>
        <?php endif; ?>
</body>

</html>