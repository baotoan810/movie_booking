<div class="news-detail">
     <h1><?= htmlspecialchars($new['title']) ?></h1>
     <p class="date">Đăng ngày: <?= htmlspecialchars($new['created_at']) ?></p>
     <?php if ($new['image'] && file_exists($new['image'])): ?>
          <img src="<?= htmlspecialchars($new['image']) ?>" alt="Hình ảnh tin tức">
     <?php endif; ?>
     <div class="content">
          <?= nl2br(htmlspecialchars($new['content'])) ?>
     </div>
     <a href="user.php?controller=news&action=index" class="back-link">Quay lại danh sách tin tức</a>
</div>

<style>
     /* Định dạng chung */
     body {
          background-color: #121212;
          color: #fff;
          font-family: Arial, sans-serif;
     }

     /* Container chính */
     .news-detail {
          max-width: 900px;
          margin: 20px auto;
          background: #1a1a1a;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
     }

     /* Tiêu đề tin tức */
     .news-detail h1 {
          font-size: 28px;
          font-weight: bold;
          color: #fdd835;
          /* Màu vàng nổi bật */
          margin-bottom: 10px;
     }

     /* Ngày đăng */
     .news-detail .date {
          font-size: 14px;
          color: #bbb;
          margin-bottom: 15px;
     }

     /* Ảnh tin tức */
     .news-detail img {
          width: 100%;
          /* height: 200px; */
          aspect-ratio: 16/9;
          object-fit: contain;
          border-radius: 8px;
          margin-bottom: 15px;
     }

     /* Nội dung tin tức */
     .news-detail .content {
          font-size: 16px;
          line-height: 1.6;
          color: #ddd;
     }

     /* Link quay lại */
     .news-detail .back-link {
          display: inline-block;
          margin-top: 20px;
          padding: 10px 15px;
          background-color: #fdd835;
          /* Màu vàng */
          color: #121212;
          text-decoration: none;
          border-radius: 5px;
          font-weight: bold;
     }

     .news-detail .back-link:hover {
          background-color: #ffc107;
     }
</style>