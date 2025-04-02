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
                        box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
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
                                <p><strong>Số ghế đã đặt:</strong> <?php echo htmlspecialchars($booking['seat_count']); ?></p>
                                <p><strong>Tổng tiền:</strong> <?php echo number_format($booking['total_price'], 0, ',', '.'); ?> VND
                                </p>
                                <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($booking['booking_time'])); ?></p>
                                <p><strong>Trạng thái:</strong>
                                        <span class="status <?php echo htmlspecialchars($booking['booking_status']); ?>">
                                                <?php echo htmlspecialchars(ucfirst($booking['booking_status'])); ?>
                                        </span>
                                </p>
                        </div>
                <?php endforeach; ?>
        <?php endif; ?>
</body>

</html>