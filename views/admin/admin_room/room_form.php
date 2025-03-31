<!-- Form thêm/sửa phòng -->
<div class="content-section section-form">
     <h1><?= $room ? 'Sửa Phòng' : 'Thêm Phòng'; ?></h1>

     <form action="admin.php?controller=room&action=save" method="POST" enctype="multipart/form-data" class="user-form"
          onsubmit="return validateForm()">
          <?php if (!empty($room)): ?>
               <input type="hidden" name="id" value="<?= htmlspecialchars($room['id']); ?>">
          <?php endif; ?>

          <div class="form-group">
               <label>Rạp</label>
               <select name="theater_id" required>
                    <option value="">Chọn rạp...</option>
                    <?php foreach ($theaters as $theater): ?>
                         <option value="<?= $theater['id']; ?>" <?= ($room && $room['theater_id'] == $theater['id']) ? 'selected' : ''; ?>>
                              <?= htmlspecialchars($theater['name']); ?>
                         </option>
                    <?php endforeach; ?>
               </select>
          </div>

          <div class="form-group">
               <label>Tên Phòng</label>
               <input type="text" name="name" placeholder="Nhập tên phòng..."
                    value="<?= htmlspecialchars($room['name'] ?? ''); ?>" required>
          </div>

          <div class="form-group">
               <label>Sức Chứa</label>
               <input type="number" name="capacity" id="capacity" placeholder="Nhập sức chứa..."
                    value="<?= htmlspecialchars($room['capacity'] ?? ''); ?>" required>
          </div>

          <div class="form-group">
               <label>Số Hàng</label>
               <input type="number" name="rows" id="rows" placeholder="Nhập số hàng..."
                    value="<?= htmlspecialchars($room['rows'] ?? ''); ?>" required oninput="calculateCapacity()">
          </div>

          <div class="form-group">
               <label>Số Cột</label>
               <input type="number" name="columns" id="columns" placeholder="Nhập số cột..."
                    value="<?= htmlspecialchars($room['columns'] ?? ''); ?>" required oninput="calculateCapacity()">
          </div>

          <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>

          <!-- Link quay lại -->
          <a href="admin.php?controller=room&action=index" class="btn-back">
               <i class="fas fa-arrow-left"></i> Quay Lại
          </a>
     </form>
</div>

<script>
     function calculateCapacity() {
          const rows = parseInt(document.getElementById('rows').value) || 0;
          const columns = parseInt(document.getElementById('columns').value) || 0;
          const capacity = rows * columns;
          document.getElementById('capacity').value = capacity;
     }

     function validateForm() {
          const rows = parseInt(document.getElementById('rows').value) || 0;
          const columns = parseInt(document.getElementById('columns').value) || 0;
          const capacity = parseInt(document.getElementById('capacity').value) || 0;
          const expectedCapacity = rows * columns;

          if (capacity !== expectedCapacity) {
               alert(`Sức chứa (${capacity}) không khớp với số hàng × số cột (${rows} × ${columns} = ${expectedCapacity})!`);
               return false;
          }
          return true;
     }
</script>