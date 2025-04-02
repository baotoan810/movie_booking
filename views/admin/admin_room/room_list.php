<!-- Danh sách người dùng -->
<div class="main-content">
     <div class="header">
          <h1>Quản Lý Phòng</h1>
          <div class="user-info">
               <span>Xin chào, ADMIN</span>
          </div>
     </div>

     <!-- Search Bar -->
     <div class="nav-search">
          <!-- <div class="search">
               <form method="GET" class="search">
                    <input type="hidden" name="controller" value="room">
                    <input type="hidden" name="action" value="index">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($keyword ?? ''); ?>"
                         placeholder="Tìm kiếm phòng...">
                    <button type="submit">Tìm kiếm</button>
               </form>
          </div> -->
          <div class="add">
               <a href="admin.php?controller=room&action=edit" class="add-btn">
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

     <table>
          <thead>
               <tr>
                    <th>STT</th>
                    <th>Tên phòng</th>
                    <th>Rạp</th>
                    <th>Sức chứa</th>
                    <th>Số hàng</th>
                    <th>Số cột</th>
                    <th>Hành động</th>
               </tr>
          </thead>
          <tbody>
               <?php $i = 1;
               foreach ($rooms as $room): ?>
                    <tr>
                         <td><?= htmlspecialchars($i); ?></td>
                         <td><?= htmlspecialchars($room['name']); ?></td>
                         <td><?= htmlspecialchars($room['theater_name']); ?></td>
                         <td><?= htmlspecialchars($room['capacity']); ?></td>
                         <td><?= htmlspecialchars($room['rows']); ?></td>
                         <td><?= htmlspecialchars($room['columns']); ?></td>
                         <td>
                              <a href="admin.php?controller=room&action=viewSeats&room_id=<?php echo $room['id']; ?>"
                                   class="btn-view">
                                   🪑
                              </a>

                              <a href="admin.php?controller=room&action=edit&id=<?= $room['id'] ?>" class="edit-btn">✏️</a>
                              <a href="#" class="delete-btn" onclick="deleteRoom(<?= $room['id'] ?>)">🗑️</a>
                         </td>
                    </tr>
                    <?php $i++; endforeach; ?>
          </tbody>
     </table>

</div>

</div>
</div>