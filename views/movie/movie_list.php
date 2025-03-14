<!-- Content -->
<div class="content">
     <div class="nav-content">
          <button class="menu-toggle">☰</button>
          <div class="admin-info">
               <p>Xin chào, Admin</p>
          </div>
     </div>

     <!-- Danh sách phim -->
     <div class="content-section">
          <h1>Quản Lý Phim</h1>
          <a href="index.php?controller=movie&action=edit" class="btn-add">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <g data-name="88-Option Add">
                         <path
                              d="M29 4h-3V3a3 3 0 0 0-3-3H3a3 3 0 0 0-3 3v20a3 3 0 0 0 3 3h1v3a3 3 0 0 0 3 3h22a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zM4 7v17H3a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h20a1 1 0 0 1 1 1v1H7a3 3 0 0 0-3 3zm26 22a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h22a1 1 0 0 1 1 1z" />
                         <path d="M19 11h-2v6h-6v2h6v6h2v-6h6v-2h-6v-6z" />
                    </g>
               </svg>
          </a>
          <div class="table-container">
               <table>
                    <thead>
                         <tr>
                              <th>ID</th>
                              <th>Tên Phim</th>
                              <th>Mô tả</th>
                              <th>Thời lượng <span>(phút)</span></th>
                              <th>Ngày phát hành</th>
                              <th>View</th>
                              <!-- <th>Ngày tạo</th> -->
                              <th>Ảnh Poster</th>
                              <th>Thao Tác</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php foreach ($movies as $movie): ?>
                              <tr>
                                   <td><?php echo $movie['id']; ?></td>
                                   <td><?php echo $movie['title']; ?></td>
                                   <td><?php echo $movie['description']; ?></td>
                                   <td><?php echo $movie['duration']; ?></td>
                                   <td><?php echo $movie['release_date']; ?></td>
                                   <td><?php echo $movie['view']; ?></td>
                                   <!-- <td><?php echo $movie['created_at']; ?></td> -->
                                   <td>
                                        <img class="user-image" src="<?php echo $movie['trailer_path']; ?>"
                                             alt="Image Poster">
                                   </td>

                                   <td class="action-form">
                                        <a href="index.php?controller=movie&action=edit&id=<?php echo $movie['id']; ?>"
                                             class="btn-edit"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn-delete" onclick="deleteMovie(<?php echo $movie['id']; ?>)">
                                             <i class="fas fa-trash"></i>
                                        </a>
                                   </td>

                              </tr>
                         <?php endforeach; ?>
                    </tbody>
               </table>
          </div>

     </div>

</div>
</div>