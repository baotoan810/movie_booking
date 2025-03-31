<section class="theater-details">
     <h1><?php echo htmlspecialchars($data['theater']['name']); ?></h1>
     <p>Địa chỉ: <?php echo htmlspecialchars($data['theater']['address']); ?></p>

     <h2>Danh sách phòng chiếu</h2>
     <div class="room-list">
          <?php if (empty($data['rooms'])): ?>
               <p>Không có phòng chiếu nào trong rạp này.</p>
          <?php else: ?>
               <?php foreach ($data['rooms'] as $room): ?>
                    <div class="room-item">
                         <strong><?php echo htmlspecialchars($room['name']); ?></strong>
                         <p>Sức chứa: <?php echo $room['capacity']; ?> chỗ</p>
                    </div>
               <?php endforeach; ?>
          <?php endif; ?>
     </div>
     <a href="user.php?controller=theater&action=index">Quay lại danh sách</a>
</section>


