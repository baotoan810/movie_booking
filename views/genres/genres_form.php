<!-- Content -->
<div class="content">
     <div class="nav-content">
          <button class="menu-toggle">☰</button>
          <div class="admin-info">
               <p>Xin chào, Admin</p>
          </div>
     </div>

     <!-- Form thêm/sửa người dùng -->
     <div class="content-section">
          <h1><?php echo $genre ? 'Sửa Thể Loại' : 'Thêm Thể Loại'; ?></h1>
          <form action="index.php?controller=genres&action=save" method="POST" enctype="multipart/form-data"
               class="user-form">
               <?php if ($genre): ?>
                    <input type="hidden" name="id" value="<?php echo $genre['id']; ?>">
               <?php endif; ?>
               <div class="form-group">
                    <label>Tên Thể Loại:</label>
                    <input type="text" name="name" value="<?php echo $genre['name'] ?? ''; ?>">
               </div>



               <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>
          </form>
          <a href="index.php?controller=genres&action=index" class="btn-back"><i class="fas fa-arrow-left"></i> Quay
               Lại</a>
     </div>
</div>


<style>
     .content-section {
          height: 572px;
          overflow-y: auto;
     }
</style>