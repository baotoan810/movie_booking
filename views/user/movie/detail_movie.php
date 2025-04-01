     <!DOCTYPE html>
     <html>
     <head>
     <title>Chi tiết phim - <?php echo htmlspecialchars($movie['title']); ?></title>
     <style>
          body {
               background-color: #121212;
               color: #fff;
               font-family: Arial, sans-serif;
               padding: 20px;
          }

          .movie-detail {
               display: flex;
               gap: 20px;
               margin-bottom: 30px;
          }

          .movie-poster img {
               width: 300px;
               border-radius: 10px;
          }

          .movie-info h1 {
               font-size: 28px;
               color: #fdd835;
               margin-bottom: 10px;
          }

          .movie-info p {
               font-size: 16px;
               color: #bbb;
               margin: 5px 0;
          }

          .description {
               margin-top: 10px;
               line-height: 1.5;
          }

          .btn-group {
               margin-top: 20px;
          }

          .book-btn, .trailer-btn {
               display: inline-block;
               padding: 10px 20px;
               background-color: #fdd835;
               color: #121212;
               text-decoration: none;
               font-weight: bold;
               border-radius: 5px;
               margin-right: 10px;
               transition: 0.3s;
          }

          .book-btn:hover, .trailer-btn:hover {
               background-color: #ffc107;
          }

          .trailer-modal {
               display: none;
               position: fixed;
               top: 0;
               left: 0;
               width: 100%;
               height: 100%;
               background: rgba(0, 0, 0, 0.8);
               z-index: 1000;
               justify-content: center;
               align-items: center;
          }

          .trailer-content {
               position: relative;
               width: 80%;
               max-width: 800px;
          }

          .close-btn {
               position: absolute;
               top: -30px;
               right: 0;
               font-size: 30px;
               color: #fff;
               cursor: pointer;
          }

          .movie-reviews {
               margin-top: 30px;
          }

          .movie-reviews h2 {
               font-size: 24px;
               color: #fdd835;
               margin-bottom: 15px;
          }

          .reviews-list {
               margin-bottom: 20px;
          }

          .review {
               background: #1a1a1a;
               padding: 15px;
               border-radius: 10px;
               margin-bottom: 15px;
          }

          .review-meta {
               font-size: 14px;
               color: #888;
               margin-bottom: 5px;
          }

          .review-author {
               font-weight: bold;
          }

          .review-text {
               font-size: 16px;
               color: #bbb;
          }

          .review-actions {
               margin-top: 10px;
          }

          .edit-review, .delete-review {
               color: #fdd835;
               text-decoration: none;
               margin-right: 10px;
          }

          .edit-review:hover, .delete-review:hover {
               color: #ffc107;
          }

          .review-form {
               background: #1a1a1a;
               padding: 20px;
               border-radius: 10px;
          }

          .review-form h3 {
               font-size: 20px;
               color: #fdd835;
               margin-bottom: 15px;
          }

          .review-form textarea {
               width: 100%;
               height: 100px;
               background: #333;
               color: #fff;
               border: none;
               border-radius: 5px;
               padding: 10px;
               font-size: 16px;
               resize: none;
          }

          .submit-review {
               display: inline-block;
               padding: 10px 20px;
               background-color: #fdd835;
               color: #121212;
               border: none;
               border-radius: 5px;
               font-weight: bold;
               cursor: pointer;
               margin-top: 10px;
               transition: 0.3s;
          }

          .submit-review:hover {
               background-color: #ffc107;
          }

          .error-message {
               color: #f44336;
               font-size: 16px;
               margin-bottom: 15px;
               text-align: center;
          }

          @media (max-width: 768px) {
               .movie-detail {
                    flex-direction: column;
                    align-items: center;
               }

               .movie-poster img {
                    width: 100%;
                    max-width: 300px;
               }

               .movie-info h1 {
                    font-size: 24px;
               }

               .movie-info p {
                    font-size: 14px;
               }
          }
     </style>
     </head>
     <body>
     <main>
          <!-- Chi tiết phim -->
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
                                             class="edit-review">Chỉnh sửa</a>
                                        <a href="user.php?controller=review&action=delete&review_id=<?php echo $review['id']; ?>&movie_id=<?php echo $movie_id; ?>"
                                             class="delete-review"
                                             onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">Xóa</a>
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
          $(document).ready(function () {
               $("#openTrailer").click(function (e) {
                    e.preventDefault();
                    $(".trailer-modal").fadeIn();
               });

               $(".close-btn").click(function () {
                    $(".trailer-modal").fadeOut();
                    $("#trailerVideo").attr("src", $("#trailerVideo").attr("src"));
               });

               $(document).click(function (e) {
                    if ($(e.target).is(".trailer-modal")) {
                         $(".trailer-modal").fadeOut();
                         $("#trailerVideo").attr("src", $("#trailerVideo").attr("src"));
                    }
               });
          });
     </script>
     </body>
     </html>