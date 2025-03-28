<div class="movie-hot">
     <h2>Phim đang chiếu</h2>
     <div class="movie-list">
          <?php foreach ($getMovieToday as $movie): ?>
               <div class="movie">
                    <!-- <img src="<?= htmlspecialchars($movie['poster_path']) ?>" alt="Phim 1">-->
                    <?php if ($movie['poster_path'] && file_exists($movie['poster_path'])): ?>
                         <img src="<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster" width="200px">
                    <?php else: ?>
                         <p>Không có ảnh poster</p>
                    <?php endif; ?>
                    <h3 class="title-movie"><?= htmlspecialchars($movie['title']) ?></h3>
                    <span class="date_movie">
                         <p>Lượt xem: <?= htmlspecialchars($movie['view']) ?></p>
                    </span>
                    <span class="genres_movie">
                         <!-- <p>Thể loại</p> -->
                         <p><?= htmlspecialchars($movie['genres']) ?></p>
                    </span>
                    <div class="btn">
                         <a href="index.php?controller=detail&action=detail&id=<?= htmlspecialchars($movie['id']) ?>"
                              class="book-btn">Xem Chi Tiết</a>
                         <a href="#" class="book-btn">🎟 Đặt Vé</a>
                    </div>
               </div>
          <?php endforeach; ?>
     </div>
</div>


<div class="movie-hot">
     <h2>Phim sắp chiếu</h2>
     <div class="movie-list">
          <?php foreach ($movies as $movie): ?>
               <div class="movie">
                    <!-- <img src="<?= htmlspecialchars($movie['poster_path']) ?>" alt="Phim 1">-->
                    <?php if ($movie['poster_path'] && file_exists($movie['poster_path'])): ?>
                         <img src="<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster" width="200px">
                    <?php else: ?>
                         <p>Không có ảnh poster</p>
                    <?php endif; ?>
                    <h3 class="title-movie"><?= htmlspecialchars($movie['title']) ?></h3>
                    <!-- <span class="date_movie">
                         <p><?= htmlspecialchars($movie['release_date']) ?></p>
                    </span> -->
                    <span class="genres_movie">
                         <!-- <p>Thể loại</p> -->
                         <p><?= htmlspecialchars($movie['genres']) ?></p>
                    </span>
                    <div class="btn">
                         <a href="index.php?controller=detail&action=detail&id=<?= htmlspecialchars($movie['id']) ?>"
                              class="book-btn">Xem Chi Tiết</a>
                         <a href="#" class="book-btn">🎟 Đặt Vé</a>
                    </div>
               </div>
          <?php endforeach; ?>
     </div>
</div>