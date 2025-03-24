<!-- Form thêm/sửa phim -->
<div class="content-section section-form">
     <h1><?= $movie ? 'Sửa Phim' : 'Thêm Phim'; ?></h1>

     <form action="index.php?controller=movie&action=save" method="POST" enctype="multipart/form-data"
          class="user-form">
          <?php if (!empty($movie)): ?>
               <input type="hidden" name="id" value="<?= htmlspecialchars($movie['id']); ?>">
          <?php endif; ?>
          <div class="form-group">
               <label>Tên Phim</label>
               <input type="text" name="title" placeholder="Nhập tên phim..."
                    value="<?= htmlspecialchars($movie['title'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
               <label>Mô tả:</label>
               <input type="text" name="description" placeholder="Nhập mô tả..."
                    value="<?= htmlspecialchars($movie['description'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
               <label>Thời lượng:</label>
               <input type="text" name="duration" placeholder="Nhập thời lượng..."
                    value="<?= htmlspecialchars($movie['duration'] ?? ''); ?>">
          </div>
          <div class="form-group">
               <label>Tác giả:</label>
               <input type="text" name="director" placeholder="Nhập tên tác giả..."
                    value="<?= htmlspecialchars($movie['director'] ?? ''); ?>">
          </div>

          <div class="form-group">
               <label>Ngày xuất bản:</label>
               <input type="date" name="release_date" value="<?= htmlspecialchars($movie['release_date'] ?? ''); ?>">
          </div>
          <div class="form-group">
               <?php foreach ($allGenres as $genre): ?>
                    <label>
                         <input type="checkbox" name="genres[]" value="<?= $genre['id'] ?>" <?= in_array($genre['id'], $selectedGenres) ? 'checked' : '' ?>>
                         <?= htmlspecialchars($genre['name']) ?>
                    </label><br>
               <?php endforeach; ?>
          </div>
          <div class="form-group">
               <label>Lượt xem:</label>
               <input type="number" name="view" placeholder="Nhập lượt xem..."
                    value="<?= htmlspecialchars($movie['view'] ?? ''); ?>">
          </div>

          <!-- note: Trailer ------------------------------  -->
          <!-- Video hiện tại -->
          <?php if (!empty($movie['trailer_path'])): ?>
               <input type="hidden" name="current_trailer" value="<?= $movie['trailer_path'] ?>">
               <video width="200" controls>
                    <source src="<?= $movie['trailer_path'] ?>" type="video/mp4">
                    Browser không hỗ trợ video.
               </video>
          <?php endif; ?>
          <!-- Upload video mới -->
          <div class="form-group">
               <label>Upload Video Mới:</label>
               <input type="file" name="trailer_video">
          </div>

          <!-- note: Poster ------------------------------  -->

          <!-- Hình ảnh hiện tại -->
          <?php if (!empty($movie['poster_path']) && file_exists($movie['poster_path'])): ?>
               <div class="form-group">
                    <label>Ảnh Hiện Tại:</label>
                    <img width="80" height="80" src="<?= htmlspecialchars($movie['poster_path']); ?>" alt="Image"
                         class="user-image-preview">
                    <input type="hidden" name="poster_path" value="<?= htmlspecialchars($movie['poster_path']); ?>">

               </div>
          <?php endif; ?>
          <!-- Upload ảnh mới -->
          <div class="form-group">
               <label>Upload Ảnh Mới:</label>
               <input type="file" name="poster_image">
          </div>

          <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>

          <!-- Link quay lại -->
          <a href="index.php?controller=movie&action=index" class="btn-back">
               <i class="fas fa-arrow-left"></i> Quay Lại
          </a>
     </form>
</div>

