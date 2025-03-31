<h1>Chọn suất chiếu - Ngày <?php echo htmlspecialchars($date); ?></h1>
<form method="post" action="user.php?controller=booking&action=selectShowtime&room_id=<?php echo $room_id; ?>">
     <?php foreach ($showtimes as $showtime): ?>
          <div>
               <h3><?php echo htmlspecialchars($showtime['title']); ?></h3>
               <p>Giờ: <?php echo date('H:i', strtotime($showtime['start_time'])); ?></p>
               <p>Giá: <?php echo number_format($showtime['price'], 2); ?> VND</p>
               <p>Còn: <?php echo $showtime['available_seats']; ?> ghế</p>
               <button type="submit" name="showtime_id" value="<?php echo $showtime['id']; ?>">Chọn suất</button>
          </div>
     <?php endforeach; ?>
</form>