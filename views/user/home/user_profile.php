<!DOCTYPE html>
<html>

<head>
        <title>Thông tin người dùng</title>
        <style>
                /* Định dạng chung */
                body {
                        background-color: #121212;
                        color: #fff;
                        font-family: Arial, sans-serif;
                        padding: 20px;
                }

                /* Tiêu đề chính */
                h1 {
                        font-size: 28px;
                        font-weight: bold;
                        color: #fdd835;
                        text-align: center;
                        margin-bottom: 20px;
                }

                /* Container thông tin người dùng */
                .user-info {
                        background: #1a1a1a;
                        padding: 20px;
                        border-radius: 10px;
                        margin-bottom: 20px;
                        box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
                        text-align: center;
                }

                .user-info img {
                        width: 100px;
                        height: 100px;
                        border-radius: 50%;
                        margin-bottom: 15px;
                }

                .user-info p {
                        font-size: 16px;
                        color: #bbb;
                        margin: 5px 0;
                }

                /* Tiêu đề lịch sử đặt vé */
                h2 {
                        font-size: 24px;
                        font-weight: bold;
                        color: #fdd835;
                        margin-bottom: 15px;
                }

                /* Thông báo không có lịch sử */
                p {
                        font-size: 16px;
                        color: #ddd;
                        text-align: center;
                }

                /* Container đặt vé */
                .booking {
                        background: #1a1a1a;
                        padding: 20px;
                        border-radius: 10px;
                        margin-bottom: 20px;
                        box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
                }

                .booking h3 {
                        font-size: 20px;
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

                .booking .status.cancelled {
                        background-color: #f44336;
                        color: #fff;
                }

                /* Responsive */
                @media (max-width: 768px) {
                        h1 {
                                font-size: 24px;
                        }

                        h2 {
                                font-size: 20px;
                        }

                        .user-info p {
                                font-size: 14px;
                        }

                        .booking h3 {
                                font-size: 18px;
                        }

                        .booking p {
                                font-size: 12px;
                        }
                }
        </style>
</head>

<body>
        <h1>Thông tin người dùng</h1>

        <!-- Thông tin người dùng -->
        <div class="user-info">
                <?php if ($user['image'] && file_exists($user['image'])): ?>
                        <img src="<?php echo htmlspecialchars($user['image']); ?>" alt="Ảnh đại diện">
                <?php else: ?>
                        <img src="public/images/default_user.png" alt="Ảnh đại diện mặc định">
                <?php endif; ?>
                <p><strong>Tên người dùng:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?>
                </p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['address'] ?? 'Chưa cập nhật'); ?></p>
                <p><strong>Vai trò:</strong> <?php echo htmlspecialchars(ucfirst($user['role'])); ?></p>
                <p><strong>Ngày tạo tài khoản:</strong> <?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?>
                </p>
        </div>

        <!-- Lịch sử đặt vé -->
        <h2>Lịch sử đặt vé</h2>
        <?php if (empty($bookings)): ?>
                <p>Bạn chưa có lịch sử đặt vé nào.</p>
        <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                        <div class="booking">
                                <h3>Đặt vé #<?php echo htmlspecialchars($booking['booking_id']); ?></h3>
                                <p><strong>Phim:</strong> <?php echo htmlspecialchars($booking['movie_title']); ?></p>
                                <p><strong>Rạp:</strong> <?php echo htmlspecialchars($booking['theater_name']); ?></p>
                                <p><strong>Phòng:</strong> <?php echo htmlspecialchars($booking['room_name']); ?></p>
                                <p><strong>Ngày chiếu:</strong> <?php echo date('d/m/Y', strtotime($booking['start_time'])); ?></p>
                                <p><strong>Giờ chiếu:</strong> <?php echo date('H:i', strtotime($booking['start_time'])); ?></p>
                                <p><strong>Ghế:</strong> <?php echo htmlspecialchars($booking['seats']); ?></p>
                                <p><strong>Tổng tiền:</strong> <?php echo number_format($booking['total_price'], 0); ?> VND</p>
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