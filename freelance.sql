-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2016 at 07:55 PM
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
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `from_user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `to_user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `content`, `from_user`, `to_user`, `created_at`, `view`) VALUES
(1, 'hi', 'phucphuc', 'phuchung95', '2016-03-05 14:38:54', 1),
(4, 'hi', 'phuc-ngo', 'phuchung95', '2016-03-12 14:38:54', 1),
(25, 'hi', 'phuchung95', 'phucphuc', '2016-03-13 02:50:13', 1),
(30, 'chao ban\n                    ', 'phuchung95', 'phucphuc', '2016-03-13 12:01:01', 1),
(31, 'aaaaa', 'phuchung95', 'phucphuc', '2016-03-13 12:02:23', 1),
(32, 'asdasd\n                    ', 'phucphuc', 'phuchung95', '2016-03-13 12:03:15', 1);

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
(5, 3, 'TÃ´i thÃ­ch há»£p cho cÃ´ng viá»‡c nÃ y.Nhanh', 5, 2000000, '2016-01-27', 12),
(6, 3, 'Co kinh nghiem thiet ke logo', 5, 1000000, '2016-02-15', 26);

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
(1, 12, 'Lập Trình Ứng Dụng,Dịch Thuật,Viết lách,Php,Java'),
(2, 13, 'Thiết kế logo,Thiết kế 2D 3D,Thiết kế brochure,Thiết kế thư mời,Thiết kế đồ họa'),
(3, 14, 'Lập Trính Di Động,Php'),
(4, 15, 'Viết lách'),
(5, 16, 'Lập Trình Ứng Dụng,Lập Trình Web,Php'),
(6, 17, 'Lập trình android'),
(7, 18, 'Lập Trình Ứng Dụng,Lập Trình Web,Php,MVC'),
(8, 22, 'Lập Trình Ứng Dụng'),
(11, 25, 'Lập Trình Web'),
(12, 26, 'Lập Trình Ứng Dụng'),
(13, 27, 'Lập Trình Ứng Dụng'),
(14, 28, 'ASP.Net'),
(15, 30, 'ASP.Net'),
(16, 31, 'Lập Trình Ứng Dụng'),
(17, 32, 'Lập Trình Ứng Dụng'),
(18, 33, 'ASP.Net'),
(19, 26, 'Thiết kế logo');

-- --------------------------------------------------------

--
-- Table structure for table `cv`
--

CREATE TABLE `cv` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `education` text COLLATE utf8_unicode_ci NOT NULL,
  `experience` text COLLATE utf8_unicode_ci NOT NULL,
  `activities` text COLLATE utf8_unicode_ci,
  `capabilities` text COLLATE utf8_unicode_ci NOT NULL,
  `skill` text COLLATE utf8_unicode_ci,
  `interests` text COLLATE utf8_unicode_ci,
  `personal_site` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `post_at` date NOT NULL,
  `day_open` tinyint(4) NOT NULL,
  `deadline` date NOT NULL,
  `active` tinyint(1) NOT NULL COMMENT '0 is open , 1 is close',
  `allowance_min` double NOT NULL,
  `allowance_max` double NOT NULL,
  `location` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `slug`, `description`, `content`, `post_at`, `day_open`, `deadline`, `active`, `allowance_min`, `allowance_max`, `location`, `user_id`) VALUES
