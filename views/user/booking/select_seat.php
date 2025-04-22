<!DOCTYPE html>
<html>

<head>
    <title>Chọn ghế - <?php echo htmlspecialchars($selectedShowtime['title']); ?></title>
    <style>
        /* Reset mặc định */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Container chính */
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        /* Sơ đồ ghế */
        .seat-section {
            flex: 1;
            min-width: 300px;
        }

        .seat-grid {
            display: grid;
            gap: 10px;
            margin: 20px 0;
            justify-content: center;
        }

        .seat {
            width: 40px;
            height: center;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ccc;
            cursor: pointer;
            font-size: 12px;
            position: relative;
        }

        .seat.normal.available {
            background-color: #28a745;
            /* Ghế thường - Có thể sử dụng: xanh lá */
        }

        .seat.vip.available {
            background-color: #ffc107;
            /* Ghế VIP - Có thể sử dụng: vàng */
        }

        .seat.booked {
            background-color: #ffffff;
            /* Ghế không khả dụng: trắng */
            border: 1px solid #ccc;
            cursor: not-allowed;
        }

        .seat.booked::after {
            content: 'X';
            position: absolute;
            color: red;
            font-size: 16px;
            font-weight: bold;
        }

        .seat input[type="checkbox"] {
            display: none;
        }

        .seat input[type="checkbox"]:checked+span {
            background-color: #007bff;
            /* Ghế đang chọn: xanh dương */
        }

        .screen {
            width: 100%;
            height: 50px;
            line-height: 50px;
            background-color: #333;
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }

        .legend {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            justify-content: center;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .legend-box {
            width: 20px;
            height: 20px;
        }

        /* Hóa đơn */
        /* Hóa đơn */
        .invoice-section {
            flex: 1;
            min-width: 300px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #dee2e6;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .invoice-section:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .invoice-section h3 {
            margin-bottom: 20px;
            font-size: 1.4rem;
            color: #343a40;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
            position: relative;
        }

        .invoice-section h3:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background: #28a745;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #ced4da;
        }

        .invoice-label {
            font-weight: 600;
            color: #495057;
            min-width: 100px;
        }

        .invoice-value {
            color: #212529;
            text-align: right;
            flex: 1;
        }

        .invoice-total {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px solid #007bff;
            font-size: 1.1rem;
        }

        .invoice-total .invoice-label {
            font-weight: 700;
            color: #343a40;
        }

        .invoice-total .invoice-value {
            font-weight: 700;
            color: #dc3545;
            font-size: 1.2rem;
        }

        /* Animation cho giá trị thay đổi */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .invoice-value.updated {
            animation: pulse 0.5s ease;
        }

        /* Nút */
        .button-group {
            text-align: center;
            margin-top: 20px;
        }

        .submit-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
            font-size: 1rem;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        /* Modal xác nhận */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius: 5px;
        }

        .modal-content button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content h2 {
            color: #333;
        }

        .modal-content .confirm-btn {
            background-color: #28a745;
            color: #fff;
        }

        .modal-content .cancel-btn {
            background-color: #dc3545;
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .seat-section,
            .invoice-section {
                width: 100%;
                max-width: 400px;
            }

            .seat-grid {
                gap: 5px;
            }

            .seat {
                width: 35px;
                height: 35px;
                font-size: 10px;
            }

            .legend {
                flex-wrap: wrap;
                gap: 10px;
            }

            .invoice-section p {
                font-size: 0.9rem;
            }

            .invoice-section p strong {
                width: 80px;
            }
        }
    </style>
</head>

