<!-- Danh sách người dùng -->
<div class="main-content">
     <div class="header">
          <h1>Quản Lý Phim</h1>
          <div class="user-info">
               <span>Xin chào, ADMIN</span>
          </div>
     </div>

     <!-- Search Bar -->
     <div class="nav-search">
          <div class="search">
               <form action="index.php" method="get" class="search">
                    <input type="hidden" name="controller" value="theater">
                    <input type="hidden" name="action" value="index">
                    <input type="text" name="search" placeholder="Tìm kiếm phim..."
                         value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit">Tìm kiếm</button>
               </form>
          </div>
          <div class="add">
               <a href="index.php?controller=theater&action=edit" class="add-btn">
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
                         <th>STT</th>
                         <th>Tên Rạp</th>
                         <th>Địa Chỉ</th>
                         <th>Sức Chứa</th>
                         <th>Thao Tác</th>
                    </tr>
               </thead>
               <tbody>
                    <?php $i = 1;
                    foreach ($theaters as $theater): ?>
                         <tr>
                              <td><?= $i ?></td>
                              <td><?= htmlspecialchars($theater['name']) ?></td>
                              <td><?= htmlspecialchars($theater['address']) ?></td>
                              <td><?= htmlspecialchars($theater['capacity']) ?></td>
                              <td class="table-setting">
                                   <a href="index.php?controller=theater&action=edit&id=<?= $theater['id']; ?>"
                                        class="edit-btn">✏️</a>
     
                                   <a href="#" class="delete-btn" onclick="deleteTheater(<?= $theater['id']; ?>)">
                                        🗑️
                                   </a>
                              </td>
                         </tr>
                         <?php $i++; endforeach; ?>
               </tbody>
          </table>
     </div>
</div>

<