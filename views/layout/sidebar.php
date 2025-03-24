<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- css   -->
    <link rel="stylesheet" href="./public/css/style.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="./public/css/admin.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="./public/css/table.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <a class="logo-link" href="index.php?controller=home&action=index">
                <h2 class="logo">Admin Movie</h2>
            </a>
            <ul class="menu">
                <li class="menu-item has-dropdown">
                    <a href="#">
                        <i class="fas fa-film"></i><span>Quản lý phim</span><i
                            class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="index.php?controller=movie&action=index">Phim</a>
                        </li>
                        <li><a href="index.php?controller=genres&action=index">Thể loại phim</a></li>
                        <li><a href="#">Đánh giá</a></li>
                    </ul>
                </li>

                <li class="menu-item has-dropdown">
                    <a href="#">
                        <i class="fas fa-theater-masks"></i><span>Quản lý rạp</span><i
                            class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="index.php?controller=theater&action=index">Rạp phim</a></li>
                        <li><a href="index.php?controller=seat&action=index">Sơ đồ ghế rạp</a></li>
                        <li><a href="index.php?controller=showtime&action=index">Lịch chiếu phim</a></li>
                    </ul>
                </li>

                <li class="menu-item has-dropdown">
                    <a href="#">
                        <i class="fas fa-ticket-alt"></i><span>Quản lý vé</span><i
                            class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="#">Quản lý đặt vé</a></li>
                        <li><a href="#">Lịch sử đặt vé</a></li>
                        <li><a href="#">Khuyến mãi</a></li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="index.php?controller=user&action=index">
                        <i class="fas fa-users"></i><span>Người dùng</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Content -->
        <div class="content">
            <div class="nav-content">
                <button class="menu-toggle">☰</button>
                <div class="admin-info">
                    <img src="public/images/user-297330_1280.png" alt="" width="30px" height="30px">
                    <p>Xin chào, Admin</p>
                </div>
            </div>