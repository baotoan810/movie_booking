<?php
require_once MODEL_PATH . 'BaseModel.php';

class NewsModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'news');
     }

     // Lấy tất cả tin tức
     public function getAllNews()
     {
          $query = "SELECT * FROM news ORDER BY created_at DESC";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Lấy một tin tức theo ID
     public function getNewsById($id)
     {
          return $this->getById($id);
     }

     // Thêm tin tức mới
     public function addNews($title, $content, $image = null)
     {
          $data = [
               'title' => $title,
               'content' => $content,
               'image' => $image
          ];
          $result = $this->add($data);
          if ($result) {
               return $this->conn->lastInsertId();
          }
          return false;
     }

     // Cập nhật tin tức
     public function updateNews($id, $title, $content, $image = null)
     {
          $data = [
               'title' => $title,
               'content' => $content
          ];
          if ($image !== null) {
               $data['image'] = $image;
          }
          return $this->update($id, $data);
     }

     // Xóa tin tức
     public function deleteNews($id)
     {
          return $this->delete($id);
     }
}
?>