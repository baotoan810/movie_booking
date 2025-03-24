<!-- Danh sách người dùng -->
<div class="content-section">
     <div class="nav">
          <h1>Quản Lý Phim</h1>

          <!-- Search ----  -->
          <form action="index.php" method="get" class="search">
               <input type="hidden" name="controller" value="genres">
               <input type="hidden" name="action" value="index">
               <input type="text" name="search" placeholder="Tìm kiếm thể loại..."
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
               <button type="submit">Tìm kiếm</button>
          </form>


          <!-- btn add -->
          <a href="index.php?controller=genres&action=edit" class="btn-add">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-square-plus">
                    <rect width="18" height="18" x="3" y="3" rx="2" />
                    <path d="M8 12h8" />
                    <path d="M12 8v8" />
               </svg>
          </a>
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
                              <td class="table-setting">
                                   <a href="index.php?controller=genres&action=edit&id=<?= $genre['id']; ?>"
                                        class="btn-edit"><i class="fas fa-edit"></i></a>
                                   <a href="#" class="btn-delete" onclick="deleteGenres(<?= $genre['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                   </a>
                              </td>
                         </tr>
                         <?php $i++; endforeach; ?>
               </tbody>
          </table>
     </div>

</div>

</div>
</div>