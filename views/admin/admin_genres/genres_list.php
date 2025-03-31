<!-- Danh sách người dùng -->
<div class="main-content">
     <div class="header">
          <h1>Quản Lý Thể Loại Phim</h1>
          <div class="user-info">
               <span>Xin chào, ADMIN</span>
          </div>
     </div>

     <!-- Search Bar -->
     <div class="nav-search">
          <div class="add">
               <a href="admin.php?controller=genres&action=edit" class="add-btn">
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
                         <th>Tên Thể Loại</th>
                         <th>Thao Tác</th>
                    </tr>
               </thead>
               <tbody>
                    <?php $i = 1;
                    foreach ($genres as $genre): ?>
                         <tr>
                              <td><?= $i ?></td>
                              <td><?= htmlspecialchars($genre['name']) ?></td>
                              <td>
                                   <a href="admin.php?controller=genres&action=edit&id=<?= $genre['id'] ?>"
                                        class="edit-btn">✏️</a>
                                   <a href="#" class="delete-btn" onclick="deleteGenres(<?= $genre['id'] ?>)">🗑️</a>
                              </td>
                         </tr>
                         <?php $i++; endforeach; ?>
               </tbody>
          </table>
     </div>

</div>