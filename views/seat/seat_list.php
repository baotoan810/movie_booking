<!-- Danh sách ghế -->
<div class="content-section">
     <div class="nav">
          <h1>Quản Lý Ghế</h1>

          <!-- Nút thêm ghế -->
          <a href="index.php?controller=seat&action=edit" class="btn-add">
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
                         <th>Tên Rạp</th>
                         <th>Hàng</th>
                         <th>Cột</th>
                         <th>Loại Ghế</th>
                         <th>Giá</th>
                         <th>Tổng Số Ghế</th>
                         <th>Thao Tác</th>
                    </tr>
               </thead>
               <tbody>
                    <?php
                    $i = 1;
                    foreach ($seats as $seat): ?>
                         <tr>
                              <td><?= $i ?></td>
                              <td><?= htmlspecialchars($seat['theater_name']) ?></td> <!-- Hiển thị tên rạp -->
                              <td><?= htmlspecialchars($seat['row']) ?></td>
                              <td><?= htmlspecialchars($seat['column']) ?></td>
                              <td><?= htmlspecialchars($seat['type_seat']) ?></td>
                              <td><?= number_format($seat['price'], 0, ',', '.') ?> VNĐ</td>
                              <td><?= htmlspecialchars($seat['capacity']) ?></td> <!-- Hiển thị tổng số ghế -->
                              <td class="table-setting">
                                   <a href="index.php?controller=seat&action=showSeatMap&theater_id=<?= $seat['theater_id']; ?>"
                                        class="btn-view">
                                        <i class="fa fa-eye"></i> 
                                   </a>
                                   <a href="index.php?controller=seat&action=edit&id=<?= $seat['id']; ?>" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                   </a>
                                   <form action="index.php?controller=seat&action=delete" method="POST"
                                        style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $seat['id']; ?>">
                                        <button type="submit" class="btn-delete"
                                             onclick="return confirm('Bạn có chắc chắn muốn xóa ghế này không?')">
                                             <i class="fas fa-trash"></i>
                                        </button>
                                   </form>
                              </td>
                         </tr>
                         <?php
                         $i++;
                    endforeach; ?>
               </tbody>
          </table>
     </div>
</div>