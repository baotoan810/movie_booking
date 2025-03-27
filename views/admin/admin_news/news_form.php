<div class="content-section section-form">
     <h2><?= isset($newsItem) ? 'Chỉnh sửa tin tức' : 'Thêm tin tức' ?></h2>
     <form action="admin.php?controller=news&action=save" method="post" enctype="multipart/form-data" class="user-form">
          <?php if (isset($newsItem)): ?>
               <input type="hidden" name="id" value="<?= htmlspecialchars($newsItem['id']) ?>">
          <?php endif; ?>
          <div class="form-group">
               <label for="title">Tiêu đề:</label>
               <input type="text" id="title" name="title"
                    value="<?= isset($newsItem) ? htmlspecialchars($newsItem['title']) : '' ?>" required>
          </div>
          <div class="form-group">
               <label for="content">Nội dung:</label>
               <textarea style="width: 100%;height:100px;" id="content" name="content"
                    required><?= isset($newsItem) ? htmlspecialchars($newsItem['content']) : '' ?></textarea>
          </div>
          <div class="form-group">
               <label for="image">Hình ảnh:</label>
               <input type="file" id="image" name="image" accept="image/*">
               <?php if (isset($newsItem) && $newsItem['image']): ?>
                    <div>
                         <p>Hình ảnh hiện tại:</p>
                         <img src="<?= htmlspecialchars($newsItem['image']) ?>" alt="Hình ảnh tin tức" class="news-image">
                    </div>
               <?php endif; ?>
          </div>
          <button type="submit" class="btn-back">Lưu</button>
          <a href="admin.php?controller=news&action=index" class="btn-back">Quay lại</a>
     </form>
</div>