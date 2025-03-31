<main>
     <!-- Chi tiết phim -->
     <main class="movie-detail">
          <div class="movie-poster">
               <img src="<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster Phim">
          </div>
          <div class="movie-info">
               <h1><?= htmlspecialchars($movie['title']) ?></h1>
               <p><strong>Thể loại:</strong><?= htmlspecialchars($movie['genres']) ?></p>
               <p><strong>Ngày phát hành:</strong><?= htmlspecialchars($movie['release_date']) ?></p>
               <p><strong>Thời lượng:</strong><?= htmlspecialchars($movie['duration']) ?></p>
               <p><strong>Đạo diễn:</strong><?= htmlspecialchars($movie['director']) ?></p>
               <p class="description"><?= htmlspecialchars($movie['description']) ?></p>

               <div class="btn-group">
                    <a href="user.php?controller=booking&action=selectTheaterAndRoom&movie_id=<?= htmlspecialchars($movie['id']) ?>"
                         class="book-btn">🎟 Đặt Vé</a>
                    <a href="#" class="trailer-btn" id="openTrailer">▶ Xem Trailer</a>
               </div>
          </div>
     </main>

     <!-- Form Trailer (Ẩn ban đầu) -->
     <div class="trailer-modal">
          <div class="trailer-content">
               <span class="close-btn">&times;</span>
               <video width="100%" controls>
                    <source src="<?= htmlspecialchars($movie['trailer_path']) ?>" type="video/mp4">
                    Trình duyệt của bạn không hỗ trợ video.
               </video>
          </div>
     </div>

     <!-- Đánh giá -->
     <section class="movie-reviews">
          <h2>Đánh Giá Phim</h2>
          <div class="reviews-list">
               <?php if (empty($reviews)): ?>
                    <p>Chưa có đánh giá nào cho phim này. Hãy là người đầu tiên đánh giá!</p>
               <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                         <div class="review">
                              <div class="review-meta">
                                   <span class="review-author">- <?php echo htmlspecialchars($review['username']); ?></span>
                                   <span
                                        class="review-date"><?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?></span>
                              </div>
                              <p class="review-text"><?php echo htmlspecialchars($review['content']); ?></p>
                              <?php if (isset($_SESSION['user_id']) && $review['user_id'] == $_SESSION['user_id']): ?>
                                   <div class="review-actions">
                                        <a href="user.php?controller=review&action=edit&review_id=<?php echo $review['id']; ?>&movie_id=<?php echo $movie_id; ?>"
                                             class="edit-review">Chỉnh sửa</a>
                                        <a href="user.php?controller=review&action=delete&review_id=<?php echo $review['id']; ?>&movie_id=<?php echo $movie_id; ?>"
                                             class="delete-review"
                                             onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">Xóa</a>
                                   </div>
                              <?php endif; ?>
                         </div>
                    <?php endforeach; ?>
               <?php endif; ?>
          </div>

          <!-- Form nhập đánh giá -->
          <form class="review-form" method="POST"
               action="user.php?controller=review&action=add&movie_id=<?php echo $movie_id; ?>">
               <h3>Viết Đánh Giá Của Bạn</h3>
               <textarea name="content" placeholder="Nhập đánh giá của bạn..." required></textarea>
               <button type="submit" class="submit-review">Gửi Đánh Giá</button>
          </form>
     </section>

</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     $(document).ready(function () {
          $("#openTrailer").click(function (e) {
               e.preventDefault();
               $(".trailer-modal").fadeIn();
          });

          $(".close-btn").click(function () {
               $(".trailer-modal").fadeOut();
               $("#trailerVideo").attr("src", $("#trailerVideo").attr("src")); // Reset video khi đóng
          });

          $(document).click(function (e) {
               if ($(e.target).is(".trailer-modal")) {
                    $(".trailer-modal").fadeOut();
                    $("#trailerVideo").attr("src", $("#trailerVideo").attr("src"));
               }
          });
     });

</script>