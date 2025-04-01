<?php
require_once DATABASE_PATH . 'config.php';
require_once MODEL_PATH . 'AuthModel.php';

// Nếu dùng Composer, thêm autoload cho PHPMailer
require_once BASH_PATH . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {
    private $authModel;

    public function __construct($pdo) {
        $this->authModel = new AuthModel($pdo);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone = $_POST['phone'] ?? null;
            $address = $_POST['address'] ?? null;
            $image = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed)) {
                    $newFilename = uniqid() . '.' . $ext;
                    $uploadPath = PUBLIC_PATH . 'images/' . $newFilename;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $image = 'public/images/' . $newFilename;
                    } else {
                        $error = "Không thể upload ảnh";
                    }
                } else {
                    $error = "Định dạng ảnh không được hỗ trợ";
                }
            }

            if (empty($username) || empty($email) || empty($password)) {
                $error = "Vui lòng điền đầy đủ thông tin bắt buộc";
            } elseif ($this->authModel->emailExists($email)) {
                $error = "Email đã được sử dụng";
            } else {
                if ($this->authModel->register($username, $email, $password, $phone, $address, $image)) {
                    header("Location: " . BASE_URL . "login");
                    exit;
                } else {
                    $error = "Đăng ký thất bại, vui lòng thử lại";
                }
            }
        }
        require_once VIEW_PATH . 'auth/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->authModel->login($email, $password);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['image'] = $user['image'];

                if ($user['role'] === 'admin') {
                    header("Location: " . BASE_URL . "admin");
                } else {
                    header("Location: " . BASE_URL . "user");
                }
                exit;
            } else {
                $error = "Email hoặc mật khẩu không đúng";
            }
        }
        require_once VIEW_PATH . 'auth/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: " . BASE_URL . "login");
        exit;
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email)) {
                $error = "Vui lòng nhập email";
            } elseif (!$this->authModel->emailExists($email)) {
                $error = "Email không tồn tại";
            } else {
                // Tạo token và lưu vào database
                $token = $this->authModel->createPasswordResetToken($email);
                if ($token) {
                    // Gửi email chứa link đặt lại mật khẩu
                    $resetLink = BASE_URL . "reset?email=" . urlencode($email) . "&token=" . $token;
                    $subject = "Đặt lại mật khẩu";
                    $message = "Nhấn vào link sau để đặt lại mật khẩu: <a href='$resetLink'>$resetLink</a>";
                    $message .= "<br>Link này sẽ hết hạn sau 1 giờ.";

                    // Gửi email bằng PHPMailer
                    $mail = new PHPMailer(true);
                    try {
                        // Cấu hình server email (dùng Gmail làm ví dụ)
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'baotoandep810@gmail.com'; // Thay bằng email của bạn
                        $mail->Password = 'gfznyscxsclahshr'; // Thay bằng App Password của Gmail
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        // Người gửi và người nhận
                        $mail->setFrom('baotoandep810@gmail.com', 'PassWord Reset');
                        $mail->addAddress($email);

                        // Nội dung email
                        $mail->isHTML(true);
                        // Mã hóa tiêu đề để hỗ trợ tiếng Việt
                        $mail->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
                        $mail->Body = $message;

                        $mail->send();
                        $success = "Link đặt lại mật khẩu đã được gửi đến email của bạn.";
                    } catch (Exception $e) {
                        $error = "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
                    }
                } else {
                    $error = "Có lỗi xảy ra, vui lòng thử lại.";
                }
            }
        }
        require_once VIEW_PATH . 'auth/forgot.php';
    }

    public function resetPassword() {
        $email = '';
        $token = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $token = $_POST['token'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';

            if (empty($email) || empty($token) || empty($newPassword)) {
                $error = "Vui lòng điền đầy đủ thông tin";
            } elseif (!$this->authModel->verifyPasswordResetToken($email, $token)) {
                $error = "Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn";
            } else {
                if ($this->authModel->resetPassword($email, $newPassword)) {
                    $success = "Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.";
                } else {
                    $error = "Có lỗi xảy ra, vui lòng thử lại.";
                }
            }
        } else {
            // Chỉ gán từ $_GET nếu không phải POST
            $email = $_GET['email'] ?? '';
            $token = $_GET['token'] ?? '';
        }

        require_once VIEW_PATH . 'auth/reset.php';
    }
}
?>