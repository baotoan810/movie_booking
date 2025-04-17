<div class="main-content">
     <div class="header">
          <h1>Quản Lý Xuất Chiếu</h1>
          <div class="user-info">
               <span>Xin chào, ADMIN</span>
          </div>
     </div>

     <!-- Search Bar -->
     <div class="nav-search">
          <!-- <div class="search">
               <form action="admin.php" method="get" class="search">
                    <input type="hidden" name="controller" value="showtime">
                    <input type="hidden" name="action" value="index">
                    <input type="text" name="search" placeholder="Tìm kiếm người dùng..."
                         value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit">Tìm kiếm</button>
               </form>
          </div> -->
          <div class="add">
               <a href="admin.php?controller=showtime&action=edit" class="add-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-square-plus">
                         <rect width="18" height="18" x="3" y="3" rx="2" />
                         <path d="M8 12h8" />
                         <path d="M12 8v8" />
                    </svg>
               </a>
          </div>
     </div>


     <div class="table-container">
          <table>
               <thead>
                    <tr>
                         <th>ID</th>
                         <th>Phim</th>
                         <th>Phòng</th>
                         <th>Rạp</th>
                         <th>Thời gian bắt đầu</th>
                         <th>Thời gian kết thúc</th>
                         <th>Giá vé (VNĐ)</th>
                         <th>Hành động</th>
                    </tr>
               </thead>
               <tbody>
                    <?php if (empty($showtimes)): ?>
                         <tr>
                              <td colspan="8" style="text-align: center;">Không có suất chiếu nào.</td>
                         </tr>
                    <?php else: ?>
                         <?php $i = 1;
                         foreach ($showtimes as $showtime): ?>
                              <tr>
                                   <td><?= htmlspecialchars($i) ?></td>
                                   <td><?= htmlspecialchars($showtime['movie_title']); ?></td>
                                   <td><?= htmlspecialchars($showtime['room_name']); ?></td>
                                   <td><?= htmlspecialchars($showtime['theater_name']); ?></td>
                                   <td><?= htmlspecialchars($showtime['start_time']); ?></td>
                                   <td><?= htmlspecialchars($showtime['end_time']); ?></td>
                                   <td><?= number_format($showtime['price'], 0, ',', '.'); ?></td>
                                   <td>
                                        <a href="admin.php?controller=showtime&action=edit&id=<?= $showtime['id']; ?>"
                                             class="edit-btn"><i class="fas fa-edit"></i> Sửa</a>
                                        <!-- <a href="index.php?controller=showtime&action=viewSeats&showtime_id=<?= $showtime['id']; ?>"
                                        class="btn-view" style="background: #17a2b8;"><i class="fas fa-chair"></i></a> -->
                                        <form method="POST" action="admin.php?controller=showtime&action=delete"
                                             style="display:inline;"
                                             onsubmit="return confirm('Bạn có chắc chắn muốn xóa suất chiếu này?');">
                                             <input type="hidden" name="id" value="<?= $showtime['id']; ?>">
                                             <button type="submit" class="delete-btn">🗑️
                                             </button>
                                        </form>
                                   </td>
                              </tr>
                         <?php $i++;
                         endforeach; ?>
                    <?php endif; ?>
               </tbody>
          </table>
     </div>

</div>