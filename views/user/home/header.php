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
               <li><a href="index.php?controller=auth&action=logout">Đăng Xuất</a></li>
               <li class="register-btn">
                    <h2>
                         <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Khách'; ?>
                    </h2>

                    <?php if (isset($_SESSION['user_image']) && !empty($_SESSION['user_image'])): ?>
                         <img width="50px" height="50px" src="<?php echo BASE_URL . $_SESSION['user_image']; ?>"
                              alt="Hình đại diện" class="user-image">
                    <?php else: ?>
                         <p>Chưa có hình đại diện.</p>
                    <?php endif; ?>
               </li>


          </ul>
     </nav>


     <script>
          window.addEventListener('scroll', function () {
               const navbar = document.querySelector('.navbar');
               if (window.scrollY > 200) {
                    navbar.classList.add('scrolled');
               } else {
                    navbar.classList.remove('scrolled');
               }
          });
     </script>