<h1>Chọn suất chiếu - <?php echo htmlspecialchars($movieTitle); ?> - Ngày <?php echo htmlspecialchars($date); ?></h1>
<?php if (empty($theaters)): ?>
     <p>Không có suất chiếu nào cho phim này trong ngày này.</p>
<?php else: ?>
     <form method="post" action="user.php?controller=booking&action=selectSeats">
          <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($_GET['movie_id']); ?>">
          <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
          <?php foreach ($theaters as $theater): ?>
               <div class="theater">
                    <h2><?php echo htmlspecialchars($theater['name']); ?></h2>
                    <p>Địa chỉ: <?php echo htmlspecialchars($theater['address']); ?></p>
                    <?php foreach ($theater['rooms'] as $room): ?>
                         <h3><?php echo htmlspecialchars($room['name']); ?> (Sức chứa: <?php echo $room['capacity']; ?>)</h3>
                         <?php foreach ($room['showtimes'] as $showtime): ?>
                              <div>
                                   <p>Giờ: <?php echo date('H:i', strtotime($showtime['start_time'])); ?></p>
                                   <p>Giá: <?php echo number_format($showtime['price'], 0); ?> VND</p>
                                   <p>Còn: <?php echo $showtime['available_seats']; ?> ghế</p>
                                   <button type="submit" name="showtime_id" value="<?php echo $showtime['id']; ?>">Chọn suất</button>
                              </div>
                         <?php endforeach; ?>
                    <?php endforeach; ?>
               </div>
          <?php endforeach; ?>
     </form>
<?php endif; ?>

<style>
     /* Định dạng chung */
     body {
          background-color: #121212;
          color: #fff;
          font-family: Arial, sans-serif;
     }

     /* Tiêu đề chính */
     h1 {
          font-size: 28px;
          font-weight: bold;
          color: #fdd835;
          /* Màu vàng */
          text-align: center;
          margin-bottom: 20px;
     }

     /* Thông báo không có suất chiếu */
     p {
          font-size: 16px;
          color: #ddd;
          text-align: center;
     }

     /* Container rạp */
     .theater {
          background: #1a1a1a;
          padding: 20px;
          border-radius: 10px;
          margin-bottom: 20px;
          box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
     }

     /* Tiêu đề rạp */
     .theater h2 {
          font-size: 22px;
          font-weight: bold;
          color: #fdd835;
     }

     /* Địa chỉ rạp */
     .theater p {
          font-size: 14px;
          color: #bbb;
     }

     /* Thông tin phòng chiếu */
     .theater h3 {
          font-size: 18px;
          font-weight: bold;
          color: #fff;
          margin-top: 10px;
     }

     /* Thông tin suất chiếu */
     .theater div {
          background: #222;
          padding: 10px;
          border-radius: 5px;
          margin-top: 10px;
     }

     /* Nút chọn suất */
     button {
          background-color: #fdd835;
          /* Màu vàng */
          color: #121212;
          font-size: 16px;
          font-weight: bold;
          padding: 10px 15px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          display: block;
          width: 100%;
          margin-top: 10px;
          transition: 0.3s;
     }

     button:hover {
          background-color: #ffc107;
     }
</style>