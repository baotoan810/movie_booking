<!-- Danh sách người dùng -->
<div class="content-section">
     <div class="nav">
          <h1>Quản Lý Phim</h1>

          <!-- Search ----  -->
          <form action="index.php" method="get" class="search">
               <input type="hidden" name="controller" value="movie">
               <input type="hidden" name="action" value="index">
               <input type="text" name="search" placeholder="Tìm kiếm phim..."
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
               <button type="submit">Tìm kiếm</button>
          </form>

          <!-- btn add -->
          <a href="index.php?controller=movie&action=edit" class="btn-add">
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
                         <th>Tên Phim</th>
                         <th>Thời Lượng</th>
                         <th>Ngày Tạo</th>
                         <th>Thể Loại</th>
                         <th>Ảnh Poster</th>
                         <th>Thao Tác</th>
                    </tr>
               </thead>
               <tbody>
                    <?php $i = 1;
                    foreach ($movies as $movie): ?>
                         <tr>
                              <td><?= $i ?></td>
                              <td><?= htmlspecialchars($movie['title']) ?></td>
                              <td><?= htmlspecialchars($movie['duration']) ?></td>
                              <td><?= htmlspecialchars($movie['release_date']) ?></td>
                              <td><?= htmlspecialchars($movie['genres'] ?: 'Chưa có thể loại') ?></td>


                              <td>
                                   <?php if ($movie['poster_path'] && file_exists($movie['poster_path'])): ?>
                                        <img src="<?= htmlspecialchars($movie['poster_path']) ?>" alt="Poster" class="image-user">
                                   <?php else: ?>
                                        <span>Không có ảnh</span>
                                   <?php endif; ?>
                              </td>


                              <td class="table-setting">
                                   <a href="index.php?controller=movie&action=view&id=<?= $movie['id']; ?>"
                                        class="btn-view"><i class="fa fa-eye"></i></a>
                                   <a href="index.php?controller=movie&action=edit&id=<?= $movie['id']; ?>"
                                        class="btn-edit"><i class="fas fa-edit"></i></a>
                                   <a href="#" class="btn-delete" onclick="deleteMovie(<?= $movie['id']; ?>)">
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
