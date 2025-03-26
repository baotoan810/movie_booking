<div class="main-content">
     <!-- Tiêu đề hiển thị tên phòng và tên rạp -->
     <h1>Sơ đồ ghế - <?php echo htmlspecialchars($room['name']); ?>
          (<?php echo htmlspecialchars($room['theater_name']); ?>)</h1>

     <!-- Chú thích (legend) giải thích ý nghĩa màu sắc và trạng thái ghế -->
     <div class="legend">
          <h3>Chú thích:</h3>
          <div class="legend-items">
               <div class="legend-item">
                    <span class="seat normal available"></span> Ghế thường - Có thể sử dụng
               </div>
               <div class="legend-item">
                    <span class="seat vip available"></span> Ghế VIP - Có thể sử dụng
               </div>
               <div class="legend-item">
                    <span class="seat normal unavailable"></span> Ghế không khả dụng (hỏng hoặc chưa thêm)
               </div>
          </div>
     </div>

     <!-- CSS để định dạng giao diện sơ đồ ghế -->
     <style>
          h1 {
               font-size: 24px;
               color: #333;
               margin-bottom: 20px;
          }

          .legend {
               margin-bottom: 30px;
          }

          .legend h3 {
               font-size: 18px;
               color: #555;
               margin-bottom: 10px;
          }

          .legend-items {
               display: flex;
               gap: 20px;
               flex-wrap: wrap;
          }

          .legend-item {
               display: flex;
               align-items: center;
               gap: 8px;
               font-size: 14px;
               color: #666;
          }

          .seat {
               width: 50px;
               height: 50px;
               margin: 5px;
               display: inline-block;
               text-align: center;
               line-height: 50px;
               border: 2px solid #ddd;
               border-radius: 5px;
               font-size: 14px;
               font-weight: bold;
               transition: transform 0.2s ease, box-shadow 0.2s ease;
               cursor: pointer;
          }

          .seat:hover {
               transform: scale(1.1);
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
          }

          .normal.available {
               background: #28a745;
               color: white;
               border-color: #218838;
          }

          .vip.available {
               background: #ffc107;
               color: black;
               border-color: #e0a800;
          }

          .normal.unavailable,
          .vip.unavailable {
               background: #ffff;
               color: white;
               border-color: #5a6268;
          }

          .seat-map {
               text-align: center;
               margin: 0 auto;
               max-width: 100%;
               overflow-x: auto;
               padding: 20px;
               background: #f8f9fa;
               border-radius: 10px;
               box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          }

          .btn-back,
          .btn-save,
          .btn-delete {
               display: inline-block;
               margin: 10px 5px;
               padding: 10px 20px;
               text-decoration: none;
               border-radius: 5px;
               transition: background 0.3s ease;
          }

          .btn-back {
               background: #6c757d;
               color: white;
          }

          .btn-back:hover {
               background: #5a6268;
          }

          .btn-save {
               background: #28a745;
               color: white;
               border: none;
               cursor: pointer;
          }

          .btn-save:hover {
               background: #218838;
          }

          .btn-delete {
               background: #dc3545;
               color: white;
               border: none;
               cursor: pointer;
          }

          .btn-delete:hover {
               background: #c82333;
          }

          .seat-form {
               display: none;
               position: fixed;
               top: 50%;
               left: 50%;
               transform: translate(-50%, -50%);
               background: white;
               padding: 20px;
               border-radius: 10px;
               box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
               z-index: 1000;
          }

          .seat-form h3 {
               margin-top: 0;
               font-size: 18px;
               color: #333;
          }

          .seat-form label {
               display: block;
               margin: 10px 0 5px;
               font-weight: bold;
          }

          .seat-form select,
          .seat-form input {
               width: 100%;
               padding: 8px;
               margin-bottom: 10px;
               border: 1px solid #ddd;
               border-radius: 5px;
          }

          .overlay {
               display: none;
               position: fixed;
               top: 0;
               left: 0;
               width: 100%;
               height: 100%;
               background: rgba(0, 0, 0, 0.5);
               z-index: 999;
          }
     </style>

     <!-- Container chứa sơ đồ ghế -->
     <div class="seat-map">
          <?php
          for ($r = 1; $r <= $room['rows']; $r++) {
               for ($c = 1; $c <= $room['columns']; $c++) {
                    $seat = $seatMap[$r][$c] ?? null;
                    if ($seat) {
                         $class = $seat['type_seat'] . ' ' . $seat['status'];
                         $label = "R{$r}C{$c}";
                         echo "
                         <div class='seat $class'
                         data-seat-id='{$seat['id']}' 
                         data-type='{$seat['type_seat']}' 
                         data-status='{$seat['status']}' 
                         data-price='{$seat['price']}' 
                         data-row='$r' data-column='$c' 
                         onclick='showSeatForm(this, false)'>$label
                         </div>";
                    } else {
                         $class = 'unavailable';
                         $label = 'X';
                         echo "<div 
                         class='seat $class' 
                         data-row='$r' 
                         data-column='$c' 
                         onclick='showSeatForm(this, true)'>$label
                         </div>";
                    }
               }
               echo "<br>";
          }
          ?>
     </div>

     <!-- Overlay và form chỉnh sửa/thêm ghế -->
     <div class="overlay" id="overlay"></div>
     <div class="seat-form" id="seatForm">
          <h3 id="formTitle">Chỉnh sửa ghế <span id="seatLabel"></span></h3>
          <form id="seatFormAction" method="POST">
               <input type="hidden" name="seat_id" id="seatId">
               <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
               <input type="hidden" name="row" id="seatRow">
               <input type="hidden" name="column" id="seatColumn">
               <label>Loại ghế:</label>
               <select name="type_seat" id="typeSeat">
                    <option value="normal">Ghế thường</option>
                    <option value="vip">Ghế VIP</option>
               </select>
               <label>Trạng thái:</label>
               <select name="status" id="seatStatus">
                    <option value="available">Có thể sử dụng</option>
                    <option value="unavailable">Không khả dụng</option>
               </select>
               <label>Giá (VNĐ):</label>
               <input type="number" name="price" id="seatPrice" step="1000" min="0">
               <button type="submit" class="btn-save">Lưu</button>
               <button type="button" id="deleteButton" class="btn-delete" onclick="deleteSeat()">Xóa ghế</button>
               <button type="button" class="btn-back" onclick="closeSeatForm()">Đóng</button>
          </form>
     </div>

     <!-- Nút quay lại danh sách phòng -->
     <a href="index.php?controller=room&action=index" class="btn-back">
          <i class="fas fa-arrow-left"></i> Quay Lại
     </a>

     <script>
          // Đảm bảo DOM đã tải xong trước khi chạy JavaScript
          document.addEventListener('DOMContentLoaded', function () {
               function showSeatForm(element, isAddMode) {
                    console.log("showSeatForm called", element, isAddMode);

                    const seatId = element.getAttribute('data-seat-id');
                    const row = element.getAttribute('data-row');
                    const column = element.getAttribute('data-column');
                    const label = element.innerText;

                    console.log("Seat data:", { seatId, row, column, label });

                    const form = document.getElementById('seatFormAction');
                    const formTitle = document.getElementById('formTitle');
                    const seatIdInput = document.getElementById('seatId');
                    const seatRowInput = document.getElementById('seatRow');
                    const seatColumnInput = document.getElementById('seatColumn');
                    const typeSeat = document.getElementById('typeSeat');
                    const seatStatus = document.getElementById('seatStatus');
                    const seatPrice = document.getElementById('seatPrice');
                    const deleteButton = document.getElementById('deleteButton');
                    const seatLabel = document.getElementById('seatLabel');

                    if (!form || !formTitle || !seatIdInput || !seatRowInput || !seatColumnInput || !typeSeat || !seatStatus || !seatPrice || !deleteButton || !seatLabel) {
                         console.error("One or more form elements not found!");
                         return;
                    }

                    if (isAddMode) {
                         form.action = 'index.php?controller=room&action=addSeat';
                         formTitle.innerText = `Thêm ghế ${label}`;
                         seatIdInput.value = '';
                         seatRowInput.value = row;
                         seatColumnInput.value = column;
                         typeSeat.value = 'normal';
                         seatStatus.value = 'available';
                         seatPrice.value = 50000;
                         deleteButton.style.display = 'none';
                    } else {
                         form.action = 'index.php?controller=room&action=updateSeat';
                         formTitle.innerText = `Chỉnh sửa ghế ${label}`;
                         seatIdInput.value = seatId;
                         seatRowInput.value = row;
                         seatColumnInput.value = column;
                         typeSeat.value = element.getAttribute('data-type');
                         seatStatus.value = element.getAttribute('data-status');
                         seatPrice.value = element.getAttribute('data-price');
                         deleteButton.style.display = 'inline-block';
                    }

                    seatLabel.innerText = label;

                    const overlay = document.getElementById('overlay');
                    const seatForm = document.getElementById('seatForm');

                    if (!overlay || !seatForm) {
                         console.error("Overlay or seatForm not found!");
                         return;
                    }

                    overlay.style.display = 'block';
                    seatForm.style.display = 'block';
               }

               function closeSeatForm() {
                    console.log("closeSeatForm called");
                    const overlay = document.getElementById('overlay');
                    const seatForm = document.getElementById('seatForm');
                    if (overlay && seatForm) {
                         overlay.style.display = 'none';
                         seatForm.style.display = 'none';
                    } else {
                         console.error("Overlay or seatForm not found!");
                    }
               }

               function deleteSeat() {
                    console.log("deleteSeat called");
                    if (!confirm('Bạn có chắc chắn muốn xóa ghế này?')) return;

                    const seatId = document.getElementById('seatId').value;
                    const roomId = <?php echo $room['id']; ?>;

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'index.php?controller=room&action=deleteSeat';

                    const seatInput = document.createElement('input');
                    seatInput.type = 'hidden';
                    seatInput.name = 'seat_id';
                    seatInput.value = seatId;

                    const roomInput = document.createElement('input');
                    roomInput.type = 'hidden';
                    roomInput.name = 'room_id';
                    roomInput.value = roomId;

                    form.appendChild(seatInput);
                    form.appendChild(roomInput);
                    document.body.appendChild(form);
                    form.submit();
               }

               // Gắn hàm showSeatForm vào window để đảm bảo có thể gọi từ HTML
               window.showSeatForm = showSeatForm;
               window.closeSeatForm = closeSeatForm;
               window.deleteSeat = deleteSeat;
          });
     </script>
</div>