<!DOCTYPE html>
<html>

<head>
    <title>Đăng ký</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>

<body>
    <div class="container">
        <h2>Đăng ký tài khoản</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>register" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tên người dùng:</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" name="phone">
            </div>

            <div class="form-group">
                <label>Địa chỉ:</label>
                <input type="text" name="address">
            </div>

            <div class="form-group">
                <label>Ảnh đại diện:</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button type="submit">Đăng ký</button>
        </form>
        <p>Đã có tài khoản? <a href="<?php echo BASE_URL; ?>login">Đăng nhập</a></p>
    </div>
</body>

</html>

<style>
    /* style.css */

    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #1c1c1e;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
        width: 40%;
        /* max-width: 400px; */
        color: #ffffff;
        text-align: center;
    }

    h2 {
        margin-bottom: 24px;
        color: #e50914;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #ccc;
    }

    .form-group input {
        width: 100%;
        padding: 10px 15px;
        border: none;
        border-radius: 8px;
        background-color: #2a2a2c;
        color: #fff;
        font-size: 16px;
        transition: 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        background-color: #333;
        box-shadow: 0 0 5px #e50914;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #e50914;
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s ease;
    }

    button:hover {
        background-color: #bf0810;
    }

    .error {
        background-color: #ff4d4d;
        color: #fff;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    a {
        color: #e50914;
        text-decoration: none;
        transition: 0.2s ease;
    }

    a:hover {
        text-decoration: underline;
    }
</style>