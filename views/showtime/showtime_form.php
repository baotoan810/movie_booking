<!-- Content -->
<div class="content">
     <div class="nav-content">
          <button class="menu-toggle">☰</button>
          <div class="admin-info">
               <p>Xin chào, Admin</p>
          </div>
     </div>

     <!-- Form thêm/sửa lịch chiếu -->
     <div class="content-section">
          <h1><?php echo $showtime ? 'Sửa Lịch Chiếu' : 'Thêm Lịch Chiếu'; ?></h1>
          <form action="index.php?controller=showtime&action=save" method="POST" class="user-form">
               <?php if ($showtime): ?>
                    <input type="hidden" name="id" value="<?php echo $showtime['id']; ?>">
               <?php endif; ?>

               <div class="form-group">
                    <label>Phim:</label>
                    <select name="movie_id" required>
                         <option value="">-- Chọn Phim --</option>
                         <?php foreach ($movies as $movie): ?>
                              <option value="<?php echo $movie['id']; ?>" <?php echo isset($showtime['movie_id']) && $showtime['movie_id'] == $movie['id'] ? 'selected' : ''; ?>>
                                   <?php echo $movie['title']; ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </div>

               <div class="form-group">
                    <label>Rạp:</label>
                    <select name="theater_id" required>
                         <option value="">-- Chọn Rạp --</option>
                         <?php foreach ($theaters as $theater): ?>
                              <option value="<?php echo $theater['id']; ?>" <?php echo isset($showtime['theater_id']) && $showtime['theater_id'] == $theater['id'] ? 'selected' : ''; ?>>
                                   <?php echo $theater['name']; ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </div>

               <div class="form-group">
                    <label>Thời Gian Chiếu:</label>
                    <input type="datetime-local" name="show_time" value="<?php echo $showtime['show_time'] ?? ''; ?>"
                         required>
               </div>

               <div class="form-group">
                    <label>Giá Vé:</label>
                    <input type="number" name="price" value="<?php echo $showtime['price'] ?? ''; ?>" required>
               </div>

               <!-- <div class="form-group">
                    <label>Số Lượng Ghế Còn:</label>
                    <input type="number" name="available_seats"
                         value="<?php echo $showtime['available_seats'] ?? ''; ?>" required>
               </div> -->

               <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>
          </form>
          <a href="index.php?controller=showtime&action=index" class="btn-back"><i class="fas fa-arrow-left"></i> Quay
               Lại</a>
     </div>
</div>

<style>
     .content-section {
          height: 572px;
          overflow-y: auto;
     }
</style>