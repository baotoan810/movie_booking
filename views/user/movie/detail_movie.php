<main class="movie-detail">
     <div class="movie-poster">
          <img src="<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster Phim">
     </div>
     <div class="movie-info">
          <h1><?= htmlspecialchars($movie['title']) ?></h1>
          <p><strong>Thể loại:</strong> <?= htmlspecialchars($movie['genres']) ?></p>
          <p><strong>Ngày phát hành:</strong> <?= htmlspecialchars($movie['release_date']) ?></p>
          <p><strong>Thời lượng:</strong> <?= htmlspecialchars($movie['duration']) ?> phút</p>
          <p><strong>Đạo diễn:</strong> <?= htmlspecialchars($movie['director']) ?></p>
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
          <span class="close-btn">×</span>
          <video width="100%" controls id="trailerVideo">
               <source src="<?= htmlspecialchars($movie['trailer_path']) ?>" type="video/mp4">
               Trình duyệt của bạn không hỗ trợ video.
          </video>
     </div>
</div>

<!-- Bình luận -->
<section class="movie-reviews">
     <h2>Bình luận phim</h2>
     <div class="reviews-list">
          <?php if (empty($reviews)): ?>
               <p>Chưa có bình luận nào cho phim này. Hãy là người đầu tiên bình luận!</p>
          <?php else: ?>
               <?php foreach ($reviews as $review): ?>
                    <div class="review">
                         <div class="review-meta">
                              <span class="review-author">- <?php echo htmlspecialchars($review['username']); ?></span>
                              <span class="review-date"><?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?></span>
                         </div>
                         <p class="review-text"><?php echo htmlspecialchars($review['content']); ?></p>
                         <?php if (isset($_SESSION['user_id']) && $review['user_id'] == $_SESSION['user_id']): ?>
                              <div class="review-actions">
                                   <a href="user.php?controller=review&action=edit&review_id=<?php echo $review['id']; ?>&movie_id=<?php echo $movie_id; ?>"
                                        class="edit-review"><i class="fa fa-edit"></i></a>
                                   <a href="user.php?controller=review&action=delete&review_id=<?php echo $review['id']; ?>&movie_id=<?php echo $movie_id; ?>"
                                        class="delete-review" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');"><i
                                             class="fa fa-trash-alt"></i></a>
                              </div>
                         <?php endif; ?>
                    </div>
               <?php endforeach; ?>
          <?php endif; ?>
     </div>

     <!-- Hiển thị thông báo lỗi nếu có -->
     <?php if (isset($_GET['error'])): ?>
          <p class="error-message"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></p>
     <?php endif; ?>

     <!-- Form nhập bình luận -->
     <?php if (isset($_SESSION['user_id'])): ?>
          <?php
          // Kiểm tra xem người dùng đã bình luận chưa
          $user_id = $_SESSION['user_id'];
          $reviewModel = new ReviewModel(new PDO('mysql:host=127.0.0.1;dbname=table_movie', 'root', ''));
          $hasReviewed = $reviewModel->hasUserReviewed($user_id, $movie_id);
          ?>
          <?php if (!$hasReviewed): ?>
               <form class="review-form" method="POST"
                    action="user.php?controller=review&action=add&movie_id=<?php echo $movie_id; ?>">
                    <h3>Viết bình luận của bạn</h3>
                    <textarea name="content" placeholder="Nhập bình luận của bạn..." required></textarea>
                    <button type="submit" class="submit-review">Gửi bình luận</button>
               </form>
          <?php else: ?>
               <p>Bạn đã bình luận cho phim này. Bạn có thể chỉnh sửa hoặc xóa bình luận của mình.</p>
          <?php endif; ?>
     <?php else: ?>
          <p>Vui lòng <a href="login.php" style="color: #fdd835;">đăng nhập</a> để viết bình luận.</p>
     <?php endif; ?>
</section>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     $(document).ready(function() {
          $("#openTrailer").click(function(e) {
               e.preventDefault();
               $(".trailer-modal").fadeIn();
          });

          $(".close-btn").click(function() {
               $(".trailer-modal").fadeOut();
               $("#trailerVideo").attr("src", $("#trailerVideo").attr("src"));
          });

          $(document).click(function(e) {
               if ($(e.target).is(".trailer-modal")) {
                    $(".trailer-modal").fadeOut();
                    $("#trailerVideo").attr("src", $("#trailerVideo").attr("src"));
               }
          });
     });
</script>

<style>
     .review-actions {
          padding: 10px;
          display: flex;
          justify-content: flex-end;
          gap: 1rem;
     }

     .review-actions a {
          text-decoration: none;
          color: #f1b963;
     }

     .review-actions a:hover {
          color: #fdd835;
     }

     @media screen and (max-width: 400px) {
          .movie-detail {
               display: flex;
               justify-content: center;
               align-items: center;
               flex-direction: column;
          }

          .movie-poster {
               display: flex;
               justify-content: center;
               align-items: center;
               flex-direction: column;
          }

          .movie-poster img {
               width: 90%;
          }

          .book-btn {
               margin-bottom: 10px;
          }
     }
</style>