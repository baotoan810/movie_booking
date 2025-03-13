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
          <h1><?php echo $theater ? 'Sửa Rạp' : 'Thêm Rạp'; ?></h1>
          <form action="index.php?controller=theater&action=save" method="POST" enctype="multipart/form-data"
               class="user-form">
               <?php if ($theater): ?>
                    <input type="hidden" name="id" value="<?php echo $theater['id']; ?>">
               <?php endif; ?>
               <div class="form-group">
                    <label>Tên Rạp:</label>
                    <input type="text" name="name" value="<?php echo $theater['name'] ?? ''; ?>">
               </div>
               <div class="form-group">
                    <label>Địa Chỉ:</label>
                    <input type="text" name="address" value="<?php echo $theater['address'] ?? ''; ?>">
               </div>
               <div class="form-group">
                    <label>Số Lượng Ghế:</label>
                    <input type="number" name="capacity" value="<?php echo $theater['capacity'] ?? ''; ?>">
               </div>

               <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>
          </form>
          <a href="index.php?controller=theater&action=index" class="btn-back"><i class="fas fa-arrow-left"></i> Quay
               Lại</a>
     </div>
</div>


<style>
     .content-section {
          height: 572px;
          overflow-y: auto;
     }
</style>