<!DOCTYPE html>
<html>
<head>
    <title>Chọn ghế - <?php echo htmlspecialchars($selectedShowtime['title']); ?></title>
    <style>
        .seat-grid {
            display: grid;
            gap: 10px;
            margin: 20px 0;
            justify-content: center;
        }
        .seat {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ccc;
            cursor: pointer;
            font-size: 12px;
            position: relative;
        }
        .seat.normal.available {
            background-color: #28a745; /* Ghế thường - Có thể sử dụng: xanh lá */
        }
        .seat.vip.available {
            background-color: #ffc107; /* Ghế VIP - Có thể sử dụng: vàng */
        }
        .seat.booked {
            background-color: #ffffff; /* Ghế không khả dụng: trắng */
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
        .seat input[type="checkbox"]:checked + span {
            background-color: #007bff; /* Ghế đang chọn: xanh dương */
        }
        .screen {
            width: 100%;
            height: 20px;
            background-color: #333;
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }
        .legend {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
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
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        /* CSS cho modal xác nhận */
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
        .modal-content .confirm-btn {
            background-color: #28a745;
            color: #fff;
        }
        .modal-content .cancel-btn {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Sơ đồ ghế - Phòng <?php echo htmlspecialchars($selectedShowtime['room_name']); ?> (<?php echo htmlspecialchars($selectedShowtime['theater_name']); ?>)</h1>

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

    <form id="bookingForm" method="post" action="index.php?controller=booking&action=payment">
        <input type="hidden" name="showtime_id" value="<?php echo $selectedShowtime['id']; ?>">

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
                        ?>
                        <label class="seat <?php echo $seatClass; ?>">
                            <input type="checkbox" name="seats[]" value="<?php echo $seat['id']; ?>"
                                <?php echo $isBooked ? 'disabled' : ''; ?>
                                data-price="<?php echo $seat['price']; ?>">
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

        <p style="text-align: center;">Tổng tiền: <input type="number" name="total_price" id="total_price" value="0" readonly> VND</p>
        <div style="text-align: center;">
            <button type="button" id="submitBtn">Thanh toán</button>
            <a href="index.php?controller=booking&action=selectTheaterAndRoom&movie_id=<?php echo htmlspecialchars($_POST['movie_id']); ?>&date=<?php echo htmlspecialchars($_POST['date']); ?>" class="back-btn">Quay lại</a>
        </div>
    </form>

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
        const submitBtn = document.getElementById('submitBtn');
        const confirmModal = document.getElementById('confirmModal');
        const confirmBtn = document.getElementById('confirmBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const modalTotalPrice = document.getElementById('modalTotalPrice');
        const bookingForm = document.getElementById('bookingForm');

        // Tính tổng tiền khi chọn ghế
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                let total = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        total += parseFloat(cb.getAttribute('data-price'));
                    }
                });
                totalPriceInput.value = total;
            });
        });

        // Hiển thị modal xác nhận khi nhấn "Thanh toán"
        submitBtn.addEventListener('click', () => {
            const totalPrice = totalPriceInput.value;
            if (totalPrice <= 0) {
                alert('Vui lòng chọn ít nhất một ghế để thanh toán.');
                return;
            }
            modalTotalPrice.textContent = totalPrice;
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
    </script>
</body>
</html>