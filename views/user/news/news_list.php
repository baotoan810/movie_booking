<section class="movie-news">
     <h2>Tin Tức Phim Mới Nhất</h2>
     <div class="news-container">
          <?php foreach ($news as $newItem): ?>
               <div class="news-item">
                    <img src="<?= htmlspecialchars($newItem['image']) ?>" alt="">
                    <div class="news-content">
                         <h3><?= htmlspecialchars($newItem['title']) ?></h3>
                         <p><?= htmlspecialchars($newItem['created_at']) ?></p>
                         <p><?= htmlspecialchars($newItem['content']) ?></p>
                         
                         <a href="user.php?controller=news&action=detail&id=<?= $newItem['id'] ?>" class="read-more">Đọc
                              tiếp</a>
                    </div>
               </div>
          <?php endforeach; ?>
     </div>
</section>