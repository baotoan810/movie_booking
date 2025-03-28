<section class="movie-news">
     <h2>Danh sách rạp phim</h2>
     <div class="movie-list">
          <?php if (empty($theaters)): ?>
               <p>Không có rạp phim nào trong hệ thống.</p>
          <?php else: ?>
               <?php foreach ($theaters as $theater): ?>
                    <div class="movie">
                         <h2><?= htmlspecialchars($theater['name']); ?></h2>
                         <p>Địa chỉ: <?= htmlspecialchars($theater['address']); ?></p>
                         <div class="new-all">
                              <a href="index.php?controller=theater&action=edit&id=<?= htmlspecialchars($theater['id']) ?>">
                                   Xem phòng
                              </a>
                         </div>
                    </div>
               <?php endforeach; ?>
          <?php endif; ?>
     </div>
</section>