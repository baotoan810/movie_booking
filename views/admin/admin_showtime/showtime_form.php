<div class="main-content">
     <h1><?php echo $showtime ? 'Sửa suất chiếu' : 'Thêm suất chiếu'; ?></h1>

     <div class="content-section">
          <form method="POST" action="index.php?controller=showtime&action=save">
               <?php if ($showtime): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($showtime['id']); ?>">
               <?php endif; ?>

               <div class="form-group">
                    <label for="movie_id">Phim:</label>
                    <select name="movie_id" id="movie_id" required>
                         <option value="">Chọn phim</option>
                         <?php foreach ($movies as $movie): ?>
                              <option value="<?php echo $movie['id']; ?>" <?php echo $showtime && $showtime['movie_id'] == $movie['id'] ? 'selected' : ''; ?>>
                                   <?php echo htmlspecialchars($movie['title']); ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </div>

               <div class="form-group">
                    <label for="room_id">Phòng:</label>
                    <select name="room_id" id="room_id" required>
                         <option value="">Chọn phòng</option>
                         <?php foreach ($rooms as $room): ?>
                              <option value="<?php echo $room['id']; ?>" <?php echo $showtime && $showtime['room_id'] == $room['id'] ? 'selected' : ''; ?>>
                                   <?php echo htmlspecialchars($room['name'] . ' (' . $room['theater_name'] . ')'); ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </div>

               <div class="form-group">
                    <label for="start_time">Thời gian bắt đầu:</label>
                    <input type="datetime-local" name="start_time" id="start_time"
                         value="<?php echo $showtime ? date('Y-m-d\TH:i', strtotime($showtime['start_time'])) : ''; ?>"
                         k required>
               </div>

               <div class="form-group">
                    <label for="end_time">Thời gian kết thúc:</label>
                    <input type="datetime-local" name="end_time" id="end_time"
                         value="<?php echo $showtime ? date('Y-m-d\TH:i', strtotime($showtime['end_time'])) : ''; ?>"
                         required>
               </div>
               <div class="form-group">
                    <label for="price">Giá</label>
                    <input type="number" name="price" value="<?= htmlspecialchars($showtime['price']) ?>">
               </div>
               <div class="form-actions">
                    <button type="submit" class="btn btn-save"><i class="fas fa-save"></i> Lưu</button>
                    <a href="index.php?controller=showtime&action=index" class="btn btn-back"><i
                              class="fas fa-arrow-left"></i> Quay lại</a>
               </div>
          </form>
     </div>
</div>