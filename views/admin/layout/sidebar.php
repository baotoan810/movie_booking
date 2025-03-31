<!DOCTYPE html>
<html lang="vi">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Quản Lý Rạp</title>
     <link rel="stylesheet" href="./public/css/admin/style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
     <div class="container">
          <!-- Sidebar -->
          <div class="sidebar">
               <div class="logo">
                    <a href="admin.php?controller=home&action=index" class="title-admin">Admin Movie</a>
               </div>
               <ul>
                    <li class="dropdown">
                         <a href="#" class="dropdown-toggle ">QUẢN LÝ PHIM</a>
                         <ul class="dropdown-menu">
                              <li><a href="admin.php?controller=movie&action=index">Danh sách phim</a></li>
                              <li><a href="admin.php?controller=genres&action=index">Thể loại phim</a></li>
                              <li><a href="admin.php?controller=review&action=index">đánh giá phim</a></li>
                              <li><a href="admin.php?controller=news&action=index">tin tức phim</a></li>
                         </ul>
                    </li>
                    <li class="dropdown">
                         <a href="#" class="dropdown-toggle">QUẢN LÝ RẠP</a>
                         <ul class="dropdown-menu">
                              <li><a href="admin.php?controller=theater&action=index">Danh sách rạp</a></li>
                              <li><a href="admin.php?controller=room&action=index">Danh sách phòng</a></li>
                              <li><a href="admin.php?controller=theater_seats&action=index">Sơ đồ rạp</a></li>
                         </ul>
                    </li>
                    <li class="dropdown">
                         <a href="#" class="dropdown-toggle">QUẢN LÝ SUẤT CHIẾU</a>
                         <ul class="dropdown-menu">
                              <li><a href="admin.php?controller=showtime&action=index">Danh sách suất chiếu</a></li>
                              <li><a href="admin.php?controller=booking&action=index">Quản lý đặt vé vé</a></li>
                         </ul>
                    </li>
                    <li class="dropdown">
                         <a href="#" class="dropdown-toggle">NGƯỜI DÙNG</a>
                         <ul class="dropdown-menu">
                              <li><a href="admin.php?controller=user&action=index">Danh sách người dùng</a></li>
                              <li><a href="#">Lịch sử đặt vé</a></li>
                         </ul>
                    </li>

               </ul>
          </div>