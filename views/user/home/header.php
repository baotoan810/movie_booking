<!DOCTYPE html>
<html lang="vi">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Đặt Vé Xem Phim</title>
     <!-- todo: link css -->
     <!-- main css -->
     <link rel="stylesheet" href="./public/css/user/home.css">

     <!-- detail movie -->
     <link rel="stylesheet" href="./public/css/user/detail.css">

     <link rel="stylesheet" href="./public/css/user/news.css">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />     
</head>

<body>
     <!-- Thanh điều hướng -->
     <nav class="navbar">
          <div class="logo">
               <img src="public/img/logo.jpg" alt="">
               <h1>BOOKING MOVIE</h1>
          </div>
          <ul>
               <li><a href="user.php">Trang Chủ</a></li>
               <li><a href="user.php?controller=detail&action=index">Phim</a></li>
               <li><a href="user.php?controller=theater&action=index">Rạp Phim</a></li>
               <li><a href="user.php?controller=news&action=index">Tin Tức Phim</a></li>
               <li><a href="<?php echo BASE_URL; ?>logout">Đăng Xuất</a></li>
               <li>
                    <a href="user.php?controller=booking&action=bookingHistory" class="book-btn">📜 Lịch sử đặt
                         vé</a>
               </li>
               <li class="register-btn">
                    <a href="user.php?controller=booking&action=userProfile">
                         <h2>
                              <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Khách'; ?>
                         </h2>
                    </a>

               </li>


          </ul>
     </nav>