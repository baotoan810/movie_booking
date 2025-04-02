<div class="main-content">
     <div class="header">
          <h1>Danh sách bình luận</h1>
          <div class="user-info">
               <span>Xin chào, ADMIN</span>
          </div>
     </div>
     <?php if (empty($reviews)): ?>
          <p>Không có bình luận nào.</p>
     <?php else: ?>
          <div class="table-container">
               <table>
                    <thead>
                         <tr>
                              <th>ID</th>
                              <th>Người dùng</th>
                              <th>Phim</th>
                              <th>Nội dung</th>
                              <th>Ngày tạo</th>
                              <th>Hành động</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php foreach ($reviews as $review): ?>
                              <tr>
                                   <td><?= htmlspecialchars($review['id']) ?></td>
                                   <td><?= htmlspecialchars($review['username']) ?></td>
                                   <td><?= htmlspecialchars($review['title']) ?></td>
                                   <td><?= htmlspecialchars($review['content']) ?></td>
                                   <td><?= htmlspecialchars($review['created_at']) ?></td>
                                   <td class="action-buttons">
                                        <form action="admin.php?controller=review&action=delete" method="post"
                                             onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                             <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                             <button type="submit" class="delete-btn">Xóa</button>
                                        </form>
                                   </td>
                              </tr>
                         <?php endforeach; ?>
                    </tbody>
               </table>
          </div>
     <?php endif; ?>

</div>