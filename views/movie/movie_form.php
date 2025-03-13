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
          <h1><?php echo $movie ? 'Sửa Phim' : 'Thêm Phim'; ?></h1>
          <form action="index.php?controller=movie&action=save" method="POST" enctype="multipart/form-data"
               class="user-form">
               <?php if ($movie): ?>
                    <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
               <?php endif; ?>
               <div class="form-group">
                    <label>Tên Phim:</label>
                    <input type="text" name="title" value="<?php echo $movie['title'] ?? ''; ?>">
               </div>
               <div class="form-group">
                    <label>Mô tả:</label>
                    <input type="text" name="description" value="<?php echo $movie['description'] ?? ''; ?>">
               </div>
               <div class="form-group">
                    <label>Thời lượng:</label>
                    <input type="number" name="duration" value="<?php echo $movie['duration'] ?? ''; ?>">
               </div>
               <div class="form-group">
                    <label>Ngày phát hành:</label>
                    <input type="date" name="release_date" value="<?php echo $movie['release_date'] ?? ''; ?>">
               </div>

               <!-- <div class="form-group">
                    <label>Hình Ảnh Hiện Tại:</label>
                    <?php if ($movie && $movie['image'] && file_exists($movie['image'])): ?>
                         <img src="<?php echo $movie['image']; ?>" alt="Hình ảnh của <?php echo $movie['username']; ?>"
                              class="user-image-preview">
                    <?php else: ?>
                         <span>Không có ảnh</span>
                    <?php endif; ?>
               </div> -->
               <div class="form-group">
                    <label>Upload Hình Ảnh Mới:</label>
                    <input type="file" name="trailer_path">
               </div>
               <div class="form-group">
                    <label>Lượt xem:</label>
                    <input type="text" name="view" value="<?php echo $movie['view'] ?? ''; ?>">
               </div>
               <div class="form-group">
                    <label>Ngày:</label>
                    <input type="datetime-local" name="created_at" value="<?php echo $movie['created_at'] ?? ''; ?>">
               </div>
               <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>
          </form>
          <a href="index.php?controller=movie&action=index" class="btn-back"><i class="fas fa-arrow-left"></i> Quay
               Lại</a>
     </div>
</div>


<style>
     .content-section {
          height: 572px;
          overflow-y: auto;
     }
</style>