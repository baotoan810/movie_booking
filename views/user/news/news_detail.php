<!DOCTYPE html>
<html lang="vi">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= htmlspecialchars($newsItem['title']) ?></title>
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

          .news-detail {
               max-width: 800px;
               margin: 20px auto;
               padding: 0 15px;
               background-color: white;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
               padding: 20px;
          }

          .news-detail img {
               max-width: 100%;
               height: auto;
               border-radius: 5px;
               margin-bottom: 15px;
          }

          .news-detail h1 {
               margin: 0 0 15px;
               font-size: 2em;
          }

          .news-detail .date {
               color: #888;
               font-size: 0.9em;
               margin-bottom: 15px;
          }

          .news-detail .content {
               line-height: 1.6;
               color: #333;
          }

          .back-link {
               display: inline-block;
               margin-top: 20px;
               color: #007bff;
               text-decoration: none;
               font-weight: bold;
          }

          .back-link:hover {
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

     <div class="news-detail">
          <h1><?= htmlspecialchars($newsItem['title']) ?></h1>
          <p class="date">Đăng ngày: <?= htmlspecialchars($newsItem['created_at']) ?></p>
          <?php if ($newsItem['image'] && file_exists($newsItem['image'])): ?>
               <img src="<?= htmlspecialchars($newsItem['image']) ?>" alt="Hình ảnh tin tức">
          <?php endif; ?>
          <div class="content">
               <?= nl2br(htmlspecialchars($newsItem['content'])) ?>
          </div>
          <a href="index.php?controller=homepage&action=news" class="back-link">Quay lại danh sách tin tức</a>
     </div>
</body>

</html>