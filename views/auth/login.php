<!DOCTYPE html>
<html lang="vi">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Đăng nhập</title>
     <link rel="stylesheet" href="<?= BASE_URL ?>public/css/auth.css">
</head>

<body>

     <div class="container">
          <h2>Đăng nhập</h2>
          <form action="<?= BASE_URL ?>index.php?action=handleLogin" method="post">
               <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
               </div>
               <div class="input-group">
                    <input type="password" name="password" placeholder="Mật khẩu" required>
               </div>
               <button type="submit" class="btn">Đăng nhập</button>
          </form>
          <div class="toggle-form">
               <p>Chưa có tài khoản? <a href="<?= BASE_URL ?>index.php?action=register">Đăng ký</a></p>
          </div>
     </div>

</body>

</html>
<style>
     * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: Arial, sans-serif;
     }

     body {
          background: linear-gradient(135deg, #667eea, #764ba2);
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
     }

     .container {
          width: 350px;
          background: #fff;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
          text-align: center;
     }

     h2 {
          margin-bottom: 20px;
     }

     .input-group {
          margin-bottom: 15px;
     }

     .input-group input {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
          outline: none;
     }

     .btn {
          width: 100%;
          padding: 10px;
          background: #667eea;
          color: white;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          font-size: 16px;
     }

     .btn:hover {
          background: #5643a9;
     }

     .toggle-form {
          margin-top: 15px;
     }

     .toggle-form a {
          color: #667eea;
          text-decoration: none;
          font-weight: bold;
     }

     .toggle-form a:hover {
          text-decoration: underline;
     }
</style>