-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 04:53 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `table_movie`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `showtime_id` int NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `booking_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','confirmed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `promotion_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `showtime_id`, `total_price`, `booking_time`, `status`, `promotion_id`) VALUES
(69, 51, 42, 100000.00, '2025-04-15 09:32:29', 'confirmed', NULL),
(70, 51, 43, 120000.00, '2025-04-15 09:33:25', 'confirmed', NULL),
(71, 69, 42, 110000.00, '2025-04-15 09:41:58', 'confirmed', NULL),
(74, 67, 42, 100000.00, '2025-05-12 09:12:03', 'confirmed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_seats`
--

CREATE TABLE `booking_seats` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `theater_seat_id` int NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `archived` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_seats`
--

INSERT INTO `booking_seats` (`id`, `booking_id`, `theater_seat_id`, `price`, `status`, `archived`) VALUES
(155, 69, 551, 50000.00, 'pending', 0),
(156, 69, 561, 50000.00, 'pending', 0),
(157, 70, 611, 75000.00, 'pending', 0),
(158, 70, 616, 75000.00, 'pending', 0),
(159, 71, 571, 50000.00, 'pending', 0),
(160, 71, 581, 75000.00, 'pending', 0),
(166, 74, 550, 50000.00, 'pending', 0),
(167, 74, 560, 50000.00, 'pending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(14, 'Hài hước'),
(15, 'Tình Cảm'),
(16, 'Kinh dị'),
(17, 'Hàn Quốc'),
(18, 'Hoạt hình'),
(19, 'Hành động'),
(20, 'Phiêu lưu'),
(21, 'Viễn tưởng'),
(23, 'Thể thao'),
(24, 'Âm nhạc'),
(25, 'Tài liệu');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `duration` int NOT NULL,
  `release_date` date NOT NULL,
  `trailer_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `director` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `description`, `duration`, `release_date`, `trailer_path`, `poster_path`, `view`, `created_at`, `director`) VALUES
(51, 'Conan phá án ở Hockaido', 'Đi qua những đau khổ và phản bội, mối tình đơn phương của Ngạn dành cho cô bạn thân thời thơ ấu Hà Lan kéo dài cả một thế hệ trong bộ phim siêu lãng mạn này.', 120, '2025-03-26', 'public/video/1743577726_trailer2.mp4', 'public/images/1743039499_poster2.jpg', 200, '2025-03-26 15:47:11', 'Văn B'),
(52, 'Phim hải tặc', 'Đi qua những đau khổ và phản bội, mối tình đơn phương của Ngạn dành cho cô bạn thân thời thơ ấu Hà Lan kéo dài cả một thế hệ trong bộ phim siêu lãng mạn này.', 200, '2025-03-28', 'public/video/1743039488_trailer4.mp4', 'public/images/1743039488_poster1.jpg', 20, '2025-03-27 08:38:08', 'Nguyễn Văn B'),
(53, 'Siêu anh hùng', 'TOP 41 mẫu Viết về một bộ phim yêu thích bằng tiếng Anh là nguồn tài liệu bổ ích viết về rất', 150, '2025-03-20', 'public/video/1743039583_1742272552_trailer1.mp4', 'public/images/1743039583_poster9.jpg', 5, '2025-03-27 08:39:43', 'Nguyễn Văn C'),
(54, 'nhà bà nữ', 'Câu chuyện tình yêu trên con tàu định mệnh.', 180, '2025-03-28', 'public/video/1743039646_1742271143_trailer1.mp4', 'public/images/1743039646_poster6.jpg', 10, '2025-03-27 08:40:46', 'Dương Văn A'),
(55, 'Đám cưới ma', 'Phim kinh dị top 1 hàn quốc', 150, '2025-03-28', 'public/video/1743043834_trailer4.mp4', 'public/images/1743043834_poster7.jpg', 200, '2025-03-27 09:50:34', 'Nguyễn Văn A'),
(58, 'nghề siêu khó nói', 'Đi qua những đau khổ và phản bội, mối tình đơn phương của Ngạn dành cho cô bạn thân thời thơ ấu Hà Lan kéo dài cả một thế hệ trong bộ phim siêu lãng mạn này.', 200, '2025-04-03', 'public/video/1743578133_trailer5.mp4', 'public/images/1743578133_poster11.jpg', 11, '2025-04-02 14:15:33', 'Nguyễn Văn B'),
(59, 'Địa đạo', 'Năm 1967, giữa lúc Chiến tranh Việt Nam đang ở đỉnh điểm, đội du kích cách mạng 21 người trở thành mục tiêu “tìm và diệt” số 1 của quân đội Mỹ khi nhận nhiệm vụ bằng mọi giá phải bảo vệ một nhóm thông tin tình báo chiến lược mới đến ẩn náu tại căn cứ.', 180, '2025-04-14', 'public/video/1744596769_1742284120_1742271191_trailer4.mp4', 'public/images/1744596769_poster5.jpg', 5, '2025-04-14 09:12:49', 'Nguyen Van C'),
(60, 'Âm dương lộ', 'Bộ đôi Tiến Luật và Ngô Kiến Huy, với nghề nghiệp \"độc lạ\" hốt xác và lái xe cứu thương, hứa hẹn mang đến những tràng cười không ngớt cho khán giả qua hành trình tìm xác có một không hai trên màn ảnh Việt. Nhờ sự trợ giúp của thế lực tâm linh, họ không chỉ đối mặt với những tình huống \"dở khóc dở cười\"', 150, '2025-04-14', 'public/video/1744596841_1742284031_trailer3.mp4', 'public/images/1744596841_poster3.jpg', 10, '2025-04-14 09:14:01', 'Nguyen Van D');

-- --------------------------------------------------------

--
-- Table structure for table `movie_genres`
--

