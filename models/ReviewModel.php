<?php
require_once MODEL_PATH . 'BaseModel.php';

class ReviewModel extends BaseModel
{
     public function __construct($conn)
     {
          parent::__construct($conn, 'reviews');
     }

     public function addReview($user_id, $movie_id, $content)
     {
          $data = [
               'user_id' => $user_id,
               'movie_id' => $movie_id,
               'content' => $content,
               'created_at' => date('Y-m-d H:i:s')
          ];
          return $this->add($data);
     }

     public function updateReview($id, $content)
     {
          $data = [
               'content' => $content
          ];
          return $this->update($id, $data);
     }

     public function deleteReview($id)
     {
          return $this->delete($id);
     }

     public function getReviewById($id)
     {
          return $this->getById($id);
     }

     public function getReviewsByMovieId($movie_id)
     {
          $query = "
               SELECT r.*, u.username
               FROM reviews r
               INNER JOIN users u ON r.user_id = u.id
               WHERE r.movie_id = :movie_id
               ORDER BY r.created_at DESC
          ";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Phương thức mới: Kiểm tra xem người dùng đã bình luận cho phim này chưa
     public function hasUserReviewed($user_id, $movie_id)
     {
          $query = "
               SELECT COUNT(*) as count
               FROM reviews
               WHERE user_id = :user_id AND movie_id = :movie_id
          ";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
          $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result['count'] > 0;
     }
}
?>