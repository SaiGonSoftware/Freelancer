-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2016 at 05:45 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freelancer`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `introduce` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed_day` int(11) NOT NULL,
  `allowance` double NOT NULL,
  `post_at` date NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `introduce`, `completed_day`, `allowance`, `post_at`, `job_id`) VALUES
(1, 1, 'Tôi tự tin về khả năng code php đã từng có 5 dự án ', 7, 1500000, '2016-01-18', 1),
(2, 2, 'Tôi thích hợp cho công việc này', 7, 1500000, '2016-01-18', 1),
(4, 15, 'Tôi thích công việc này', 2, 1500000, '2016-01-18', 1),
(90, 14, 'Tôi thích hợp cho công việc này', 5, 2000000, '2016-01-27', 5);

-- --------------------------------------------------------

--
-- Table structure for table `content_tag`
--

CREATE TABLE `content_tag` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `tag_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `content_tag`
--

INSERT INTO `content_tag` (`id`, `job_id`, `tag_content`) VALUES
(1, 12, 'Lập Trình Ứng Dụng,Dịch Thuật,Viết lách,Php,Java');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `post_at` date NOT NULL,
  `day_open` tinyint(4) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `allowance_min` double NOT NULL,
  `allowance_max` double NOT NULL,
  `location` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `slug`, `content`, `post_at`, `day_open`, `active`, `allowance_min`, `allowance_max`, `location`, `user_id`) VALUES
(1, 'Thiết kế website hệ thống du lịch', 'thiet-ke-website-he-thong-du-lich', 'thiết kế một hệ thống website dành cho du lịch sử dụng laravel frameworks, vuejs, html5, css/sass/less, js\r\nChi tiết công việc sẽ trao đổi trực tiếp.\r\nLàm việc tại vũng tàu, có chỗ ăn, ở tại vũng tàu, sau khi hoàn thành dự án có để xây dựng cổ phần với công ty mếu muốn.\r\nDự án phát triển lâu dài.\r\nLiên hệ: https://www.facebook.com/***; email: ***', '2015-11-24', 10, 0, 4000000, 5000000, 'Hồ Chí Minh', 1),
(2, 'Tối ưu hoá angularjs', 'toi-uu-hoa-angularjs', 'Chào các bạn.\n			Mình đang làm 1 dự án sử dụng ionic để build app trên ios.\n			Do app ngày càng lớn nên app ngày càng chậm. Trên các máy iphone 4 thì rất tệ.\n			Nay mình muốn tìm 1 bạn chuyên gia về angularjs để giúp mình tối ưu hoá lại ứng dụng. Sao cho trên iphone4 cũng chạy mượt được.\n			Không yêu cầu các bạn phải code lại mà yêu cầu các bạn chỉ ra các điểm yếu và phải xử lý như thế nào.', '2015-11-26', 10, 0, 500000, 2000000, 'Hồ Chí Minh', 1),
(3, 'Tìm team phát triển trang web kinh doanh thực phẩm online', 'tìm-team-phat-trien-trang-web-kinh-doanh-thuc-pham-online', 'Cần tìm cá nhân hay team phát triển trang web kinh doanh thực phẩm online.\n\nThông tin này đã đăng 1 lần rồi nhưng do chưa tìm được đối tác như ý nên mình xin đăng lại với đầy đủ chi tiết hơn.\n\nYêu cầu:\n\n1. Phát triển front-end và back-end theo tài liệu mô tả yêu cầu có sẵn.\n\n2. Sử dụng MySQL, PHP. Cấu trúc DB do team thiết kế và cung cấp. Framework do team quyết định.\n\n3. Trang web có sử dụng kỹ thuật đổi từ địa chỉ bình thường sang tọa độ GPS để xác định khoảng cách giữa khách hàng với các quầy giao dịch. Nếu team chưa có kinh nghiệm với kỹ thuật này thì có thể bỏ khỏi báo giá.\n\n4. Deadline: front-end yêu cầu cuối tháng 12/2015 phải publish. Back-end và cả hệ thống đến cuối 1/2016 phải hoàn thành.\n\n5. Cung cấp demo theo yêu cầu của mình. Demo này sẽ được trả phí bất kể đạt hay không đạt yêu cầu. \n\n6. Chi trả theo từng giai đoạn sau khi hoàn tất và test kiểm tra OK.\n\nThông tin chi tiết xin vui lòng inbox.\n\nCám ơn đã đọc tin', '2015-11-26', 10, 0, 500000, 2000000, 'Hồ Chí Minh', 1),
(4, 'Cần xây dựng website dạng forum kết hợp bán hàng online.', 'can-xay-dung-website-dang-forum-ket-hop-ban-hang-online', 'Tôi đang cần tìm một coder để xây dựng website dạng forum kết hợp bán hàng online.\n\nDo đây chưa phải là một website chuẩn nên sẽ xây dựng từng phần, khảo sát phản ứng của user và chỉnh sửa vài lần mới đi đến hoàn thiện.\n\nSẽ trao đổi cụ thể hơn khi tìm được coder.', '2015-11-26', 10, 0, 500000, 2000000, 'Hồ Chí Minh', 1),
(5, 'website', 'website', 'mình đang làm 1 muốn làm 1 website kiểu về even\n\n1. trả lời trắc nghiệp câu hỏi.\n\n2. yêu cầu quay vòng xoay trúng thưởng http://www.cooky.vn/qua-tang kiểu giống trang này\n\n3. kết quả ra minh có thể tính được kết quả trong lúc quay \n\nminh có rất nhiều even nên rất mong hợp tác với bạn nào làm có kinh nghiệm và đã làm web kiểu này rồi bạn nào có nhu cầu thì gửi báo giá cho mình nhé', '2015-11-26', 10, 0, 500000, 2000000, 'Hồ Chí Minh', 1),
(6, 'Cần 1 bạn phát triển plugin cho wordpress', 'can-1-ban-phat-trien-plugin-cho-wordpress', 'Hiện tại mình đang có 1 job về wp cần 1 bạn phát triển 1 số plugin cho wp\n\nplugin của mình đơn giản\n\nbạn nào có khả năng thi để lại thông tin cho mình nhé\n\nMình sẽ trao đổi lại\n\nCảm ơn các bạn đã quan tâm', '2015-11-26', 10, 0, 500000, 2000000, 'Hồ Chí Minh', 2),
(7, 'Cộng tác viên test game', 'cong-tac-vien-test-game', 'Tham gia chơi game và test lỗi game, hỗ trợ member cài đặt, hướng dẫn cách chơi\r\nLập kế hoạch test game\r\nNghiên cứu về các game của đối thủ.', '2015-12-30', 7, 1, 100000, 500000, 'Hồ Chí Minh', 2),
(8, 'Thiết kế và lập trình website bán hàng', 'thiet-ke-va-lap-trinh-website-ban-hang', 'Loại website cần làm: Bán hàng\r\nLĩnh vực hoạt động: Bán buôn\r\nLayout của website: Chưa có\r\nSố lượng trang cần làm: 1\r\nNền tảng muốn làm: cs-cart\r\nHệ thống Back-end: Không cần\r\nCác tính năng cần có: Đầy đủ tính năng như website bán hàng, Thân thiện với mobile, Hỗ trợ SEO, Làm theo yêu cầu\r\nYêu cầu khác của khách hàng\r\nBên mình cần một bạn chuyên thiết kế giao diện và tính năng cho CS-Cart.\r\nGặp trực tiếp tại TP.HCM để thống nhất về giao diện và báo giá.', '2015-12-30', 7, 1, 4000000, 6000000, 'Hồ Chí Minh', 2),
(12, 'Hoàn thiện web và biên tập nội dung web, thiết kế nội dung, hình ảnh', 'hoan-thien-web-va-bien-tap-noi-dung-web,-thiet-ke-noi-dung,-hinh-anh', 'Hiện tại mình đã có web (mẫu http://theme.crumina.net/index.php?theme=secondtouch và http://the7.dream-demo.com/demo/) đã cài lên server và muốn hoàn thiện tốt hơn, cần thiết kế một số hình ảnh giao diện cho web, cần ngay và luôn, sẵn sàng trả giá, bồ dưỡng cho Anh Em nhiệt tình và có nhiều dự án khác trong tháng 2, 3. Thỏa thuận\n\nMình cũng cần tuyển 10 bạn biên tập nội dung cho website CTy về thương mại điện tử - dịch vụ du lịch Hàn Quốc\n\nA. Yêu cầu:\n1. Biên soạn lại từ những bài viết khác, đặc biệt rất khuyến khích cá nhân tự viết, phát huy khả năng sáng tạo của cá nhân, viết theo chủ đề về du lịch, xúc tiến thương mại, quan hệ Việt Nam - Hàn Quốc.\n2. Có hiểu biết về du lịch, chăm sóc sức khỏe, thương mại điện tử, SEO web, phần mềm cơ bản chuyên nghiệp;\n3. Viết tối thiểu 4 bài/ngày (viết càng nhiều các bạn càng có nhuận bút càng nhiều),\n4. Hoàn thành tốt các Tiêu chí duyệt bài theo quy định (nội dung sinh động, hình ảnh phù hợp, định dạng chuẩn,..)\n5. Khuyến khích CTV viết bài ổn định, có ý muốn cộng tác lâu dài với công ty\n\nB. Hình thức trả lương:\nNhuận bút: từ 10.000 - 50.000/bài (tùy chất lượng từng bài viết)\nHình thức thanh toán: chuyển khoản hàng tuần.\nBạn nào mong muốn có nhu cầu tìm việc Cộng tác viên có thể liên lac với mình nhé!\nFdivivietnam @ gmail . com\nGod Bless You All', '2016-01-31', 6, 0, 100000, 200000, 'Bạn không thể chọn hơn 1 yêu cầuHà Nội', 14);

-- --------------------------------------------------------

--
-- Table structure for table `manage`
--

CREATE TABLE `manage` (
  `id_manage` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `provinceid` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`provinceid`, `name`, `type`) VALUES
('01', 'Hà Nội', 'Thành Phố'),
('02', 'Hà Giang', 'Tỉnh'),
('04', 'Cao Bằng', 'Tỉnh'),
('06', 'Bắc Kạn', 'Tỉnh'),
('08', 'Tuyên Quang', 'Tỉnh'),
('10', 'Lào Cai', 'Tỉnh'),
('11', 'Điện Biên', 'Tỉnh'),
('12', 'Lai Châu', 'Tỉnh'),
('14', 'Sơn La', 'Tỉnh'),
('15', 'Yên Bái', 'Tỉnh'),
('17', 'Hòa Bình', 'Tỉnh'),
('19', 'Thái Nguyên', 'Tỉnh'),
('20', 'Lạng Sơn', 'Tỉnh'),
('22', 'Quảng Ninh', 'Tỉnh'),
('24', 'Bắc Giang', 'Tỉnh'),
('25', 'Phú Thọ', 'Tỉnh'),
('26', 'Vĩnh Phúc', 'Tỉnh'),
('27', 'Bắc Ninh', 'Tỉnh'),
('30', 'Hải Dương', 'Tỉnh'),
('31', 'Hải Phòng', 'Thành Phố'),
('33', 'Hưng Yên', 'Tỉnh'),
('34', 'Thái Bình', 'Tỉnh'),
('35', 'Hà Nam', 'Tỉnh'),
('36', 'Nam Định', 'Tỉnh'),
('37', 'Ninh Bình', 'Tỉnh'),
('38', 'Thanh Hóa', 'Tỉnh'),
('40', 'Nghệ An', 'Tỉnh'),
('42', 'Hà Tĩnh', 'Tỉnh'),
('44', 'Quảng Bình', 'Tỉnh'),
('45', 'Quảng Trị', 'Tỉnh'),
('46', 'Thừa Thiên Huế', 'Tỉnh'),
('48', 'Đà Nẵng', 'Thành Phố'),
('49', 'Quảng Nam', 'Tỉnh'),
('51', 'Quảng Ngãi', 'Tỉnh'),
('52', 'Bình Định', 'Tỉnh'),
('54', 'Phú Yên', 'Tỉnh'),
('56', 'Khánh Hòa', 'Tỉnh'),
('58', 'Ninh Thuận', 'Tỉnh'),
('60', 'Bình Thuận', 'Tỉnh'),
('62', 'Kon Tum', 'Tỉnh'),
('64', 'Gia Lai', 'Tỉnh'),
('66', 'Đắk Lắk', 'Tỉnh'),
('67', 'Đắk Nông', 'Tỉnh'),
('68', 'Lâm Đồng', 'Tỉnh'),
('70', 'Bình Phước', 'Tỉnh'),
('72', 'Tây Ninh', 'Tỉnh'),
('74', 'Bình Dương', 'Tỉnh'),
('75', 'Đồng Nai', 'Tỉnh'),
('77', 'Bà Rịa - Vũng Tàu', 'Tỉnh'),
('79', 'Hồ Chí Minh', 'Thành Phố'),
('80', 'Long An', 'Tỉnh'),
('82', 'Tiền Giang', 'Tỉnh'),
('83', 'Bến Tre', 'Tỉnh'),
('84', 'Trà Vinh', 'Tỉnh'),
('86', 'Vĩnh Long', 'Tỉnh'),
('87', 'Đồng Tháp', 'Tỉnh'),
('89', 'An Giang', 'Tỉnh'),
('91', 'Kiên Giang', 'Tỉnh'),
('92', 'Cần Thơ', 'Thành Phố'),
('93', 'Hậu Giang', 'Tỉnh'),
('94', 'Sóc Trăng', 'Tỉnh'),
('95', 'Bạc Liêu', 'Tỉnh'),
('96', 'Cà Mau', 'Tỉnh');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'Lập Trình Ứng Dụng'),
(2, 'Lập Trính Di Động'),
(3, 'Dịch Thuật'),
(4, 'Lập Trình Web'),
(5, 'Viết lách'),
(6, 'Php'),
(7, 'Asp.net'),
(8, 'Java'),
(9, 'MVC'),
(10, 'Angular js'),
(11, 'CMS'),
(12, 'Word press'),
(13, 'Tiếng Anh'),
(14, 'Tiếng Nhật'),
(15, 'Tiếng Trung'),
(16, 'C#'),
(17, 'R'),
(18, 'Ios'),
(19, 'HTML/CSS'),
(20, 'C'),
(21, 'C++'),
(22, 'JavaScript'),
(23, 'Objective-C'),
(24, 'Perl'),
(25, 'Python'),
(26, 'SQL'),
(27, 'CSS'),
(28, 'Laravel'),
(29, 'Zend'),
(30, 'CI'),
(31, 'Cake'),
(32, 'Lập trình wordpress'),
(33, 'Lập trình Joomla'),
(34, 'Lập trình android'),
(35, 'Lập trình PhoneGap'),
(36, 'IT Support'),
(37, 'Lập trình Joomla'),
(38, 'Phân tích dữ liệu và báo cáo'),
(39, 'QA/Testing'),
(40, 'Hệ thống thương mại điện tử'),
(41, 'Quản trị hệ thống'),
(42, 'Quản lý website'),
(43, 'Thiết kế logo'),
(44, '\r\nThiết kế ứng dụng'),
(45, 'Thiết kế thư mời,tờ rơi'),
(46, 'Thiết kế brochure'),
(47, 'Thiết kế 2D , 3D'),
(48, 'Thiết kế đồ họa'),
(49, 'Viết bài PR'),
(50, 'Dich thuật'),
(51, 'SEO'),
(52, 'Trade Marketing (marketing tại điểm bán hàng)'),
(53, 'Dựng video');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `social_id` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `total_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `social_id`, `username`, `full_name`, `avatar`, `email`, `password`, `remember_token`, `level`, `active`, `total_post`) VALUES
(1, '', 'phucngo', 'Ngô Hùng Phúc', 'images/phucngo/156979699d5ad8.png', 'ngohungphuc1237695@gmail.com', '$2y$10$.xfmLvsDBGM.c10WdYWP7uzEY/yvLRNrfjGs7lteR54WR2tX/YklK', 'UTwPUz6v3tRbRd2kksExHJa3nrM2o0wl0JFU3oP4BmNNXSANfQ7oqmH7DRRr', 0, 1, 0),
(2, '', 'hoangphucvu', 'Hoàng Phúc Vũ', 'images/hpv/125695d660e429f.jpg', 'ngohungphuc9123125@gmail.com', '$2y$10$.xfmLvsDBGM.c10WdYWP7uzEY/yvLRNrfjGs7lteR54WR2tX/YklK', 'cRIczqYYY2SHAjnj43g4HVjlKwGDooBLohae2isI', 0, 1, 0),
(14, NULL, 'phuchung95', 'Phúc 95', 'images/phuchung95/1456a8cde3173de.jpg', 'ngohungphuc7695@gmail.com', '$2y$10$wEtMyQEOWhi2wu1x90x9JuHw7.NYwu.K.doUTa8CHjp3696ADt/Gq', 'XzcC9OIJNI9CUK1sG59dx3CLgKfBmSKgfJXcj1Re6Eo1h04d4h39Nrmg9XHR', 0, 1, 0),
(15, '1718310388387487', 'phuc-ngo', 'Phúc Ngô', 'images/phuc-ngo/15569c836fcd7f9.jpg', NULL, '$2y$10$.xfmLvsDBGM.c10WdYWP7uzEY/yvLRNrfjGs7lteR54WR2tX/YklK', 'vM4PqKVEuH9o9KSFComNmYfmiRbVOEfqztRAcdhPu9upwi9hmltO04SYJtAu', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_tag`
--
ALTER TABLE `content_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manage`
--
ALTER TABLE `manage`
  ADD PRIMARY KEY (`id_manage`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`provinceid`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `content_tag`
--
ALTER TABLE `content_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `manage`
--
ALTER TABLE `manage`
  MODIFY `id_manage` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
