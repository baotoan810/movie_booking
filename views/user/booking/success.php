<div class="success-container">
        <h1>Đặt vé thành công!</h1>
        <p>Mã đặt vé của bạn: <?php echo htmlspecialchars($bookingId); ?></p>
        <a href="user.php?controller=homepage&action=index">🎬 Đặt vé khác</a>
</div>
<style>
        .success-container {
                background-color: #3333;
                padding: 40px 30px;
                border-radius: 12px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                text-align: center;
        }

        .success-container h1 {
                color: #27ae60;
                font-size: 28px;
                margin-bottom: 15px;
        }

        .success-container p {
                font-size: 18px;
                margin-bottom: 20px;
        }

        .success-container a {
                display: inline-block;
                padding: 10px 20px;
                background-color: #3498db;
                color: white;
                text-decoration: none;
                border-radius: 6px;
                transition: background-color 0.3s ease;
        }

        .success-container a:hover {
                background-color: #2980b9;
        }
</style>