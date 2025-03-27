<!DOCTYPE html>
<html lang="vi">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Danh sách tin tức</title>
     <style>
          body {
               font-family: Arial, sans-serif;
               margin: 0;
               padding: 0;
               background-color: #f4f4f4;
          }

          header {
               background-color: #333;
               color: white;
               padding: 15px 0;
               text-align: center;
          }

          header a {
               color: white;
               text-decoration: none;
               margin: 0 15px;
          }

          header a:hover {
               text-decoration: underline;
          }

          .news-container {
               max-width: 1200px;
               margin: 20px auto;
               padding: 0 15px;
          }

          .news-item {
               display: flex;
               gap: 20px;
               background-color: white;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
               margin-bottom: 20px;
               padding: 15px;
          }

          .news-item img {
               max-width: 200px;
               height: auto;
               border-radius: 5px;
          }

          .news-content {
               flex: 1;
          }

          .news-content h3 {
               margin: 0 0 10px;
               font-size: 1.5em;
          }

          .news-content p {
               margin: 0 0 10px;
               color: #555;
          }

          .news-content .date {
               color: #888;
               font-size: 0.9em;
          }

          .read-more {
               color: #007bff;
               text-decoration: none;
               font-weight: bold;
          }

          .read-more:hover {
               text-decoration: underline;
          }
     </style>
</head>

<body>
     <header>
          <h1>Tin Tức Phim</h1>
          <nav>
               <a href="index.php?controller=homepage&action=index">Trang chủ</a>
               <a href="index.php?controller=homepage&action=news">Tin tức</a>
          </nav>
     </header>

     <div class="news-container">
          <h2>Tin Tức Phim Mới Nhất</h2>
          <?php if (empty($news)): ?>
               <p>Chưa có tin tức nào.</p>
          <?php else: ?>
               <?php foreach ($news as $newsItem): ?>
                    <div class="news-item">
                         <?php if ($newsItem['image'] && file_exists($newsItem['image'])): ?>
                              <img src="<?= htmlspecialchars($newsItem['image']) ?>" alt="Hình ảnh tin tức">
                         <?php else: ?>
                              <p>Không có hình ảnh</p>
                         <?php endif; ?>
                         <div class="news-content">
                              <h3><?= htmlspecialchars($newsItem['title']) ?></h3>
                              <p class="date">Đăng ngày: <?= htmlspecialchars($newsItem['created_at']) ?></p>
                              <p><?= htmlspecialchars(substr($newsItem['content'], 0, 200)) . (strlen($newsItem['content']) > 200 ? '...' : '') ?>
                              </p>
                              <a href="index.php?controller=homepage&action=newsDetail&news_id=<?= $newsItem['id'] ?>"
                                   class="read-more">Đọc tiếp</a>
                         </div>
                    </div>
               <?php endforeach; ?>
          <?php endif; ?>
     </div>
</body>

</html>