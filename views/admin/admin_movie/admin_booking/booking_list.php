<div class="main-content">
     <h1>Quản lý đặt vé</h1>

     <table>
          <thead>
               <tr>
                    <th>ID</th>
                    <th>Người Dùng</th>
                    <th>Phim</th>
                    <th>Rạp</th>
                    <th>Phòng</th>
                    <th>Thời Gian Chiếu</th>
                    <th>Ngày Đặt</th>
                    <th>Tổng Giá</th>
                    <th>Hành Động</th>
               </tr>
          </thead>
          <tbody>
               <?php foreach ($bookings as $booking): ?>
                    <tr>
                         <td><?php echo htmlspecialchars($booking['id']); ?></td>
                         <td><?php echo htmlspecialchars($booking['username']); ?></td>
                         <td><?php echo htmlspecialchars($booking['movie_title']); ?></td>
                         <td><?php echo htmlspecialchars($booking['theater_name']); ?></td>
                         <td><?php echo htmlspecialchars($booking['room_name']); ?></td>
                         <td><?php echo htmlspecialchars($booking['start_time']); ?></td>
                         <td><?php echo htmlspecialchars($booking['booking_time']); ?></td>
                         <td><?php echo number_format($booking['total_price'], 0, ',', '.') . ' VNĐ'; ?></td>
                         <td>
                              <a href="index.php?controller=booking&action=viewDetails&id=<?php echo $booking['id']; ?>"
                                   class="btn-view">
                                   <i class="fas fa-eye"></i> Xem
                              </a>
                              <?php if ($booking['status'] !== 'cancelled'): ?>
                                   <a href="index.php?controller=booking&action=cancel&id=<?php echo $booking['id']; ?>"
                                        class="btn-cancel" onclick="return confirm('Bạn có chắc chắn muốn hủy đặt vé này?');">
                                        <i class="fas fa-trash"></i> Hủy
                                   </a>
                              <?php endif; ?>
                         </td>
                    </tr>
               <?php endforeach; ?>
          </tbody>
     </table>
</div>