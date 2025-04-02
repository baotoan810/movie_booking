<div class="main-content">
     <h1><?php echo $showtime ? 'Sửa suất chiếu' : 'Thêm suất chiếu'; ?></h1>

     <div class="content-section">
          <?php if (isset($error)): ?>
               <div class="error-message" style="color: red; margin-bottom: 10px;">
                    <?php echo htmlspecialchars($error); ?>
               </div>
          <?php endif; ?>

          <form method="POST" action="admin.php?controller=showtime&action=save" onsubmit="return validateForm()">
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
                         required>
               </div>

               <div class="form-group">
                    <label for="end_time">Thời gian kết thúc:</label>
                    <input type="datetime-local" name="end_time" id="end_time"
                         value="<?php echo $showtime ? date('Y-m-d\TH:i', strtotime($showtime['end_time'])) : ''; ?>"
                         required>
               </div>

               <div class="form-group">
                    <label for="price">Giá:</label>
                    <input type="number" name="price" id="price" min="0" step="1000"
                         value="<?php echo $showtime ? htmlspecialchars($showtime['price']) : '50000'; ?>" required>
               </div>

               <div class="form-actions">
                    <button type="submit" class="btn btn-save"><i class="fas fa-save"></i> Lưu</button>
                    <a href="admin.php?controller=showtime&action=index" class="btn btn-back"><i
                              class="fas fa-arrow-left"></i> Quay lại</a>
               </div>
          </form>
     </div>
</div>

<script>
     function validateForm() {
          const startTimeInput = document.getElementById('start_time').value;
          const endTimeInput = document.getElementById('end_time').value;

          // Kiểm tra xem các trường có rỗng không
          if (!startTimeInput || !endTimeInput) {
               alert('Vui lòng chọn thời gian bắt đầu và thời gian kết thúc!');
               return false;
          }

          // Chuyển đổi thời gian thành timestamp để so sánh
          const startDate = new Date(startTimeInput);
          const endDate = new Date(endTimeInput);

          // Kiểm tra xem thời gian có hợp lệ không
          if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
               alert('Thời gian không hợp lệ! Vui lòng chọn thời gian đúng định dạng.');
               return false;
          }

          // Kiểm tra start_time < end_time
          if (startDate >= endDate) {
               alert('Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc!');
               return false;
          }

          return true;
     }
</script>

<style>
     .main-content {
          max-width: 700px;
          margin: 20px auto;
          padding: 20px;
          background: #fff;
          border-radius: 8px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          text-align: center;
     }

     h1 {
          font-size: 24px;
          margin-bottom: 20px;
          color: #333;
     }

     .content-section {
          padding: 15px;
          background: #f9f9f9;
          border-radius: 8px;
     }

     .error-message {
          color: red;
          font-size: 14px;
          margin-bottom: 10px;
     }

     .form-group {
          margin-bottom: 15px;
          text-align: left;
     }

     .form-group label {
          font-weight: bold;
          display: block;
          margin-bottom: 5px;
          color: #444;
     }

     .form-group input,
     .form-group select {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
          font-size: 16px;
     }

     .form-group input:focus,
     .form-group select:focus {
          border-color: #007bff;
          outline: none;
          box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
     }

     .form-actions {
          display: flex;
          justify-content: space-between;
          margin-top: 20px;
     }

     .btn {
          padding: 10px 15px;
          font-size: 16px;
          font-weight: bold;
          border: none;
          cursor: pointer;
          border-radius: 5px;
          text-decoration: none;
     }

     .btn-save {
          background-color: #28a745;
          color: white;
     }

     .btn-save:hover {
          background-color: #218838;
     }

     .btn-back {
          background-color: #007bff;
          color: white;
     }

     .btn-back:hover {
          background-color: #0056b3;
     }
</style>