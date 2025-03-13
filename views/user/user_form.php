<!-- Content -->
<div class="content">
    <div class="nav-content">
        <button class="menu-toggle">☰</button>
        <div class="admin-info">
            <p>Xin chào, Admin</p>
        </div>
    </div>

    <!-- Form thêm/sửa người dùng -->
    <div class="content-section">
        <h1><?php echo $user ? 'Sửa Người Dùng' : 'Thêm Người Dùng'; ?></h1>
        <form action="index.php?controller=user&action=save" method="POST" enctype="multipart/form-data"
            class="user-form">
            <?php if ($user): ?>
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <?php endif; ?>
            <div class="form-group">
                <label>Tên Đăng Nhập:</label>
                <input type="text" name="username" value="<?php echo $user['username'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $user['email'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Mật Khẩu:</label>
                <input type="password" name="password" <?php echo $user['password'] ?? ''; ?>>
            </div>
            <div class="form-group">
                <label>Số Điện Thoại:</label>
                <input type="text" name="phone" value="<?php echo $user['phone'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label>Địa Chỉ:</label>
                <input type="text" name="address" value="<?php echo $user['address'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label>Hình Ảnh Hiện Tại:</label>
                <?php if ($user && $user['image'] && file_exists($user['image'])): ?>
                    <img src="<?php echo $user['image']; ?>" alt="Hình ảnh của <?php echo $user['username']; ?>"
                        class="user-image-preview">
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
        <a href="index.php?controller=user&action=index" class="btn-back"><i class="fas fa-arrow-left"></i> Quay
            Lại</a>
    </div>
</div>


<style>
    .content-section {
        height: 572px;
        overflow-y: auto;
    }
</style>