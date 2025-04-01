<!DOCTYPE html>
<html>

<head>
        <title>Chỉnh sửa bình luận</title>
        <style>
                body {
                        background-color: #121212;
                        color: #fff;
                        font-family: Arial, sans-serif;
                        padding: 20px;
                }

                h1 {
                        font-size: 28px;
                        color: #fdd835;
                        text-align: center;
                        margin-bottom: 20px;
                }

                .review-form {
                        background: #1a1a1a;
                        padding: 20px;
                        border-radius: 10px;
                        max-width: 600px;
                        margin: 0 auto;
                }

                .review-form h3 {
                        font-size: 20px;
                        color: #fdd835;
                        margin-bottom: 15px;
                }

                .review-form textarea {
                        width: 100%;
                        height: 100px;
                        background: #333;
                        color: #fff;
                        border: none;
                        border-radius: 5px;
                        padding: 10px;
                        font-size: 16px;
                        resize: none;
                }

                .submit-review {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #fdd835;
                        color: #121212;
                        border: none;
                        border-radius: 5px;
                        font-weight: bold;
                        cursor: pointer;
                        margin-top: 10px;
                        transition: 0.3s;
                }

                .submit-review:hover {
                        background-color: #ffc107;
                }
        </style>
</head>

<body>
        <h1>Chỉnh sửa bình luận</h1>
        <form class="review-form" method="POST"
                action="user.php?controller=review&action=edit&review_id=<?php echo $review['id']; ?>&movie_id=<?php echo $movie_id; ?>">
                <h3>Chỉnh sửa bình luận của bạn</h3>
                <textarea name="content" placeholder="Nhập bình luận của bạn..."
                        required><?php echo htmlspecialchars($review['content']); ?></textarea>
                <button type="submit" class="submit-review">Cập nhật bình luận</button>
        </form>
</body>

</html>