<div class="main-content">

     <div class="header">
          <h1>Quản Lý Tin Tức</h1>
          <div class="user-info">
               <span>Xin chào, ADMIN</span>
          </div>
     </div>
     <div class="nav-search">
          <div class="add">
               <a href="admin.php?controller=news&action=edit" class="add-btn">
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
     <?php if (empty($news)): ?>
          <p>Không có tin tức nào.</p>
     <?php else: ?>
          <table>
               <thead>
                    <tr>
                         <th>ID</th>
                         <th>Hình ảnh</th>
                         <th>Tiêu đề</th>
                         <th>Nội dung</th>
                         <th>Ngày tạo</th>
                         <th>Hành động</th>
                    </tr>
               </thead>
               <tbody>
                    <?php foreach ($news as $newsItem): ?>
                         <tr>
                              <td><?= htmlspecialchars($newsItem['id']) ?></td>
                              <td>
                                   <?php if ($newsItem['image']): ?>
                                        <img src="<?= htmlspecialchars($newsItem['image']) ?>" alt="Hình ảnh tin tức"
                                             class="image-user">
                                   <?php else: ?>
                                        Không có hình ảnh
                                   <?php endif; ?>
                              </td>
                              <td><?= htmlspecialchars($newsItem['title']) ?></td>
                              <td><?= htmlspecialchars(substr($newsItem['content'], 0, 100)) . (strlen($newsItem['content']) > 100 ? '...' : '') ?>
                              </td>
                              <td><?= htmlspecialchars($newsItem['created_at']) ?></td>
                              <td>
                                   <a href="admin.php?controller=news&action=edit&id=<?= $newsItem['id'] ?>"
                                        class="edit-btn">✏️</a>
                                   <a href="#" class="delete-btn" onclick="deleteNews(<?= $newsItem['id'] ?>)">🗑️</a>
                              </td>
                         </tr>
                    <?php endforeach; ?>
               </tbody>
          </table>
     <?php endif; ?>

</div>