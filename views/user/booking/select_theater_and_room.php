<h1>Chọn suất chiếu - <?php echo htmlspecialchars($movieTitle); ?> - Ngày <?php echo htmlspecialchars($date); ?></h1>
<?php if (empty($theaters)): ?>
     <p>Không có suất chiếu nào cho phim này trong ngày này.</p>
<?php else: ?>
     <form method="post" action="index.php?controller=booking&action=selectSeats">
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