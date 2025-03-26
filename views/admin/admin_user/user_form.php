<!-- Form thêm/sửa người dùng -->
<div class="main-content">
     <a href="index.php?controller=user&action=index" class="btn-back">
          <i class="fas fa-arrow-left"></i> Quay Lại
     </a>
     <div class="content-section">
          <h1><?php echo $user ? 'Sửa Người Dùng' : 'Thêm Người Dùng'; ?></h1>
          <form action="index.php?controller=user&action=save" method="POST" enctype="multipart/form-data"
               class="user-form">
               <?php if ($user): ?>
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
               <?php endif; ?>
               <div class="form-group">
                    <label>Tên Đăng Nhập:</label>
                    <input type="text" name="username" value="<?php echo $user['username'] ?? ''; ?>"
                         placeholder="Nhập tên đăng nhập" required>
               </div>
               <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?php echo $user['email'] ?? ''; ?>"
                         placeholder="Nhập địa chỉ email" required>
               </div>
               <div class="form-group">
                    <label>Mật Khẩu:</label>
                    <input type="password" name="password" placeholder="Nhập mật khẩu" minlength="8">
               </div>
               <div class="form-group">
                    <label>Số Điện Thoại:</label>
                    <input type="text" name="phone" value="<?php echo $user['phone'] ?? ''; ?>"
                         placeholder="Nhập số điện thoại">
               </div>
               <div class="form-group">
                    <label>Địa Chỉ:</label>
                    <input type="text" name="address" value="<?php echo $user['address'] ?? ''; ?>"
                         placeholder="Nhập địa chỉ của bạn">
               </div>
               <div class="form-group">
                    <label>Hình Ảnh Hiện Tại:</label>
                    <?php if ($user && $user['image'] && file_exists($user['image'])): ?>
                         <img width="80px" height="80px" src="<?php echo $user['image']; ?>"
                              alt="Hình ảnh của <?php echo $user['username']; ?>" class="user-image-preview">
                    <?php else: ?>
                         <span>Không có ảnh</span>
                    <?php endif; ?>
               </div>
               <div class="form-group">
                    <label>Upload Hình Ảnh Mới:</label>
                    <input type="file" name="image">
               </div>
               <div class="form-group">
                    <label>Vai Trò:</label>
                    <select name="role">
                         <option value="user" <?php echo ($user['role'] ?? '') == 'user' ? 'selected' : ''; ?>>User
                         </option>
                         <option value="admin" <?php echo ($user['role'] ?? '') == 'admin' ? 'selected' : ''; ?>>Admin
                         </option>
                    </select>
               </div>
               <button type="submit" class="btn-save"><i class="fas fa-save"></i> Lưu</button>
          </form>
     </div>

</div>