<body>
    <h1>Sơ đồ ghế - Phòng <?php echo htmlspecialchars($selectedShowtime['room_name']); ?> (<?php echo htmlspecialchars($selectedShowtime['theater_name']); ?>)</h1>

    <!-- Chú thích trạng thái ghế -->
    <div class="legend">
        <div class="legend-item">
            <div class="legend-box" style="background-color: #28a745;"></div>
            <span>Ghế thường - Có thể sử dụng</span>
        </div>
        <div class="legend-item">
            <div class="legend-box" style="background-color: #ffc107;"></div>
            <span>Ghế VIP - Có thể sử dụng</span>
        </div>
        <div class="legend-item">
            <div class="legend-box" style="background-color: #ffffff; border: 1px solid #ccc;"></div>
            <span>Ghế không khả dụng</span>
        </div>
    </div>

    <div class="container">
        <!-- Sơ đồ ghế -->
        <div class="seat-section">
            <form id="bookingForm" method="post" action="user.php?controller=booking&action=payment">
                <input type="hidden" name="showtime_id" value="<?php echo $selectedShowtime['id']; ?>">
                <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($_POST['movie_id']); ?>">
                <input type="hidden" name="date" value="<?php echo htmlspecialchars($_POST['date']); ?>">
                <input type="hidden" name="total_price" id="total_price" value="0">

                <div class="screen">Màn hình</div>

                <div class="seat-grid" style="grid-template-columns: repeat(<?php echo $room['columns']; ?>, 40px);">
                    <?php
                    for ($row = 1; $row <= $room['rows']; $row++) {
                        for ($col = 1; $col <= $room['columns']; $col++) {
                            if (isset($seatMap[$row][$col])) {
                                $seat = $seatMap[$row][$col];
                                $isBooked = $seat['showtime_status'] === 'booked';
                                $seatType = $seat['type_seat'] ?? 'normal';
                                $seatClass = $isBooked ? 'booked' : ($seatType . ' available');

                                // Tính giá ghế dựa trên showtime price và type_seat
                                // $seatPrice = $selectedShowtime['price'] * ($seatType === 'vip' ? 1.1 : 1);

                                $basePrice = floatval($selectedShowtime['price']); // Đảm bảo giá cơ bản là số
                                $seatPrice = $basePrice; // Giá cơ bản cho ghế thường
                                if ($seatType === 'vip') {
                                    $seatPrice += 10000; // Tăng thêm 10,000 VND cho ghế VIP
                                }
                    ?>
                                <label class="seat <?php echo $seatClass; ?>">
                                    <input type="checkbox" name="seats[]" value="<?php echo $seat['id']; ?>"
                                        <?php echo $isBooked ? 'disabled' : ''; ?>
                                        data-price="<?php echo $seatPrice; ?>">
                                    <span><?php echo 'R' . $row . 'C' . $col; ?></span>
                                </label>
                    <?php
                            } else {
                                echo '<div class="seat" style="visibility: hidden;"></div>';
                            }
                        }
                    }
                    ?>
                </div>
            </form>
        </div>

        <!-- Hóa đơn -->
        <div class="invoice-section">
            <h3>Hóa đơn</h3>
            <div class="invoice-details">
                <div class="invoice-item">
                    <span class="invoice-label">Phim:</span>
                    <span class="invoice-value"><?php echo htmlspecialchars($selectedShowtime['title']); ?></span>
                </div>
                <div class="invoice-item">
                    <span class="invoice-label">Rạp:</span>
                    <span class="invoice-value"><?php echo htmlspecialchars($selectedShowtime['theater_name']); ?></span>
                </div>
                <div class="invoice-item">
                    <span class="invoice-label">Phòng:</span>
                    <span class="invoice-value"><?php echo htmlspecialchars($selectedShowtime['room_name']); ?></span>
                </div>
                <div class="invoice-item">
                    <span class="invoice-label">Ngày:</span>
                    <span class="invoice-value"><?php echo date('d/m/Y', strtotime($selectedShowtime['start_time'])); ?></span>
                </div>
                <div class="invoice-item">
                    <span class="invoice-label">Giờ:</span>
                    <span class="invoice-value">
                        <?php echo date('H:i', strtotime($selectedShowtime['start_time'])); ?> -
                        <?php echo date('H:i', strtotime($selectedShowtime['end_time'])); ?>
                    </span>
                </div>
                <div class="invoice-item">
                    <span class="invoice-label">Ghế:</span>
                    <span class="invoice-value" id="selectedSeats">Chưa chọn ghế</span>
                </div>
            </div>
            <div class="invoice-item invoice-total">
                <span class="invoice-label">Tổng tiền:</span>
                <span class="invoice-value" id="totalPriceDisplay">0 VND</span>
            </div>

            <div class="button-group">
                <button type="button" class="submit-btn" id="submitBtn">Thanh toán</button>
                <a href="user.php?controller=booking&action=selectTheaterAndRoom&movie_id=<?php echo htmlspecialchars($_POST['movie_id']); ?>&date=<?php echo htmlspecialchars($_POST['date']); ?>" class="back-btn">Quay lại</a>
            </div>
        </div>
    </div>

    <!-- Modal xác nhận -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <h2>Xác nhận thanh toán</h2>
            <p>Bạn có chắc chắn muốn thanh toán với tổng số tiền: <span id="modalTotalPrice">0</span> VND?</p>
            <button class="confirm-btn" id="confirmBtn">Xác nhận</button>
            <button class="cancel-btn" id="cancelBtn">Hủy</button>
        </div>
    </div>

    <script>
        const checkboxes = document.querySelectorAll('input[name="seats[]"]');
        const totalPriceInput = document.getElementById('total_price');
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');
        const selectedSeatsDisplay = document.getElementById('selectedSeats');
        const submitBtn = document.getElementById('submitBtn');
        const confirmModal = document.getElementById('confirmModal');
        const confirmBtn = document.getElementById('confirmBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const modalTotalPrice = document.getElementById('modalTotalPrice');
        const bookingForm = document.getElementById('bookingForm');

        // Cập nhật hóa đơn khi chọn ghế
        function updateInvoice() {
            let total = 0;
            const selectedSeats = [];

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const price = parseFloat(cb.getAttribute('data-price')) || 0;
                    total += price;
                    const seatLabel = cb.nextElementSibling.textContent; // Lấy nhãn ghế (R1C1, R1C2, v.v.)
                    selectedSeats.push(seatLabel);
                }
            });

            // Cập nhật tổng tiền
            totalPriceInput.value = total;
            totalPriceDisplay.textContent = total.toLocaleString('vi-VN');

            // Cập nhật danh sách ghế
            selectedSeatsDisplay.textContent = selectedSeats.length > 0 ? selectedSeats.join(', ') : 'Chưa chọn ghế';
        }

        // Tính tổng tiền và cập nhật hóa đơn khi chọn ghế
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateInvoice);
        });

        // Hiển thị modal xác nhận khi nhấn "Thanh toán"
        submitBtn.addEventListener('click', () => {
            const totalPrice = parseFloat(totalPriceInput.value);
            if (totalPrice <= 0) {
                alert('Vui lòng chọn ít nhất một ghế để thanh toán.');
                return;
            }
            modalTotalPrice.textContent = totalPrice.toLocaleString('vi-VN');
            confirmModal.style.display = 'block';
        });

        // Xác nhận thanh toán
        confirmBtn.addEventListener('click', () => {
            bookingForm.submit();
        });

        // Hủy thanh toán
        cancelBtn.addEventListener('click', () => {
            confirmModal.style.display = 'none';
        });

        // Cập nhật hóa đơn lần đầu khi tải trang
        updateInvoice();
    </script>
</body>

</html>