
<main>
     <!-- Banner quảng cáo -->
     <section class="banner">
          <div class="slider">
               <div class="slide fade">
                    <img src="public/img/bn1.png" alt="Phim 1">
               </div>
               <div class="slide fade">
                    <img src="public/img/bn2.png" alt="Phim 1">
               </div>
               <div class="slide fade">
                    <img src="public/img/bn3.png" alt="Phim 1">
               </div>
          </div>
     </section>

     <!-- Tìm kiếm -->
     <!-- <div class="search-input">
          <h2>🎥 Tìm Kiếm Phim</h2>
          <form action="index.php" method="get" class="search-form">
               <input type="hidden" name="controller" value="homepage">
               <input type="hidden" name="action" value="index">
               <input id="search-movie" class="input-search" type="text" name="search" placeholder="Tìm kiếm phim..."
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
               <button type="submit" class="btn-search">Tìm kiếm</button>
          </form>

     </div> -->

     <!-- Danh sách phim -->
     <div class="movie-hot">
          <h2>Phim đang chiếu</h2>
          <div class="movie-list">
               <?php foreach ($movies as $movie): ?>
                    <div class="movie">
                         <?php if ($movie['poster_path'] && file_exists($movie['poster_path'])): ?>
                              <img src="<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster" width="200px">
                         <?php else: ?>
                              <p>Không có ảnh poster</p>
                         <?php endif; ?>
                         <h3 class="title-movie"><?= htmlspecialchars($movie['title']) ?></h3>
                         <span class="date_movie">
                              <p><?= htmlspecialchars($movie['release_date']) ?></p>
                         </span>
                         <span class="genres_movie">
                              <p><?= htmlspecialchars($movie['genres']) ?></p>
                         </span>
                         <div class="btn">
                              <a href="user.php?controller=detail&action=detail&id=<?= htmlspecialchars($movie['id']) ?>"
                                   class="book-btn">Xem Chi Tiết</a>
                              <a href="user.php?controller=booking&action=selectTheaterAndRoom&movie_id=<?= htmlspecialchars($movie['id']) ?>"
                                   class="book-btn">🎟 Đặt Vé</a>
                         </div>
                    </div>
               <?php endforeach; ?>
          </div>
     </div>

     <!-- Tin tức phim -->
     <section class="movie-news">
          <h2>Tin Tức Phim Mới Nhất</h2>
          <div class="news-container">
               <?php foreach ($news as $newItem): ?>
                    <div class="news-item">
                         <img src="<?= htmlspecialchars($newItem['image']) ?>" alt="">
                         <div class="news-content">
                              <h3><?= htmlspecialchars($newItem['title']) ?></h3>
                              <p><?= htmlspecialchars($newItem['content']) ?></p>
                              <a href="user.php?controller=news&action=detail&id=<?= $newItem['id'] ?>" class="read-more">Đọc
                                   tiếp</a>
                         </div>
                    </div>
               <?php endforeach; ?>
          </div>

          <div class="new-all">
               <a href="user.php?controller=news&action=index">Xem tất cả</a>
          </div>
     </section>


</main>