<!-- Form thêm/sửa Thể Loại -->
<div class="content-section section-form">

     <h1><?php echo $genre ? 'Sửa Thể Loại' : 'Thêm Thể Loại'; ?></h1>


     <form action="admin.php?controller=genres&action=save" method="POST" enctype="multipart/form-data"
          class="user-form">
          <?php if ($genre): ?>
               <input type="hidden" name="id" value="<?php echo $genre['id']; ?>">
          <?php endif; ?>
          <div class="form-group">
               <label>Tên Thể Loại:</label>
               <input type="text" name="name" value="<?php echo $genre['name'] ?? ''; ?>"
                    placeholder="Nhập tên thể loại" required>
          </div>

          <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>
          <a href="admin.php?controller=genres&action=index" class="btn-back"><i class="fas fa-arrow-left"></i> Quay
               Lại</a>
     </form>
</div>