(3, 'Tìm team phát triển trang web kinh doanh thực phẩm online', 'tìm-team-phat-trien-trang-web-kinh-doanh-thuc-pham-online', '', 'Cần tìm cá nhân hay team phát triển trang web kinh doanh thực phẩm online.\n\nThông tin này đã đăng 1 lần rồi nhưng do chưa tìm được đối tác như ý nên mình xin đăng lại với đầy đủ chi tiết hơn.\n\nYêu cầu:\n\n1. Phát triển front-end và back-end theo tài liệu mô tả yêu cầu có sẵn.\n\n2. Sử dụng MySQL, PHP. Cấu trúc DB do team thiết kế và cung cấp. Framework do team quyết định.\n\n3. Trang web có sử dụng kỹ thuật đổi từ địa chỉ bình thường sang tọa độ GPS để xác định khoảng cách giữa khách hàng với các quầy giao dịch. Nếu team chưa có kinh nghiệm với kỹ thuật này thì có thể bỏ khỏi báo giá.\n\n4. Deadline: front-end yêu cầu cuối tháng 12/2015 phải publish. Back-end và cả hệ thống đến cuối 1/2016 phải hoàn thành.\n\n5. Cung cấp demo theo yêu cầu của mình. Demo này sẽ được trả phí bất kể đạt hay không đạt yêu cầu. \n\n6. Chi trả theo từng giai đoạn sau khi hoàn tất và test kiểm tra OK.\n\nThông tin chi tiết xin vui lòng inbox.\n\nCám ơn đã đọc tin', '2015-11-24', 10, '2015-12-04', 1, 500000, 2000000, 'Hồ Chí Minh', 1),
(4, 'Cần xây dựng website dạng forum kết hợp bán hàng online.', 'can-xay-dung-website-dang-forum-ket-hop-ban-hang-online', '', 'Tôi đang cần tìm một coder để xây dựng website dạng forum kết hợp bán hàng online.\n\nDo đây chưa phải là một website chuẩn nên sẽ xây dựng từng phần, khảo sát phản ứng của user và chỉnh sửa vài lần mới đi đến hoàn thiện.\n\nSẽ trao đổi cụ thể hơn khi tìm được coder.', '2015-11-24', 10, '2015-12-04', 1, 500000, 2000000, 'Hồ Chí Minh', 1),
(5, 'website', 'website', '', 'mình đang làm 1 muốn làm 1 website kiểu về even\n\n1. trả lời trắc nghiệp câu hỏi.\n\n2. yêu cầu quay vòng xoay trúng thưởng http://www.cooky.vn/qua-tang kiểu giống trang này\n\n3. kết quả ra minh có thể tính được kết quả trong lúc quay \n\nminh có rất nhiều even nên rất mong hợp tác với bạn nào làm có kinh nghiệm và đã làm web kiểu này rồi bạn nào có nhu cầu thì gửi báo giá cho mình nhé', '2015-11-24', 10, '2015-12-04', 1, 500000, 2000000, 'Hồ Chí Minh', 1),
(6, 'Cần 1 bạn phát triển plugin cho wordpress', 'can-1-ban-phat-trien-plugin-cho-wordpress', '', 'Hiện tại mình đang có 1 job về wp cần 1 bạn phát triển 1 số plugin cho wp\n\nplugin của mình đơn giản\n\nbạn nào có khả năng thi để lại thông tin cho mình nhé\n\nMình sẽ trao đổi lại\n\nCảm ơn các bạn đã quan tâm', '2015-11-24', 10, '2015-12-04', 1, 500000, 2000000, 'Hồ Chí Minh', 2),
(7, 'Cộng tác viên test game', 'cong-tac-vien-test-game', '', 'Tham gia chơi game và test lỗi game, hỗ trợ member cài đặt, hướng dẫn cách chơi\r\nLập kế hoạch test game\r\nNghiên cứu về các game của đối thủ.', '2015-11-24', 10, '2015-12-04', 1, 100000, 500000, 'Hồ Chí Minh', 2),
(8, 'Thiết kế và lập trình website bán hàng', 'thiet-ke-va-lap-trinh-website-ban-hang', '', 'Loại website cần làm: Bán hàng\r\nLĩnh vực hoạt động: Bán buôn\r\nLayout của website: Chưa có\r\nSố lượng trang cần làm: 1\r\nNền tảng muốn làm: cs-cart\r\nHệ thống Back-end: Không cần\r\nCác tính năng cần có: Đầy đủ tính năng như website bán hàng, Thân thiện với mobile, Hỗ trợ SEO, Làm theo yêu cầu\r\nYêu cầu khác của khách hàng\r\nBên mình cần một bạn chuyên thiết kế giao diện và tính năng cho CS-Cart.\r\nGặp trực tiếp tại TP.HCM để thống nhất về giao diện và báo giá.', '2015-11-24', 10, '2015-12-04', 1, 4000000, 6000000, 'Hồ Chí Minh', 2),
(12, 'Hoàn thiện web và biên tập nội dung web, thiết kế nội dung, hình ảnh', 'hoan-thien-web-va-bien-tap-noi-dung-web-thiet-ke-noi-dung-hinh-anh', '', 'Hiện tại mình đã có web (mẫu http://theme.crumina.net/index.php?theme=secondtouch và http://the7.dream-demo.com/demo/) đã cài lên server và muốn hoàn thiện tốt hơn, cần thiết kế một số hình ảnh giao diện cho web, cần ngay và luôn, sẵn sàng trả giá, bồ dưỡng cho Anh Em nhiệt tình và có nhiều dự án khác trong tháng 2, 3. Thỏa thuận\n\nMình cũng cần tuyển 10 bạn biên tập nội dung cho website CTy về thương mại điện tử - dịch vụ du lịch Hàn Quốc\n\nA. Yêu cầu:\n1. Biên soạn lại từ những bài viết khác, đặc biệt rất khuyến khích cá nhân tự viết, phát huy khả năng sáng tạo của cá nhân, viết theo chủ đề về du lịch, xúc tiến thương mại, quan hệ Việt Nam - Hàn Quốc.\n2. Có hiểu biết về du lịch, chăm sóc sức khỏe, thương mại điện tử, SEO web, phần mềm cơ bản chuyên nghiệp;\n3. Viết tối thiểu 4 bài/ngày (viết càng nhiều các bạn càng có nhuận bút càng nhiều),\n4. Hoàn thành tốt các Tiêu chí duyệt bài theo quy định (nội dung sinh động, hình ảnh phù hợp, định dạng chuẩn,..)\n5. Khuyến khích CTV viết bài ổn định, có ý muốn cộng tác lâu dài với công ty\n\nB. Hình thức trả lương:\nNhuận bút: từ 10.000 - 50.000/bài (tùy chất lượng từng bài viết)\nHình thức thanh toán: chuyển khoản hàng tuần.\nBạn nào mong muốn có nhu cầu tìm việc Cộng tác viên có thể liên lac với mình nhé!\nFdivivietnam @ gmail . com\nGod Bless You All', '2015-11-24', 10, '2015-12-04', 1, 100000, 200000, 'Hà Nội', 14),
(13, 'Tìm freelancer thiết kế logo', 'tim-freelancer-thiet-ke-logo', '', 'Cần tìm freelancer chuyên về thiết kế logo, poster, key visual cho các event, activation. Lương thỏa thuận. Xin vui lòng gửi portfolio vào email uyenpt@skylarkcommunications.com.', '2015-11-24', 10, '2015-12-04', 1, 3000000, 8000000, 'Hà Nội', 14),
(14, 'Cần tìm người viết plugin cho code vinaget', 'can-tim-nguoi-viet-plugin-cho-code-vinaget', '', 'Mình cần một bạn nhiệt tình viết plugin cho code vinaget phiên bản 2.6.3 và 2.7.0\nFacebook của mình: http://facebook.com/LyTieuDaoFC', '2015-11-24', 10, '2015-12-04', 1, 100000, 50000, 'Hồ Chí Minh', 14),
(15, 'Freelance Content Writers for Travel Magazine', 'freelance-content-writers-for-travel-magazine', '', 'Work from Home\n\nDear future writers, we are excited to launch a new fun travel magazine for young travellers.\n\nWe are looking for freelancer in Ho Chi Minh city who are passionate about REVEALING and GUIDING travellers with local wisdom.\n\nYour tasks: \n\n- Writing short, informative but original articles about cities.\n- Reading and curating with lightning speed.\n- Producing 35 short articles/ day (420 short articles/month). \n- Sample: http://www.buzzfeed.com/isabellelaureta/jimmy-bondoc-would-be-proud#.eyVdzXA1Z\n\nBenefits\n\n- A great opportunity to enhance your writing skills\n- Work from home. Only need to be at the office 3 hours/ week.\n- Reimbursement of VND1,500,000/month. Up to 10,000,000 if you can write more.\n- Opportunity to showcase your creativity\n- Improve your professional English writing and editorial skills.\n- Learn new working digital tools.\n- Work with people work hard to travel. You will travel as work.\n\nWe want you on our team because you are capable of:\n\n- Living and breathing on social media sites.\n- Being passionate about traveling and desired of changing the way people travel.\n- EXCELLENTLY fluent in English and writing away.\n- If your writing can make people screw their safe comfort zone and pack for a trip to a city, JOIN US!\n- Tell the world how beautiful your city is and together we will help you spread your words on a GLOBAL scale.\n- Excellent team-work and smart-solution.\n- AWESOME time-management skill.\n- Punctual, honest, efficient, quick-response.\n- If you can make people stand up from their desk to grab their purses and go out for the food that you are blogging, JOIN US!\n\n', '2015-11-24', 10, '2015-12-04', 1, 3000000, 8000000, 'Hà Nội', 14),
(16, 'Dựng 1 web bán hàng giống như lexus.com mới', 'dung-1-web-ban-hang-giong-nhu-lexus.com-moi', '', 'Mình đang cần dựng 1 trang web giống zalora.vn để kinh doanh nhiều mặt hàng online. Vì vậy, các yêu cầu quan trọng của trang web là:\n- Giữ lại UX đã tối ưu của zalora cho nhiều nhóm sản phẩm, mỗi nhóm sản phẩm có những đặc tính riêng\n- Tính toán về responsive cho 2 nhóm thiết bị chính là laptop & mobi\n- Phần admin phải làm tốt việc:\n+ Quản lý nhiều nhóm sản phẩm với nhiều đặc tính riêng\n+ Quản lý giá, khuyến mãi tốt theo event, tồn kho,... thanh toán trực tuyến hoặc online in ra hóa đơn bán lẻ\n+ Phần mua bán hàng online phải tiện dụng (bán lẻ hoặc bán đại lý báo giá)\n+ So sánh các sản phẩm trong website với nhau\n+ Quản lý đại lý cấp dưới\n+ Tạo các hiệu ứng click chuột vào sản phẩm hoặc hình ảnh\n+ Cókhảnăngtùychỉnhđangkhungtheo\n+ Có commnet, đánh giá, mỗi 1 sản phẩm, cùng 1 sản phẩm màu khác nhau giá tiền sẽ khác nhau.\n+ Tìm kiếm theo từ gợi ý (giá, thông số kỹ thuật, màu sắc…)\n+ Theo chuẩn SEO\n+ Tích hợp liên kết với facebook, google+, twitter, instagram..zalo, skype\n+ Đánh giá (kiểu dáng, giá cả, chất lượng)\n', '2015-11-24', 10, '2015-12-04', 1, 5000000, 10000000, 'Hà Nội', 14),
(17, 'Cần người Clone App Android Đơn Giản', 'can-nguoi-clone-app-android-Don-gian', '', 'Mình cần người clone app Android (Dạng app download). Liên hệ email: ***@gmail.com hoặc skype: ***dai để lấy mẫu và nói chuyện cụ thể.', '2015-11-24', 10, '2015-12-04', 1, 100000, 500000, 'Hà Nội', 14),
(18, 'Cần FIX Code Jquery Image PhP', 'can-fix-code-jquery-image-php', '', 'Hiện tại mình đang cần 1 bạn FIX Code Jquery Image PhP\nWebsite ****: http://www.thietbixe.com\nHình sản phẩm mờ : http://thietbixe.com/mua-ban-xe-ct-7.html --- Website bên mình\nHình sản phẩm nét : http://gianhangvn.com/oto-xe-may-xe-dap-1104a.html ( Gianhangvn.com )\nMenu Danh mục Sản Phẩm giống ++>> obdvietnam.vn\n\n1. Tinh chỉnh lại Sản Phẩm bằng javascript - Jquery Image\n2. Menu Danh Mục Sản Phẩm giống Obdvietnam.vn\nBáo giá sớm quan bên mình nha .\nSố Điện Thoại : Mr . Tín ****\nEmail: ****\n****', '2015-11-24', 10, '2015-12-04', 1, 100000, 50000, 'Hà Nội', 14),
(22, 'web-app quản lý công ty nhỏ', 'web-app-quan-ly-cong-ty-nho', 'images/phuchung95/baiviet/download.png', 'Mình đang cần làm 1 web-app quản lý doanh nghiệp có thể chạy trên nền tảng web ( qua hosting ) cho quy mô công ty nhỏ dưới 10 nhân viên. \r\n\r\n\r\n\r\nApp cần có 3 module chính:\r\n1. Kế hoạch kinh doanh:\r\n- Hệ thống giá sản phẩm ( lưu theo mã code tên sản phẩm ) theo từng năm. Có thể xuất báo cáo tỷ lệ giá theo từng thời kỳ tăng giảm.\r\n- Module báo giá tự động theo số thứ tự hệ thống quy định ( vd: khi nhập các yêu cầu báo giá sản phẩm sẽ chọn sp rồi tự động xuất bảng báo giá format sẵn ). Có 2 người quyết định, người lập và người duyệt ( gửi thông báo hoặc link để người điều hành đồng ý trước khi xuất in báo giá )\r\n- Quản lý hợp đồng: Lập quản lý các hợp đồng theo số nhảy tự động của hệ thống ( cứ lập HĐ mới sẽ ra số thứ tự của hệ thống ). Theo dõi tiến độ thực hiện HĐ và quá trình thanh toán. Có thể truy xuất HĐ đang ở trong giai đoạn nào. To-do list..\r\n- Hồ sơ thầu: Các biểu mẫu thiết lập sẵn theo quy định hiện hành theo luật đấu thầu ( Các biểu mẫu, format của HST quốc tế, trong nước, chỉ định thầu rút gọn..). Mỗi lần làm 1 HST thầu mới sẽ nhập các dữ liệu vào các blank trống của biểu mẫu để xuất in ra theo format quy định.\r\n- Các module khác trong quá trình làm..\r\n\r\n2. Dịch vụ khách hàng :\r\n- Gồm hạng mục công việc, thời gian, người liên quan, tiến độ xử lý công việc ( to-do list ), thông báo qua email cho từng người-bộ phận liên quan. Giống như 1 dash-board chung để khi có việc yêu cầu từ khách hàng thì người quan lý sẽ nhập đầu mục công việc và phân công người phụ trách, tiến độ xử lý, trách nhiệm, và các ghi chú khác.\r\n\r\n3. Tài chính:\r\n- Theo dõi chi phí, lợi nhuận của từng dự án. Quyền truy cập chỉ dành cho giám đốc hoặc người chỉ định. Cập nhập từng chi phí liên quan dự án.\r\n- Công tác: nhập mẫu có sẵn công tác và các chi phí và hoàn ứng sau khi công tác xong. Người lập và người duyệt theo chỉ định.\r\n- Quỹ TM: thu chi quỹ TM ( nội bộ ).\r\n\r\n4. Yêu cầu chung:\r\n- Thiết lập theo tài khoản chỉ đinh. Vd: Chuyên viên kinh doanh thì vào làm các báo giá, hệ thống giá và được duyệt bởi người quản lý sau đó mới lưu vào hệ thống. Module dịch vụ thì tuỳ vào cấp độ quyền tạo ra hạng mục việc theo chế độ ưu tiên và giảm dần. \r\n-web-app: Giao diện sử dụng được trên PC, IPAD, Iphone qua web đơn giản, dễ nhìn.\r\n- Có back-up dữ liệu định kỳ và backup dữ liệu ổ cứng ngoài tại đơn vị.', '2015-11-24', 10, '2015-12-04', 1, 100000, 200000, 'Hà Nội', 14),
(26, 'Thiết kế logo', 'thiet-ke-logo', NULL, 'Mình muốn thiết kế logo cho dự án startup phù hợp với các yếu tố được đề ra.<br />Giá là 500k.<br />Chỉnh sửa cho đến khi vừa ý và phù hợp requirement.', '2016-02-14', 7, '2016-02-21', 1, 100000, 500000, 'Hà Nội', 14);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_approved`
--

CREATE TABLE `jobs_approved` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_assign` int(11) NOT NULL,
  `user_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jobs_approved`
