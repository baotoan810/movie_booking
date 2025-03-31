<!-- views/admin/layout/home.php -->
<div class="main-content admin-main-content">
     <div class="main admin-main">
          <h2 class="admin-title">Trang Admin</h2>
          <p class="admin-welcome">Chào mừng đến với trang Admin</p>
          <a href="index.php?controller=auth&action=logout" class="admin-logout-btn">Đăng Xuất</a>
     </div>
</div>

<style>
     .admin-main-content {
          background-image: url('<?php echo BASE_URL; ?>public/images/bg.jpg');
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
          background-attachment: fixed;
          z-index: 111;
          min-height: 100vh;
          /* Đảm bảo chiều cao tối thiểu bằng chiều cao màn hình */
          padding: 20px;
     }

     .admin-main {
          display: flex;
          justify-content: flex-start;
          align-items: center;
          flex-direction: column;
          background-color: rgba(255, 255, 255, 0.9);
          /* Nền trắng mờ để nổi bật trên hình nền */
          border-radius: 10px;
          padding: 30px;
          max-width: 600px;
          margin: 0 auto;
          box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
     }

     .admin-title {
          font-size: 28px;
          text-align: center;
          margin-top: 20px;
          color: #333;
     }

     .admin-welcome {
          font-size: 20px;
          text-align: center;
          color: #555;
          margin-bottom: 20px;
     }

     .admin-logout-btn {
          display: inline-block;
          margin-top: 20px;
          padding: 10px 20px;
          background-color: #dc3545;
          color: white;
          text-decoration: none;
          border-radius: 4px;
          transition: background-color 0.3s ease;
     }

     .admin-logout-btn:hover {
          background-color: #c82333;
     }
</style>