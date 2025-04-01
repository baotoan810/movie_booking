<!DOCTYPE html>
<html>
<head>
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
<div class="container">
    <h2>Quên mật khẩu</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="<?php echo BASE_URL; ?>forgot">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <button type="submit">Gửi yêu cầu</button>
    </form>
    <p>Quay lại <a href="<?php echo BASE_URL; ?>login">Đăng nhập</a></p>
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
        width: 100%;
        max-width: 400px;
        color: #ffffff;
        text-align: center;
        animation: fadeIn 0.6s ease-in-out;
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

    a {
        color: #e50914;
        text-decoration: none;
        transition: 0.2s ease;
    }

    a:hover {
        text-decoration: underline;
    }

    .error, .success {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .error {
        background-color: #ff4d4d;
        color: white;
    }

    .success {
        background-color: #4caf50;
        color: white;
    }

    /* Optional fade-in animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

</style>