--

INSERT INTO `jobs_approved` (`id`, `job_id`, `user_assign`, `user_post`) VALUES
(1, 12, 3, 14);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_post`
--

CREATE TABLE `jobs_post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `experience_year` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `salary` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `post_at` date NOT NULL,
  `location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jobs_post`
--

INSERT INTO `jobs_post` (`id`, `title`, `slug`, `content`, `experience_year`, `quantity`, `salary`, `post_at`, `location`, `user_id`) VALUES
(1, '[Salary up to $900] PHP Developer - DWORK', '[salary-up-to-$900]-php-developer---dwork', 'JOB DESCRIPTION<br /><br />Follow best practice conventions and project structure<br />Reading blogs and compelling ideas how to improve our skills.<br />Know how to handle the entire software development life cycle, end to end.<br />Have good DBA and strong DB schema design skills<br />Must be able to write complex queries in SQL and understand the EXPLAIN query.<br />Best practice conventions and project structure. We hate fat file<br /> <br /><br />YOUR SKILL AND EXPERIENCE<br /><br />Can master any server-side PHP framework and client-side HTML framework quickly<br />HTML and CSS must be strictly DRY (i.e. CSS classes and HTML component must be reusable)<br />Be aware of basic web optimization methods (concatenate and minify JavaScript and CSS assets, sprites)<br />Experience with using browser Web Inspector<br />Experience in Linux environment to do basic sysadmin tasks<br />Knowledge of PostgreSQL, MySQL<br />Good jQuery skills<br />OOP should be expected<br />Aware of CSS preprocessors<br />Responsive web with Bootstrap<br />Experience with some MVC PHP frameworks (CodeIgniter, YII , Phalcon, CakePHP, CodeIgniter, ...)<br />Aware of search framework like Elastic-search<br />Hybrid app experience is a huge plus<br /> <br /><br />BENEFITS<br /><br />Competitive salary (up to $900 gross)<br />Bao Viet Insurance, snacks, transportation will be negotiable.<br />Having good and fair reward and promotion system <br />Chances to travel oversea learning trip!!!<br /> <br /><br />WHY YOU''LL LOVE WORKING HERE<br /><br />Competitive salary<br />A workspace with great view to green Hoang Van Thu park (Yellow Flowers are there for fan boys too)<br />A bunch of funny and motivated people<br />Standing by window, sitting at desk, hugging the beanbag, lying on the floor. Free your style, bright your code<br />SNACKS!<br /> <br /><br />WHY YOU''LL HATE WORKING HERE<br /><br />Join foosball world''s champion<br />Fat boss<br />Cute Office/HR/Finance manager<br />Naughty dog<br />Get FATTTTT', 1, 3, '900$', '2016-02-16', 'Hồ Chí Minh', 14),
(3, '[HN] Junior Software Engineer - Competitive Salary', '[hn]-junior-software-engineer---competitive-salary', 'Mô tả công việc<br /><br />Phát triển hệ thống phần mềm giúp vận hành bộ máy quản lý của JupViec.vn<br />Thực hiện hoá hệ thống cloud platform chuyên về các dịch vụ gia đình, mục tiêu như sau:<br />Kết nối giữa khách hàng và người giúp việc<br />Quản lý các hoạt động trong công ty<br />Viết ứng dụng mobile phục vụ cho nhân viên và khách hàng.<br />Cải tiến các chức năng cũ của hệ thống hiện tại<br />Yêu cầu<br /><br />Các ứng viên cần đạt tối thiểu các yêu cầu sau (>= 3 tháng kinh nghiệm)<br /><br />Java Core, Spring Framework, PHP, Ajax<br />Javascript, HTML, CSS<br />Chế độ đãi ngộ<br /><br />Lương thưởng hấp dẫn (từ $400 trở lên + bonus theo dự án)<br />Bảo hiểm, trợ cấp đầy đủ<br />Chính sách thưởng tết, các ngày lễ tết dương lịch, 2/9,…<br />Được mentor học hỏi thêm các kĩ năng mới; và thường xuyên training.<br />Được thử thách với nhiều dự án hấp dẫn khác nhau của công ty<br />Môi trường làm việc trẻ, năng động và thoải mái; nhiều hoạt động sôi nổi giúp bản thân không bị nhàm chán với công việc. ', 1, 2, '$400 - $700', '2016-02-17', 'Hà Nội', 14);

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
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `cv_id` int(11) NOT NULL,
  `skill_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`id`, `cv_id`, `skill_name`, `user_id`) VALUES
(1, 1, 'PHP', 14),
(2, 1, 'Asp.net', 14);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`, `slug`) VALUES
(1, 'Lập Trình Ứng Dụng', 'lap-trinh-ung-dung'),
(2, 'Lập Trính Di Động', 'lap-trinh-di-dong'),
(3, 'Dịch Thuật', 'dich-thuat'),
(4, 'Lập Trình Web', 'lap-trinh-web'),
(5, 'Viết Lách', 'viet-lach'),
(6, 'PHP', 'php'),
(7, 'ASP.Net', 'asp.net'),
(8, 'Java', 'java'),
(9, 'MVC', 'mvc'),
(10, 'Angular JS', 'angular-js'),
(11, 'CMS', 'cms'),
(12, 'WordPress', 'word-press'),
(13, 'Tiếng Anh', 'tieng-anh'),
(14, 'Tiếng Nhật', 'tieng-nhat'),
(15, 'Tiếng Trung', 'tieng-trung'),
(16, 'C#', 'c#'),
(17, 'R', 'r'),
(18, 'IOS', 'ios'),
(19, 'HTML/CSS', 'html-css'),
(20, 'C', 'c'),
(21, 'C++', 'c++'),
(22, 'JavaScript', 'javascript'),
(23, 'Objective-C', 'objective-c'),
(24, 'Perl', 'perl'),
(25, 'Python', 'python'),
(26, 'SQL', 'sql'),
(27, 'NodeJs', 'node-js'),
(28, 'Laravel', 'laravel'),
(29, 'Zend', 'zend'),
(30, 'CI', 'ci'),
(31, 'Cake PHP', 'cake-php'),
(32, 'Lập trình Ruby', 'lap-trinh-ruby'),
(33, 'Lập trình Joomla', 'lap-trinh-joomla'),
(34, 'Lập trình android', 'lap-trinh-android'),
(35, 'Lập trình PhoneGap', 'lap-trinh-phonegap'),
(36, 'IT Support', 'it-support'),
(37, 'Lập trình Ruby On Rails', 'lap-trinh-ruby-on-rails'),
(38, 'Phân tích dữ liệu và báo cáo', 'phan-tich-du-lieu'),
(39, 'QA/Testing', 'qa-testing'),
(40, 'Hệ thống thương mại điện tử', 'he-thong-thuong-mai-dien-tu'),
(41, 'Quản trị hệ thống', 'quan-tri-he-thong'),
(42, 'Quản lý website', 'quan-ly-website'),
(43, 'Thiết kế logo', 'thiet-ke-logo'),
(44, '\r\nThiết kế ứng dụng', 'thiet-ke-ung-dung'),
(45, 'Thiết kế thư mời tờ rơi', 'thiet-ke-thu-moi-to-roi'),
(46, 'Thiết kế brochure', 'thiet-ke-brochure'),
(47, 'Thiết kế 2D 3D', 'thiet-ke-2d-3d'),
(48, 'Thiết kế đồ họa', 'thiet-ke-do-hoa'),
(49, 'Viết bài PR', 'viet-bai-pr'),
(50, 'Dich thuật', 'dich-thuat'),
(51, 'SEO', 'seo'),
(52, 'Trade Marketing (marketing tại điểm bán hàng)', 'trade-marketing'),
(53, 'Dựng video', 'dung-video');

