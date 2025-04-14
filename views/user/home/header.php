<!DOCTYPE html>
<html lang="vi">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Đặt Vé Xem Phim</title>

     <!-- CSS -->
     <link rel="stylesheet" href="./public/css/user/home.css">
     <link rel="stylesheet" href="./public/css/user/detail.css">
     <link rel="stylesheet" href="./public/css/user/news.css">

     <!-- Font Awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

     <style>
          .navbar {
               display: flex;
               justify-content: space-between;
               align-items: center;
               padding: 30px;
               background-color: #222;
               color: white;
               flex-wrap: wrap;
          }

          .navbar .logo {
               display: flex;
               align-items: center;
               gap: 10px;
          }

          .navbar .logo img {
               width: 40px;
               height: 40px;
               object-fit: cover;
               border-radius: 50%;
          }

          .menu-toggle {
               display: none;
               font-size: 24px;
               cursor: pointer;
               color: white;
          }

          .navbar ul {
               display: flex;
               gap: 20px;
               list-style: none;
               margin: 0;
               padding: 0;
          }

          .navbar ul li a {
               color: white;
               text-decoration: none;
               font-weight: 500;
          }


          /* Responsive */
          @media (max-width: 768px) {
               .menu-toggle {
                    display: block;
               }

               .navbar ul {
                    display: none;
                    flex-direction: column;
                    width: 100%;
                    background-color: #333;
                    padding: 10px 0;
                    margin-top: 10px;
               }

               .navbar ul.active {
                    display: flex;
               }

               .navbar ul li {
                    text-align: center;
                    padding: 10px 0;
               }
          }
     </style>
</head>

<body>

     <nav class="navbar">
          <div class="logo">
               <img src="public/img/logo.jpg" alt="Logo">
               <h1>BOOKING MOVIE</h1>
          </div>

          <!-- Hamburger menu -->
          <div class="menu-toggle" id="mobile-menu">
               <i class="fas fa-bars"></i>
          </div>

          <!-- Menu -->
          <ul id="nav-links">
               <li><a href="user.php">Trang Chủ</a></li>
               <li><a href="user.php?controller=detail&action=index">Phim</a></li>
               <li><a href="user.php?controller=theater&action=index">Rạp Phim</a></li>
               <li><a href="user.php?controller=news&action=index">Tin Tức Phim</a></li>
               <li><a href="<?php echo BASE_URL; ?>logout">Đăng Xuất</a></li>
               <li><a href="user.php?controller=booking&action=bookingHistory" class="book-btn">📜 Lịch sử đặt vé</a>
               </li>
               <li class="register-btn">
                    <a href="user.php?controller=booking&action=userProfile">
                         <h2><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Khách'; ?>
                         </h2>
                    </a>
               </li>
          </ul>
     </nav>

     <script>
          document.addEventListener('DOMContentLoaded', function () {
               const mobileMenu = document.getElementById('mobile-menu');
               const navLinks = document.getElementById('nav-links');

               mobileMenu.addEventListener('click', function () {
                    navLinks.classList.toggle('active');
               });
          });
     </script>