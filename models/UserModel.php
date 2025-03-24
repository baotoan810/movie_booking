<?php
require_once MODEL_PATH . 'BaseModel.php';

class UserModel extends BaseModel
{
     public function __construct($db)
     {
          // Gọi constructor của BaseModel với tên bảng là 'users'
          parent::__construct($db, 'users');
     }

     public function addUser($username, $email, $password, $phone, $address, $image, $role)
     {
          $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
          $data = [
               'username' => $username,
               'email' => $email,
               'password' => $hashedPassword,
               'phone' => $phone,
               'address' => $address,
               'image' => $image,
               'role' => $role
          ];

          return $this->add($data);
     }


     public function updateUser($id, $username, $email, $password, $phone, $address, $image, $role)
     {
          $currentUser = $this->getById($id);
          if (empty($image)) {
               $image = $currentUser['image'];
          }

          $data = [
               'username' => $username,
               'email' => $email,
               'phone' => $phone,
               'address' => $address,
               'image' => $image,
               'role' => $role
          ];

          if (!empty($password)) {
               $data['password'] = password_hash($password, PASSWORD_BCRYPT);
          }

          return $this->update($id, $data);
     }



     public function deleteUser($id)
     {
          return $this->delete($id);
     }

     // Tìm kiếm
     public function searchUsers($keyword)
     {
          return $this->search('username', $keyword);
     }

     // Kiểm tra trùng email
     public function emailExists($email, $excludeId = null)
     {
          $query = "SELECT id FROM users WHERE email = :email";

          if ($excludeId) {
               $query .= " AND id != :excludeId"; // Không kiểm tra trùng với user đang chỉnh sửa
          }

          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':email', $email, PDO::PARAM_STR);

          if ($excludeId) {
               $stmt->bindParam(':excludeId', $excludeId, PDO::PARAM_INT);
          }

          $stmt->execute();

          return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
     }

}
?>