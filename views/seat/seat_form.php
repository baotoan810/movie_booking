<!-- Form thêm/sửa ghế -->
<div class="content-section section-form">
     <h1><?= isset($seat) ? 'Sửa Ghế' : 'Thêm Ghế'; ?></h1>

     <form action="index.php?controller=seat&action=save" method="POST" class="user-form">
          <?php if (!empty($seat)): ?>
               <input type="hidden" name="id" value="<?= htmlspecialchars($seat['id']); ?>">
          <?php endif; ?>

          <!-- Chọn Rạp Chiếu -->
          <div class="form-group">
               <label>Chọn Rạp</label>
               <select name="theater_id" id="theater_select" required>
                    <option value="">-- Chọn Rạp --</option>
                    <?php foreach ($allTheaters as $theater): ?>
                         <option value="<?= $theater['id']; ?>" data-capacity="<?= $theater['capacity']; ?>"
                              <?= (!empty($seat['theater_id']) && $seat['theater_id'] == $theater['id']) ? 'selected' : ''; ?>>
                              <?= htmlspecialchars($theater['name']); ?>
                         </option>
                    <?php endforeach; ?>
               </select>
          </div>

          <!-- Hiển thị tên rạp đã chọn -->
          <!-- <div class="form-group">
               <label>Tên Rạp:</label>
               <input type="text" id="selected_theater_name"
                    value="<?= isset($seat['theater_name']) ? htmlspecialchars($seat['theater_name']) : ''; ?>"
                    readonly>
          </div> -->

          <!-- Tổng Số Ghế của Rạp -->
          <div class="form-group">
               <label>Tổng Số Ghế của Rạp:</label>
               <input type="number" id="total_capacity" name="total_capacity" readonly
                    value="<?= isset($seat['capacity']) ? htmlspecialchars($seat['capacity']) : 0; ?>">
          </div>

          <!-- Nhập Số Hàng -->
          <div class="form-group">
               <label>Số Hàng Ghế:</label>
               <input type="number" id="row" name="row" placeholder="Nhập số hàng ghế..."
                    value="<?= isset($seat['row']) ? htmlspecialchars($seat['row']) : ''; ?>" required>
          </div>

          <!-- Nhập Số Cột -->
          <div class="form-group">
               <label>Số Cột Ghế:</label>
               <input type="number" id="column" name="column" placeholder="Nhập số cột ghế..."
                    value="<?= isset($seat['column']) ? htmlspecialchars($seat['column']) : ''; ?>" required>
          </div>

          <!-- Giá -->
          <div class="form-group">
               <label>Giá:</label>
               <input type="number" step="1000" name="price" placeholder="Nhập giá ghế..."
                    value="<?= isset($seat['price']) ? number_format($seat['price'], 0, '', '') : ''; ?>" required>
          </div>

          <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>

          <!-- Link quay lại -->
          <a href="index.php?controller=seat&action=index" class="btn-back">
               <i class="fas fa-arrow-left"></i> Quay Lại
          </a>
     </form>
</div>

<!-- Script cập nhật số ghế & tên rạp -->
<script>
     document.addEventListener("DOMContentLoaded", function () {
          let theaterSelect = document.getElementById("theater_select");
          let totalCapacityInput = document.getElementById("total_capacity");
          let selectedTheaterName = document.getElementById("selected_theater_name");
          let rowInput = document.getElementById("row");
          let columnInput = document.getElementById("column");

          // Khi thay đổi rạp, cập nhật tổng số ghế và tên rạp
          theaterSelect.addEventListener("change", function () {
               let selectedOption = theaterSelect.options[theaterSelect.selectedIndex];
               let capacity = selectedOption.getAttribute("data-capacity") || 0;
               let theaterName = selectedOption.textContent.trim(); // Lấy tên rạp từ option

               totalCapacityInput.value = capacity;
               selectedTheaterName.value = theaterName;
          });

          // Gọi sự kiện change ban đầu để load dữ liệu nếu có sẵn
          theaterSelect.dispatchEvent(new Event("change"));

          // Kiểm tra số hàng * số cột không vượt quá tổng số ghế
          function validateSeats() {
               let rowCount = parseInt(rowInput.value) || 0;
               let columnCount = parseInt(columnInput.value) || 0;
               let totalCapacity = parseInt(totalCapacityInput.value) || 0;

               if (rowCount * columnCount > totalCapacity) {
                    alert('Số hàng * số cột không được vượt quá tổng số ghế của rạp!');
                    rowInput.value = '';
                    columnInput.value = '';
               }
          }

          rowInput.addEventListener('input', validateSeats);
          columnInput.addEventListener('input', validateSeats);
     });
</script>