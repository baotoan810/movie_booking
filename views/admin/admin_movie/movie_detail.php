<div class="main-content">
     <div class="content-section" style="width: 900px;">
          <div class="form-input">
               <a href="admin.php?controller=movie&action=index"><i class="fa fa-arrow-left"></i></a>
          </div>
          <h1>Chi Tiết Phim: <?= htmlspecialchars($movie['title']) ?></h1>
          <div class="form-input">
               <strong>Mô tả</strong>
               <p><?= htmlspecialchars($movie['description']) ?></p>
          </div>
          <div class="form-input">
               <strong>Thời Lượng</strong>
               <p><?= htmlspecialchars($movie['duration']) ?> phút</p>
          </div>
          <div class="form-input">
               <strong>Đạo Diễn:</strong>
               <p><?= htmlspecialchars($movie['director'] ?: 'Chưa có đạo diễn') ?></p>
          </div>
          <div class="form-input">
               <strong>Thể Loại: </strong>
               <p><?= htmlspecialchars($movie['genres'] ?: 'Chưa có thể loại') ?></p>
          </div>
          <div class="form-input">
               <strong>Ngày Xuất Bản:</strong>
               <p><?= htmlspecialchars($movie['release_date']) ?></p>
          </div>
          <div class="form-input">
               <strong>Lượt Xem:</strong>
               <p><?= htmlspecialchars($movie['view']) ?></p>
          </div>
          <div class="form-input">
               <strong>Video Trailer:</strong>
               <?php if ($movie['trailer_path'] && file_exists($movie['trailer_path'])): ?>
                    <video width="600px" controls>
                         <source src="<?= htmlspecialchars($movie['trailer_path']) ?>" type="video/mp4">
                         Trình duyệt của bạn không hỗ trợ video.
                    </video>
               <?php else: ?>
                    <p>Không có video trailer</p>
               <?php endif; ?>
          </div>
          <div class="form-input">
               <strong>Ảnh Poster:</strong>
               <?php if ($movie['poster_path'] && file_exists($movie['poster_path'])): ?>
                    <img src="<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster" width="200px">
               <?php else: ?>
                    <p>Không có ảnh poster</p>
               <?php endif; ?>
          </div>

     </div>
</div>

<style>
     .main-content {
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 20px;
     }

     .content-section {
          width: 900px;
          background: #fff;
          border-radius: 8px;
          padding: 20px;
          box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
          overflow-y: auto;
          max-height: 700px;
     }

     h1 {
          font-size: 24px;
          font-weight: bold;
          color: #333;
          text-align: center;
          margin-bottom: 20px;
     }

     .form-input {
          margin-bottom: 15px;
     }

     .form-input strong {
          display: block;
          font-size: 16px;
          color: #444;
          margin-bottom: 5px;
     }

     .form-input p {
          font-size: 14px;
          color: #666;
          background: #f5f5f5;
          padding: 8px;
          border-radius: 4px;
     }

     .form-input a {
          text-decoration: none;
          font-size: 18px;
          color: #007BFF;
          display: inline-block;
          margin-bottom: 10px;
     }

     .form-input a:hover {
          color: #0056b3;
     }

     .video-container {
          text-align: center;
          margin-top: 10px;
     }

     video {
          width: 100%;
          max-width: 600px;
          border-radius: 8px;
          box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
     }

     .poster-container {
          text-align: center;
          margin-top: 10px;
     }

     img {
          width: 200px;
          border-radius: 8px;
          box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
     }
</style>