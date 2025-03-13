<!-- Content -->
<div class="content">
    <div class="nav-content">
        <button class="menu-toggle">☰</button>
        <div class="admin-info">
            <p>Xin chào, Admin</p>
        </div>
    </div>

    <!-- Danh sách người dùng -->
    <div class="content-section">
        <h1>Quản Lý Người Dùng</h1>
        <a href="index.php?controller=user&action=edit" class="btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                <g data-name="88-Option Add">
                    <path
                        d="M29 4h-3V3a3 3 0 0 0-3-3H3a3 3 0 0 0-3 3v20a3 3 0 0 0 3 3h1v3a3 3 0 0 0 3 3h22a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zM4 7v17H3a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h20a1 1 0 0 1 1 1v1H7a3 3 0 0 0-3 3zm26 22a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h22a1 1 0 0 1 1 1z" />
                    <path d="M19 11h-2v6h-6v2h6v6h2v-6h6v-2h-6v-6z" />
                </g>
            </svg> </a>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Đăng Nhập</th>
                        <th>Email</th>
                        <th>Số Điện Thoại</th>
                        <th>Địa Chỉ</th>
                        <th>Vai Trò</th>
                        <th>Avatar</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['phone']; ?></td>
                            <td><?php echo $user['address']; ?></td>

                            <td>
                                <?php if ($user['image'] && file_exists($user['image'])): ?>
                                    <img src="<?php echo $user['image']; ?>" alt="Hình ảnh của <?php echo $user['username']; ?>"
                                        class="user-image">
                                <?php else: ?>
                                    <span>Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $user['role']; ?></td>

                            <td class="action-form">
                                <a href="index.php?controller=user&action=edit&id=<?php echo $user['id']; ?>"
                                    class="btn-edit"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn-delete" onclick="deleteUser(<?php echo $user['id']; ?>)">
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