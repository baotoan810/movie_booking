<div class="main-content">
     <!-- Header -->
     <div class="header">
          <h1>Quản Lý Người Dùng</h1>
          <div class="user-info">
               <span>Xin chào, ADMIN</span>
          </div>
     </div>

     <!-- Search Bar -->
     <div class="nav-search">
          <div class="search">
               <form action="index.php" method="get" class="search">
                    <input type="hidden" name="controller" value="user">
                    <input type="hidden" name="action" value="index">
                    <input type="text" name="search" placeholder="Tìm kiếm người dùng..."
                         value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit">Tìm kiếm</button>
               </form>
          </div>
          <div class="add">
               <a href="index.php?controller=user&action=edit" class="add-btn">
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

     <!-- Table -->
     <table>
          <thead>
               <tr>
                    <th>STT</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Avata</th>
                    <th>Phân quyền</th>
                    <th>Thao Tác</th>
               </tr>
          </thead>
          <tbody>
               <?php $i = 1;
               foreach ($users as $user): ?>
                    <tr>
                         <td><?= $i ?></td>
                         <td><?= htmlspecialchars($user['username']) ?></td>
                         <td><?= htmlspecialchars($user['email']) ?></td>
                         <td><?= htmlspecialchars($user['phone']) ?></td>
                         <td><?= htmlspecialchars($user['address']) ?></td>
                         <td>
                              <img src="<?= htmlspecialchars($user['image']) ?>" alt="Image User" class="image-user">
                         </td>
                         <td><?= htmlspecialchars($user['role']) ?></td>
                         <td >
                              <a href="index.php?controller=user&action=edit&id=<?= $user['id'] ?>" class="edit-btn">✏️</a>
                              <a href="#" class="delete-btn" onclick="deleteUser(<?= $user['id'] ?>)">🗑️</a>
                         </td>
                    </tr>
                    <?php $i++; endforeach; ?>
          </tbody>
     </table>
</div>