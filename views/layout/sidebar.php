<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- css   -->
    <link rel="stylesheet" href="./public/css/style.css?v=<?php echo time(); ?>">


    <link rel="stylesheet" href="./public/css/admin.css?v=<?php echo time(); ?>">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2 class="logo">Admin Movie</h2>
            <ul class="menu">
                <li class="menu-item active"><a href="index.php?controller=user&action=index"><i
                            class="fas fa-users"></i><span>Người Dùng</span></a></li>
                <li class="menu-item active"><a href="index.php?controller=movie&action=index"><i
                            class="fas fa-film"></i><span>Phim</span></a></li>
                <li class="menu-item"><a href="index.php?controller=theater&action=index"><i
                            class="fas fa-theater-masks"></i><span>Rạp phim</span></a></li>
                <li class="menu-item"><a href="#"><i class="fas fa-list"></i><span>Thể loại phim</span></a></li>
                <li class="menu-item"><a href="#"><i class="fas fa-calendar-alt"></i><span>Lịch chiếu phim</span></a>
                </li>
                <li class="menu-item"><a href="#"><i class="fas fa-ticket-alt"></i><span>Quản lý đặt vé</span></a></li>
                <li class="menu-item"><a href="#"><i class="fas fa-tags"></i><span>Khuyến mãi</span></a></li>
                <li class="menu-item"><a href="#"><i class="fas fa-star"></i><span>Đánh giá</span></a></li>
                <li class="menu-item"><a href="#"><i class="fas fa-history"></i><span>Lịch sử đặt vé</span></a></li>
            </ul>
        </div>