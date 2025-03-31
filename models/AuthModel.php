<?php
// models/AuthModel.php
class AuthModel
{
     private $db;

     public function __construct($db)
     {
          $this->db = $db;
     }

     // 📌 Tìm user theo email
     public function findByEmail($email)
     {
          try {
               $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
               $stmt->execute([$email]);
               return $stmt->fetch();
          } catch (PDOException $e) {
               return null;
          }
     }

     // 📌 Tìm user theo ID
     public function findById($id)
     {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
          $stmt->execute([$id]);
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }


     // 📌 Tạo user mới
     public function create($data)
     {
          try {
               $stmt = $this->db->prepare("
                    INSERT INTO users (username, email, password, phone, address, image, role, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
               ");
               return $stmt->execute([
                    $data['username'],
                    $data['email'],
                    $data['password'],  // Lưu mật khẩu đã mã hóa
                    $data['phone'],
                    $data['address'],
                    $data['image'],  // Chỉ lưu đường dẫn ảnh
                    $data['role']
               ]);
          } catch (PDOException $e) {
               return false;
          }
     }
}
