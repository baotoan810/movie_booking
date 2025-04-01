<?php
require_once DATABASE_PATH . 'database.php';

class AuthModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($username, $email, $password, $phone = null, $address = null, $image = null) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, phone, address, image, role) 
                VALUES (:username, :email, :password, :phone, :address, :image, 'user')");

            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':phone' => $phone,
                ':address' => $address,
                ':image' => $image
            ]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    // Thêm token đặt lại mật khẩu vào bảng password_resets
    public function createPasswordResetToken($email) {
        try {
            $token = bin2hex(random_bytes(32)); // Tạo token ngẫu nhiên, an toàn và duy nhất
            $stmt = $this->pdo->prepare("INSERT INTO password_resets (email, token) VALUES (:email, :token)");
            $stmt->execute([':email' => $email, ':token' => $token]);
            return $token;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Kiểm tra token đặt lại mật khẩu
    public function verifyPasswordResetToken($email, $token) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM password_resets WHERE email = :email AND token = :token LIMIT 1");
            $stmt->execute([':email' => $email, ':token' => $token]);
            $reset = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reset) {
                // Kiểm tra thời gian hết hạn (ví dụ: 1 giờ)
                $createdAt = new DateTime($reset['created_at']);
                $now = new DateTime();
                $interval = $now->diff($createdAt);
                if ($interval->h < 24) { // Token hết hạn sau 1 giờ
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật mật khẩu mới
    public function resetPassword($email, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
            $stmt->execute([':password' => $hashedPassword, ':email' => $email]);

            // Xóa token sau khi đặt lại mật khẩu
            $stmt = $this->pdo->prepare("DELETE FROM password_resets WHERE email = :email");
            $stmt->execute([':email' => $email]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>