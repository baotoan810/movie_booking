<?php
require_once MODEL_PATH . 'BaseModel.php';

class ReviewModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'reviews');
     }

     // Lấy tất cả bình luận (kèm thông tin người dùng và phim) - Dành cho admin
     public function getAllReviews()
     {
          $query = "SELECT reviews.*, users.username, movies.title 
                 FROM reviews 
                 LEFT JOIN users ON reviews.user_id = users.id 
                 JOIN movies ON reviews.movie_id = movies.id 
                 ORDER BY reviews.created_at DESC";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Nếu user_id là NULL, gán username là "User"
          foreach ($reviews as &$review) {
               if (is_null($review['user_id'])) {
                    $review['username'] = 'User';
               }
          }
          return $reviews;
     }

     // Lấy một bình luận theo ID
     public function getReviewById($review_id)
     {
          $query = "SELECT reviews.*, users.username, movies.title 
                 FROM reviews 
                 LEFT JOIN users ON reviews.user_id = users.id 
                 JOIN movies ON reviews.movie_id = movies.id 
                 WHERE reviews.id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $review_id, PDO::PARAM_INT);
          $stmt->execute();
          $review = $stmt->fetch(PDO::FETCH_ASSOC);

          // Nếu user_id là NULL, gán username là "User"
          if ($review && is_null($review['user_id'])) {
               $review['username'] = 'User';
          }
          return $review;
     }

     // Lấy tất cả bình luận của một phim (dành cho giao diện người dùng)
     public function getReviewsByMovieId($movie_id)
     {
          $query = "SELECT reviews.*, users.username 
                 FROM reviews 
                 LEFT JOIN users ON reviews.user_id = users.id 
                 WHERE reviews.movie_id = :movie_id 
                 ORDER BY reviews.created_at DESC";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
          $stmt->execute();
          $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Nếu user_id là NULL, gán username là "User"
          foreach ($reviews as &$review) {
               if (is_null($review['user_id'])) {
                    $review['username'] = 'User';
               }
          }
          return $reviews;
     }

     // Thêm một bình luận mới
     public function addReview($user_id, $movie_id, $content)
     {
          $data = [
               'user_id' => $user_id, // Có thể là NULL nếu người dùng chưa đăng nhập
               'movie_id' => $movie_id,
               'content' => $content,
               'created_at' => date('Y-m-d H:i:s')
          ];
          $result = $this->add($data);
          if ($result) {
               return $this->conn->lastInsertId();
          }
          return false;
     }

     // Cập nhật bình luận
     public function updateReview($review_id, $content)
     {
          $data = [
               'content' => $content
          ];
          return $this->update($review_id, $data);
     }

     // Xóa một bình luận
     public function deleteReview($review_id)
     {
          return $this->delete($review_id);
     }

     // Kiểm tra xem người dùng có phải là chủ sở hữu của bình luận không
     public function isReviewOwner($review_id, $user_id)
     {
          $query = "SELECT user_id FROM reviews WHERE id = :id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $review_id, PDO::PARAM_INT);
          $stmt->execute();
          $review = $stmt->fetch(PDO::FETCH_ASSOC);
          return $review && $review['user_id'] == $user_id;
     }

     // Lấy danh sách người dùng (dành cho admin)
     public function getAllUsers()
     {
          $query = "SELECT id, username FROM users";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // Lấy danh sách phim (dành cho admin)
     public function getAllMovies()
     {
          $query = "SELECT id, title FROM movies";
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
}