-- --------------------------------------------------------

--
-- Table structure for table `tracker`
--

CREATE TABLE `tracker` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `visit_date` date NOT NULL,
  `visit_time` time NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tracker`
--

INSERT INTO `tracker` (`id`, `username`, `visit_date`, `visit_time`, `hits`) VALUES
(1, 'phuchung95', '2016-03-20', '15:26:31', 1),
(2, 'phuchung95', '2016-03-21', '15:26:31', 1),
(3, 'phuc-ngo', '2016-03-21', '15:26:01', 1),
(4, 'phuchung95', '2016-03-22', '23:23:05', 2),
(16, 'phuc-ngo', '2016-03-23', '09:00:06', 2),
(17, 'phuchung95', '2016-03-23', '09:00:35', 100),
(18, 'phuchung95', '2016-03-24', '11:58:56', 1),
(19, 'phuchung95', '2016-03-27', '08:13:29', 2),
(20, 'phuchung95', '2016-03-28', '23:11:13', 1),
(21, 'phuchung95', '2016-03-29', '16:18:55', 2),
(22, 'phuc-ngo', '2016-04-14', '15:35:10', 1),
(23, 'phuchung95', '2016-04-14', '15:55:39', 1),
(24, 'phuc-ngo', '2016-04-18', '14:47:32', 1);

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
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_approved`
--
ALTER TABLE `jobs_approved`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_post`
--
ALTER TABLE `jobs_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`provinceid`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracker`
--
ALTER TABLE `tracker`
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
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `content_tag`
--
ALTER TABLE `content_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `cv`
--
ALTER TABLE `cv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `jobs_approved`
--
ALTER TABLE `jobs_approved`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jobs_post`
--
ALTER TABLE `jobs_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `tracker`
--
ALTER TABLE `tracker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
