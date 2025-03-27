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
                    <a href="booking.html" class="book-btn">🎟 Đặt Vé</a>
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

     <section class="movie-reviews">
          <h2>Đánh Giá Phim</h2>
          <div class="reviews-list">
               <!-- Hiển thị các đánh giá -->
               <div class="review">
                    <div class="review-meta">
                         <span class="review-author">- Nguyễn Văn A</span>
                    </div>
                    <p class="review-text">"Bộ phim rất hấp dẫn! Kịch bản lôi cuốn và hình ảnh tuyệt đẹp!"</p>
               </div>
               <div class="review">
                    <div class="review-meta">
                         <span class="review-author">- Trần Thị B</span>
                    </div>
                    <p class="review-text">"Tuyệt vời, rất đáng xem! Diễn xuất của diễn viên quá ấn tượng."</p>
               </div>
          </div>

          <!-- Form nhập đánh giá -->
          <form class="review-form">
               <h3>Viết Đánh Giá Của Bạn</h3>
               
               <textarea placeholder="Nhập đánh giá của bạn..." required></textarea>

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