CREATE TABLE `movie_genres` (
  `id` int NOT NULL,
  `movie_id` int NOT NULL,
  `genre_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_genres`
--

INSERT INTO `movie_genres` (`id`, `movie_id`, `genre_id`) VALUES
(103, 51, 18),
(104, 51, 19),
(101, 52, 14),
(102, 52, 15),
(81, 53, 14),
(82, 53, 15),
(83, 54, 14),
(84, 54, 15),
(85, 55, 14),
(86, 55, 16),
(95, 58, 14),
(96, 58, 15),
(97, 59, 19),
(98, 59, 20),
(99, 60, 14),
(100, 60, 16);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `image`, `title`, `content`, `created_at`) VALUES
(6, 'public/images/news/1743576881_poster9.jpg', 'Bom tấn Avengers sắp ra mắt', 'Bộ phim Avengers phần mới nhất sẽ ra mắt vào mùa hè năm nay với nhiều pha hành động mãn nhãn.Bộ phim Avengers phần mới nhất đang được Marvel Studios lên kế hoạch công chiếu vào mùa hè năm nay. \r\nPhim tiếp tục kể về cuộc chiến chống lại các thế lực hắc ám đang đe dọa vũ trụ. Dàn diễn viên gồm Robert Downey Jr., \r\nChris Evans, và Scarlett Johansson hứa hẹn sẽ mang đến những pha hành động mãn nhãn cùng những tình tiết đầy bất ngờ. \r\nCác fan hâm mộ đang rất mong đợi trailer chính thức sẽ được phát hành trong thời gian sắp tới', '2025-04-02 06:54:04'),
(7, 'public/images/news/1743577027_poster3.jpg', 'John Wick 5 đang được sản xuất', 'Keanu Reeves xác nhận tiếp tục tham gia vào phần tiếp theo của John Wick, dự kiến công chiếu vào năm sau.Marvel Studios và Sony Pictures đã đạt được thỏa thuận để Spider-Man tiếp tục xuất hiện trong các bộ phim thuộc vũ trụ điện ảnh Marvel (MCU). \r\nSau những tin đồn về việc Sony rút Spider-Man khỏi MCU, người hâm mộ đã rất lo lắng. Tuy nhiên, với thỏa thuận mới này, nhân vật Peter Parker \r\ncủa Tom Holland sẽ tiếp tục có mặt trong các bộ phim Marvel sắp tới. Đây là tin vui lớn đối với các fan của Marvel cũng như Spider-Man. Hiện tại, \r\nphim riêng tiếp theo của Spider-Man vẫn chưa được công bố chính thức, nhưng dự kiến sẽ ra mắt trong vài năm tới.Marvel Studios và Sony Pictures đã đạt được thỏa thuận để Spider-Man tiếp tục xuất hiện trong các bộ phim thuộc vũ trụ điện ảnh Marvel (MCU). \r\nSau những tin đồn về việc Sony rút Spider-Man khỏi MCU, người hâm mộ đã rất lo lắng. Tuy nhiên, với thỏa thuận mới này, nhân vật Peter Parker \r\ncủa Tom Holland sẽ tiếp tục có mặt trong các bộ phim Marvel sắp tới. Đây là tin vui lớn đối với các fan của Marvel cũng như Spider-Man. Hiện tại, \r\nphim riêng tiếp theo của Spider-Man vẫn chưa được công bố chính thức, nhưng dự kiến sẽ ra mắt trong vài năm tới.', '2025-04-02 06:54:04'),
(8, 'public/images/news/1743577039_poster4.jpg', 'Fast & Furious 11 sẽ là phần cuối?', 'Dàn diễn viên Fast & Furious xác nhận phần 11 có thể sẽ là phần phim cuối cùng của loạt phim đình đám này.Marvel Studios và Sony Pictures đã đạt được thỏa thuận để Spider-Man tiếp tục xuất hiện trong các bộ phim thuộc vũ trụ điện ảnh Marvel (MCU). \r\nSau những tin đồn về việc Sony rút Spider-Man khỏi MCU, người hâm mộ đã rất lo lắng. Tuy nhiên, với thỏa thuận mới này, nhân vật Peter Parker \r\ncủa Tom Holland sẽ tiếp tục có mặt trong các bộ phim Marvel sắp tới. Đây là tin vui lớn đối với các fan của Marvel cũng như Spider-Man. Hiện tại, \r\nphim riêng tiếp theo của Spider-Man vẫn chưa được công bố chính thức, nhưng dự kiến sẽ ra mắt trong vài năm tới.Marvel Studios và Sony Pictures đã đạt được thỏa thuận để Spider-Man tiếp tục xuất hiện trong các bộ phim thuộc vũ trụ điện ảnh Marvel (MCU). \r\nSau những tin đồn về việc Sony rút Spider-Man khỏi MCU, người hâm mộ đã rất lo lắng. Tuy nhiên, với thỏa thuận mới này, nhân vật Peter Parker \r\ncủa Tom Holland sẽ tiếp tục có mặt trong các bộ phim Marvel sắp tới. Đây là tin vui lớn đối với các fan của Marvel cũng như Spider-Man. Hiện tại, \r\nphim riêng tiếp theo của Spider-Man vẫn chưa được công bố chính thức, nhưng dự kiến sẽ ra mắt trong vài năm tới.', '2025-04-02 06:54:04'),
(9, 'public/images/news/1743577048_poster5.jpg', 'Phim kinh dị IT sắp có phần 3', 'Sau thành công của IT Chapter 2, hãng phim đang lên kế hoạch phát triển phần 3 của bộ phim kinh dị nổi tiếng này.Marvel Studios và Sony Pictures đã đạt được thỏa thuận để Spider-Man tiếp tục xuất hiện trong các bộ phim thuộc vũ trụ điện ảnh Marvel (MCU). \r\nSau những tin đồn về việc Sony rút Spider-Man khỏi MCU, người hâm mộ đã rất lo lắng. Tuy nhiên, với thỏa thuận mới này, nhân vật Peter Parker \r\ncủa Tom Holland sẽ tiếp tục có mặt trong các bộ phim Marvel sắp tới. Đây là tin vui lớn đối với các fan của Marvel cũng như Spider-Man. Hiện tại, \r\nphim riêng tiếp theo của Spider-Man vẫn chưa được công bố chính thức, nhưng dự kiến sẽ ra mắt trong vài năm tới.Marvel Studios và Sony Pictures đã đạt được thỏa thuận để Spider-Man tiếp tục xuất hiện trong các bộ phim thuộc vũ trụ điện ảnh Marvel (MCU). \r\nSau những tin đồn về việc Sony rút Spider-Man khỏi MCU, người hâm mộ đã rất lo lắng. Tuy nhiên, với thỏa thuận mới này, nhân vật Peter Parker \r\ncủa Tom Holland sẽ tiếp tục có mặt trong các bộ phim Marvel sắp tới. Đây là tin vui lớn đối với các fan của Marvel cũng như Spider-Man. Hiện tại, \r\nphim riêng tiếp theo của Spider-Man vẫn chưa được công bố chính thức, nhưng dự kiến sẽ ra mắt trong vài năm tới.', '2025-04-02 06:54:04'),
(10, 'public/images/news/1743577055_poster11.jpg', 'Spider-Man trở lại MCU', 'Marvel và Sony đã đạt thỏa thuận giúp Spider-Man tiếp tục xuất hiện trong các bộ phim thuộc vũ trụ điện ảnh Marvel.Marvel Studios và Sony Pictures đã đạt được thỏa thuận để Spider-Man tiếp tục xuất hiện trong các bộ phim thuộc vũ trụ điện ảnh Marvel (MCU). \r\nSau những tin đồn về việc Sony rút Spider-Man khỏi MCU, người hâm mộ đã rất lo lắng. Tuy nhiên, với thỏa thuận mới này, nhân vật Peter Parker \r\ncủa Tom Holland sẽ tiếp tục có mặt trong các bộ phim Marvel sắp tới. Đây là tin vui lớn đối với các fan của Marvel cũng như Spider-Man. Hiện tại, \r\nphim riêng tiếp theo của Spider-Man vẫn chưa được công bố chính thức, nhưng dự kiến sẽ ra mắt trong vài năm tới.Marvel Studios và Sony Pictures đã đạt được thỏa thuận để Spider-Man tiếp tục xuất hiện trong các bộ phim thuộc vũ trụ điện ảnh Marvel (MCU). \r\nSau những tin đồn về việc Sony rút Spider-Man khỏi MCU, người hâm mộ đã rất lo lắng. Tuy nhiên, với thỏa thuận mới này, nhân vật Peter Parker \r\ncủa Tom Holland sẽ tiếp tục có mặt trong các bộ phim Marvel sắp tới. Đây là tin vui lớn đối với các fan của Marvel cũng như Spider-Man. Hiện tại, \r\nphim riêng tiếp theo của Spider-Man vẫn chưa được công bố chính thức, nhưng dự kiến sẽ ra mắt trong vài năm tới.', '2025-04-02 06:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int NOT NULL,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `code`, `discount_percent`, `start_time`, `end_time`) VALUES
(1, 'SALE20', 20.00, '2025-03-01 00:00:00', '2025-03-15 23:59:59'),
(2, 'WELCOME10', 10.00, '2025-03-05 00:00:00', '2025-03-20 23:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `movie_id`, `content`, `created_at`) VALUES
(11, 69, 52, 'Phim rất tệ', '2025-04-15 02:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int NOT NULL,
  `theater_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int NOT NULL,
  `rows` int NOT NULL,
  `columns` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `theater_id`, `name`, `capacity`, `rows`, `columns`) VALUES
(16, 2, 'Phòng C1', 30, 5, 6),
(17, 2, 'Phòng C2', 50, 5, 10),
(18, 18, 'Phòng V1', 25, 5, 5),
(19, 18, 'Phòng V2', 25, 5, 5),
(20, 19, 'Phòng C Vip 1', 50, 5, 10),
(21, 19, 'Phòng C vip 2', 50, 5, 10),
(22, 20, 'Phòng G vip', 60, 6, 10);

--
-- Triggers `rooms`
--
DELIMITER $$
CREATE TRIGGER `update_showtime_seats` AFTER UPDATE ON `rooms` FOR EACH ROW BEGIN
    UPDATE showtimes 
    SET available_seats = NEW.capacity
    WHERE room_id = NEW.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `showtimes`
--

CREATE TABLE `showtimes` (
  `id` int NOT NULL,
  `movie_id` int NOT NULL,
  `theater_id` int NOT NULL,
  `room_id` int NOT NULL,
  `start_time` datetime NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `available_seats` int NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `showtimes`
--

INSERT INTO `showtimes` (`id`, `movie_id`, `theater_id`, `room_id`, `start_time`, `price`, `available_seats`, `end_time`) VALUES
(41, 51, 2, 16, '2025-05-12 08:20:00', 50000.00, 28, '2025-05-12 10:20:00'),
(42, 52, 2, 17, '2025-05-12 06:10:00', 50000.00, 44, '2025-05-12 08:25:00'),
(43, 53, 18, 18, '2025-05-13 21:15:00', 50000.00, 23, '2025-05-13 23:30:00'),
(44, 54, 18, 19, '2025-05-14 21:20:00', 50000.00, 25, '2025-05-14 23:30:00'),
(45, 55, 20, 22, '2025-05-12 09:30:00', 50000.00, 57, '2025-05-12 11:30:00'),
(46, 60, 19, 21, '2025-05-12 08:30:00', 50000.00, 48, '2025-05-12 10:30:00'),
(47, 52, 19, 20, '2025-05-16 22:10:00', 50000.00, 50, '2025-05-17 12:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `showtime_seats`
--

CREATE TABLE `showtime_seats` (
  `id` int NOT NULL,
  `showtime_id` int NOT NULL,
  `theater_seat_id` int NOT NULL,
  `status` enum('available','booked') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `showtime_seats`
--

INSERT INTO `showtime_seats` (`id`, `showtime_id`, `theater_seat_id`, `status`) VALUES
(633, 41, 512, 'available'),
(634, 41, 513, 'available'),
(635, 41, 514, 'available'),
(636, 41, 515, 'available'),
(637, 41, 516, 'available'),
(638, 41, 517, 'available'),
(639, 41, 518, 'available'),
(640, 41, 519, 'available'),
(641, 41, 520, 'available'),
(642, 41, 521, 'available'),
(643, 41, 522, 'available'),
(644, 41, 523, 'available'),
(645, 41, 524, 'available'),
(646, 41, 525, 'available'),
(647, 41, 526, 'available'),
(648, 41, 527, 'available'),
(649, 41, 528, 'available'),
(650, 41, 529, 'booked'),
(651, 41, 530, 'available'),
(652, 41, 531, 'available'),
(653, 41, 532, 'available'),
(654, 41, 533, 'available'),
(655, 41, 534, 'available'),
(656, 41, 535, 'booked'),
(657, 41, 536, 'available'),
(658, 41, 537, 'available'),
(659, 41, 538, 'available'),
(660, 41, 539, 'available'),
(661, 41, 540, 'available'),
(662, 41, 541, 'available'),
(663, 42, 542, 'available'),
(664, 42, 543, 'available'),
(665, 42, 544, 'available'),
(666, 42, 545, 'available'),
(667, 42, 546, 'available'),
(668, 42, 547, 'available'),
(669, 42, 548, 'available'),
(670, 42, 549, 'available'),
(671, 42, 550, 'booked'),
(672, 42, 551, 'booked'),
(673, 42, 552, 'available'),
(674, 42, 553, 'available'),
(675, 42, 554, 'available'),
(676, 42, 555, 'available'),
(677, 42, 556, 'available'),
(678, 42, 557, 'available'),
(679, 42, 558, 'available'),
(680, 42, 559, 'available'),
(681, 42, 560, 'booked'),
(682, 42, 561, 'booked'),
(683, 42, 562, 'available'),
(684, 42, 563, 'available'),
(685, 42, 564, 'available'),
(686, 42, 565, 'available'),
(687, 42, 566, 'available'),
(688, 42, 567, 'available'),
(689, 42, 568, 'available'),
(690, 42, 569, 'available'),
(691, 42, 570, 'available'),
(692, 42, 571, 'booked'),
(693, 42, 572, 'available'),
(694, 42, 573, 'available'),
(695, 42, 574, 'available'),
(696, 42, 575, 'available'),
(697, 42, 576, 'available'),
(698, 42, 577, 'available'),
(699, 42, 578, 'available'),
(700, 42, 579, 'available'),
(701, 42, 580, 'available'),
(702, 42, 581, 'booked'),
(703, 42, 582, 'available'),
(704, 42, 583, 'available'),
(705, 42, 584, 'available'),
(706, 42, 585, 'available'),
(707, 42, 586, 'available'),
(708, 42, 587, 'available'),
(709, 42, 588, 'available'),
(710, 42, 589, 'available'),
(711, 42, 590, 'available'),
(712, 42, 591, 'available'),
(713, 43, 592, 'available'),
(714, 43, 593, 'available'),
(715, 43, 594, 'available'),
(716, 43, 595, 'available'),
(717, 43, 596, 'available'),
(718, 43, 597, 'available'),
(719, 43, 598, 'available'),
(720, 43, 599, 'available'),
(721, 43, 600, 'available'),
(722, 43, 601, 'available'),
(723, 43, 602, 'available'),
(724, 43, 603, 'available'),
(725, 43, 604, 'available'),
(726, 43, 605, 'available'),
(727, 43, 606, 'available'),
(728, 43, 607, 'available'),
(729, 43, 608, 'available'),
(730, 43, 609, 'available'),
(731, 43, 610, 'available'),
(732, 43, 611, 'booked'),
(733, 43, 612, 'available'),
(734, 43, 613, 'available'),
(735, 43, 614, 'available'),
(736, 43, 615, 'available'),
(737, 43, 616, 'booked'),
(738, 44, 617, 'available'),
(739, 44, 618, 'available'),
(740, 44, 619, 'available'),
(741, 44, 620, 'available'),
(742, 44, 621, 'available'),
(743, 44, 622, 'available'),
(744, 44, 623, 'available'),
(745, 44, 624, 'available'),
(746, 44, 625, 'available'),
(747, 44, 626, 'available'),
(748, 44, 627, 'available'),
(749, 44, 628, 'available'),
(750, 44, 629, 'available'),
(751, 44, 630, 'available'),
(752, 44, 631, 'available'),
(753, 44, 632, 'available'),
(754, 44, 633, 'available'),
(755, 44, 634, 'available'),
(756, 44, 635, 'available'),
(757, 44, 636, 'available'),
(758, 44, 637, 'available'),
(759, 44, 638, 'available'),
(760, 44, 639, 'available'),
(761, 44, 640, 'available'),
(762, 44, 641, 'available'),
(763, 45, 742, 'available'),
(764, 45, 743, 'available'),
(765, 45, 744, 'available'),
(766, 45, 745, 'available'),
(767, 45, 746, 'available'),
(768, 45, 747, 'available'),
(769, 45, 748, 'available'),
(770, 45, 749, 'available'),
(771, 45, 750, 'available'),
(772, 45, 752, 'available'),
(773, 45, 753, 'available'),
(774, 45, 754, 'available'),
(775, 45, 755, 'available'),
(776, 45, 756, 'available'),
(777, 45, 757, 'available'),
(778, 45, 758, 'available'),
(779, 45, 759, 'available'),
(780, 45, 760, 'available'),
(781, 45, 761, 'booked'),
(782, 45, 762, 'available'),
(783, 45, 763, 'available'),
(784, 45, 764, 'available'),
(785, 45, 765, 'available'),
(786, 45, 766, 'available'),
(787, 45, 767, 'available'),
(788, 45, 768, 'available'),
(789, 45, 769, 'available'),
(790, 45, 770, 'available'),
(791, 45, 771, 'available'),
(792, 45, 772, 'available'),
(793, 45, 773, 'available'),
(794, 45, 774, 'available'),
(795, 45, 775, 'available'),
(796, 45, 776, 'available'),
(797, 45, 777, 'available'),
(798, 45, 778, 'available'),
(799, 45, 779, 'available'),
(800, 45, 780, 'available'),
(801, 45, 781, 'available'),
(802, 45, 782, 'available'),
(803, 45, 783, 'available'),
(804, 45, 784, 'available'),
(805, 45, 785, 'available'),
(806, 45, 786, 'available'),
(807, 45, 787, 'available'),
(808, 45, 788, 'available'),
(809, 45, 789, 'available'),
(810, 45, 790, 'available'),
(811, 45, 791, 'available'),
(812, 45, 792, 'available'),
(813, 45, 793, 'available'),
(814, 45, 794, 'available'),
(815, 45, 795, 'available'),
(816, 45, 796, 'available'),
(817, 45, 797, 'available'),
(818, 45, 798, 'available'),
(819, 45, 799, 'available'),
(820, 45, 800, 'available'),
(821, 45, 801, 'booked'),
(822, 45, 802, 'booked'),
(823, 46, 692, 'available'),
(824, 46, 693, 'available'),
(825, 46, 694, 'available'),
(826, 46, 695, 'available'),
(827, 46, 696, 'available'),
(828, 46, 697, 'available'),
(829, 46, 698, 'available'),
(830, 46, 699, 'available'),
(831, 46, 700, 'available'),
(832, 46, 701, 'booked'),
(833, 46, 702, 'available'),
(834, 46, 703, 'available'),
(835, 46, 704, 'available'),
(836, 46, 705, 'available'),
(837, 46, 706, 'available'),
(838, 46, 707, 'available'),
(839, 46, 708, 'available'),
(840, 46, 709, 'available'),
(841, 46, 710, 'available'),
(842, 46, 711, 'booked'),
(843, 46, 712, 'available'),
(844, 46, 713, 'available'),
(845, 46, 714, 'available'),
(846, 46, 715, 'available'),
(847, 46, 716, 'available'),
(848, 46, 717, 'available'),
(849, 46, 718, 'available'),
(850, 46, 719, 'available'),
(851, 46, 720, 'available'),
(852, 46, 721, 'available'),
(853, 46, 722, 'available'),
(854, 46, 723, 'available'),
(855, 46, 724, 'available'),
(856, 46, 725, 'available'),
(857, 46, 726, 'available'),
(858, 46, 727, 'available'),
(859, 46, 728, 'available'),
(860, 46, 729, 'available'),
(861, 46, 730, 'available'),
(862, 46, 731, 'available'),
(863, 46, 732, 'available'),
(864, 46, 733, 'available'),
(865, 46, 734, 'available'),
(866, 46, 735, 'available'),
(867, 46, 736, 'available'),
(868, 46, 737, 'available'),
(869, 46, 738, 'available'),
(870, 46, 739, 'available'),
(871, 46, 740, 'available'),
(872, 46, 741, 'available'),
(873, 47, 642, 'available'),
(874, 47, 643, 'available'),
(875, 47, 644, 'available'),
(876, 47, 645, 'available'),
(877, 47, 646, 'available'),
(878, 47, 647, 'available'),
(879, 47, 648, 'available'),
(880, 47, 649, 'available'),
(881, 47, 650, 'available'),
(882, 47, 651, 'available'),
(883, 47, 652, 'available'),
(884, 47, 653, 'available'),
(885, 47, 654, 'available'),
(886, 47, 655, 'available'),
(887, 47, 656, 'available'),
(888, 47, 657, 'available'),
(889, 47, 658, 'available'),
(890, 47, 659, 'available'),
(891, 47, 660, 'available'),
(892, 47, 661, 'available'),
(893, 47, 662, 'available'),
(894, 47, 663, 'available'),
(895, 47, 664, 'available'),
(896, 47, 665, 'available'),
(897, 47, 666, 'available'),
(898, 47, 667, 'available'),
(899, 47, 668, 'available'),
(900, 47, 669, 'available'),
(901, 47, 670, 'available'),
(902, 47, 671, 'available'),
(903, 47, 672, 'available'),
(904, 47, 673, 'available'),
(905, 47, 674, 'available'),
(906, 47, 675, 'available'),
(907, 47, 676, 'available'),
(908, 47, 677, 'available'),
(909, 47, 678, 'available'),
(910, 47, 679, 'available'),
(911, 47, 680, 'available'),
(912, 47, 681, 'available'),
(913, 47, 682, 'available'),
(914, 47, 683, 'available'),
(915, 47, 684, 'available'),
(916, 47, 685, 'available'),
(917, 47, 686, 'available'),
(918, 47, 687, 'available'),
(919, 47, 688, 'available'),
(920, 47, 689, 'available'),
(921, 47, 690, 'available'),
(922, 47, 691, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `theaters`
--

CREATE TABLE `theaters` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theaters`
--

INSERT INTO `theaters` (`id`, `name`, `address`, `capacity`) VALUES
(2, 'Lotte Cinema', 'Hà Nội', 80),
(18, 'Rạp Vincom', 'Cần Thơ', 50),
(19, 'Rạp CGV', 'Hồ Chí Minh', 100),
(20, 'Rạp Galaxy', 'Long Xuyên', 60);

-- --------------------------------------------------------

--
-- Table structure for table `theater_seats`
--

CREATE TABLE `theater_seats` (
  `id` int NOT NULL,
  `room_id` int NOT NULL,
  `row` int NOT NULL,
  `column` int NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `type_seat` enum('vip','normal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `status` enum('available','booked','unavailable') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theater_seats`
--

INSERT INTO `theater_seats` (`id`, `room_id`, `row`, `column`, `price`, `type_seat`, `status`) VALUES
(512, 16, 1, 1, 50000.00, 'normal', 'available'),
(513, 16, 1, 2, 50000.00, 'normal', 'available'),
(514, 16, 1, 3, 50000.00, 'normal', 'available'),
(515, 16, 1, 4, 50000.00, 'normal', 'available'),
(516, 16, 1, 5, 50000.00, 'normal', 'available'),
(517, 16, 1, 6, 50000.00, 'normal', 'available'),
(518, 16, 2, 1, 50000.00, 'normal', 'available'),
(519, 16, 2, 2, 50000.00, 'normal', 'available'),
(520, 16, 2, 3, 50000.00, 'normal', 'available'),
(521, 16, 2, 4, 50000.00, 'normal', 'available'),
(522, 16, 2, 5, 50000.00, 'normal', 'available'),
(523, 16, 2, 6, 50000.00, 'normal', 'available'),
(524, 16, 3, 1, 50000.00, 'normal', 'available'),
(525, 16, 3, 2, 50000.00, 'normal', 'available'),
(526, 16, 3, 3, 50000.00, 'normal', 'available'),
(527, 16, 3, 4, 50000.00, 'normal', 'available'),
(528, 16, 3, 5, 50000.00, 'normal', 'available'),
(529, 16, 3, 6, 50000.00, 'normal', 'available'),
(530, 16, 4, 1, 50000.00, 'vip', 'available'),
(531, 16, 4, 2, 50000.00, 'vip', 'available'),
(532, 16, 4, 3, 50000.00, 'vip', 'available'),
(533, 16, 4, 4, 50000.00, 'vip', 'available'),
(534, 16, 4, 5, 50000.00, 'vip', 'available'),
(535, 16, 4, 6, 50000.00, 'vip', 'available'),
(536, 16, 5, 1, 50000.00, 'vip', 'available'),
(537, 16, 5, 2, 50000.00, 'vip', 'available'),
(538, 16, 5, 3, 50000.00, 'vip', 'available'),
(539, 16, 5, 4, 50000.00, 'vip', 'available'),
(540, 16, 5, 5, 50000.00, 'vip', 'available'),
(541, 16, 5, 6, 50000.00, 'vip', 'available'),
(542, 17, 1, 1, 50000.00, 'normal', 'available'),
(543, 17, 1, 2, 50000.00, 'normal', 'available'),
(544, 17, 1, 3, 50000.00, 'normal', 'available'),
(545, 17, 1, 4, 50000.00, 'normal', 'available'),
(546, 17, 1, 5, 50000.00, 'normal', 'available'),
(547, 17, 1, 6, 50000.00, 'normal', 'available'),
(548, 17, 1, 7, 50000.00, 'normal', 'available'),
(549, 17, 1, 8, 50000.00, 'normal', 'available'),
(550, 17, 1, 9, 50000.00, 'normal', 'available'),
(551, 17, 1, 10, 50000.00, 'normal', 'available'),
(552, 17, 2, 1, 50000.00, 'normal', 'available'),
(553, 17, 2, 2, 50000.00, 'normal', 'available'),
(554, 17, 2, 3, 50000.00, 'normal', 'available'),
(555, 17, 2, 4, 50000.00, 'normal', 'available'),
(556, 17, 2, 5, 50000.00, 'normal', 'available'),
(557, 17, 2, 6, 50000.00, 'normal', 'available'),
(558, 17, 2, 7, 50000.00, 'normal', 'available'),
(559, 17, 2, 8, 50000.00, 'normal', 'available'),
(560, 17, 2, 9, 50000.00, 'normal', 'available'),
(561, 17, 2, 10, 50000.00, 'normal', 'available'),
(562, 17, 3, 1, 50000.00, 'normal', 'available'),
(563, 17, 3, 2, 50000.00, 'normal', 'available'),
(564, 17, 3, 3, 50000.00, 'normal', 'available'),
(565, 17, 3, 4, 50000.00, 'normal', 'available'),
(566, 17, 3, 5, 50000.00, 'normal', 'available'),
(567, 17, 3, 6, 50000.00, 'normal', 'available'),
(568, 17, 3, 7, 50000.00, 'normal', 'available'),
(569, 17, 3, 8, 50000.00, 'normal', 'available'),
(570, 17, 3, 9, 50000.00, 'normal', 'available'),
(571, 17, 3, 10, 50000.00, 'normal', 'available'),
(572, 17, 4, 1, 50000.00, 'vip', 'available'),
(573, 17, 4, 2, 50000.00, 'vip', 'available'),
(574, 17, 4, 3, 50000.00, 'vip', 'available'),
(575, 17, 4, 4, 50000.00, 'vip', 'available'),
(576, 17, 4, 5, 50000.00, 'vip', 'available'),
(577, 17, 4, 6, 50000.00, 'vip', 'available'),
(578, 17, 4, 7, 50000.00, 'vip', 'available'),
(579, 17, 4, 8, 50000.00, 'vip', 'available'),
(580, 17, 4, 9, 50000.00, 'vip', 'available'),
(581, 17, 4, 10, 50000.00, 'vip', 'available'),
(582, 17, 5, 1, 50000.00, 'vip', 'available'),
(583, 17, 5, 2, 50000.00, 'vip', 'available'),
(584, 17, 5, 3, 50000.00, 'vip', 'available'),
(585, 17, 5, 4, 50000.00, 'vip', 'available'),
(586, 17, 5, 5, 50000.00, 'vip', 'available'),
(587, 17, 5, 6, 50000.00, 'vip', 'available'),
(588, 17, 5, 7, 50000.00, 'vip', 'available'),
(589, 17, 5, 8, 50000.00, 'vip', 'available'),
(590, 17, 5, 9, 50000.00, 'vip', 'available'),
(591, 17, 5, 10, 50000.00, 'vip', 'available'),
(592, 18, 1, 1, 50000.00, 'normal', 'available'),
(593, 18, 1, 2, 50000.00, 'normal', 'available'),
(594, 18, 1, 3, 50000.00, 'normal', 'available'),
(595, 18, 1, 4, 50000.00, 'normal', 'available'),
(596, 18, 1, 5, 50000.00, 'normal', 'available'),
(597, 18, 2, 1, 50000.00, 'normal', 'available'),
(598, 18, 2, 2, 50000.00, 'normal', 'available'),
(599, 18, 2, 3, 50000.00, 'normal', 'available'),
(600, 18, 2, 4, 50000.00, 'normal', 'available'),
(601, 18, 2, 5, 50000.00, 'normal', 'available'),
(602, 18, 3, 1, 50000.00, 'normal', 'available'),
(603, 18, 3, 2, 50000.00, 'normal', 'available'),
(604, 18, 3, 3, 50000.00, 'normal', 'available'),
(605, 18, 3, 4, 50000.00, 'normal', 'available'),
(606, 18, 3, 5, 50000.00, 'normal', 'available'),
(607, 18, 4, 1, 50000.00, 'vip', 'available'),
(608, 18, 4, 2, 50000.00, 'vip', 'available'),
(609, 18, 4, 3, 50000.00, 'vip', 'available'),
(610, 18, 4, 4, 50000.00, 'vip', 'available'),
(611, 18, 4, 5, 50000.00, 'vip', 'available'),
(612, 18, 5, 1, 50000.00, 'vip', 'available'),
(613, 18, 5, 2, 50000.00, 'vip', 'available'),
(614, 18, 5, 3, 50000.00, 'vip', 'available'),
(615, 18, 5, 4, 50000.00, 'vip', 'available'),
(616, 18, 5, 5, 50000.00, 'vip', 'available'),
(617, 19, 1, 1, 50000.00, 'normal', 'available'),
(618, 19, 1, 2, 50000.00, 'normal', 'available'),
(619, 19, 1, 3, 50000.00, 'normal', 'available'),
(620, 19, 1, 4, 50000.00, 'normal', 'available'),
(621, 19, 1, 5, 50000.00, 'normal', 'available'),
(622, 19, 2, 1, 50000.00, 'normal', 'available'),
(623, 19, 2, 2, 50000.00, 'normal', 'available'),
(624, 19, 2, 3, 50000.00, 'normal', 'available'),
(625, 19, 2, 4, 50000.00, 'normal', 'available'),
(626, 19, 2, 5, 50000.00, 'normal', 'available'),
(627, 19, 3, 1, 50000.00, 'normal', 'available'),
(628, 19, 3, 2, 50000.00, 'normal', 'available'),
(629, 19, 3, 3, 50000.00, 'normal', 'available'),
(630, 19, 3, 4, 50000.00, 'normal', 'available'),
(631, 19, 3, 5, 50000.00, 'normal', 'available'),
(632, 19, 4, 1, 50000.00, 'vip', 'available'),
(633, 19, 4, 2, 50000.00, 'vip', 'available'),
(634, 19, 4, 3, 50000.00, 'vip', 'available'),
(635, 19, 4, 4, 50000.00, 'vip', 'available'),
(636, 19, 4, 5, 50000.00, 'vip', 'available'),
(637, 19, 5, 1, 50000.00, 'vip', 'available'),
(638, 19, 5, 2, 50000.00, 'vip', 'available'),
(639, 19, 5, 3, 50000.00, 'vip', 'available'),
(640, 19, 5, 4, 50000.00, 'vip', 'available'),
(641, 19, 5, 5, 50000.00, 'vip', 'available'),
(642, 20, 1, 1, 50000.00, 'normal', 'available'),
(643, 20, 1, 2, 50000.00, 'normal', 'available'),
(644, 20, 1, 3, 50000.00, 'normal', 'available'),
(645, 20, 1, 4, 50000.00, 'normal', 'available'),
(646, 20, 1, 5, 50000.00, 'normal', 'available'),
(647, 20, 1, 6, 50000.00, 'normal', 'available'),
(648, 20, 1, 7, 50000.00, 'normal', 'available'),
(649, 20, 1, 8, 50000.00, 'normal', 'available'),
(650, 20, 1, 9, 50000.00, 'normal', 'available'),
(651, 20, 1, 10, 50000.00, 'normal', 'available'),
(652, 20, 2, 1, 50000.00, 'normal', 'available'),
(653, 20, 2, 2, 50000.00, 'normal', 'available'),
(654, 20, 2, 3, 50000.00, 'normal', 'available'),
(655, 20, 2, 4, 50000.00, 'normal', 'available'),
(656, 20, 2, 5, 50000.00, 'normal', 'available'),
(657, 20, 2, 6, 50000.00, 'normal', 'available'),
(658, 20, 2, 7, 50000.00, 'normal', 'available'),
(659, 20, 2, 8, 50000.00, 'normal', 'available'),
(660, 20, 2, 9, 50000.00, 'normal', 'available'),
(661, 20, 2, 10, 50000.00, 'normal', 'available'),
(662, 20, 3, 1, 50000.00, 'normal', 'available'),
(663, 20, 3, 2, 50000.00, 'normal', 'available'),
(664, 20, 3, 3, 50000.00, 'normal', 'available'),
(665, 20, 3, 4, 50000.00, 'normal', 'available'),
(666, 20, 3, 5, 50000.00, 'normal', 'available'),
(667, 20, 3, 6, 50000.00, 'normal', 'available'),
(668, 20, 3, 7, 50000.00, 'normal', 'available'),
(669, 20, 3, 8, 50000.00, 'normal', 'available'),
(670, 20, 3, 9, 50000.00, 'normal', 'available'),
(671, 20, 3, 10, 50000.00, 'normal', 'available'),
(672, 20, 4, 1, 50000.00, 'normal', 'available'),
(673, 20, 4, 2, 50000.00, 'normal', 'available'),
(674, 20, 4, 3, 50000.00, 'normal', 'available'),
(675, 20, 4, 4, 50000.00, 'normal', 'available'),
(676, 20, 4, 5, 50000.00, 'normal', 'available'),
(677, 20, 4, 6, 50000.00, 'normal', 'available'),
(678, 20, 4, 7, 50000.00, 'normal', 'available'),
(679, 20, 4, 8, 50000.00, 'normal', 'available'),
(680, 20, 4, 9, 50000.00, 'normal', 'available'),
(681, 20, 4, 10, 50000.00, 'normal', 'available'),
(682, 20, 5, 1, 50000.00, 'vip', 'available'),
(683, 20, 5, 2, 50000.00, 'vip', 'available'),
(684, 20, 5, 3, 50000.00, 'vip', 'available'),
(685, 20, 5, 4, 50000.00, 'vip', 'available'),
(686, 20, 5, 5, 50000.00, 'vip', 'available'),
(687, 20, 5, 6, 50000.00, 'vip', 'available'),
(688, 20, 5, 7, 50000.00, 'vip', 'available'),
(689, 20, 5, 8, 50000.00, 'vip', 'available'),
(690, 20, 5, 9, 50000.00, 'vip', 'available'),
(691, 20, 5, 10, 50000.00, 'vip', 'available'),
(692, 21, 1, 1, 50000.00, 'normal', 'available'),
(693, 21, 1, 2, 50000.00, 'normal', 'available'),
(694, 21, 1, 3, 50000.00, 'normal', 'available'),
(695, 21, 1, 4, 50000.00, 'normal', 'available'),
(696, 21, 1, 5, 50000.00, 'normal', 'available'),
(697, 21, 1, 6, 50000.00, 'normal', 'available'),
(698, 21, 1, 7, 50000.00, 'normal', 'available'),
(699, 21, 1, 8, 50000.00, 'normal', 'available'),
(700, 21, 1, 9, 50000.00, 'normal', 'available'),
(701, 21, 1, 10, 50000.00, 'normal', 'available'),
(702, 21, 2, 1, 50000.00, 'normal', 'available'),
(703, 21, 2, 2, 50000.00, 'normal', 'available'),
(704, 21, 2, 3, 50000.00, 'normal', 'available'),
(705, 21, 2, 4, 50000.00, 'normal', 'available'),
(706, 21, 2, 5, 50000.00, 'normal', 'available'),
(707, 21, 2, 6, 50000.00, 'normal', 'available'),
(708, 21, 2, 7, 50000.00, 'normal', 'available'),
(709, 21, 2, 8, 50000.00, 'normal', 'available'),
(710, 21, 2, 9, 50000.00, 'normal', 'available'),
(711, 21, 2, 10, 50000.00, 'normal', 'available'),
(712, 21, 3, 1, 50000.00, 'normal', 'available'),
(713, 21, 3, 2, 50000.00, 'normal', 'available'),
(714, 21, 3, 3, 50000.00, 'normal', 'available'),
(715, 21, 3, 4, 50000.00, 'normal', 'available'),
(716, 21, 3, 5, 50000.00, 'normal', 'available'),
(717, 21, 3, 6, 50000.00, 'normal', 'available'),
(718, 21, 3, 7, 50000.00, 'normal', 'available'),
(719, 21, 3, 8, 50000.00, 'normal', 'available'),
(720, 21, 3, 9, 50000.00, 'normal', 'available'),
(721, 21, 3, 10, 50000.00, 'normal', 'available'),
(722, 21, 4, 1, 50000.00, 'normal', 'available'),
(723, 21, 4, 2, 50000.00, 'normal', 'available'),
(724, 21, 4, 3, 50000.00, 'normal', 'available'),
(725, 21, 4, 4, 50000.00, 'normal', 'available'),
(726, 21, 4, 5, 50000.00, 'normal', 'available'),
(727, 21, 4, 6, 50000.00, 'normal', 'available'),
(728, 21, 4, 7, 50000.00, 'normal', 'available'),
(729, 21, 4, 8, 50000.00, 'normal', 'available'),
(730, 21, 4, 9, 50000.00, 'normal', 'available'),
(731, 21, 4, 10, 50000.00, 'normal', 'available'),
(732, 21, 5, 1, 50000.00, 'vip', 'available'),
(733, 21, 5, 2, 50000.00, 'vip', 'available'),
(734, 21, 5, 3, 50000.00, 'vip', 'available'),
(735, 21, 5, 4, 50000.00, 'vip', 'available'),
(736, 21, 5, 5, 50000.00, 'vip', 'available'),
(737, 21, 5, 6, 50000.00, 'vip', 'available'),
(738, 21, 5, 7, 50000.00, 'vip', 'available'),
(739, 21, 5, 8, 50000.00, 'vip', 'available'),
(740, 21, 5, 9, 50000.00, 'vip', 'available'),
(741, 21, 5, 10, 50000.00, 'vip', 'available'),
(742, 22, 1, 1, 50000.00, 'normal', 'available'),
(743, 22, 1, 2, 50000.00, 'normal', 'available'),
(744, 22, 1, 3, 50000.00, 'normal', 'available'),
(745, 22, 1, 4, 50000.00, 'normal', 'available'),
(746, 22, 1, 5, 50000.00, 'normal', 'available'),
(747, 22, 1, 6, 50000.00, 'normal', 'available'),
(748, 22, 1, 7, 50000.00, 'normal', 'available'),
(749, 22, 1, 8, 50000.00, 'normal', 'available'),
(750, 22, 1, 9, 50000.00, 'normal', 'available'),
(752, 22, 2, 1, 50000.00, 'normal', 'available'),
(753, 22, 2, 2, 50000.00, 'normal', 'available'),
(754, 22, 2, 3, 50000.00, 'normal', 'available'),
(755, 22, 2, 4, 50000.00, 'normal', 'available'),
(756, 22, 2, 5, 50000.00, 'normal', 'available'),
(757, 22, 2, 6, 50000.00, 'normal', 'available'),
(758, 22, 2, 7, 50000.00, 'normal', 'available'),
(759, 22, 2, 8, 50000.00, 'normal', 'available'),
(760, 22, 2, 9, 50000.00, 'normal', 'available'),
(761, 22, 2, 10, 50000.00, 'normal', 'available'),
(762, 22, 3, 1, 50000.00, 'normal', 'available'),
(763, 22, 3, 2, 50000.00, 'normal', 'available'),
(764, 22, 3, 3, 50000.00, 'normal', 'available'),
(765, 22, 3, 4, 50000.00, 'normal', 'available'),
(766, 22, 3, 5, 50000.00, 'normal', 'available'),
(767, 22, 3, 6, 50000.00, 'normal', 'available'),
(768, 22, 3, 7, 50000.00, 'normal', 'available'),
(769, 22, 3, 8, 50000.00, 'normal', 'available'),
(770, 22, 3, 9, 50000.00, 'normal', 'available'),
(771, 22, 3, 10, 50000.00, 'normal', 'available'),
(772, 22, 4, 1, 50000.00, 'normal', 'available'),
(773, 22, 4, 2, 50000.00, 'normal', 'available'),
(774, 22, 4, 3, 50000.00, 'normal', 'available'),
(775, 22, 4, 4, 50000.00, 'normal', 'available'),
(776, 22, 4, 5, 50000.00, 'normal', 'available'),
(777, 22, 4, 6, 50000.00, 'normal', 'available'),
(778, 22, 4, 7, 50000.00, 'normal', 'available'),
(779, 22, 4, 8, 50000.00, 'normal', 'available'),
(780, 22, 4, 9, 50000.00, 'normal', 'available'),
(781, 22, 4, 10, 50000.00, 'normal', 'available'),
(782, 22, 5, 1, 50000.00, 'normal', 'available'),
(783, 22, 5, 2, 50000.00, 'normal', 'available'),
(784, 22, 5, 3, 50000.00, 'normal', 'available'),
(785, 22, 5, 4, 50000.00, 'normal', 'available'),
(786, 22, 5, 5, 50000.00, 'normal', 'available'),
(787, 22, 5, 6, 50000.00, 'normal', 'available'),
(788, 22, 5, 7, 50000.00, 'normal', 'available'),
(789, 22, 5, 8, 50000.00, 'normal', 'available'),
(790, 22, 5, 9, 50000.00, 'normal', 'available'),
(791, 22, 5, 10, 50000.00, 'normal', 'available'),
(792, 22, 6, 1, 50000.00, 'vip', 'available'),
(793, 22, 6, 2, 50000.00, 'vip', 'available'),
(794, 22, 6, 3, 50000.00, 'vip', 'available'),
(795, 22, 6, 4, 50000.00, 'vip', 'available'),
(796, 22, 6, 5, 50000.00, 'vip', 'available'),
(797, 22, 6, 6, 50000.00, 'vip', 'available'),
(798, 22, 6, 7, 50000.00, 'vip', 'available'),
(799, 22, 6, 8, 50000.00, 'vip', 'available'),
(800, 22, 6, 9, 50000.00, 'vip', 'available'),
(801, 22, 6, 10, 50000.00, 'vip', 'available'),
(802, 22, 1, 10, 50000.00, 'normal', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `phone`, `email`, `password`, `address`, `image`, `role`, `created_at`) VALUES
(51, 'toan', '0983497539', 'toan@gmail.com', '$2y$10$Yxa6EiZAtKep6Vk5ThJwHu0xsO6ktbh8EVlxQnREIuBhwZhgPWZfu', 'Cần Thơ', 'public/images/ali-morshedlou-WMD64tMfc4k-unsplash.jpg', 'admin', '2025-03-21 17:19:30'),
(67, 'baotoan', '0702940214', 'hbtoan-cntt16@tdu.edu.vn', '$2y$10$bICkjPUQIjLyFjvHkUlC1e8XT3.UqN6aMCygGsjKvIM88LI.pFtSy', 'cần thơ', 'public/images/67eb4b5e10ddb.jpg', 'user', '2025-04-01 09:11:42'),
(68, 'nam', '0983736461', 'thanh123@gmail.com', '$2y$10$zzBXgHrwGEB6NCiRDxFcf.hLuNNgZj6/mFzfaQq36ZyewKoV4uVL2', 'Cần Thơ', 'public/images/oguz-yagiz-kara-MZf0mI14RI0-unsplash.jpg', 'user', '2025-04-01 14:50:57'),
(69, 'Nam', '0702940214', 'namngueyn@gmail.com', '$2y$10$.rJ0RlqTvZTDH5DYA6pH2ewN5rxGZj11l.360rGft0Z8VFCwVKgZq', 'cần thơ', 'public/images/67fdc76a327b1.jpg', 'user', '2025-04-15 09:41:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `showtime_id` (`showtime_id`),
  ADD KEY `promotion_id` (`promotion_id`);

--
-- Indexes for table `booking_seats`
--
ALTER TABLE `booking_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `theater_seat_id` (`theater_seat_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_release_date` (`release_date`);

--
-- Indexes for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_movie_genre` (`movie_id`,`genre_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theater_id` (`theater_id`);

--
-- Indexes for table `showtimes`
--
ALTER TABLE `showtimes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `theater_id` (`theater_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `idx_start_time` (`start_time`);

--
-- Indexes for table `showtime_seats`
--
ALTER TABLE `showtime_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `showtime_id` (`showtime_id`),
  ADD KEY `theater_seat_id` (`theater_seat_id`);

--
-- Indexes for table `theaters`
--
ALTER TABLE `theaters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theater_seats`
--
ALTER TABLE `theater_seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_seat` (`room_id`,`row`,`column`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `booking_seats`
--
ALTER TABLE `booking_seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `movie_genres`
--
ALTER TABLE `movie_genres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `showtimes`
--
ALTER TABLE `showtimes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `showtime_seats`
--
ALTER TABLE `showtime_seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=923;

--
-- AUTO_INCREMENT for table `theaters`
--
ALTER TABLE `theaters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `theater_seats`
--
ALTER TABLE `theater_seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=803;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`showtime_id`) REFERENCES `showtimes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_seats`
--
ALTER TABLE `booking_seats`
  ADD CONSTRAINT `booking_seats_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_seats_ibfk_2` FOREIGN KEY (`theater_seat_id`) REFERENCES `theater_seats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD CONSTRAINT `movie_genres_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`theater_id`) REFERENCES `theaters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `showtimes`
--
ALTER TABLE `showtimes`
  ADD CONSTRAINT `showtimes_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `showtimes_ibfk_2` FOREIGN KEY (`theater_id`) REFERENCES `theaters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `showtimes_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `showtime_seats`
--
ALTER TABLE `showtime_seats`
  ADD CONSTRAINT `showtime_seats_ibfk_1` FOREIGN KEY (`showtime_id`) REFERENCES `showtimes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `showtime_seats_ibfk_2` FOREIGN KEY (`theater_seat_id`) REFERENCES `theater_seats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `theater_seats`
--
ALTER TABLE `theater_seats`
  ADD CONSTRAINT `theater_seats_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
