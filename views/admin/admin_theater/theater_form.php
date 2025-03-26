<!-- Form thêm/sửa phim -->
<div class="content-section section-form">
     <h1><?= $theater ? 'Sửa Rạp' : 'Thêm Rạp'; ?></h1>

     <form action="index.php?controller=theater&action=save" method="POST" enctype="multipart/form-data"
          class="user-form">
          <?php if (!empty($theater)): ?>
               <input type="hidden" name="id" value="<?= htmlspecialchars($theater['id']); ?>">
          <?php endif; ?>
          <div class="form-group">
               <label>Tên Rạp</label>
               <input type="text" name="name" placeholder="Nhập tên rạp..."
                    value="<?= htmlspecialchars($theater['name'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
               <label>Địa Chỉ</label>
               <input type="text" name="address" placeholder="Nhập địa chỉ..."
                    value="<?= htmlspecialchars($theater['address'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
               <label>Sức Chứa</label>
               <input min="50" max="100" type="number" name="capacity" placeholder="Nhập số lượng..."
                    value="<?= htmlspecialchars($theater['capacity'] ?? ''); ?>" required>
          </div>



          <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>

          <!-- Link quay lại -->
          <a href="index.php?controller=theater&action=index" class="btn-back">
               <i class="fas fa-arrow-left"></i> Quay Lại
          </a>
     </form>
</div>