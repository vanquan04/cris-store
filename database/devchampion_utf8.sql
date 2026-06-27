-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: devchampion
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ai_knowledge`
--

DROP TABLE IF EXISTS `ai_knowledge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ai_knowledge` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ai_knowledge`
--

LOCK TABLES `ai_knowledge` WRITE;
/*!40000 ALTER TABLE `ai_knowledge` DISABLE KEYS */;
INSERT INTO `ai_knowledge` VALUES (1,'sản phẩm','Các loại sản phẩm của cửa hàng','Cửa hàng Cris Store chuyên bán các dòng giày đá bóng chính hãng từ Nike, Adidas, Puma, Mizuno... Chúng tôi cung cấp đủ các loại đế cho sân cỞ nhân tạo (TF), sân cỞ tự nhiên (FG/AG) và giày futsal (IC). Tất cả sản phẩm đỞu cam kết chính hãng 100%.',NULL,'2026-05-19 16:41:45','2026-05-19 16:41:45'),(2,'thông tin','Giới thiệu Cris Store','Cris Store - Chuyên giày đá bóng chính hãng hàng đầu. Cửa hàng tỞa lạc tại Ğại hỞc Công nghệ Ğông Þ. Hotline: 0375284572. Email: admin@crisstore.com. Chúng tôi cam kết mang đến những đôi giày chất lượng nhất để nâng tầm đôi chân Việt.',NULL,'2026-05-19 16:41:45','2026-05-19 16:41:45'),(3,'vận chuyển','Chính sách vận chuyển','Miễn phí giao hàng toàn quốc. ThỞi gian giao hàng từ 3-7 ngày tùy khu vực. Ğơn hàng trên 500.000đ được miễn phí vận chuyển.',NULL,'2026-05-19 16:41:45','2026-05-19 16:41:45'),(4,'thanh toán','Phương thức thanh toán','Hỗ trợ thanh toán khi nhận hàng (COD) và thanh toán online qua VNPay. Khách hàng có thể thanh toán trực tiếp khi nhận hàng hoặc thanh toán trước qua chuyển khoản.',NULL,'2026-05-19 16:41:45','2026-05-19 16:41:45'),(5,'đổi trả','Chính sách đổi trả','Chính sách đổi mới: Khách hàng được đổi sản phẩm trong vòng 7 ngày nếu sản phẩm bị lỗi từ nhà sản xuất. Sản phẩm đổi phải còn nguyên vẹn, có đầy đủ phụ kiện và hóa đơn.',NULL,'2026-05-19 16:41:45','2026-05-19 16:41:45'),(6,'tài khoản','Thẻ thành viên','Khách hàng có thể làm thẻ thành viên tại cửa hàng để hưởng các ưu đãi và điểm tích lũy. Ğiểm tích lũy có thể đổi quà tặng và các sản phẩm đặc biệt.',NULL,'2026-05-19 16:41:45','2026-05-19 16:41:45');
/*!40000 ALTER TABLE `ai_knowledge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb_banner` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `sort` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banners_creator_foreign` (`creator`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (2,'Banner 2','#','uploads/banner3.jpg',22,3,'2023-07-25 19:08:41','2023-07-26 09:06:37',1,NULL),(4,'Banner 4','#','uploads/bannerTQStore.jpg.png',22,4,'2023-07-01 14:51:14','2023-07-01 15:01:35',1,NULL),(5,'Banner 1','#','uploads/banner1.jpg',22,1,'2023-07-26 09:04:03','2023-07-26 09:04:03',1,NULL),(7,'Banner 2','#','uploads/banner2.jpg',22,2,'2023-07-26 09:05:19','2023-07-26 09:05:19',1,NULL);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_demo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb_main` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_parent` bigint unsigned NOT NULL,
  `creator` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `slug` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blogs_cat_parent_foreign` (`cat_parent`),
  KEY `blogs_creator_foreign` (`creator`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (8,'Ukraine nói Nga rút gần như toàn bộ lực lượng khỞi Belarus','<h2 class=\"singular-sapo\" style=\"text-align: center;\"><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>(D&acirc;n tr&iacute;) - Quan chức Ukraine n&oacute;i rằng Nga đ&atilde; r&uacute;t gần như to&agrave;n bộ lực lượng khỞi l&atilde;nh thổ quốc gia đồng minh Belarus.</strong></span></h2>\r\n<div class=\"singular-content\" style=\"text-align: center;\">\r\n<figure class=\"image align-center\"><img class=\"entered loaded\" title=\"Ukraine n&oacute;i Nga r&uacute;t gần như to&agrave;n bộ lực lượng khỞi Belarus - 1\" src=\"https://icdn.dantri.com.vn/thumb_w/680/2023/07/14/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.jpeg\" srcset=\"https://icdn.dantri.com.vn/thumb_w/680/2023/07/14/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.jpeg 1x, https://icdn.dantri.com.vn/thumb_w/1020/2023/07/14/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.jpeg 1.5x, https://icdn.dantri.com.vn/thumb_w/1360/2023/07/14/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.jpeg 2x\" alt=\"Ukraine n&oacute;i Nga r&uacute;t gần như to&agrave;n bộ lực lượng khỞi Belarus - 1\" data-width=\"680\" data-height=\"368\" data-original=\"https://icdn.dantri.com.vn/2023/07/14/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.jpeg\" data-photo-id=\"2548127\" data-track-content=\"\" data-content-name=\"article-content-image\" data-content-piece=\"article-content-image_2548127\" data-content-target=\"/the-gioi/ukraine-noi-nga-rut-gan-nhu-toan-bo-luc-luong-khoi-belarus-20230714201054632.htm\" data-src=\"https://icdn.dantri.com.vn/thumb_w/680/2023/07/14/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.jpeg\" data-srcset=\"https://icdn.dantri.com.vn/thumb_w/680/2023/07/14/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.jpeg 1x, https://icdn.dantri.com.vn/thumb_w/1020/2023/07/14/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.jpeg 1.5x, https://icdn.dantri.com.vn/thumb_w/1360/2023/07/14/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.jpeg 2x\" data-ll-status=\"loaded\" />\r\n<figcaption>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>Binh sĩ Nga v&agrave; Belarus trong một cuộc diễn tập (Ảnh: Defense Express).</strong></span></p>\r\n</figcaption>\r\n</figure>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>Andrii Demchenko, ph&aacute;t ng&ocirc;n vi&ecirc;n của Cục Bi&ecirc;n ph&ograve;ng Nh&agrave; nước Ukraine, cho biết Nga hiện thỞi đ&atilde; đưa hầu hết binh sĩ ở Belarus vỞ nước.</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>\"T&igrave;nh h&igrave;nh ở bi&ecirc;n giới với Belarus vẫn nằm dưới sự kiểm so&aacute;t ho&agrave;n to&agrave;n của Ukraine. Ở ph&iacute;a b&ecirc;n kia bi&ecirc;n giới, ch&uacute;ng t&ocirc;i kh&ocirc;ng thấy đối phương c&oacute; đủ lực lượng cần thiết để tấn c&ocirc;ng Ukraine một lần nữa. Tuy nhi&ecirc;n, ch&uacute;ng t&ocirc;i phải chuẩn bị cho bất kỳ diễn biến n&agrave;o của t&igrave;nh h&igrave;nh, bởi v&igrave; Belarus vẫn tiếp tục hỗ trợ Nga trong cuộc chiến chống lại Ukraine\", &ocirc;ng Demchenko ph&aacute;t biểu.</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>\"Nga huấn luyện qu&acirc;n đội ở Belarus. Số lượng binh sĩ Nga tại c&aacute;c cơ sở huấn luyện của Belarus gần đ&acirc;y đang giảm dần v&agrave; cho đến gần đ&acirc;y, ch&uacute;ng t&ocirc;i đ&atilde; ghi nhận con số n&agrave;y l&ecirc;n tới 2.000 ngưỞi. Tuy nhi&ecirc;n, hiện tại, đợt lu&acirc;n chuyển tiếp theo đ&atilde; diễn ra v&agrave; gần như to&agrave;n bộ qu&acirc;n đội Nga đ&atilde; r&uacute;t khỞi Belarus\", &ocirc;ng cho biết.</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>\"Ch&uacute;ng t&ocirc;i kh&ocirc;ng thể loại trừ khả năng trong tương lai gần, nhiỞu binh sĩ hơn c&oacute; thể được đưa trở lại l&atilde;nh thổ Belarus, nhưng ch&uacute;ng t&ocirc;i kh&ocirc;ng quan s&aacute;t thấy điỞu đ&oacute; v&agrave;o l&uacute;c n&agrave;y\", &ocirc;ng nhấn mạnh.</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>Ngo&agrave;i ra, theo &ocirc;ng Demchenko, lực lượng Bi&ecirc;n ph&ograve;ng Nh&agrave; nước Ukraine ghi nhận ở Belarus c&oacute; sự xuất hiện của bất kỳ nh&oacute;m l&iacute;nh đ&aacute;nh thu&ecirc; n&agrave;o từ c&aacute;c c&ocirc;ng ty&nbsp;<a href=\"https://dantri.com.vn/the-gioi/quan-su.htm\" data-auto-link-id=\"6137992efb044100119a147e\" data-track-content=\"\" data-content-name=\"article-content-autolink\" data-content-piece=\"article-content-autolink_6137992efb044100119a147e\" data-content-target=\"/the-gioi/ukraine-noi-nga-rut-gan-nhu-toan-bo-luc-luong-khoi-belarus-20230714201054632.htm\">qu&acirc;n sự</a>&nbsp;tư nh&acirc;n của Nga.</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>Trước đ&oacute;, &ocirc;ng tr&ugrave;m tổ chức qu&acirc;n sự tư nh&acirc;n Nga Wagner Yevgeny Prigozhin đồng &yacute; chuyển đến Belarus sau cuộc nổi loạn bất th&agrave;nh ở Nga h&ocirc;m 24/6. C&aacute;c th&agrave;nh vi&ecirc;n Wagner cũng c&oacute; thể chuyển đến Belarus hoặc lựa chỞn k&yacute; hợp đồng với Bộ Quốc ph&ograve;ng Nga hoặc trở vỞ với gia đ&igrave;nh.</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>Trả lỞi c&aacute;c ph&oacute;ng vi&ecirc;n h&ocirc;m 6/7, Tổng thống Lukashenko n&oacute;i rằng, Minsk đ&atilde; đỞ nghị cho Wagner sử dụng một số cơ sở đồn tr&uacute;&nbsp;qu&acirc;n sự&nbsp;cũ của nước n&agrave;y từ thỞi Li&ecirc;n X&ocirc;, bao gồm căn cứ ở Osipovichy, c&aacute;ch bi&ecirc;n giới Ukraine khoảng 200km.</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>Theo nh&agrave; l&atilde;nh đạo Belarus, c&aacute;c th&agrave;nh vi&ecirc;n Wagner sẽ được đưa từ Nga sang Belarus với \"những điỞu kiện nhất định\" như sẽ được triển khai ngay lập tức khi cần bảo vệ nước n&agrave;y. Tuy nhi&ecirc;n, &ocirc;ng khẳng định việc chuyển lực lượng Wagner sang Belarus ho&agrave;n to&agrave;n phụ thuộc v&agrave;o Moscow.</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>&Ocirc;ng nhấn mạnh, nếu được triển khai ở quốc gia n&agrave;y, lực lượng Wagner c&oacute; thể được sử dụng để bảo vệ Belarus. Tuần trước, &ocirc;ng Lukashenko cho biết, Wagner sẽ được y&ecirc;u cầu k&yacute; hợp đồng với ch&iacute;nh phủ Belarus, gi&uacute;p b&aacute;c bỞ những lo ngại vỞ một cuộc binh biến Wagner c&oacute; thể xảy ra ở Belarus.</strong></span></p>\r\n</div>\r\n<div class=\"singular-source\" style=\"text-align: center;\"><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>Theo&nbsp;Ukrainska Pravda</strong></span></div>','Quan chức Ukraine nói rằng Nga đã rút gần như toàn bộ lực lượng khỞi lãnh thổ quốc gia đồng minh Belarus.','uploads/dau-hieu-la-tu-bien-gioi-belarus-quan-doi-ukraine-chuan-bi-san-sang-chien-daudocx-1659930482466-1670159041634-1689340106608.webp',18,22,'2023-07-15 12:29:55','2023-08-01 09:05:59',1,'ukraine-noi-nga-rut-gan-nhu-toan-bo-luc-luong-khoi-belarus','2023-08-01 09:05:59'),(9,'Tổng thống Hàn Quốc bất ngỞ thăm Ukraine','<h1 class=\"title-page detail\">Tổng thống H&agrave;n Quốc bất ngỞ thăm Ukraine</h1>\r\n<div class=\"flex-author-collection\">\r\n<div class=\"author-wrap\">\r\n<div class=\"author-avatar\"><a class=\"author-avatar__picture\" href=\"https://dantri.com.vn/tac-gia/duc-hoang-103.htm\"><img src=\"https://icdn.dantri.com.vn/zoom/60_60/2023/06/14/image20230614165249314-edited-1686736434868.jpeg\" srcset=\"https://icdn.dantri.com.vn/zoom/60_60/2023/06/14/image20230614165249314-edited-1686736434868.jpeg 1x, https://icdn.dantri.com.vn/zoom/120_120/2023/06/14/image20230614165249314-edited-1686736434868.jpeg 2x\" alt=\"Ğức Ho&agrave;ng\" width=\"60\" height=\"60\" /></a></div>\r\n<div class=\"author-meta\">\r\n<div class=\"author-name\"><a href=\"https://dantri.com.vn/tac-gia/duc-hoang-103.htm\"><strong>Ğức Ho&agrave;ng</strong></a></div>\r\n<time class=\"author-time\" datetime=\"2023-07-15 19:02\">Thứ bảy, 15/07/2023 - 19:02</time></div>\r\n</div>\r\n</div>\r\n<div data-module=\"article-audio\" data-article-id=\"20230715152334053\">\r\n<div id=\"article-audio\">\r\n<div class=\"EsdXAjX6XO8ox_lsYCzX\">\r\n<div class=\"sLxGvlVmZa19lKpXpvhw\">\r\n<div class=\"_l6TeaFX4mYmSA8Bcjsl\">&nbsp;</div>\r\n<div class=\"VFVqE4b8qZzTByyqkKg1\">\r\n<div class=\"ZLls4v_Q9PZhugaRRiOh\">00:00/01:31</div>\r\n<div class=\"EY7izJEB9CFUy8VdhTDC\">\r\n<div class=\"LsdUEd63bwEMTS9284WR\">&nbsp;</div>\r\n</div>\r\n</div>\r\n<div class=\"qIu870O7sg4Tfu8IkDWj\">\r\n<div class=\"qAW0EIMWqGnYGmi6RtSI\">&nbsp;</div>\r\n<div class=\"m3YBcBKp6luAXPZdUc0e\">Nam miỞn Bắc</div>\r\n<div class=\"Ho5_fNB9aAk0UlxWXYWx\">&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<h2 class=\"singular-sapo\">(D&acirc;n tr&iacute;) - Tổng thống H&agrave;n Quốc Yoon Suk-yeol đến Ukraine trong chuyến thăm kh&ocirc;ng được th&ocirc;ng b&aacute;o rộng r&atilde;i trước đ&oacute;.</h2>\r\n<div class=\"singular-content\">\r\n<figure class=\"image align-center\"><img class=\"entered loaded\" title=\"Tổng thống H&agrave;n Quốc bất ngỞ thăm Ukraine - 1\" src=\"https://icdn.dantri.com.vn/thumb_w/680/2023/07/15/tongthonghanquoc-1672279255257-1686646080665-1689409272512.jpg\" srcset=\"https://icdn.dantri.com.vn/thumb_w/680/2023/07/15/tongthonghanquoc-1672279255257-1686646080665-1689409272512.jpg 1x, https://icdn.dantri.com.vn/thumb_w/1020/2023/07/15/tongthonghanquoc-1672279255257-1686646080665-1689409272512.jpg 1.5x, https://icdn.dantri.com.vn/thumb_w/1360/2023/07/15/tongthonghanquoc-1672279255257-1686646080665-1689409272512.jpg 2x\" alt=\"Tổng thống H&agrave;n Quốc bất ngỞ thăm Ukraine - 1\" data-width=\"680\" data-height=\"453\" data-original=\"https://icdn.dantri.com.vn/2023/07/15/tongthonghanquoc-1672279255257-1686646080665-1689409272512.jpg\" data-photo-id=\"2548745\" data-track-content=\"\" data-content-name=\"article-content-image\" data-content-piece=\"article-content-image_2548745\" data-content-target=\"/the-gioi/tong-thong-han-quoc-bat-ngo-tham-ukraine-20230715152334053.htm\" data-src=\"https://icdn.dantri.com.vn/thumb_w/680/2023/07/15/tongthonghanquoc-1672279255257-1686646080665-1689409272512.jpg\" data-srcset=\"https://icdn.dantri.com.vn/thumb_w/680/2023/07/15/tongthonghanquoc-1672279255257-1686646080665-1689409272512.jpg 1x, https://icdn.dantri.com.vn/thumb_w/1020/2023/07/15/tongthonghanquoc-1672279255257-1686646080665-1689409272512.jpg 1.5x, https://icdn.dantri.com.vn/thumb_w/1360/2023/07/15/tongthonghanquoc-1672279255257-1686646080665-1689409272512.jpg 2x\" data-ll-status=\"loaded\" />\r\n<figcaption>\r\n<p>Tổng thống H&agrave;n Quốc Yoon Suk-yeol (Ảnh: AP).</p>\r\n</figcaption>\r\n</figure>\r\n<p><em>Reuters</em>&nbsp;đưa tin, Văn ph&ograve;ng tổng thống H&agrave;n Quốc ng&agrave;y 15/7 th&ocirc;ng b&aacute;o, &ocirc;ng Yoon đ&atilde; đến thăm Ukraine v&agrave; dự kiến gặp gỡ ngưỞi đồng cấp Volodymyr Zelensky.</p>\r\n<p>Ğ&acirc;y l&agrave; chuyến thăm kh&aacute; bất ngỞ v&igrave; H&agrave;n Quốc kh&ocirc;ng th&ocirc;ng b&aacute;o th&ocirc;ng tin rộng r&atilde;i từ trước. Chuyến thăm diễn ra sau khi &ocirc;ng Yoon dự hội nghị thượng đỉnh NATO ở Lithuania v&agrave;o đầu tuần n&agrave;y v&agrave; &ocirc;ng đ&atilde; thể hiện tinh thần đo&agrave;n kết với Ukraine, cũng như t&igrave;m c&aacute;ch hỗ trợ Kiev trong cuộc chiến k&eacute;o d&agrave;i hơn một năm qua với Nga.</p>\r\n<p>&Ocirc;ng Yoon đ&atilde; thăm c&aacute;c địa điểm ở Ukraine như Bucha hay Irpin.</p>\r\n<p>L&agrave; đồng minh của Mỹ v&agrave; nh&agrave; xuất khẩu quốc ph&ograve;ng mới nổi, H&agrave;n Quốc đang phải đối mặt những lỞi k&ecirc;u gỞi li&ecirc;n quan tới việc cung cấp vũ kh&iacute; cho Ukraine. Cho tới nay, ch&iacute;nh quyỞn &ocirc;ng Yoon chưa viện trợ vũ kh&iacute; cho Ukraine, thay v&agrave;o đ&oacute; l&agrave; hỗ trợ vỞ nh&acirc;n đạo v&agrave; t&agrave;i ch&iacute;nh.</p>\r\n<p>Theo giới quan s&aacute;t đ&acirc;y được xem l&agrave; động th&aacute;i c&oacute; t&iacute;nh thận trỞng do Nga c&oacute; ảnh hưởng với TriỞu Ti&ecirc;n v&agrave; H&agrave;n Quốc kh&ocirc;ng muốn l&agrave;m theo thang căng thẳng với Moscow. &nbsp;</p>\r\n<p>&Ocirc;ng Yoon tuần n&agrave;y cho biết, H&agrave;n Quốc đang chuẩn bị gửi thiết bị r&agrave; ph&aacute; bom m&igrave;n v&agrave; xe cứu thương theo y&ecirc;u cầu từ Ukraine. Seoul cũng sẽ tham gia quỹ ủy th&aacute;c của NATO cho Ukraine.</p>\r\n<p>Trong cuộc gặp đầu ti&ecirc;n hồi th&aacute;ng 5, &ocirc;ng Zelensky đ&atilde; đỞ nghị &ocirc;ng Yoon hỗ trợ&nbsp;<a href=\"https://dantri.com.vn/the-gioi/quan-su.htm\" data-auto-link-id=\"6137992efb044100119a147e\" data-track-content=\"\" data-content-name=\"article-content-autolink\" data-content-piece=\"article-content-autolink_6137992efb044100119a147e\" data-content-target=\"/the-gioi/tong-thong-han-quoc-bat-ngo-tham-ukraine-20230715152334053.htm\">qu&acirc;n sự</a>&nbsp;cho Ukraine.</p>\r\n<p>Trong cuộc gặp Tổng thống Ba Lan Andrzej Duda h&ocirc;m 13/7, &ocirc;ng Yoon b&agrave;y tỞ lo ngại vỞ chiến dịch qu&acirc;n sự của Nga. &Ocirc;ng đồng thỞi cho biết, H&agrave;n Quốc c&oacute; thể trở th&agrave;nh một đối t&aacute;c tốt trong c&ocirc;ng cuộc t&aacute;i thiết Ukraine.</p>\r\n<p>Bộ Ğất đai, Cơ sở hạ tầng v&agrave;&nbsp;<a href=\"https://dantri.com.vn/xa-hoi/giao-thong.htm\" data-auto-link-id=\"614ad62f4a01660018e67e13\" data-track-content=\"\" data-content-name=\"article-content-autolink\" data-content-piece=\"article-content-autolink_614ad62f4a01660018e67e13\" data-content-target=\"/the-gioi/tong-thong-han-quoc-bat-ngo-tham-ukraine-20230715152334053.htm\">Giao th&ocirc;ng</a>&nbsp;H&agrave;n Quốc h&ocirc;m thứ 14/7 cho hay hỞ c&oacute; kế hoạch hỗ trợ t&aacute;i thiết cơ sở hạ tầng của Ukraine, như c&ocirc;ng tr&igrave;nh giao th&ocirc;ng, năng lượng v&agrave; c&ocirc;ng nghiệp.</p>\r\n</div>\r\n<div class=\"singular-source\">Theo&nbsp;<strong>Reuters</strong></div>','Tổng thống Hàn Quốc Yoon Suk-yeol đến Ukraine trong chuyến thăm không được thông báo rộng rãi trước đó.','uploads/tongthonghanquoc-1672279255257-1686646080665-1689409272512.webp',18,22,'2023-07-15 12:31:59','2023-08-01 09:05:54',1,'tong-thong-han-quoc-bat-ngo-tham-ukraine','2023-08-01 09:05:54'),(10,'〞Hướng Dẫn】Cách Làm Cây Xanh Từ Vật Liệu Phế Thải Ğơn Giản Nhất','<header class=\"entry-header\">\r\n<div class=\"entry-header-text entry-header-text-top text-center\">\r\n<h1 class=\"entry-title\" style=\"text-align: center;\">〞Hướng Dẫn】C&aacute;ch L&agrave;m C&acirc;y Xanh Từ Vật Liệu Phế Thải Ğơn Giản Nhất</h1>\r\n<div class=\"entry-divider is-divider small\" style=\"text-align: center;\">&nbsp;</div>\r\n<div class=\"entry-meta uppercase is-xsmall\" style=\"text-align: center;\"><span class=\"posted-on\">POSTED ON&nbsp;<a href=\"https://suaxemaytainha.com/cach-lam-cay-xanh-tu-vat-lieu-phe-thai/\" rel=\"bookmark\"><time class=\"entry-date published updated\" datetime=\"2023-03-09T07:15:28+00:00\">MARCH 9, 2023</time></a></span><span class=\"byline\">&nbsp;BY&nbsp;<span class=\"meta-author vcard\"><a class=\"url fn n\" href=\"https://suaxemaytainha.com/author/phuonganh/\">PHUONG ANH</a></span></span></div>\r\n</div>\r\n<div class=\"entry-image relative\" style=\"text-align: center;\"><a href=\"https://suaxemaytainha.com/cach-lam-cay-xanh-tu-vat-lieu-phe-thai/\"><img class=\"attachment-large size-large wp-post-image lazy-load-active\" src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai.jpg\" sizes=\"(max-width: 512px) 100vw, 512px\" srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai.jpg 512w, https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai-300x169.jpg 300w\" alt=\"\" width=\"512\" height=\"288\" data-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai.jpg\" data-srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai.jpg 512w, https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai-300x169.jpg 300w\" /></a>\r\n<div class=\"badge absolute top post-date badge-outline\">\r\n<div class=\"badge-inner\">&nbsp;</div>\r\n</div>\r\n</div>\r\n</header>\r\n<div class=\"entry-content single-page\">\r\n<p style=\"text-align: center;\">Mỗi ng&agrave;y, h&agrave;ng tấn phế thải thải ra m&ocirc;i trưỞng v&agrave; đ&ograve;i hỞi ch&uacute;ng ta cần c&oacute; biện ph&aacute;p t&aacute;i chế hợp l&yacute; để giảm thiệu lượng r&aacute;c thải n&agrave;y. H&agrave;nh động bảo vệ v&agrave; l&agrave;m trong sạch m&ocirc;i trưỞng đang l&agrave; xu hướng hiện nay. C&oacute; rất nhiỞu c&aacute;ch để thể hiện sự t&ocirc;n trỞng với m&ocirc;i trưỞng, một trong số đ&oacute; vừa hữu &iacute;ch, dễ l&agrave;m lại mang t&iacute;nh thẩm mỹ cao đ&oacute; l&agrave; c&aacute;ch l&agrave;m c&acirc;y xanh từ vật liệu phế thải . H&atilde;y c&ugrave;ng t&igrave;m hiểu ngay&nbsp;<strong>c&aacute;ch l&agrave;m c&acirc;y xanh từ vật liệu phế thải</strong> trong b&agrave;i viết n&agrave;y nh&eacute;.</p>\r\n<h2 style=\"text-align: center;\"><span id=\"Huong_dan_cach_lam_cay_xanh_tu_vat_lieu_phe_thai\" class=\"ez-toc-section\"></span>Hướng dẫn c&aacute;ch l&agrave;m c&acirc;y xanh từ vật liệu phế thải</h2>\r\n<h3 style=\"text-align: center;\"><span id=\"Cach_lam_cay_xanh_bang_bia_cung\" class=\"ez-toc-section\"></span>C&aacute;ch l&agrave;m c&acirc;y xanh bằng b&igrave;a cứng</h3>\r\n<p style=\"text-align: center;\"><strong>Vật liệu:&nbsp;</strong>B&igrave;a cứng, nỉ xanh, b&uacute;t m&agrave;u, k&eacute;o.</p>\r\n<p style=\"text-align: center;\"><strong>C&aacute;ch l&agrave;m:</strong></p>\r\n<ul style=\"text-align: center;\">\r\n<li>Bước 1: Trải phẳng tấm b&igrave;a cứng c&oacute; k&iacute;ch thước tương đối tr&ecirc;n mặt b&agrave;n. Tiến h&agrave;nh ph&aacute;c hỞa th&acirc;n v&agrave; c&agrave;nh ch&iacute;nh của c&acirc;y. Sau đ&oacute; d&ugrave;ng k&eacute;o cắt theo đưỞng vẽ v&agrave; cắt bỞ phần thừa. Vẽ th&ecirc;m c&aacute;c c&agrave;nh nhỞ cho c&acirc;y tr&ecirc;n miếng b&igrave;a cứng rồi cắt ra v&agrave; d&aacute;n c&aacute;c c&agrave;nh ch&iacute;nh lại với nhau.</li>\r\n<li>Bước 2: Qu&eacute;t 1 m&agrave;u duy nhất ph&ugrave; hợp với m&agrave;u của th&acirc;n v&agrave; c&agrave;nh, m&agrave;u thưỞng d&ugrave;ng l&agrave; đen, n&acirc;u. D&ugrave;ng keo d&aacute;n l&aacute; v&agrave;o c&aacute;c vị tr&iacute; tr&ecirc;n c&agrave;nh. Bạn c&oacute; thể l&agrave;m một c&aacute;i c&acirc;y theo m&ocirc; h&igrave;nh lớn hơn để che một g&oacute;c của trưỞng mẫu gi&aacute;o</li>\r\n<li>Bước 3: Cuộn tr&ograve;n giấy bạc l&agrave;m th&acirc;n c&acirc;y rồi d&ugrave;ng keo d&aacute;n cố định l&ecirc;n nắp hộp để tạo trụ gi&uacute;p c&acirc;y đứng vững.</li>\r\n</ul>\r\n<div style=\"text-align: center;\">\r\n<p><img class=\"lazy-load-active\" src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/maxresdefault.jpg\" alt=\"C&aacute;ch l&agrave;m M&ocirc; h&igrave;nh c&acirc;y 3D - lớp 6 ; 3 Ng&ocirc;i nh&agrave; tương lai - C&acirc;y trong vưỞn - YouTube\" data-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/maxresdefault.jpg\" data-cke-saved-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/maxresdefault.jpg\" /></p>\r\n</div>\r\n<h3 style=\"text-align: center;\"><span id=\"Cach_lam_cay_dua_tu_chai_nhua\" class=\"ez-toc-section\"></span>C&aacute;ch l&agrave;m c&acirc;y dừa từ chai nhựa</h3>\r\n<p style=\"text-align: center;\">Ğể l&agrave;m c&acirc;y dừa non từ vật liệu phế thải, bạn cần chuẩn bị: chai nhựa đ&atilde; qua sử dụng (chai 1,5 l&iacute;t hoặc chai 350ml đỞu được), sơn, k&eacute;o, dao rỞc giấy, th&eacute;p, giấy trắng, băng keo m&agrave;u, đ&aacute; nhỞ.</p>\r\n<p style=\"text-align: center;\"><img class=\"lazy-load-active\" src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai.jpg\" alt=\"C&aacute;ch l&agrave;m c&acirc;y xanh từ phế liệu g&oacute;p phần bảo vệ m&ocirc;i trưỞng\" data-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai.jpg\" data-cke-saved-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai.jpg\" /></p>\r\n<p style=\"text-align: center;\"><strong>C&aacute;ch l&agrave;m c&acirc;y xanh từ phế liệu</strong></p>\r\n<ul style=\"text-align: center;\">\r\n<li>Bước 1: Chai nhựa rửa sạch, d&ugrave;ng dao rỞc giấy cắt chai nhựa th&agrave;nh 3 phần.</li>\r\n<li>Bước 2: Lấy phần giữa của chai nhựa v&agrave; d&ugrave;ng k&eacute;o tỉa th&agrave;nh l&aacute; dừa. Mỗi l&aacute; c&oacute; chiỞu d&agrave;i tấm từ 15-30cm t&ugrave;y sở th&iacute;ch.</li>\r\n<li>Bước 3: Sau khi cắt xong, d&ugrave;ng que th&eacute;p (d&acirc;y ch&igrave;) gập đ&ocirc;i lại rồi d&ugrave;ng giấy trắng quấn quanh que th&eacute;p để tạo th&agrave;nh th&acirc;n c&acirc;y.</li>\r\n<li>Bước 4: Nối c&aacute;c l&aacute; dừa đ&atilde; cắt v&agrave;o th&acirc;n c&acirc;y, d&ugrave;ng băng d&iacute;nh m&agrave;u cố định lại rồi d&aacute;n keo to&agrave;n bộ th&acirc;n c&acirc;y. Sử dụng băng m&agrave;u n&acirc;u c&agrave;ng nhiỞu c&agrave;ng tốt hoặc sử dụng c&aacute;c m&agrave;u kh&aacute;c để s&aacute;ng tạo.</li>\r\n<li>Bước 5: D&ugrave;ng giấy để vo tr&ograve;n tạo th&agrave;nh những tr&aacute;i dừa, vẽ t&ecirc;n m&agrave;u theo &yacute; th&iacute;ch. Sau đ&oacute; d&ugrave;ng keo d&aacute;n v&agrave;o th&acirc;n c&acirc;y.</li>\r\n<li>Bước 6: Gh&eacute;p những vi&ecirc;n đ&aacute; nhỞ dưới th&acirc;n c&acirc;y để tạo th&agrave;nh trụ gi&uacute;p c&acirc;y đứng vững v&agrave; đẹp hơn.</li>\r\n</ul>\r\n<p style=\"text-align: center;\">Bạn c&oacute; thể d&ugrave;ng chậu c&acirc;y đ&oacute; để trang tr&iacute; ở những g&oacute;c m&igrave;nh muốn như ở b&agrave;n l&agrave;m việc, tủ s&aacute;ch nơi bạn y&ecirc;u th&iacute;ch, vừa tăng t&iacute;nh thẩm mỹ cho căn ph&ograve;ng, vừa kịp thỞi xử l&yacute; chai nhựa m&agrave; kh&ocirc;ng g&acirc;y &ocirc; nhiễm m&ocirc;i trưỞng. Hoặc nếu bạn c&oacute; con nhỞ, h&atilde;y c&ugrave;ng ch&uacute;ng tạo ra những c&acirc;y dừa nhỞ xinh để trang tr&iacute; nh&agrave; cửa, tăng khả năng s&aacute;ng tạo v&agrave; n&acirc;ng cao &yacute; thức bảo vệ m&ocirc;i trưỞng, giảm thiểu r&aacute;c thải.</p>\r\n<h3 style=\"text-align: center;\"><span id=\"Cach_lam_chau_hoa_con_ong_tu_vat_lieu_phe_thai\" class=\"ez-toc-section\"></span>C&aacute;ch l&agrave;m chậu hoa con ong từ vật liệu phế thải</h3>\r\n<p style=\"text-align: center;\">Ngo&agrave;i d&ugrave;ng phế thải để l&agrave;m m&ocirc; h&igrave;nh c&acirc;y xanh, bạn cũng c&oacute; thể d&ugrave;ng những chai lỞ rỗng để l&agrave;m những b&igrave;nh hoa sặc sỡ v&agrave; đẹp mắt cho khu vưỞn của m&igrave;nh.</p>\r\n<p style=\"text-align: center;\">Những nguy&ecirc;n liệu cần chuẩn bị để l&agrave;m chậu hoa l&agrave; sơn, cỞ vẽ, chai nhựa, dao rỞc giấy, keo d&aacute;n. Chai nhựa bỞ đi hiện được t&aacute;i sử dụng hiệu quả.</p>\r\n<p style=\"text-align: center;\"><img class=\"lazy-load-active\" src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai-1.jpg\" alt=\"C&aacute;ch l&agrave;m c&acirc;y xanh từ phế liệu g&oacute;p phần bảo vệ m&ocirc;i trưỞng\" data-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai-1.jpg\" data-cke-saved-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-cay-xanh-tu-vat-lieu-phe-thai-1.jpg\" /></p>\r\n<p style=\"text-align: center;\"><strong>C&aacute;ch l&agrave;m chậu hoa con ong từ vật liệu phế thải</strong></p>\r\n<ul style=\"text-align: center;\">\r\n<li>Bước 1: Vệ sinh sạch sẽ chai nhựa v&agrave; để nơi kh&ocirc; r&aacute;o.</li>\r\n<li>Bước 2: D&ugrave;ng k&eacute;o cắt th&agrave;nh hai phần nhưng chỉ lấy phần ở miệng chai l&agrave;m th&acirc;n. Phần c&ograve;n lại cắt th&agrave;nh c&aacute;nh ong.</li>\r\n<li>Bước 3: D&ugrave;ng m&agrave;u vẽ l&ecirc;n c&aacute;nh v&agrave; th&acirc;n. Bạn c&oacute; thể chỞn m&agrave;u t&ugrave;y th&iacute;ch hoặc xen kẽ m&agrave;u v&agrave;ng v&agrave; n&acirc;u.</li>\r\n<li>Bước 4: Lấy keo cố định c&aacute;nh đ&atilde; chuẩn bị sẵn v&agrave;o th&acirc;n ong sau khi m&agrave;u đ&atilde; kh&ocirc;.</li>\r\n</ul>\r\n<p style=\"text-align: center;\">Trồng nhiỞu c&acirc;y xanh, đặc biệt l&agrave; t&aacute;i chế chai nhựa cũ để l&agrave;m chậu hoa sẽ cải thiện m&ocirc;i trưỞng rất nhiỞu, m&ocirc;i trưỞng sẽ trở n&ecirc;n xanh, sạch, đẹp.</p>\r\n<h3 style=\"text-align: center;\"><span id=\"Cach_lam_chau_hoa_tu_can_nhua\" class=\"ez-toc-section\"></span>C&aacute;ch l&agrave;m chậu hoa từ can nhựa</h3>\r\n<div style=\"text-align: center;\">\r\n<ul>\r\n<li>Ğầu ti&ecirc;n, bạn cắt đ&ocirc;i chiếc chai, c&oacute; thể tỉa bớt để tạo th&agrave;nh những đưỞng lượn s&oacute;ng bắt mắt. Tiếp theo, bạn d&ugrave;ng một chiếc đĩa CD cũ d&aacute;n v&agrave;o miệng chai. T&aacute;c dụng của miếng đĩa CD l&agrave; giữ thăng bằng cho phần b&igrave;nh nước.</li>\r\n<li>Tiếp theo, bạn d&ugrave;ng sơn xịt để trang tr&iacute; cho chậu hoa th&ecirc;m đẹp, v&igrave; m&agrave;u sắc ban đầu của chai nước sẽ kh&ocirc;ng đẹp khi bạn cho đất v&agrave; c&acirc;y v&agrave;o.</li>\r\n<li>C&aacute;ch l&agrave;m chậu hoa bằng chai nhựa n&agrave;y sẽ tạo sự sang trỞng v&agrave; bắt mắt. bắt những chiếc cốc c&oacute; thể trồng c&acirc;y nhỞ v&agrave; đặt tr&ecirc;n b&agrave;n l&agrave;m việc.</li>\r\n</ul>\r\n</div>\r\n<div style=\"text-align: center;\">\r\n<p><img class=\"alignnone wp-image-3022 size-full lazy-load-active\" src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-ly-nuoc.jpg\" sizes=\"(max-width: 700px) 100vw, 700px\" srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-ly-nuoc.jpg 700w, https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-ly-nuoc-247x300.jpg 247w\" alt=\"\" width=\"700\" height=\"851\" data-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-ly-nuoc.jpg\" data-srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-ly-nuoc.jpg 700w, https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-ly-nuoc-247x300.jpg 247w\" /></p>\r\n</div>\r\n<h3 style=\"text-align: center;\"><span id=\"Tai_che_chai_nhua_thanh_chau_hoa_hinh_thu\" class=\"ez-toc-section\"></span>T&aacute;i chế chai nhựa th&agrave;nh chậu hoa h&igrave;nh th&uacute;</h3>\r\n<div style=\"text-align: center;\">\r\n<p>Nếu như phần tr&ecirc;n của chai c&oacute; thể t&aacute;i chế th&agrave;nh những chậu thủy tinh h&igrave;nh con vật sang trỞng th&igrave; nửa dưới của chai c&oacute; thể được &ldquo;h&ocirc; biến&rdquo; th&agrave;nh những chậu c&acirc;y h&igrave;nh động vật xinh xắn.</p>\r\n<p>C&aacute;ch t&aacute;i chế chai nhựa th&agrave;nh chậu hoa rất đơn giản:</p>\r\n<ul>\r\n<li>Ğầu ti&ecirc;n, bạn tỉa bớt phần th&acirc;n tr&ecirc;n một ch&uacute;t để tạo th&agrave;nh 2 tai th&uacute;, sau đ&oacute; d&ugrave;ng sơn xịt để t&ocirc; m&agrave;u cho &ldquo;qu&aacute;i th&uacute;&rdquo;. Cuối c&ugrave;ng, d&ugrave;ng s&uacute;ng bắn keo d&aacute;n th&ecirc;m mắt v&agrave; mũi.</li>\r\n<li>D&ugrave;ng b&agrave;n l&agrave; đục v&agrave;i lỗ dưới đ&aacute;y chậu hoa để tho&aacute;t nước. Tại thỞi điểm n&agrave;y, chậu đ&atilde; sẵn s&agrave;ng để trồng đất v&agrave; c&acirc;y cảnh.</li>\r\n<li>Ğối với chậu hoa mini từ b&igrave;nh nước 1,5 l&iacute;t, bạn chỉ n&ecirc;n trồng những loại c&acirc;y mỞc thấp, t&aacute;n rộng để tạo sự h&agrave;i h&ograve;a cho tổng thể chậu. C&aacute;ch l&agrave;m chậu c&acirc;y từ chai nhựa đơn giản v&agrave; dễ l&agrave;m n&agrave;y sẽ gi&uacute;p bạn tiết kiệm thỞi gian .</li>\r\n</ul>\r\n</div>\r\n<div style=\"text-align: center;\">\r\n<p><img class=\"alignnone size-full wp-image-3023 lazy-load-active\" src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-thu-hoac-chau-cay.jpg\" sizes=\"(max-width: 720px) 100vw, 720px\" srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-thu-hoac-chau-cay.jpg 720w, https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-thu-hoac-chau-cay-300x200.jpg 300w\" alt=\"\" width=\"720\" height=\"480\" data-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-thu-hoac-chau-cay.jpg\" data-srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-thu-hoac-chau-cay.jpg 720w, https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-hoa-hinh-thu-hoac-chau-cay-300x200.jpg 300w\" /></p>\r\n</div>\r\n<h3 style=\"text-align: center;\"><span id=\"Tai_che_chai_nhua_thanh_chau_trong_cay_hinh_coc_doc_dao\" class=\"ez-toc-section\"></span>T&aacute;i chế chai nhựa th&agrave;nh chậu trồng c&acirc;y h&igrave;nh cốc độc đ&aacute;o</h3>\r\n<div style=\"text-align: center;\">\r\n<p>Tương tự như c&aacute;ch t&aacute;i chế tr&ecirc;n nhưng bạn c&oacute; thể biến h&oacute;a nhiỞu h&igrave;nh dạng của chiếc ly. Tuy nhi&ecirc;n, lần n&agrave;y bạn sẽ thay đế cốc bằng đế chai nhựa. Tận dụng tối đa những g&igrave; chai nhựa c&oacute; v&agrave; n&ecirc;n chỞn những loại chai c&oacute; đế d&agrave;y như coca 1.5 l&iacute;t,&hellip;</p>\r\n<p>Ğ&acirc;y l&agrave; c&aacute;ch thực hiện:</p>\r\n<ul>\r\n<li>Ğầu ti&ecirc;n, bạn cắt phần giao giữa đưỞng cong v&agrave; đưỞng thẳng của th&acirc;n chai, lấy phần tr&ecirc;n.</li>\r\n<li>Tiếp theo, bạn cắt bỞ phần đ&aacute;y chai, rồi d&ugrave;ng k&eacute;o cắt phần nh&ocirc; ra th&agrave;nh h&igrave;nh tam gi&aacute;c. Ğể hiểu r&otilde; hơn, h&atilde;y xem h&igrave;nh ảnh b&ecirc;n dưới.</li>\r\n<li>Ğục một lỗ dưới đ&aacute;y vừa miệng chai nước.</li>\r\n<li>Lấy phần tr&ecirc;n gắn v&agrave;o lỗ đ&atilde; đục ở đ&aacute;y chai, sau đ&oacute; d&ugrave;ng keo d&aacute;n cố định lại.</li>\r\n<li>Tiếp theo, trang tr&iacute; theo sở th&iacute;ch của bạn l&agrave; xong.</li>\r\n</ul>\r\n</div>\r\n<div style=\"text-align: center;\">\r\n<p>D&ugrave;ng đ&aacute;y chai l&agrave;m đế cũng l&agrave; một c&aacute;ch hay khi bạn muốn tạo c&aacute;c h&igrave;nh th&ugrave; kh&aacute;c nhau.</p>\r\n</div>\r\n<div>\r\n<p style=\"text-align: center;\"><img class=\"alignnone size-full wp-image-3024 lazy-load-active\" src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-trong-cay-hinh-ly-nuoc-cuc-doc-dao.jpg\" sizes=\"(max-width: 720px) 100vw, 720px\" srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-trong-cay-hinh-ly-nuoc-cuc-doc-dao.jpg 720w, https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-trong-cay-hinh-ly-nuoc-cuc-doc-dao-300x169.jpg 300w\" alt=\"\" width=\"720\" height=\"405\" data-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-trong-cay-hinh-ly-nuoc-cuc-doc-dao.jpg\" data-srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-trong-cay-hinh-ly-nuoc-cuc-doc-dao.jpg 720w, https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-thanh-chau-trong-cay-hinh-ly-nuoc-cuc-doc-dao-300x169.jpg 300w\" /></p>\r\n<h3 style=\"text-align: center;\"><span id=\"Cach_tai_che_chai_nhua_5_lit_thanh_chau_hoa_don_gian\" class=\"ez-toc-section\"></span>C&aacute;ch t&aacute;i chế chai nhựa 5 l&iacute;t th&agrave;nh chậu hoa đơn giản</h3>\r\n<div style=\"text-align: center;\">\r\n<p>B&ecirc;n cạnh những c&aacute;ch l&agrave;m chậu hoa bằng chai nhựa tr&ecirc;n, bạn c&oacute; thể t&aacute;i chế chai nhựa để trồng c&acirc;y, trồng rau sạch ngay tại nh&agrave;.</p>\r\n<ul>\r\n<li>Ğể l&agrave;m chậu trồng rau, bạn chỉ cần cắt một h&igrave;nh chữ nhật lớn dỞc theo th&acirc;n chai, sau đ&oacute; đục lỗ tho&aacute;t nước xung quanh chai nhựa v&agrave; th&ecirc;m đất v&agrave;o.</li>\r\n<li>Tiếp theo, bạn chỉ cần hỞc c&aacute;ch trồng rau sạch tại nh&agrave; v&agrave; gieo hạt chỞ ng&agrave;y thu hoạch. L&agrave;m chậu hoa từ chai nhựa thật đơn giản phải kh&ocirc;ng n&agrave;o!</li>\r\n</ul>\r\n<p>C&aacute;ch t&aacute;i chế chai nhựa th&agrave;nh chậu hoa cực đơn giản v&agrave; dễ l&agrave;m n&ecirc;n thử ngay</p>\r\n<p><img class=\"alignnone size-full wp-image-3025 lazy-load-active\" src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-5-lit-thanh-chau-hoa.jpg\" sizes=\"(max-width: 719px) 100vw, 719px\" srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-5-lit-thanh-chau-hoa.jpg 719w, https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-5-lit-thanh-chau-hoa-300x199.jpg 300w\" alt=\"\" width=\"719\" height=\"478\" data-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-5-lit-thanh-chau-hoa.jpg\" data-srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-5-lit-thanh-chau-hoa.jpg 719w, https://suaxemaytainha.com/wp-content/uploads/2023/03/tai-che-chai-nhua-5-lit-thanh-chau-hoa-300x199.jpg 300w\" /></p>\r\n</div>\r\n<h3 style=\"text-align: center;\"><span id=\"Cach_lam_chau_hoa_tu_can_nhua_2_tang_cuc_doc_dao\" class=\"ez-toc-section\"></span>C&aacute;ch l&agrave;m chậu hoa từ can nhựa 2 tầng cực độc đ&aacute;o</h3>\r\n<div style=\"text-align: center;\">\r\n<p>Bạn c&oacute; thể kiếm được một chiếc can nhựa từ lon nước rửa ch&eacute;n, nước lau s&agrave;n&hellip; v&agrave; tuyệt hơn nữa l&agrave; c&oacute; tay cầm. C&aacute;ch thực hiện chỉ v&agrave;i bước đơn giản như sau:</p>\r\n<ul>\r\n<li>Ğầu ti&ecirc;n, bạn d&ugrave;ng dao cắt đ&ocirc;i chiếc can nhựa theo chiỞu ngang v&agrave; kh&ocirc;ng n&ecirc;n cắt đứt hẳn.</li>\r\n<li>Tiếp theo, giữ cho can nhựa thẳng đứng rồi cắt theo chiỞu dỞc để cắt rỞi phần đầu ra, nhưng kh&ocirc;ng cắt rỞi phần quai.</li>\r\n<li>D&ugrave;ng tay k&eacute;o phần quai lon l&ecirc;n cao v&agrave; d&ugrave;ng dao cắt bỞ phần nối c&aacute;ch miệng lon 5 cm.</li>\r\n<li>Ğể ngược phần đầu v&agrave; d&ugrave;ng keo d&aacute;n phần tay cầm lại. Bạn c&oacute; thể xem h&igrave;nh b&ecirc;n dưới để dễ thực hiện hơn.</li>\r\n</ul>\r\n<p>Can nhựa c&oacute; thể l&agrave;m chậu hoa nhựa hai tầng cực lạ mắt v&agrave; độc đ&aacute;o</p>\r\n<p><img class=\"alignnone size-full wp-image-3026 lazy-load-active\" src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-chau-hoa-tu-can-nhua-cuc-doc-dao.jpg\" sizes=\"(max-width: 720px) 100vw, 720px\" srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-chau-hoa-tu-can-nhua-cuc-doc-dao.jpg 720w, https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-chau-hoa-tu-can-nhua-cuc-doc-dao-300x169.jpg 300w\" alt=\"\" width=\"720\" height=\"405\" data-src=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-chau-hoa-tu-can-nhua-cuc-doc-dao.jpg\" data-srcset=\"https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-chau-hoa-tu-can-nhua-cuc-doc-dao.jpg 720w, https://suaxemaytainha.com/wp-content/uploads/2023/03/cach-lam-chau-hoa-tu-can-nhua-cuc-doc-dao-300x169.jpg 300w\" /></p>\r\n</div>\r\n<h2 style=\"text-align: center;\"><span id=\"Luu_y_cach_tai_che_chai_nhua_thanh_chau_hoa\" class=\"ez-toc-section\"></span>Lưu &yacute; c&aacute;ch t&aacute;i chế chai nhựa th&agrave;nh chậu hoa</h2>\r\n<h3 style=\"text-align: center;\"><span id=\"Xu_ly_vet_ban_tren_chai_nhua_da_qua_su_dung\" class=\"ez-toc-section\"></span>Xử l&yacute; vết bẩn tr&ecirc;n chai nhựa đ&atilde; qua sử dụng</h3>\r\n<div style=\"text-align: center;\">\r\n<p>Ğể l&agrave;m chậu hoa từ chai nhựa, chai nhựa sau khi sử dụng sẽ c&oacute; nước ngỞt hoặc dầu mỡ đỞng lại n&ecirc;n bạn nhớ rửa sạch v&agrave; để kh&ocirc; ho&agrave;n to&agrave;n trước nh&eacute;. V&igrave; vậy, muốn thực hiện &yacute; tưởng&nbsp;Ğể l&agrave;m chậu hoa bằng chai nhựa , bạn h&atilde;y đặc biệt lưu &yacute; vấn đỞ n&agrave;y.</p>\r\n</div>\r\n<div style=\"text-align: center;\">\r\n<p>Rửa sạch chai nhựa để loại bỞ nước giải kh&aacute;t hoặc dầu mỡ, vi khuẩn b&aacute;m b&ecirc;n trong trước khi bắt đầu t&aacute;i chế</p>\r\n</div>\r\n<h3 style=\"text-align: center;\"><span id=\"Tan_dung_moi_thu_tu_chai_nhua\" class=\"ez-toc-section\"></span>Tận dụng mỞi thứ từ chai nhựa</h3>\r\n<div style=\"text-align: center;\">\r\n<p>Ğể tr&aacute;nh thải nhựa ra m&ocirc;i trưỞng, bạn n&ecirc;n tận dụng tối đa những g&igrave; m&agrave; chai nhựa c&oacute;. V&iacute; dụ, nếu phải cắt chai nhựa th&agrave;nh hai phần, bạn n&ecirc;n cắt cẩn thận v&agrave; đỞu tay để kh&ocirc;ng tạo ra c&aacute;c vụn nhựa. Hoặc nếu kh&ocirc;ng cần đến n&uacute;t chai nhựa, bạn c&oacute; thể thu gom ch&uacute;ng để t&aacute;i chế chai nhựa hoặc t&aacute;i sử dụng trong trưỞng hợp cần thiết.</p>\r\n</div>\r\n<div style=\"text-align: center;\">\r\n<p>MỞi thứ vỞ chai nhựa đỞu c&oacute; thể t&aacute;i chế, v&igrave; vậy h&atilde;y sử dụng n&oacute; để k&iacute;ch th&iacute;ch khả năng s&aacute;ng tạo của bạn</p>\r\n</div>\r\n<h3 style=\"text-align: center;\"><span id=\"Tranh_bao_quan_chai_nhua_o_noi_nong_am\" class=\"ez-toc-section\"></span>Tr&aacute;nh bảo quản chai nhựa ở nơi n&oacute;ng ẩm</h3>\r\n<div>\r\n<p style=\"text-align: center;\">Chai nhựa sau khi được rửa sạch v&agrave; lau kh&ocirc; ho&agrave;n to&agrave;n sẽ kh&ocirc;ng c&ograve;n trong v&agrave; nhựa sẽ mỞm hơn ban đầu. V&igrave; vậy, để chai nhựa kh&ocirc;ng bị mỞm khi t&aacute;i chế, bạn n&ecirc;n tr&aacute;nh để ch&uacute;ng trong m&ocirc;i trưỞng n&oacute;ng ẩm để kh&ocirc;ng l&agrave;m giảm tuổi thỞ v&agrave; sử dụng l&acirc;u d&agrave;i.</p>\r\n</div>\r\n</div>\r\n</div>','Mỗi ngày, hàng tấn phế thải thải ra môi trưỞng và đòi hỞi chúng ta cần có biện pháp tái chế hợp lý để giảm thiệu lượng rác thải này. Hành động bảo vệ và làm trong sạch môi trưỞng đang là xu hướng hiện nay. Có rất nhiỞu cách để thể hiện sự tôn trỞng với môi trưỞng, một trong số đó vừa hữu ích, dễ làm lại mang tính thẩm mỹ cao đó là cách làm cây xanh từ vật liệu phế thải . Hãy cùng tìm hiểu ngay cách làm cây xanh từ vật liệu phế thải trong bài viết này nhé.','uploads/blog1.jpg',19,22,'2023-07-26 10:34:12','2023-07-26 10:34:12',1,'〞huong-dan】cach-lam-cay-xanh-tu-vat-lieu-phe-thai-don-gian-nhat',NULL),(11,'TruyỞn thông quốc tế đặc biệt quan tâm chuyến thăm Việt Nam của bà Harris','<h1 class=\"title-page detail\"><span style=\"font-family: \'comic sans ms\', sans-serif;\">TruyỞn th&ocirc;ng quốc tế đặc biệt quan t&acirc;m chuyến thăm Việt Nam của b&agrave; Harris</span></h1>\r\n<div data-module=\"article-audio\" data-article-id=\"20210826221703796\">\r\n<div id=\"article-audio\">\r\n<div class=\"EsdXAjX6XO8ox_lsYCzX\">\r\n<div class=\"sLxGvlVmZa19lKpXpvhw\">\r\n<div class=\"qIu870O7sg4Tfu8IkDWj\">\r\n<div class=\"Ho5_fNB9aAk0UlxWXYWx\">&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<h2 class=\"singular-sapo\"><span style=\"font-family: \'comic sans ms\', sans-serif;\">(D&acirc;n tr&iacute;) - Chuyến thăm của b&agrave; Kamala Harris, đ&aacute;nh dấu lần đầu ti&ecirc;n một ph&oacute; tổng thống Mỹ thăm Việt Nam, diễn ra trong bối cảnh quan hệ song phương tiếp tục ph&aacute;t triển t&iacute;ch cực, n&ecirc;n được dư luận quốc tế quan t&acirc;m.</span></h2>\r\n<div class=\"singular-content\">\r\n<figure class=\"image align-center\"><img class=\"entered loaded\" title=\"TruyỞn th&ocirc;ng quốc tế đặc biệt quan t&acirc;m chuyến thăm Việt Nam của b&agrave; Harris - 1\" src=\"https://icdn.dantri.com.vn/thumb_w/660/2021/08/26/hop-bao-ptt-my-7-1629967640745.jpg\" srcset=\"https://icdn.dantri.com.vn/thumb_w/660/2021/08/26/hop-bao-ptt-my-7-1629967640745.jpg 1x, https://icdn.dantri.com.vn/thumb_w/990/2021/08/26/hop-bao-ptt-my-7-1629967640745.jpg 1.5x, https://icdn.dantri.com.vn/thumb_w/1320/2021/08/26/hop-bao-ptt-my-7-1629967640745.jpg 2x\" alt=\"TruyỞn th&ocirc;ng quốc tế đặc biệt quan t&acirc;m chuyến thăm Việt Nam của b&agrave; Harris - 1\" data-width=\"2048\" data-height=\"1365\" data-original=\"https://icdn.dantri.com.vn/2021/08/26/hop-bao-ptt-my-7-1629967640745.jpg\" data-photo-id=\"1566580\" data-track-content=\"\" data-content-name=\"article-content-image\" data-content-piece=\"article-content-image_1566580\" data-content-target=\"/the-gioi/truyen-thong-quoc-te-dac-biet-quan-tam-chuyen-tham-viet-nam-cua-ba-harris-20210826221703796.htm\" data-src=\"https://icdn.dantri.com.vn/thumb_w/660/2021/08/26/hop-bao-ptt-my-7-1629967640745.jpg\" data-srcset=\"https://icdn.dantri.com.vn/thumb_w/660/2021/08/26/hop-bao-ptt-my-7-1629967640745.jpg 1x, https://icdn.dantri.com.vn/thumb_w/990/2021/08/26/hop-bao-ptt-my-7-1629967640745.jpg 1.5x, https://icdn.dantri.com.vn/thumb_w/1320/2021/08/26/hop-bao-ptt-my-7-1629967640745.jpg 2x\" data-ll-status=\"loaded\" />\r\n<figcaption>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">Ph&oacute; Tổng thống Mỹ Kamala Harris trong cuộc hỞp b&aacute;o chiỞu 26/8 tại H&agrave; Nội (Ảnh: Tiến Tuấn).</span></p>\r\n</figcaption>\r\n</figure>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">C&aacute;c h&atilde;ng truyỞn th&ocirc;ng lớn tr&ecirc;n thế giới trong những ng&agrave;y qua đỞu đăng tải th&ocirc;ng&nbsp;<a href=\"https://dantri.com.vn/\" data-auto-link-id=\"5fd33a0a5333a60018f3a1e4\" data-track-content=\"\" data-content-name=\"article-content-autolink\" data-content-piece=\"article-content-autolink_5fd33a0a5333a60018f3a1e4\" data-content-target=\"/the-gioi/truyen-thong-quoc-te-dac-biet-quan-tam-chuyen-tham-viet-nam-cua-ba-harris-20210826221703796.htm\">tin nhanh</a>&nbsp;nhất vỞ chuyến c&ocirc;ng du đến Việt Nam của Ph&oacute; Tổng thống Mỹ Kamala Harris, trong đ&oacute; đặc biệt quan t&acirc;m tới c&aacute;c chủ đỞ ứng ph&oacute; với đại dịch, quan hệ thương mại, vấn đỞ an ninh khu vực&hellip;</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">Trong c&aacute;c b&agrave;i viết mới nhất, hầu hết c&aacute;c tỞ b&aacute;o lớn như&nbsp;<em>AFP, New York Times, Washington Post</em>&nbsp;hay&nbsp;<em>Reuters&nbsp;</em>đỞu nhận định rằng, chuyến thăm n&agrave;y r&otilde; r&agrave;ng cho thấy cam kết chặt chẽ của Washington vỞ kinh tế v&agrave; cả an ninh với khu vực Ğ&ocirc;ng Nam &Aacute;, đồng thỞi th&uacute;c đẩy mục ti&ecirc;u Washington vỞ một khu vực Ấn Ğộ - Th&aacute;i B&igrave;nh Dương tự do v&agrave; rộng mở.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>T&aacute;i khẳng định cam kết của Mỹ</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">Với tựa đỞ: \"B&agrave; Harris kết th&uacute;c chuyến c&ocirc;ng du tốt đẹp ở ch&acirc;u &Aacute;\", h&atilde;ng tin Ph&aacute;p&nbsp;<em>AFP</em>&nbsp;nhấn mạnh vỞ cam kết của Mỹ đối với khu vực bằng việc mở Văn ph&ograve;ng Trung t&acirc;m Ph&ograve;ng ngừa v&agrave; Kiểm so&aacute;t Dịch bệnh Mỹ (CDC) khu vực Ğ&ocirc;ng Nam &Aacute; tại H&agrave; Nội v&agrave; tặng một triệu liỞu vắc xin Covid-19 cho Việt Nam.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">B&aacute;o&nbsp;<em>New York Times</em>&nbsp;của Mỹ cho rằng, chuyến c&ocirc;ng du Ğ&ocirc;ng Nam &Aacute;, trong đ&oacute; c&oacute; Việt Nam của Ph&oacute; Tổng thống Harris, được cho l&agrave; đ&oacute;ng vai tr&ograve; quan trỞng trong nỗ lực t&aacute;i khẳng định cam kết của Mỹ đối với c&aacute;c đồng minh v&agrave; đối t&aacute;c tại khu vực Ğ&ocirc;ng Nam &Aacute;.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">Ğ&acirc;y cũng được xem l&agrave; cơ hội để Mỹ củng cố quan hệ kinh tế v&agrave; an ninh với c&aacute;c đối t&aacute;c quan trỞng ở Ğ&ocirc;ng Nam &Aacute; như Singapore v&agrave; Việt Nam, một phần quan trỞng trong chiến lược của Tổng thống Joe Biden trong khu vực. Cũng theo&nbsp;<em>New York Times</em>, chuyến đi mang theo th&ocirc;ng điệp r&otilde; r&agrave;ng rằng, c&aacute;c nước h&atilde;y tin tưởng v&agrave;o Mỹ.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">NhiỞu tỞ b&aacute;o kh&aacute;c cũng đưa tin đậm n&eacute;t vỞ chuyến thăm đến Việt Nam lần n&agrave;y của b&agrave; Harris.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">Theo b&aacute;o&nbsp;<em>Washington Post</em>, Mỹ cần phải h&agrave;nh động nhiỞu hơn nữa để chứng minh vai tr&ograve; của m&igrave;nh ở Ğ&ocirc;ng Nam &Aacute; cũng khu vực Ấn Ğộ - Th&aacute;i B&igrave;nh Dương, sau nhiỞu năm&nbsp;chỉ tập trung ưu ti&ecirc;n cho Trung Ğ&ocirc;ng.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">Trong b&agrave;i viết ng&agrave;y 26/8, h&atilde;ng tin Anh&nbsp;<em>Reuters</em>&nbsp;tr&iacute;ch dẫn tuy&ecirc;n bố của b&agrave; Harris trong cuộc hỞp b&aacute;o tại H&agrave; Nội chiỞu nay. \"Ch&uacute;ng t&ocirc;i sẽ l&ecirc;n tiếng khi c&oacute; những h&agrave;nh động đe dỞa trật tự quốc tế, kh&ocirc;ng ph&ugrave; hợp với luật lệ\", b&agrave; n&oacute;i.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">B&aacute;o&nbsp;<em>Irrawaddy</em>&nbsp;của Myanmar c&oacute; b&agrave;i viết với ti&ecirc;u đỞ \"Chuyến thăm Ğ&ocirc;ng Nam &Aacute; của Ph&oacute; Tổng thống Mỹ gửi th&ocirc;ng điệp tới ASEAN\", trong đ&oacute; cho rằng, theo quan điểm của Mỹ, hai quốc gia trong điểm đến lần n&agrave;y của b&agrave; Harris được coi l&agrave; những đối t&aacute;c quan trỞng trong việc th&uacute;c đẩy tầm nh&igrave;n của Washington vỞ một khu vực Ấn Ğộ Dương - Th&aacute;i B&igrave;nh Dương tự do v&agrave; rộng mở.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><strong>Củng cố quan hệ thương mại, chống đại dịch Covid-19</strong></span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">Kh&ocirc;ng chỉ nhằm th&uacute;c đẩy quan hệ song phương vỞ kinh tế v&agrave; an ninh, chuyến đi của b&agrave; Harris lần n&agrave;y c&ograve;n nhằm khẳng định cam kết hỗ trợ của Mỹ d&agrave;nh cho Việt Nam đối ph&oacute; với đại dịch Covid-19.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\"><em>Fox News</em>&nbsp;ng&agrave;y 26/8 c&oacute; b&agrave;i viết cho rằng, việc Mỹ t&agrave;i trợ một triệu liỞu vắc xin Covid-19 Pfizer ch&iacute;nh l&agrave; một phần của nỗ lực rộng lớn hơn nhằm vun đắp mối quan hệ chặt chẽ hơn với Việt Nam.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">B&aacute;o&nbsp;<em>ABC News</em>&nbsp;nhấn mạnh rằng Mỹ hiện l&agrave; nh&agrave; t&agrave;i trợ vắc xin lớn nhất cho Việt Nam, với việc trao tặng 5 triệu liỞu Moderna th&ocirc;ng qua cơ chế COVAX trước đ&oacute;, ngo&agrave;i một triệu liỞu Pfizer mới c&ocirc;ng bố ng&agrave;y 25/8.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">Trang&nbsp;<em>Geopolitical Monitor</em>&nbsp;dẫn lỞi một số nh&agrave; ph&acirc;n t&iacute;ch cho rằng, thương mại l&agrave; chủ đỞ ch&iacute;nh trong chuyến thăm Việt Nam của b&agrave; Harris, nhất l&agrave; trong bối cảnh Việt Nam đang đ&oacute;ng vai tr&ograve; quan trỞng trong chuỗi cung ứng to&agrave;n cầu, đặc biệt l&agrave; chuỗi cung ứng chất b&aacute;n dẫn.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">B&aacute;o&nbsp;<em>Nikkei Asia</em>&nbsp;của Nhật Bản c&oacute; b&agrave;i viết nhấn mạnh, Việt Nam l&agrave; đối t&aacute;c đặc biệt quan trỞng với nỞn kinh tế Mỹ.</span></p>\r\n<p><span style=\"font-family: \'comic sans ms\', sans-serif;\">Theo&nbsp;<em>Politico</em>, ngay cả khi Ph&oacute; Tổng thống Harris kh&ocirc;ng đưa ra những cam kết lớn vỞ thương mại, chuyến c&ocirc;ng du lần n&agrave;y của b&agrave; cũng tạo tiỞn đỞ để Tổng thống Joe Biden đưa ra những cam kết đ&oacute; tại hội nghị thượng đỉnh trực tuyến giữa c&aacute;c nước APEC v&agrave; ASEAN trong năm nay.</span></p>\r\n</div>','Chuyến thăm của bà Kamala Harris, đánh dấu lần đầu tiên một phó tổng thống Mỹ thăm Việt Nam, diễn ra trong bối cảnh quan hệ song phương tiếp tục phát triển tích cực, nên được dư luận quốc tế quan tâm.','uploads/blog2.jpg',18,22,'2023-07-26 10:38:45','2023-07-26 10:38:45',1,'truyen-thong-quoc-te-dac-biet-quan-tam-chuyen-tham-viet-nam-cua-ba-harris',NULL),(12,'\"Hô biến\" rác thải thành những cỞ cây, hoa lá, đồ trang trí tuyệt đẹp','<h2 style=\"text-align: center;\"><strong><em>Biến phế liệu th&agrave;nh nghệ thuật</em></strong></h2>\r\n<p style=\"text-align: center;\">Với niỞm đam m&ecirc; l&agrave;m đồ handmade, lại trăn trở vỞ vấn đỞ m&ocirc;i trưỞng&hellip; chị Xu&acirc;n Hoa (53 tuổi, sinh sống ở TP. Hải Ph&ograve;ng) quyết t&acirc;m tạo ra những t&aacute;c phẩm độc đ&aacute;o từ&nbsp;<a class=\"seo-suggest-link\" title=\"Clip: Kinh nghiệm biến r&aacute;c thải nh&agrave; bếp th&agrave;nh ph&acirc;n b&oacute;n cho vưỞn rau trĩu trịt, xanh tốt\" href=\"https://danviet.vn/clip-kinh-nghiem-bien-rac-thai-nha-bep-thanh-phan-bon-cho-vuon-rau-triu-trit-xanh-tot-20200508090213955.htm\" target=\"_blank\" rel=\"noopener\">r&aacute;c thải</a>&nbsp;như chai lỞ, t&uacute;i nilon bỞ đi.</p>\r\n<p style=\"text-align: center;\">Cơ duy&ecirc;n đến từ một lần chị Hoa thử l&agrave;m một hộp b&uacute;t bằng lỞ nhựa để con tặng bạn dịp sinh nhật. Sau khi đưa sản phẩm l&ecirc;n mạng, được bạn b&egrave; phản hồi t&iacute;ch cực, chị nảy ra &yacute; định t&aacute;i chế đồ d&ugrave;ng cũ.</p>\r\n<figure class=\"VCSortableInPreviewMode\" style=\"text-align: center;\">\r\n<div><a class=\"detail-img-lightbox\" title=\"Ğ&egrave;n trang tr&iacute; được l&agrave;m từ chai nước kho&aacute;ng.\" href=\"https://danviet.mediacdn.vn/296231569849192448/2022/3/31/13-1635324532-16487163859901845098055.jpg\" data-fancybox-group=\"img-lightbox\"><img id=\"img_433910775148974080\" class=\"lightbox-content\" title=\"đ - Ảnh 1.\" src=\"https://danviet.mediacdn.vn/296231569849192448/2022/3/31/13-1635324532-16487163859901845098055.jpg\" alt=\"đ - Ảnh 1.\" width=\"\" height=\"\" data-original=\"https://danviet.mediacdn.vn/296231569849192448/2022/3/31/13-1635324532-16487163859901845098055.jpg\" /></a></div>\r\n<figcaption class=\"PhotoCMS_Caption\">\r\n<p data-placeholder=\"[nhập ch&uacute; th&iacute;ch]\">Ğ&egrave;n trang tr&iacute; được l&agrave;m từ chai nước kho&aacute;ng.</p>\r\n</figcaption>\r\n</figure>\r\n<p style=\"text-align: center;\">Dưới b&agrave;n tay kh&eacute;o l&eacute;o v&agrave; tỉ mỉ của chị Xu&acirc;n Hoa, từ vỞ chai nước ngỞt 1,5 l&iacute;t, t&uacute;i nilong, vỞ chai nước muối sinh l&yacute;, que kem, chai nước ... đ&atilde; được chị h&ocirc; biến th&agrave;nh đ&egrave;n hoa, đ&egrave;n ph&ograve;ng ngủ, hoa c&uacute;c ping pong, hộp đựng b&uacute;t, đ&egrave;n trang tr&iacute; độc đ&aacute;o v&agrave; ấn tượng.</p>\r\n<p style=\"text-align: center;\">Chị Hoa cho hay, nguồn nguy&ecirc;n liệu gồm chai, lỞ nhựa bỞ đi được chị gom từ h&agrave;ng x&oacute;m, bạn b&egrave; v&agrave; ngo&agrave;i đưỞng. Ği đ&acirc;u thấy c&oacute; chai nhựa, t&uacute;i nilon, chị đỞu nhặt mang vỞ, n&ecirc;n thưỞng bị chồng v&agrave; c&aacute;c con tr&ecirc;u đ&ugrave;a \"tha&nbsp;<a class=\"seo-suggest-link\" title=\"l&agrave;m ph&acirc;n b&oacute;n từ r&aacute;c thải nh&agrave; bếp\" href=\"https://danviet.vn/lam-phan-bon-tu-rac-thai-nha-bep.html\" target=\"_blank\" rel=\"noopener\">r&aacute;c thải</a>&nbsp;vỞ nh&agrave;\".</p>\r\n<figure class=\"VCSortableInPreviewMode\" style=\"text-align: center;\">\r\n<div><a class=\"detail-img-lightbox\" title=\"Ğ&egrave;n ngủ được l&agrave;m từ vỞ chai nhựa.\" href=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/3/15508352313512807718989331954010347763812244n-16487164014901292040545-16489242883481653500671.jpeg\" data-fancybox-group=\"img-lightbox\"><img id=\"img_433910839976136704\" class=\"lightbox-content\" title=\"đ - Ảnh 2.\" src=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/3/15508352313512807718989331954010347763812244n-16487164014901292040545-16489242883481653500671.jpeg\" alt=\"đ - Ảnh 2.\" width=\"\" height=\"\" data-original=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/3/15508352313512807718989331954010347763812244n-16487164014901292040545-16489242883481653500671.jpeg\" /></a></div>\r\n<figcaption class=\"PhotoCMS_Caption\">\r\n<p data-placeholder=\"[nhập ch&uacute; th&iacute;ch]\">Ğ&egrave;n ngủ được l&agrave;m từ vỞ chai nhựa.</p>\r\n</figcaption>\r\n</figure>\r\n<p style=\"text-align: center;\">Theo chị Hoa, điỞu kh&oacute; nhất khi t&aacute;i sử dụng những vật liệu nhựa xuất ph&aacute;t từ đặc t&iacute;nh của vật liệu đặc biệt n&agrave;y. Chai nhựa thưỞng sẽ c&oacute; độ nhẹ, mỞm n&ecirc;n dễ m&oacute;p m&eacute;o, gặp nhiệt độ n&oacute;ng như keo nến th&igrave; rất dễ co lại. V&igrave; vậy, qu&aacute; tr&igrave;nh l&agrave;m chị lu&ocirc;n cẩn thận để kh&ocirc;ng mất thỞi gian v&agrave; tr&aacute;nh hư hỞng.</p>\r\n<h3 style=\"text-align: center;\">T&aacute;i chế&nbsp;<a class=\"seo-suggest-link\" title=\"NhỞ r&aacute;c thải nh&agrave; bếp, mẹ 8X &quot;phủ xanh&quot; s&acirc;n thượng, rau củ quả ăn kh&ocirc;ng hết\" href=\"https://danviet.vn/nho-rac-thai-nha-bep-me-8x-phu-xanh-san-thuong-rau-cu-qua-an-khong-het-20210927164703394.htm\" target=\"_blank\" rel=\"noopener\">r&aacute;c thải</a>&nbsp;v&igrave; muốn lan tỞa lối sống xanh, bảo vệ m&ocirc;i trưỞng</h3>\r\n<p style=\"text-align: center;\">Chị Hoa t&acirc;m sự: &ldquo;T&ocirc;i nhận thấy lượng phế t&uacute;i nilon,&nbsp;<a class=\"seo-suggest-link\" title=\"Clip: Kinh nghiệm biến r&aacute;c thải nh&agrave; bếp th&agrave;nh ph&acirc;n b&oacute;n cho vưỞn rau trĩu trịt, xanh tốt\" href=\"https://danviet.vn/clip-kinh-nghiem-bien-rac-thai-nha-bep-thanh-phan-bon-cho-vuon-rau-triu-trit-xanh-tot-20200508090213955.htm\" target=\"_blank\" rel=\"noopener\">r&aacute;c thải</a>&nbsp;nhựa thải ra khu vực m&igrave;nh sống rất nhiỞu, g&acirc;y &ocirc; nhiễm m&ocirc;i trưỞng v&agrave; l&agrave;m mất mỹ quan đ&ocirc; thị. Bởi thế, t&ocirc;i ấp ủ ước mơ t&aacute;i chế lại những đồ d&ugrave;ng vứt đi.</p>\r\n<figure class=\"VCSortableInPreviewMode\" style=\"text-align: center;\">\r\n<div><a class=\"detail-img-lightbox\" title=\"Chị Nguyễn Thị Xu&acirc;n Hoa b&ecirc;n những sản phẩm t&aacute;i chế l&agrave;m từ r&aacute;c thải.\" href=\"https://danviet.mediacdn.vn/296231569849192448/2022/3/31/11275386-883166625084627-457470955-n1635326320-16487170288551630760176.jpg\" data-fancybox-group=\"img-lightbox\"><img id=\"img_433913471599747072\" class=\"lightbox-content\" title=\"đ - Ảnh 3.\" src=\"https://danviet.mediacdn.vn/296231569849192448/2022/3/31/11275386-883166625084627-457470955-n1635326320-16487170288551630760176.jpg\" alt=\"đ - Ảnh 3.\" width=\"\" height=\"\" data-original=\"https://danviet.mediacdn.vn/296231569849192448/2022/3/31/11275386-883166625084627-457470955-n1635326320-16487170288551630760176.jpg\" /></a></div>\r\n<figcaption class=\"PhotoCMS_Caption\">\r\n<p data-placeholder=\"[nhập ch&uacute; th&iacute;ch]\">Chị Nguyễn Thị Xu&acirc;n Hoa b&ecirc;n những sản phẩm t&aacute;i chế l&agrave;m từ r&aacute;c thải.</p>\r\n</figcaption>\r\n</figure>\r\n<p style=\"text-align: center;\">Với t&igrave;nh y&ecirc;u m&ocirc;i trưỞng v&agrave; nỗi trăn trở l&agrave;m sao để bảo vệ m&ocirc;i trưỞng, t&ocirc;i mong muốn h&agrave;nh động của m&igrave;nh sẽ được đ&oacute;n nhận v&agrave; truyỞn năng lượng t&iacute;ch cực l&agrave;m m&ocirc;i trưỞng sống tốt l&ecirc;n mỗi ng&agrave;y\".</p>\r\n<div id=\"zone-k57lxxr9\" style=\"text-align: center;\">\r\n<div id=\"share-k57ly1bh\">\r\n<div id=\"placement-kpm0j48t\">\r\n<div id=\"banner-k57lxxr9-kpm0j4p7\">\r\n<div id=\"slot-1-k57lxxr9-kpm0j4p7\">&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<p style=\"text-align: center;\">Chia sẻ b&iacute; quyết l&agrave;m ra một sản phẩm ưng &yacute;, chị Hoa th&ocirc;ng tin điỞu quan trỞng nhất l&agrave; phải l&ecirc;n &yacute; tưởng v&agrave; t&igrave;m nguy&ecirc;n liệu ph&ugrave; hợp. Qu&aacute; tr&igrave;nh n&agrave;y sẽ hơi mất thỞi giỞ bởi nguy&ecirc;n liệu kh&ocirc;ng phải khi n&agrave;o cũng sẵn c&oacute;.</p>\r\n<p style=\"text-align: center;\">ThỞi gian để tạo ra một sản phẩm phụ thuộc nhiỞu v&agrave;o mẫu m&atilde; m&igrave;nh định thực hiện. C&oacute; những mẫu chị chỉ mất 1-2 giỞ để ho&agrave;n th&agrave;nh nhưng cũng c&oacute; những mẫu mất đến gần nửa ng&agrave;y mới xong.</p>\r\n<p style=\"text-align: center;\">Hiện, chị Hoa sử dụng th&ecirc;m k&ecirc;nh Youtube để chia sẻ c&aacute;ch t&aacute;i chế vật liệu nhựa tới mỞi ngưỞi. Ğồng thỞi chị c&ograve;n mở lớp hướng dẫn trực tiếp cho c&aacute;c bạn trẻ, nh&acirc;n cơ hội n&agrave;y chị Hoa muốn tiếp cận v&agrave; lan tỞa th&ocirc;ng điệp bảo vệ m&ocirc;i trưỞng rộng hơn tới cộng đồng.</p>\r\n<figure class=\"VCSortableInPreviewMode\" style=\"text-align: center;\">\r\n<div><a class=\"detail-img-lightbox\" title=\"Hoa c&uacute;c ping pong t&aacute;i chế từ r&aacute;c thải l&agrave; t&uacute;i nilon, hộp đựng b&uacute;t l&agrave;m từ vỞ chai nước muối sinh l&yacute; v&agrave; que kem.\" href=\"https://danviet.mediacdn.vn/296231569849192448/2022/3/31/24089144814722200764716683540016677596987709n-1648716435961201487330.jpg\" data-fancybox-group=\"img-lightbox\"><img id=\"img_433910984416956416\" class=\"lightbox-content\" title=\"đ - Ảnh 3.\" src=\"https://danviet.mediacdn.vn/296231569849192448/2022/3/31/24089144814722200764716683540016677596987709n-1648716435961201487330.jpg\" alt=\"đ - Ảnh 3.\" width=\"\" height=\"\" data-original=\"https://danviet.mediacdn.vn/296231569849192448/2022/3/31/24089144814722200764716683540016677596987709n-1648716435961201487330.jpg\" /></a></div>\r\n<figcaption class=\"PhotoCMS_Caption\">\r\n<p data-placeholder=\"[nhập ch&uacute; th&iacute;ch]\">Hoa c&uacute;c ping pong t&aacute;i chế từ r&aacute;c thải l&agrave; t&uacute;i nilon, hộp đựng b&uacute;t l&agrave;m từ vỞ chai nước muối sinh l&yacute; v&agrave; que kem.</p>\r\n</figcaption>\r\n</figure>\r\n<figure class=\"VCSortableInPreviewMode\" style=\"text-align: center;\">\r\n<div><a class=\"detail-img-lightbox\" title=\"Lồng đ&egrave;n Trung thu được l&agrave;m từ r&aacute;c thải l&agrave; chai nhựa v&agrave; t&uacute;i nilon\" href=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/16123972-258617034543732-2023353797450924032-n-1635324528-1648821173451566061771.jpg\" data-fancybox-group=\"img-lightbox\"><img id=\"img_434350290053369856\" class=\"lightbox-content\" title=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 5.\" src=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/16123972-258617034543732-2023353797450924032-n-1635324528-1648821173451566061771.jpg\" alt=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 5.\" width=\"\" height=\"\" data-original=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/16123972-258617034543732-2023353797450924032-n-1635324528-1648821173451566061771.jpg\" /></a></div>\r\n<figcaption class=\"PhotoCMS_Caption\">\r\n<p class=\"\" data-placeholder=\"[Nhập ch&uacute; th&iacute;ch ảnh]\">Lồng đ&egrave;n Trung thu được l&agrave;m từ r&aacute;c thải l&agrave; chai nhựa v&agrave; t&uacute;i nilon</p>\r\n</figcaption>\r\n</figure>\r\n<figure class=\"VCSortableInPreviewMode\" style=\"text-align: center;\">\r\n<div><a class=\"detail-img-lightbox\" title=\"Khung ảnh được l&agrave;m từ r&aacute;c thải l&agrave; que kem bỞ đi.\" href=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/14781527013373773032892802348841322449636453n-16488212277811723478761.jpg\" data-fancybox-group=\"img-lightbox\"><img id=\"img_434350517528002560\" class=\"lightbox-content\" title=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 6.\" src=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/14781527013373773032892802348841322449636453n-16488212277811723478761.jpg\" alt=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 6.\" width=\"\" height=\"\" data-original=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/14781527013373773032892802348841322449636453n-16488212277811723478761.jpg\" /></a></div>\r\n<figcaption class=\"PhotoCMS_Caption\">\r\n<p class=\"\" data-placeholder=\"[Nhập ch&uacute; th&iacute;ch ảnh]\">Khung ảnh được l&agrave;m từ r&aacute;c thải l&agrave; que kem bỞ đi.</p>\r\n</figcaption>\r\n</figure>\r\n<figure class=\"VCSortableInPreviewMode\" style=\"text-align: center;\">\r\n<div><a class=\"detail-img-lightbox\" title=\"C&aacute;c sản phẩm của chị Xu&acirc;n Hoa được nhiỞu ngưỞi th&iacute;ch th&uacute; v&agrave; đặt mua.\" href=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/23662360414658717971064961139287564207444786n-16488212450031302658225.jpg\" data-fancybox-group=\"img-lightbox\"><img id=\"img_434350589549834240\" class=\"lightbox-content\" title=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 7.\" src=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/23662360414658717971064961139287564207444786n-16488212450031302658225.jpg\" alt=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 7.\" width=\"\" height=\"\" data-original=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/23662360414658717971064961139287564207444786n-16488212450031302658225.jpg\" /></a></div>\r\n<figcaption class=\"PhotoCMS_Caption\">\r\n<p class=\"\" data-placeholder=\"[Nhập ch&uacute; th&iacute;ch ảnh]\">C&aacute;c sản phẩm của chị Xu&acirc;n Hoa được nhiỞu ngưỞi th&iacute;ch th&uacute; v&agrave; đặt mua.</p>\r\n</figcaption>\r\n</figure>\r\n<figure class=\"VCSortableInPreviewMode noCaption\" style=\"text-align: center;\">\r\n<div><a class=\"detail-img-lightbox\" title=\"\" href=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/23665575214631176073819151487441972719959960n-16488212669201546137384.jpg\" data-fancybox-group=\"img-lightbox\"><img id=\"img_434350681945542656\" class=\"lightbox-content\" title=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 8.\" src=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/23665575214631176073819151487441972719959960n-16488212669201546137384.jpg\" alt=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 8.\" width=\"\" height=\"\" data-original=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/23665575214631176073819151487441972719959960n-16488212669201546137384.jpg\" /></a></div>\r\n</figure>\r\n<figure class=\"VCSortableInPreviewMode small-img\" style=\"text-align: center;\">\r\n<div><a class=\"detail-img-lightbox\" title=\"Ğ&egrave;n ngủ &quot;độc đ&aacute;o&quot; từ chai nhựa khiến ai cũng phải trầm trồ th&aacute;n phục trước sự kh&eacute;o tay của chị Hoa.\" href=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/2654490561545955165764825915129643343543036n-16488212834001739221222.jpg\" data-fancybox-group=\"img-lightbox\"><img id=\"img_434350751318523904\" class=\"lightbox-content\" title=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 9.\" src=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/2654490561545955165764825915129643343543036n-16488212834001739221222.jpg\" alt=\"Gặp gỡ ngưỞi phụ nữ Hải Ph&ograve;ng &amp;quot;thổi hồn&amp;quot; cho r&aacute;c thải th&agrave;nh t&aacute;c phẩm nghệ thuật - Ảnh 9.\" width=\"\" height=\"\" data-original=\"https://danviet.mediacdn.vn/296231569849192448/2022/4/1/2654490561545955165764825915129643343543036n-16488212834001739221222.jpg\" /></a></div>\r\n</figure>','Từ rác thải, chị Nguyễn Xuân Hoa ( Hải Phòng) đã tái chế thành những sản phẩm đẹp mắt, hữu dụng trong gia đình, góp phần lan toả tinh thần sống xanh.','uploads/post3.jpg',19,22,'2023-08-01 14:41:46','2023-08-01 14:41:46',1,'ho-bien-rac-thai-thanh-nhung-co-cay-hoa-la-do-trang-tri-tuyet-dep',NULL),(13,'Trần Quang Quý','<p>hihi</p>','demo','uploads/thay-doi-anh-bai-viet-facebook.jpg',20,22,'2023-12-15 01:30:26','2023-12-15 01:47:42',1,'tran-quang-quy','2023-12-15 01:47:42');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_blogs`
--

DROP TABLE IF EXISTS `cat_blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_blogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `slug` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cat_blogs_creator_foreign` (`creator`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_blogs`
--

LOCK TABLES `cat_blogs` WRITE;
/*!40000 ALTER TABLE `cat_blogs` DISABLE KEYS */;
INSERT INTO `cat_blogs` VALUES (10,'Chính trị',22,'2023-07-15 12:13:53','2023-07-15 12:13:53',1,'chinh-tri',9),(12,'Môi trưỞng',22,'2023-07-15 12:14:36','2023-07-15 12:14:36',1,'moi-truong',9),(13,'Bóng đá',22,'2023-07-15 12:14:55','2023-07-15 12:14:55',1,'bong-da',11),(14,'Cầu lông',22,'2023-07-15 12:15:08','2023-07-15 12:15:08',0,'cau-long',11),(16,'Xã hội',22,'2023-07-15 12:23:48','2023-07-15 12:23:48',1,'xa-hoi',0),(17,'Thể thao',22,'2023-07-15 12:24:02','2023-07-15 12:24:02',1,'the-thao',0),(18,'Chính trị',22,'2023-07-15 12:24:13','2023-07-15 12:24:13',1,'chinh-tri',16),(19,'Môi trưỞng',22,'2023-07-15 12:24:21','2023-07-15 12:24:21',1,'moi-truong',16),(20,'Bóng đá',22,'2023-07-15 12:24:29','2023-07-15 14:19:10',0,'bong-da',17);
/*!40000 ALTER TABLE `cat_blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_products`
--

DROP TABLE IF EXISTS `cat_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned NOT NULL DEFAULT '0',
  `creator` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_products_creator_foreign` (`creator`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_products`
--

LOCK TABLES `cat_products` WRITE;
/*!40000 ALTER TABLE `cat_products` DISABLE KEYS */;
INSERT INTO `cat_products` VALUES (1,'Giày Ğá Bóng Nike',0,41,1,'2026-05-19 23:24:37','2026-05-19 23:24:37','giay-da-bong-nike'),(2,'Giày Ğá Bóng Adidas',0,41,1,'2026-05-19 23:24:37','2026-05-19 23:24:37','giay-da-bong-adidas'),(3,'Giày Ğá Bóng Puma',0,41,1,'2026-05-19 23:24:37','2026-05-19 23:24:37','giay-da-bong-puma'),(4,'Phụ Kiện Thể Thao',0,41,1,'2026-05-19 23:24:37','2026-05-19 23:24:37','phu-kien-the-thao');
/*!40000 ALTER TABLE `cat_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `changepoints`
--

DROP TABLE IF EXISTS `changepoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `changepoints` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `amount` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `changepoints_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `changepoints`
--

LOCK TABLES `changepoints` WRITE;
/*!40000 ALTER TABLE `changepoints` DISABLE KEYS */;
INSERT INTO `changepoints` VALUES (6,30,'10','2023-07-26 16:43:35','2023-07-26 17:15:31',1),(10,30,'100','2023-07-26 20:50:16','2023-07-26 20:50:23',1),(15,30,'100','2023-07-27 07:06:09','2023-07-27 07:06:24',1),(17,30,'400','2023-07-31 07:09:38','2023-07-31 07:10:53',1);
/*!40000 ALTER TABLE `changepoints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint unsigned NOT NULL,
  `sender` enum('user','bot') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'NgưỞi gửi: user hoặc bot',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nội dung tin nhắn',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `chat_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_messages`
--

LOCK TABLES `chat_messages` WRITE;
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
INSERT INTO `chat_messages` VALUES (1,1,'user','Cua hang ban ban nhung san pham nao?','2026-05-19 23:45:00','2026-05-19 23:45:00'),(2,1,'bot','➠︞ AI trả vỞ lỗi: openrouter/owl-ai/owl-alpha is not a valid model ID','2026-05-19 23:45:01','2026-05-19 23:45:01'),(3,2,'user','Cua hang ban ban nhung san pham nao?','2026-05-19 23:45:27','2026-05-19 23:45:27'),(4,2,'bot','➠︞ AI trả vỞ lỗi: openrouter/owl-ai/owl-alpha is not a valid model ID','2026-05-19 23:45:28','2026-05-19 23:45:28'),(5,3,'user','Cua hang ban ban nhung san pham nao?','2026-05-19 23:46:06','2026-05-19 23:46:06'),(6,3,'bot','Chào bạn! 👋\n\nCửa hàng Cris Store chuyên bán các sản phẩm **nội thất gia đình** bao gồm:\n\n📺 **Kệ tivi**\n🛋︞ **Bàn trà, ghế sofa, ghế gỗ tái chế**\n🞽︞ **Bàn ăn**\n🛞︞ **GiưỞng ngủ**\n💄 **Bàn trang điểm**\n🞳 **Tủ bếp**\n🪑 **Bộ bàn ghế cao su tái chế**\n🞗 **Bộ bàn ghế lốp xe tái chế**\n🞡 **Xích đu sân vưỞn**\n🌿 **Cây xanh trang trí từ chai nhựa tái chế**\n\nTất cả sản phẩm đỞu được làm từ **vật liệu thân thiện môi trưỞng** 🌱\n\nBạn muốn tìm hiểu thêm vỞ sản phẩm nào không?','2026-05-19 23:46:22','2026-05-19 23:46:22'),(7,4,'user','Thong tin cua hang','2026-05-19 23:46:44','2026-05-19 23:46:44'),(8,4,'bot','Chào bạn! 👋\n\nDưới đây là thông tin vỞ **Cris Store**:\n\n---\n\n**🞪 Cris Store - Nâng niu bàn chân Việt**\n\n📞 **Ğịa chỉ:** TỞa lạc tại Ğại hỞc Công nghệ Ğông Þ\n\n📞 **Hotline:** 19006750\n\n📧 **Email:** quannguyen04082004@gmail.com\n\n---\n\n**🛋︞ Sản phẩm chính:**\nCris Store chuyên bán các sản phẩm nội thất gia đình bao gồm:\n- Kệ tivi, bàn trà, bàn ăn, giưỞng ngủ, bàn trang điểm\n- Tủ bếp, ghế sofa, ghế gỗ tái chế, xích đu sân vưỞn\n- Cây xanh trang trí từ chai nhựa tái chế\n- Bộ bàn ghế cao su tái chế, bộ bàn ghế lốp xe tái chế\n\n♻︞ *Tất cả sản phẩm đỞu được làm từ vật liệu thân thiện môi trưỞng.*\n\n---\n\n**🞞 Chính sách vận chuyển:** Miễn phí giao hàng toàn quốc (3-7 ngày tùy khu vực)\n\n**💳 Thanh toán:** COD & VNPay\n\n**🔄 Ğổi trả:** 7 ngày nếu lỗi từ nhà sản xuất\n\n**🞷︞ Thẻ thành viên:** Tích điểm & đổi quà\n\nBạn cần biết thêm thông tin gì nữa không? 😞','2026-05-19 23:47:09','2026-05-19 23:47:09'),(9,4,'user','Co ban hang ban giao khong?','2026-05-19 23:47:13','2026-05-19 23:47:13'),(10,4,'bot','Có bạn! 👋\n\nCris Store **có bán bàn giưỞng ngủ** nhé! 🛞︞\n\nCửa hàng chuyên bán các sản phẩm nội thất gia đình bao gồm:\n\n- **GiưỞng ngủ** ✅\n- Kệ tivi, bàn trà, bàn ăn\n- Bàn trang điểm, tủ bếp\n- Ghế sofa, ghế gỗ tái chế\n- Xích đu sân vưỞn\n- Cây xanh trang trí từ chai nhựa tái chế\n- Bộ bàn ghế cao su tái chế, bộ bàn ghế lốp xe tái chế\n\n♻︞ Tất cả sản phẩm đỞu được làm từ vật liệu thân thiện môi trưỞng.\n\nBạn muốn biết thêm thông tin chi tiết vỞ sản phẩm nào cụ thể không? 😞','2026-05-19 23:47:29','2026-05-19 23:47:29'),(11,4,'user','Xuat excel cuoc hoi thoai','2026-05-19 23:47:33','2026-05-19 23:47:33'),(12,4,'bot','<a href=\"http://localhost:8000/admin/chatbox/export/4\" target=\"_blank\">Excel cuộc hội thoại</a>','2026-05-19 23:47:38','2026-05-19 23:47:38'),(13,5,'user','Xin chao, gio ban co khuyen mai gi khong?','2026-05-19 23:48:02','2026-05-19 23:48:02'),(14,5,'bot','Xin chào bạn! 👋\n\nHiện tại mình chưa có thông tin cụ thể vỞ các chương trình khuyến mãi đang diễn ra tại Cris Store.\n\nBạn có thể liên hệ trực tiếp với Cris Store để được cập nhật ưu đãi mới nhất:\n\n- **Hotline:** 19006750\n- **Email:** quannguyen04082004@gmail.com\n- **Ğịa chỉ:** Ğại hỞc Công nghệ Ğông Þ\n\nBạn còn cần mình hỗ trợ gì không? 😞','2026-05-19 23:48:15','2026-05-19 23:48:15'),(15,6,'user','Xin chao, cho toi biet ve cua hang','2026-05-19 23:49:31','2026-05-19 23:49:31'),(16,6,'bot','Xin chào bạn! 👋\n\nMình là trợ lý của **Cris Store** - cửa hàng chuyên bán nội thất gia đình.\n\n**VỞ Cris Store:**\n- 📞 Ğịa chỉ: TỞa lạc tại Ğại hỞc Công nghệ Ğông Þ\n- 📞 Hotline: **1900 6750**\n- 📧 Email: quannguyen04082004@gmail.com\n\n**Sản phẩm chính:**\nCris Store chuyên cung cấp các sản phẩm nội thất gia đình bao gồm:\n- Kệ tivi, bàn trà, bàn ăn\n- GiưỞng ngủ, bàn trang điểm\n- Tủ bếp, ghế sofa, ghế gỗ tái chế\n- Xích đu sân vưỞn, cây xanh trang trí từ chai nhựa tái chế\n- Bộ bàn ghế cao su tái chế, bộ bàn ghế lốp xe tái chế\n\n👉 Tất cả sản phẩm đỞu được làm từ **vật liệu thân thiện môi trưỞng**.\n\n**Chính sách nổi bật:**\n- 🞞 Miễn phí giao hàng toàn quốc (đơn từ 500.000đ)\n- 🔄 Ğổi mới trong 7 ngày nếu sản phẩm lỗi\n- 💳 Thanh toán COD hoặc online qua VNPay\n- 🞞 Có thẻ thành viên tích lũy điểm\n\nBạn muốn tìm hiểu thêm vỞ sản phẩm nào hoặc cần hỗ trợ gì ạ? 😞','2026-05-19 23:49:56','2026-05-19 23:49:56'),(17,6,'user','Cửa hàng bạn bán những sản phẩm nào?','2026-05-19 23:54:09','2026-05-19 23:54:09'),(18,6,'bot','Chào bạn! 😞\n\n**Cris Store** chuyên bán các sản phẩm **nội thất gia đình**, bao gồm:\n\n🪑 **Bàn ghế:**\n- Kệ tivi, bàn trà, bàn ăn\n- Ghế sofa, ghế gỗ tái chế\n- Bộ bàn ghế cao su tái chế, bộ bàn ghế lốp xe tái ché\n\n🛞︞ **GiưỞng & Tủ:**\n- GiưỞng ngủ, bàn trang điểm, tủ bếp\n\n🌿 **Trang trí & Ngoại thất:**\n- Xích đu sân vưỞn\n- Cây xanh trang trí từ chai nhựa tái chế\n\n👉 **Ğặc biệt:** Tất cả sản phẩm đỞu được làm từ **vật liệu thân thiện môi trưỞng** 🌱\n\nBạn quan tâm đến sản phẩm nào cụ thể không ạ? Mình có thể tư vấn thêm cho bạn!','2026-05-19 23:54:35','2026-05-19 23:54:35'),(19,6,'user','Cửa hàng của bạn bán những sản phẩm nào?','2026-05-19 23:57:48','2026-05-19 23:57:48'),(20,6,'bot','Chào bạn! 😞\n\n**Cris Store** chuyên bán các sản phẩm **nội thất gia đình**, bao gồm:\n\n🪑 **Bàn ghế:**\n- Kệ tivi, bàn trà, bàn ăn\n- Ghế sofa, ghế gỗ tái chế\n- Bộ bàn ghế cao su tái chế, bộ bàn ghế lốp xe tái ché\n\n🛞︞ **GiưỞng & Tủ:**\n- GiưỞng ngủ, bàn trang điểm, tủ bếp\n\n🌿 **Trang trí & Ngoại thất:**\n- Xích đu sân vưỞn\n- Cây xanh trang trí từ chai nhựa tái chế\n\n👉 **Ğặc biệt:** Tất cả sản phẩm đỞu được làm từ **vật liệu thân thiện môi trưỞng** 🌱\n\nBạn quan tâm đến sản phẩm nào cụ thể không ạ? Mình có thể tư vấn thêm cho bạn!','2026-05-19 23:58:08','2026-05-19 23:58:08'),(21,6,'user','hãy xuất file excle báo giá 1 vài sản phẩm nổi bật','2026-05-20 00:07:21','2026-05-20 00:07:21'),(22,6,'bot','➠︞ Không thể kết nối tới máy chủ AI.','2026-05-20 00:07:52','2026-05-20 00:07:52'),(23,7,'user','hãy xuất file excle báo giá 1 vài sản phẩm nổi bật','2026-05-20 00:08:18','2026-05-20 00:08:18'),(24,7,'bot','Dưới đây là bảng báo giá một vài sản phẩm nổi bật tại **Cris Store**:\n\n| **STT** | **Tên sản phẩm** | **Ğơn giá (VNĞ)** |\n|---------|-------------------|-------------------|\n| 1 | Kệ tivi | 1.500.000 |\n| 2 | Bàn trà | 1.200.000 |\n| 3 | Bàn ăn | 2.000.000 |\n| 4 | GiưỞng ngủ | 3.500.000 |\n| 5 | Ghế sofa | 2.800.000 |\n\n> ➠︞ **Lưu ý:** Bảng giá trên chỉ mang tính chất tham khảo. Giá thực tế có thể thay đổi tùy thỞi điểm. Vui lòng liên hệ **Hotline: 19006750** hoặc **Email: quannguyen04082004@gmail.com** để được tư vấn chính xác nhất.\n\n---\n\n[📥 Tải Excel](http://localhost:8000/admin/chatbox/export/7)','2026-05-20 00:08:38','2026-05-20 00:08:38'),(25,8,'user','Cửa hàng của bạn bán những sản phẩm nào?','2026-05-20 05:26:23','2026-05-20 05:26:23'),(26,9,'user','Cửa hàng của bạn bán những sản phẩm nào?','2026-05-20 05:29:10','2026-05-20 05:29:10'),(27,9,'bot','### Câu trả lỞi dựa trên dữ liệu cơ sở:\n\nChúng tôi chỉ được trả lỞi thông tin liên quan trực tiếp đến **Cris Store**, như sau:\n\n---\n\n### 🔞 Thông tin sản phẩm đang có (Từ `KNOWLEDGE`):\n- **Kệ tiệp kết hợp bàn trà** – 9 lượt mua, giá 2.430.000đ  \n- **Kệ tiệp kết hợp bàn trà Bắc Âu** – 8 lượt mua, giá 6.100.000đ  \n- **Xích đu sân vưỞn thỞi trang cao su tái chế** – 6 lượt mua, giá 600.000đ  \n- **Bộ bàn ghế cao su thân thiện môi trưỞng cao cấp** – 5 lượt mua, giá 1.515.000đ  \n- **Cây Xanh Từ Chai Nhựa Ğồ Trang Trí** – 5 lượt mua, giá 135.000đ  \n\n---\n\n### 📋 Danh sách sản phẩm nổi bật:\n1. **Kệ tiệp kết hợp bàn trà** – 9 lượt, 2.430.000đ  \n2. **Kệ tiệp kết hợp bàn trà Bắc Âu** – 8 lượt, 6.100.000đ  \n3. **Xích đu sân vưỞn thỞi trang cao su tái chế** – 6 lượt, 600.000đ  \n4. **Bộ bàn ghế cao su** – 5 lượt, 1.515.000đ  \n5. **Cây Xanh Từ chai nhựa** – 5 lượt, 135.000đ  \n\n---\n\n### 📌 Lưu ý quan trỞng:\n- Thông tin này chỉ được trả lỞi từ cơ sở dữ liệu được cung cấp (KNOWLEDGE, PRODUCT_RESULTS, ORDER_INFO).  \n- Không được tạo ra hoặc đoán thông tin không có trong hệ thống.  \n- Nếu bạn cần thông tin chi tiết hơn (ví dụ: mã sản phẩm, thông tin chi tiết giao dịch), vui lòng liên hệ trực tiếp qua chat.\n\n---\n\n📩 **Lưu ý:** Chúng tôi luôn cập nhật thông tin chính xác nhất từ cơ sở dữ liệu để đảm bảo chính xác.','2026-05-20 05:29:18','2026-05-20 05:29:18'),(28,10,'user','Cửa hàng của bạn bán những sản phẩm nào?','2026-05-20 05:49:34','2026-05-20 05:49:34'),(29,10,'bot','📋 **Các sản phẩm được bán tại Cris Store:**\n\n- **Kệ TI VI KẾT HỢP BÀN TRÀ**  \n  - Số lượt mua: 9  \n  - Giá: 2.430.000đ  \n\n- **KATINA KỆ TI VI KẾT HỢP BÀN TRÀ BẮC ÂU**  \n  - Số lượt mua: 8  \n  - Giá: 6.100.000đ  \n\n- **Xích đu sân vưỞn thỞi trang cao su tái chế**  \n  - Số lượt mua: 6  \n  - Giá: 600.000đ  \n\n- **Bộ bàn ghế cao su thân thiện môi trưỞng cao cấp**  \n  - Số lượt mua: 5  \n  - Giá: 1.515.000đ  \n\n- **Cây Xanh Từ Chai Nhựa Ğồ Trang Trí**  \n  - Số lượt mua: 5  \n  - Giá: 135.000đ  \n\n🔞 **Lưu ý:**  \n- Thông tin này được trích trực tiếp từ **KNOWLEDGE**, **PRODUCT_RESULTS**, và **ORDER_INFO**.  \n- Chỉ được trả lỞi từ thông tin sản phẩm đã xem xét.  \n- Nếu có thêm câu hỞi, hãy cho tôi biết! 😞','2026-05-20 05:49:39','2026-05-20 05:49:39'),(30,10,'user','xuất excel','2026-05-20 05:49:47','2026-05-20 05:49:47'),(31,10,'bot','📥 **Tải Excel của Cris Store**  \n\nĞể tải file Excel, hãy thực hiện các bước sau:\n\n1. **Ğăng nhập vào trang admin Cris Store**  \n2. Truy cập cảng thả xuất Excel và chỞn **Export**.  \n3. ChỞn địa chỉ URL sau:  \n   ```markdown\n   [📥 Tải Excel](http://localhost:8000/admin/chatbox/export/10)\n   ```  \n4. ChỞn tên tệp Excel để tải (ví dụ: `cris_store_sales.xlsx`).  \n5. Sau khi tạo tệp, nhấp vào **Download** để được tải file.\n\n📌 **Lưu ý:**  \n- File Excel sẽ chứa dữ liệu giao hàng, đơn hàng và thông tin sản phẩm.  \n- Nếu cần thêm tài liệu khác, hãy liên hệ trực tiếp qua email hoặc hotline được cung cấp.  \n\n📞 **Hãy đảm bảo:**  \n- Tên file đạt định dạng `.xlsx` (hoặc `.csv` nếu cần).  \n\nNếu bạn cần thêm thông tin cụ thể vỞ dữ liệu, hãy cho tôi biết! 😞','2026-05-20 05:49:52','2026-05-20 05:49:52'),(32,10,'user','xuất excel','2026-05-20 05:50:03','2026-05-20 05:50:03'),(33,10,'bot','✅ **Ğịnh dạng file Excel đã được tạo:**  \n[📥 Tải Excel Cris Store](http://localhost:8000/admin/chatbox/export/10)  \n\n📄 **Thông tin tải:**  \n- File được tải từ URL trên được **tách biệt** theo các bảng (sản phẩm, đơn hàng, giá).  \n- Có thông tin chi tiết vỞ sản phẩm, đơn hàng, và giao hàng được ghi chú rõ ràng.  \n- Thức ưu: Nếu cần xem lại, bạn chỉ cần mở file tải từ link trên.  \n\n📌 **Lưu ý:**  \n- ĞỞc kỹ các bảng để nhận diện thông tin chính.  \n- Nếu cần điỞu chỉnh dữ liệu, hãy liên hệ qua **Hotline** hoặc email **quannguyen04082004@gmail.com**.  \n\n😞 **Chúc bạn thành công!**','2026-05-20 05:50:08','2026-05-20 05:50:08'),(34,10,'user','Cửa hàng của bạn bán những sản phẩm nào?','2026-05-20 06:21:20','2026-05-20 06:21:20'),(35,10,'bot','📞 **Xuất dữ liệu sản phẩm được bán tại Cris Store**  \n\nĞể tải file Excel, hãy tham khảo **các bảng sau** (tên tệp được tạo theo định dạng `.xlsx`):  \n\n1. **Sản phẩm - Kệ TI VI KẾT HỢP BÀN TRÀ**  \n   - Số lượt mua: 9  \n   - Giá: 2.430.000đ  \n\n2. **Sản phẩm - Kệ TI VI KẾT HỢP BÀN TRÀ BẮC ÂU**  \n   - Số lượt mua: 8  \n   - Giá: 6.100.000đ  \n\n3. **Sản phẩm - Kệ Bàn (Bàn ghế cao su)**  \n   - Số lượt mua: 6  \n   - Giá: 1.515.000đ  \n\n4. **Sản phẩm - Xích đu sân vưỞn thỞi trang cao su tái chế**  \n   - Số lượt mua: 5  \n   - Giá: 600.000đ  \n\n5. **Sản phẩm - Bộ bàn ghế cao su thân thiện môi trưỞng**  \n   - Số lượt mua: 5  \n   - Giá: 1.275.000đ  \n\n📌 **Lưu ý:**  \n- Các bảng được tạo dựa trên dữ liệu từ **KNOWLEDGE**, **PRODUCT_RESULTS**, và **ORDER_INFO**.  \n- Bạn có thể xem chi tiết chi tiết hơn từ file Excel để lắng nghe chi tiết giao hàng, gói gửi,…  \n- Nếu cần thêm thông tin nhất quán, hãy liên hệ qua **Hotline** hoặc email **quannguyen04082004@gmail.com**.  \n\n👉 **Tải file tại địa chỉ được:** [📥 Tải Excel Cris Store](http://localhost:8000/admin/chatbox/export/10)  \n\nNếu cần thêm tài liệu khác, hãy cho tôi biết! 😞','2026-05-20 06:21:27','2026-05-20 06:21:27');
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_sessions`
--

DROP TABLE IF EXISTS `chat_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_sessions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Tên khách hàng',
  `user_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Số điện thoại khách hàng',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ğịa chỉ IP khách',
  `status` enum('active','ended') COLLATE utf8mb4_unicode_ci DEFAULT 'active' COMMENT 'Trạng thái hội thoại',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_sessions`
--

LOCK TABLES `chat_sessions` WRITE;
/*!40000 ALTER TABLE `chat_sessions` DISABLE KEYS */;
INSERT INTO `chat_sessions` VALUES (1,NULL,NULL,NULL,'active','2026-05-19 23:45:00','2026-05-19 23:45:00'),(2,NULL,NULL,NULL,'active','2026-05-19 23:45:27','2026-05-19 23:45:27'),(3,NULL,NULL,NULL,'active','2026-05-19 23:46:06','2026-05-19 23:46:06'),(4,NULL,NULL,NULL,'active','2026-05-19 23:46:44','2026-05-19 23:46:44'),(5,NULL,NULL,NULL,'active','2026-05-19 23:48:02','2026-05-19 23:48:02'),(6,NULL,NULL,NULL,'active','2026-05-19 23:49:31','2026-05-19 23:49:31'),(7,NULL,NULL,NULL,'active','2026-05-20 00:08:18','2026-05-20 00:08:18'),(8,NULL,NULL,NULL,'active','2026-05-20 05:26:23','2026-05-20 05:26:23'),(9,NULL,NULL,NULL,'active','2026-05-20 05:29:10','2026-05-20 05:29:10'),(10,NULL,NULL,NULL,'active','2026-05-20 05:49:34','2026-05-20 05:49:34');
/*!40000 ALTER TABLE `chat_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `colors_creator_foreign` (`creator`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` VALUES (1,'Màu xanh','mau-xanh','#98eca6',22,1,'2023-07-19 19:07:24','2023-07-18 07:49:26'),(2,'Màu đỞ','mau-do','#ee9191',22,0,'2023-07-19 19:08:28','2023-07-04 06:53:25'),(3,'Màu tím','mau-tim','#d6a6ed',22,1,'2023-07-19 19:08:48','2023-07-02 17:50:27'),(4,'Màu vàng','mau-vang','#f7f5bb',22,1,'2023-07-19 19:09:08','2023-07-02 17:50:21'),(5,'Màu nâu','mau-nau','#e4ad95',22,1,'2023-07-19 19:10:49','2023-07-02 07:51:06');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `memory` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `configs_creator_foreign` (`creator`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configs`
--

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
INSERT INTO `configs` VALUES (4,'Loại 1','40',22,1,'2023-07-26 06:14:31','2023-07-26 06:14:31'),(5,'Loại 2','45',22,1,'2023-07-26 06:20:13','2026-05-20 06:34:10'),(6,'Loại 3','43',22,1,'2023-07-26 06:20:29','2023-07-26 06:20:29');
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_groups`
--

DROP TABLE IF EXISTS `customer_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_groups`
--

LOCK TABLES `customer_groups` WRITE;
/*!40000 ALTER TABLE `customer_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `star` int NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
INSERT INTO `feedback` VALUES (18,30,5,'Hàng tốt lắm! Shop nhiệt tình😞','2023-07-30 12:06:43','2023-07-30 12:06:43',NULL),(38,32,5,'Sản phẩm thân thiện với môi trưỞng🤩🤩🤩','2023-07-30 17:02:41','2023-07-30 17:02:41',NULL),(50,33,4,'Giao hàng chậm, Nhưng chủ shop dễ thương nên tạm cho 4 sao','2023-07-30 18:50:23','2023-07-30 18:50:23',NULL),(51,33,5,'Không có lỞi đánh giá.','2023-07-30 18:50:45','2023-07-30 18:50:45',NULL),(52,30,1,'Không có lỞi đánh giá.','2023-07-31 17:19:16','2023-07-31 17:19:16',NULL);
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gifts`
--

DROP TABLE IF EXISTS `gifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gifts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `thumb` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gifts`
--

LOCK TABLES `gifts` WRITE;
/*!40000 ALTER TABLE `gifts` DISABLE KEYS */;
INSERT INTO `gifts` VALUES (1,'uploads/Cay-xanh.png','900',NULL,NULL),(2,'uploads/Cay-xanh-3.png','1200',NULL,NULL),(3,'uploads/Cay-xanh-2.png','1900',NULL,NULL);
/*!40000 ALTER TABLE `gifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(4,'2023_06_01_094354_add_soft_delete_to_users',2),(5,'2023_06_08_100745_create_permissions_table',3),(7,'2023_06_08_101740_create_roles_table',4),(8,'2023_06_08_110137_create_role_permission',5),(9,'2023_06_09_055204_create_user_role_table',6),(19,'2023_06_21_163118_create_cat_blogs_table',14),(20,'2023_06_21_163227_create_blogs_table',15),(24,'2023_06_24_160623_create_cat_products_table',16),(25,'2023_06_25_171612_create_products_table',16),(26,'2023_06_19_182319_create_configs_table',17),(27,'2023_06_18_155824_create_colors_table',18),(28,'2023_06_26_003556_create_product_color_table',19),(29,'2023_06_26_003621_create_product_config_table',19),(30,'2023_06_29_163144_create_sliders_table',20),(31,'2023_06_29_164546_create_banners_table',21),(34,'2023_06_21_162414_create_pages_table',22),(40,'2023_07_16_015806_create_orders_table',23),(41,'2023_07_18_100732_add_soft_delete_to_orders',24),(42,'2023_07_18_100857_add_soft_delete_to_products',25),(43,'2023_07_18_101306_add_soft_delete_to_banner',26),(44,'2023_07_18_101330_add_soft_delete_to_sliders',26),(45,'2023_07_18_113946_add_soft_delete_to_blogs',27),(46,'2023_07_26_214656_create_change_points_table',28),(50,'2023_07_27_134923_create_user_gift_table',29),(51,'2023_07_30_140416_create_feedback_table',30),(52,'2019_12_14_000001_create_personal_access_tokens_table',31);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `total` decimal(10,0) NOT NULL DEFAULT '0',
  `method_pay` tinyint(1) NOT NULL DEFAULT '0',
  `code_bill` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `progress` int NOT NULL DEFAULT '0',
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (5,'Nguyễn Hoàng Anh','Xã Chi Lăng Nam - Huyện Thanh Miện - Tỉnh Hải Dương','0943833031','Giao sớm nha','quytran52003@gmail.com','{\"718c4f5e60a0639a58f7b7ab45cc2dfc\":{\"rowId\":\"718c4f5e60a0639a58f7b7ab45cc2dfc\",\"id\":75,\"name\":\"KATINA K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 B\\u1eaeC \\u00c2U - KTV37\",\"qty\":1,\"price\":6100000,\"options\":{\"thumb_main\":\"uploads\\/sp1-main.jpg\",\"slug\":\"katina-ke-ti-vi-ket-hop-ban-tra-bac-au-ktv37\",\"code\":\"TQ#75\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"6100000.00\"},\"edaaa9ba22b87cbb6dfdad5b124b04f2\":{\"rowId\":\"edaaa9ba22b87cbb6dfdad5b124b04f2\",\"id\":76,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 - KTV24\",\"qty\":\"2\",\"price\":4200000,\"options\":{\"thumb_main\":\"uploads\\/sp2-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-ktv24\",\"code\":\"TQ#76\",\"option\":\"Lo\\u1ea1i 3\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"8400000.00\"},\"09a99bf06280e69eb6f21c98827ab14b\":{\"rowId\":\"09a99bf06280e69eb6f21c98827ab14b\",\"id\":76,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 - KTV24\",\"qty\":1,\"price\":2430000,\"options\":{\"thumb_main\":\"uploads\\/sp2-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-ktv24\",\"code\":\"TQ#76\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"2430000.00\"}}',4,16930000,0,'bill-26135701',2,NULL,'2023-07-26 06:57:01','2023-07-26 06:59:24',NULL),(6,'Trần Quang Kiên','Xã Tân Tiến - Thành phố Bắc Giang - Tỉnh Bắc Giang','0943833031',NULL,'nghia101022@gmail.com','{\"1fe1f4ef8e280ffd3e674e8f913e43ce\":{\"rowId\":\"1fe1f4ef8e280ffd3e674e8f913e43ce\",\"id\":80,\"name\":\"T\\u1ee6 KH\\u1eec TR\\u00d9NG \\u1ea4M TR\\u00c0 - PKT09\",\"qty\":\"2\",\"price\":11200000,\"options\":{\"thumb_main\":\"uploads\\/sp6-main.jpg\",\"slug\":\"tu-khu-trung-am-tra-pkt09\",\"code\":\"TQ#80\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"22400000.00\"},\"4929890ca531dcba126e17f63ee6e83c\":{\"rowId\":\"4929890ca531dcba126e17f63ee6e83c\",\"id\":84,\"name\":\"SOFIA SFG44 - SOFA GI\\u01af\\u1edcNG G\\u1ed6 T\\u00c1I CH\\u1ebe\",\"qty\":1,\"price\":6590000,\"options\":{\"thumb_main\":\"uploads\\/sp10-main.jpg\",\"slug\":\"sofia-sfg44-sofa-giuong-go-tai-che\",\"code\":\"TQ#84\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"6590000.00\"}}',3,28990000,0,'bill-31001501',2,NULL,'2023-07-30 17:15:01','2023-07-30 17:20:06',NULL),(8,'Trần Quang Dũng','Xã Năng Khả - Huyện Na Hang - Tỉnh Tuyên Quang','0943833031',NULL,'hiamnhatdz203@gmail.com','{\"7aae4bc8e21d329345affc2cba35b6a4\":{\"rowId\":\"7aae4bc8e21d329345affc2cba35b6a4\",\"id\":88,\"name\":\"C\\u00e2y Xanh T\\u1eeb Chai Nh\\u1ef1a \\u0110\\u1ed3 Trang Tr\\u00ed\",\"qty\":1,\"price\":135000,\"options\":{\"thumb_main\":\"uploads\\/sp13-main.jpg\",\"slug\":\"cach-lam-cay-xanh-tu-chai-nhua\",\"code\":\"TQ#88\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"135000.00\"},\"99f2cbff876fc69748cc61039ee00cdb\":{\"rowId\":\"99f2cbff876fc69748cc61039ee00cdb\",\"id\":87,\"name\":\"X\\u00edch \\u0111u s\\u00e2n v\\u01b0\\u1eddn th\\u1eddi trang cao su t\\u00e1i ch\\u1ebf\",\"qty\":1,\"price\":600000,\"options\":{\"thumb_main\":\"uploads\\/sp12-detail2.jpg\",\"slug\":\"xich-du-san-vuon-thoi-trang\",\"code\":\"TQ#87\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"600000.00\"},\"6b5dce214a53df3a1085ba99d4df856c\":{\"rowId\":\"6b5dce214a53df3a1085ba99d4df856c\",\"id\":86,\"name\":\"B\\u1ed9 b\\u00e0n gh\\u1ebf cao su th\\u00e2n thi\\u1ec7n m\\u00f4i tr\\u01b0\\u1eddng cao c\\u1ea5p\",\"qty\":1,\"price\":1515000,\"options\":{\"thumb_main\":\"uploads\\/sp11-main.jpg\",\"slug\":\"bo-ban-ghe-cao-su-than-thien-moi-truong-cao-cap\",\"code\":\"TQ#86\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"1515000.00\"},\"a417d8bef405b9f418cc47ffd4eee4f4\":{\"rowId\":\"a417d8bef405b9f418cc47ffd4eee4f4\",\"id\":85,\"name\":\"B\\u1ed9 b\\u00e0n gh\\u1ebf l\\u1ed1p xe t\\u00e1i ch\\u1ebf cao c\\u1ea5p\",\"qty\":1,\"price\":840000,\"options\":{\"thumb_main\":\"uploads\\/sp11-detail2.jpg\",\"slug\":\"bo-ban-ghe-lop-xe-tai-che-cao-cap\",\"code\":\"TQ#85\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"840000.00\"}}',4,3090000,0,'bill-31005643',2,NULL,'2023-07-30 17:56:43','2023-07-30 18:00:23',NULL),(10,'Mầu KiỞu Trang','Xã Yên Giả - Huyện Quế Võ - Tỉnh Bắc Ninh','0868690603',NULL,'ferreteriahuincacara@gmail.com','{\"09a99bf06280e69eb6f21c98827ab14b\":{\"rowId\":\"09a99bf06280e69eb6f21c98827ab14b\",\"id\":76,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 - KTV24\",\"qty\":1,\"price\":2430000,\"options\":{\"thumb_main\":\"uploads\\/sp2-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-ktv24\",\"code\":\"TQ#76\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"2430000.00\"}}',1,2430000,0,'bill-31012341',3,NULL,'2023-07-30 18:23:41','2023-12-16 08:09:02',NULL),(11,'Mầu KiỞu Tranggg','PhưỞng Khắc Niệm - Thành phố Bắc Ninh - Tỉnh Bắc Ninh','0868690603',NULL,'ferreteriahuincacara@gmail.com','{\"caee71a3d37b058d314bcda806168305\":{\"rowId\":\"caee71a3d37b058d314bcda806168305\",\"id\":89,\"name\":\"B\\u00c0N \\u0102N G\\u1ed6 B\\u00d4NG HI\\u1ec6N \\u0110\\u1ea0I TQ#16\",\"qty\":1,\"price\":900000,\"options\":{\"thumb_main\":\"uploads\\/sp14-main.jpg\",\"slug\":\"ban-an-cao-cap-tq16\",\"code\":\"TQ#89\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"900000.00\"}}',1,900000,0,'bill-31012419',2,NULL,'2023-07-30 18:24:19','2023-10-07 14:21:07',NULL),(12,'Phan Thanh Nhàn','PhưỞng Khắc Niệm - Thành phố Bắc Ninh - Tỉnh Bắc Ninh','0868690603',NULL,'Thanhnhan@gmail.com','{\"09a99bf06280e69eb6f21c98827ab14b\":{\"rowId\":\"09a99bf06280e69eb6f21c98827ab14b\",\"id\":76,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 - KTV24\",\"qty\":1,\"price\":2430000,\"options\":{\"thumb_main\":\"uploads\\/sp2-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-ktv24\",\"code\":\"TQ#76\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"2430000.00\"}}',1,2430000,0,'bill-31012711',2,NULL,'2023-07-30 18:27:11','2023-10-07 14:21:14',NULL),(13,'Phan Thanh Nhàn','Xã Chi Lăng Nam - Huyện Thanh Miện - Tỉnh Hải Dương','0943833031',NULL,'Thanhnhan@gmail.com','{\"09a99bf06280e69eb6f21c98827ab14b\":{\"rowId\":\"09a99bf06280e69eb6f21c98827ab14b\",\"id\":76,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 - KTV24\",\"qty\":1,\"price\":2430000,\"options\":{\"thumb_main\":\"uploads\\/sp2-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-ktv24\",\"code\":\"TQ#76\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"2430000.00\"}}',1,2430000,0,'bill-31012753',2,NULL,'2023-07-30 18:27:53','2023-10-07 14:21:20',NULL),(14,'Trần Hoàng','Xã Quang Minh - Huyện Gia Lộc - Tỉnh Hải Dương','0943833031',NULL,'tranhoang@gmail.com','{\"09a99bf06280e69eb6f21c98827ab14b\":{\"rowId\":\"09a99bf06280e69eb6f21c98827ab14b\",\"id\":76,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 - KTV24\",\"qty\":1,\"price\":2430000,\"options\":{\"thumb_main\":\"uploads\\/sp2-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-ktv24\",\"code\":\"TQ#76\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"2430000.00\"},\"718c4f5e60a0639a58f7b7ab45cc2dfc\":{\"rowId\":\"718c4f5e60a0639a58f7b7ab45cc2dfc\",\"id\":75,\"name\":\"KATINA K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 B\\u1eaeC \\u00c2U - KTV37\",\"qty\":1,\"price\":6100000,\"options\":{\"thumb_main\":\"uploads\\/sp1-main.jpg\",\"slug\":\"katina-ke-ti-vi-ket-hop-ban-tra-bac-au-ktv37\",\"code\":\"TQ#75\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"6100000.00\"},\"528e36b718f267ac25c3b03e8137d6db\":{\"rowId\":\"528e36b718f267ac25c3b03e8137d6db\",\"id\":77,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 CAO C\\u1ea4P G\\u1ed6 T\\u00c1I CH\\u1ebe\",\"qty\":1,\"price\":3690000,\"options\":{\"thumb_main\":\"uploads\\/sp3-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-cao-cap-go-tai-che\",\"code\":\"TQ#77\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"3690000.00\"},\"1fe1f4ef8e280ffd3e674e8f913e43ce\":{\"rowId\":\"1fe1f4ef8e280ffd3e674e8f913e43ce\",\"id\":80,\"name\":\"T\\u1ee6 KH\\u1eec TR\\u00d9NG \\u1ea4M TR\\u00c0 - PKT09\",\"qty\":1,\"price\":11200000,\"options\":{\"thumb_main\":\"uploads\\/sp6-main.jpg\",\"slug\":\"tu-khu-trung-am-tra-pkt09\",\"code\":\"TQ#80\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"11200000.00\"},\"758a077038c74a84f603c1e7a5b432ba\":{\"rowId\":\"758a077038c74a84f603c1e7a5b432ba\",\"id\":78,\"name\":\"JONDA BAC45 - B\\u00c0N \\u0102N G\\u1ed6 \\u00c9P CAO C\\u1ea4P\",\"qty\":1,\"price\":12375000,\"options\":{\"thumb_main\":\"uploads\\/sp4-main.jpg\",\"slug\":\"jonda-bac45-ban-an-go-ep\",\"code\":\"TQ#78\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"12375000.00\"}}',5,35795000,0,'bill-31013351',1,NULL,'2023-07-30 18:33:51','2023-10-07 14:21:28',NULL),(15,'Lê Quang Thắng','PhưỞng Sông Ğà - Thị Xã MưỞng Lay - Tỉnh Ğiện Biên','0375284572',NULL,'quangthang@gmail.com','{\"09a99bf06280e69eb6f21c98827ab14b\":{\"rowId\":\"09a99bf06280e69eb6f21c98827ab14b\",\"id\":76,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 - KTV24\",\"qty\":1,\"price\":2430000,\"options\":{\"thumb_main\":\"uploads\\/sp2-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-ktv24\",\"code\":\"TQ#76\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"2430000.00\"}}',1,2430000,0,'bill-31014720',1,NULL,'2023-07-30 18:47:20','2023-12-16 07:47:44',NULL),(24,'Nguyễn Thị Mai','Xã Hồng Phong - Huyện Ninh Giang - Tỉnh Hải Dương','0375284572',NULL,'quytran52003@gmail.com','{\"a417d8bef405b9f418cc47ffd4eee4f4\":{\"rowId\":\"a417d8bef405b9f418cc47ffd4eee4f4\",\"id\":85,\"name\":\"B\\u1ed9 b\\u00e0n gh\\u1ebf l\\u1ed1p xe t\\u00e1i ch\\u1ebf cao c\\u1ea5p\",\"qty\":\"4\",\"price\":840000,\"options\":{\"thumb_main\":\"uploads\\/sp11-detail2.jpg\",\"slug\":\"bo-ban-ghe-lop-xe-tai-che-cao-cap\",\"code\":\"TQ#85\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"3360000.00\"},\"6b5dce214a53df3a1085ba99d4df856c\":{\"rowId\":\"6b5dce214a53df3a1085ba99d4df856c\",\"id\":86,\"name\":\"B\\u1ed9 b\\u00e0n gh\\u1ebf cao su th\\u00e2n thi\\u1ec7n m\\u00f4i tr\\u01b0\\u1eddng cao c\\u1ea5p\",\"qty\":1,\"price\":1515000,\"options\":{\"thumb_main\":\"uploads\\/sp11-main.jpg\",\"slug\":\"bo-ban-ghe-cao-su-than-thien-moi-truong-cao-cap\",\"code\":\"TQ#86\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"1515000.00\"},\"99f2cbff876fc69748cc61039ee00cdb\":{\"rowId\":\"99f2cbff876fc69748cc61039ee00cdb\",\"id\":87,\"name\":\"X\\u00edch \\u0111u s\\u00e2n v\\u01b0\\u1eddn th\\u1eddi trang cao su t\\u00e1i ch\\u1ebf\",\"qty\":1,\"price\":600000,\"options\":{\"thumb_main\":\"uploads\\/sp12-detail2.jpg\",\"slug\":\"xich-du-san-vuon-thoi-trang\",\"code\":\"TQ#87\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"600000.00\"},\"7aae4bc8e21d329345affc2cba35b6a4\":{\"rowId\":\"7aae4bc8e21d329345affc2cba35b6a4\",\"id\":88,\"name\":\"C\\u00e2y Xanh T\\u1eeb Chai Nh\\u1ef1a \\u0110\\u1ed3 Trang Tr\\u00ed\",\"qty\":1,\"price\":135000,\"options\":{\"thumb_main\":\"uploads\\/sp13-main.jpg\",\"slug\":\"cach-lam-cay-xanh-tu-chai-nhua\",\"code\":\"TQ#88\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"135000.00\"}}',7,5610000,0,'bill-01161502',0,NULL,'2023-08-01 09:15:05','2023-08-01 09:15:05',NULL),(25,'Nguyễn Hoài Anh','Xã Sơn Ğồng - Huyện Hoài Ğức - Thành phố Hà Nội - Số 152','0375284572','Giao hàng nhanh nha shop','tranquy52003@gmail.com','{\"09a99bf06280e69eb6f21c98827ab14b\":{\"rowId\":\"09a99bf06280e69eb6f21c98827ab14b\",\"id\":76,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 - KTV24\",\"qty\":1,\"price\":2430000,\"options\":{\"thumb_main\":\"uploads\\/sp2-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-ktv24\",\"code\":\"TQ#76\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"2430000.00\"}}',1,2430000,0,'bill-17184423',0,NULL,'2023-12-17 11:44:27','2023-12-17 11:44:27',NULL),(26,'Trần Quý','PhưỞng Hạp Lĩnh - Thành phố Bắc Ninh - Tỉnh Bắc Ninh','0375284572',NULL,'tranquy52003@gmail.com','{\"6b5dce214a53df3a1085ba99d4df856c\":{\"rowId\":\"6b5dce214a53df3a1085ba99d4df856c\",\"id\":86,\"name\":\"B\\u1ed9 b\\u00e0n gh\\u1ebf cao su th\\u00e2n thi\\u1ec7n m\\u00f4i tr\\u01b0\\u1eddng cao c\\u1ea5p\",\"qty\":1,\"price\":1515000,\"options\":{\"thumb_main\":\"uploads\\/sp11-main.jpg\",\"slug\":\"bo-ban-ghe-cao-su-than-thien-moi-truong-cao-cap\",\"code\":\"TQ#86\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"1515000.00\"}}',1,1515000,1,'bill-27204655',0,NULL,'2023-12-27 13:46:58','2023-12-27 13:46:58',NULL),(27,'Trần Quý','PhưỞng Hoàng Quế - Thị xã Ğông TriỞu - Tỉnh Quảng Ninh','+84375284572',NULL,'quytran52003@gmail.com','{\"7aae4bc8e21d329345affc2cba35b6a4\":{\"rowId\":\"7aae4bc8e21d329345affc2cba35b6a4\",\"id\":88,\"name\":\"C\\u00e2y Xanh T\\u1eeb Chai Nh\\u1ef1a \\u0110\\u1ed3 Trang Tr\\u00ed\",\"qty\":1,\"price\":135000,\"options\":{\"thumb_main\":\"uploads\\/sp13-main.jpg\",\"slug\":\"cach-lam-cay-xanh-tu-chai-nhua\",\"code\":\"TQ#88\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"135000.00\"}}',1,135000,0,'bill-03110648',0,NULL,'2024-01-03 04:06:51','2024-01-03 04:06:51',NULL),(28,'Trần Quý','PhưỞng Trúc Bạch - Quận Ba Ğình - Thành phố Hà Nội','+84375284572',NULL,'tranquy52003@gmail.com','{\"a417d8bef405b9f418cc47ffd4eee4f4\":{\"rowId\":\"a417d8bef405b9f418cc47ffd4eee4f4\",\"id\":85,\"name\":\"B\\u1ed9 b\\u00e0n gh\\u1ebf l\\u1ed1p xe t\\u00e1i ch\\u1ebf cao c\\u1ea5p\",\"qty\":1,\"price\":840000,\"options\":{\"thumb_main\":\"uploads\\/sp11-detail2.jpg\",\"slug\":\"bo-ban-ghe-lop-xe-tai-che-cao-cap\",\"code\":\"TQ#85\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"840000.00\"},\"99f2cbff876fc69748cc61039ee00cdb\":{\"rowId\":\"99f2cbff876fc69748cc61039ee00cdb\",\"id\":87,\"name\":\"X\\u00edch \\u0111u s\\u00e2n v\\u01b0\\u1eddn th\\u1eddi trang cao su t\\u00e1i ch\\u1ebf\",\"qty\":\"4\",\"price\":600000,\"options\":{\"thumb_main\":\"uploads\\/sp12-detail2.jpg\",\"slug\":\"xich-du-san-vuon-thoi-trang\",\"code\":\"TQ#87\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"2400000.00\"},\"7aae4bc8e21d329345affc2cba35b6a4\":{\"rowId\":\"7aae4bc8e21d329345affc2cba35b6a4\",\"id\":88,\"name\":\"C\\u00e2y Xanh T\\u1eeb Chai Nh\\u1ef1a \\u0110\\u1ed3 Trang Tr\\u00ed\",\"qty\":1,\"price\":135000,\"options\":{\"thumb_main\":\"uploads\\/sp13-main.jpg\",\"slug\":\"cach-lam-cay-xanh-tu-chai-nhua\",\"code\":\"TQ#88\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"135000.00\"}}',6,3375000,0,'bill-12114344',2,NULL,'2024-01-12 04:43:48','2024-01-12 05:31:56',NULL),(29,'Trần Quý','PhưỞng Nam Ğồng - Thành phố Hải Dương - Tỉnh Hải Dương','+84375284572',NULL,'tranquy52003@gmail.com','{\"6b5dce214a53df3a1085ba99d4df856c\":{\"rowId\":\"6b5dce214a53df3a1085ba99d4df856c\",\"id\":86,\"name\":\"B\\u1ed9 b\\u00e0n gh\\u1ebf cao su th\\u00e2n thi\\u1ec7n m\\u00f4i tr\\u01b0\\u1eddng cao c\\u1ea5p\",\"qty\":1,\"price\":1515000,\"options\":{\"thumb_main\":\"uploads\\/sp11-main.jpg\",\"slug\":\"bo-ban-ghe-cao-su-than-thien-moi-truong-cao-cap\",\"code\":\"TQ#86\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"1515000.00\"},\"528e36b718f267ac25c3b03e8137d6db\":{\"rowId\":\"528e36b718f267ac25c3b03e8137d6db\",\"id\":77,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 CAO C\\u1ea4P G\\u1ed6 T\\u00c1I CH\\u1ebe\",\"qty\":1,\"price\":3690000,\"options\":{\"thumb_main\":\"uploads\\/sp3-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-cao-cap-go-tai-che\",\"code\":\"TQ#77\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"3690000.00\"}}',2,5205000,1,'bill-13162647',0,NULL,'2024-01-13 09:26:51','2024-01-13 09:26:51',NULL),(30,'Trần Quý','PhưỞng Þi Quốc - Thành phố Hải Dương - Tỉnh Hải Dương','+84375284572',NULL,'tranquy52003@gmail.com','{\"6b5dce214a53df3a1085ba99d4df856c\":{\"rowId\":\"6b5dce214a53df3a1085ba99d4df856c\",\"id\":86,\"name\":\"B\\u1ed9 b\\u00e0n gh\\u1ebf cao su th\\u00e2n thi\\u1ec7n m\\u00f4i tr\\u01b0\\u1eddng cao c\\u1ea5p\",\"qty\":1,\"price\":1515000,\"options\":{\"thumb_main\":\"uploads\\/sp11-main.jpg\",\"slug\":\"bo-ban-ghe-cao-su-than-thien-moi-truong-cao-cap\",\"code\":\"TQ#86\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"1515000.00\"},\"528e36b718f267ac25c3b03e8137d6db\":{\"rowId\":\"528e36b718f267ac25c3b03e8137d6db\",\"id\":77,\"name\":\"K\\u1ec6 TI VI K\\u1ebeT H\\u1ee2P B\\u00c0N TR\\u00c0 CAO C\\u1ea4P G\\u1ed6 T\\u00c1I CH\\u1ebe\",\"qty\":1,\"price\":3690000,\"options\":{\"thumb_main\":\"uploads\\/sp3-main.jpg\",\"slug\":\"ke-ti-vi-ket-hop-ban-tra-cao-cap-go-tai-che\",\"code\":\"TQ#77\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"3690000.00\"}}',2,5205000,0,'bill-13162749',0,NULL,'2024-01-13 09:27:52','2024-01-13 09:27:52',NULL),(31,'Trần Quý','PhưỞng Khắc Niệm - Thành phố Bắc Ninh - Tỉnh Bắc Ninh','+84375284572',NULL,'tranquy52003@gmail.com','{\"99f2cbff876fc69748cc61039ee00cdb\":{\"rowId\":\"99f2cbff876fc69748cc61039ee00cdb\",\"id\":87,\"name\":\"X\\u00edch \\u0111u s\\u00e2n v\\u01b0\\u1eddn th\\u1eddi trang cao su t\\u00e1i ch\\u1ebf\",\"qty\":1,\"price\":600000,\"options\":{\"thumb_main\":\"uploads\\/sp12-detail2.jpg\",\"slug\":\"xich-du-san-vuon-thoi-trang\",\"code\":\"TQ#87\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"600000.00\"}}',1,600000,0,'bill-13162929',0,NULL,'2024-01-13 09:29:33','2024-01-13 09:29:33',NULL),(32,'Trần Quý','PhưỞng Liên Bảo - Thành phố Vĩnh Yên - Tỉnh Vĩnh Phúc','+84375284572',NULL,'tranquy52003@gmail.com','{\"99f2cbff876fc69748cc61039ee00cdb\":{\"rowId\":\"99f2cbff876fc69748cc61039ee00cdb\",\"id\":87,\"name\":\"X\\u00edch \\u0111u s\\u00e2n v\\u01b0\\u1eddn th\\u1eddi trang cao su t\\u00e1i ch\\u1ebf\",\"qty\":1,\"price\":600000,\"options\":{\"thumb_main\":\"uploads\\/sp12-detail2.jpg\",\"slug\":\"xich-du-san-vuon-thoi-trang\",\"code\":\"TQ#87\"},\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"600000.00\"}}',1,600000,0,'bill-21140415',0,NULL,'2024-01-21 07:04:21','2024-01-21 07:04:21',NULL),(33,'Tran Trung Hanh','PhưỞng Phúc Xá - Quận Ba Ğình - Thành phố Hà Nội - 3','0332029410',NULL,'info@campuslearning.online','{\"f0b8b1e63b14ce43e3fa4b65c828b880\":{\"rowId\":\"f0b8b1e63b14ce43e3fa4b65c828b880\",\"id\":79,\"name\":\"T\\u1ee6 B\\u1ebeP ACRYLIC HI\\u1ec6N \\u0110\\u1ea0I - TB06\",\"qty\":1,\"price\":2560000,\"options\":{\"thumb_main\":\"uploads\\/sp5-main.jpg\",\"slug\":\"tu-bep-acrylic-hien-dai-tb06\",\"code\":\"TQ#79\"},\"tax\":\"537600.00\",\"isSaved\":false,\"subtotal\":\"2560000.00\"}}',1,3097600,1,'bill-16230131',0,NULL,'2026-05-16 23:01:36','2026-05-16 23:01:36',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_creator_foreign` (`creator`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (5,'Giới thiệu','gioi-thieu','<p style=\"text-align: center;\"><strong>Chào mừng bạn đến vá»›i Cris Store - Thiên đưỞng giày đá bóng chính hãng. Chúng tôi cung cấp các loại giày đá bóng từ những thương hiệu hàng đầu như Nike, Adidas, Puma... vá»›i cam kết chất lượng tốt nhất và giá cả cạnh tranh.</strong></p>',22,1,'2023-07-02 09:48:10','2023-07-25 18:43:14','Giá»›i thiệu vỞ Cris Store'),(6,'Liên hệ','lien-he','<p style=\"text-align: center;\"><strong>Nếu bạn có bất kỳ câu hỞi nào vỞ sản phẩm giày đá bóng, hãy liên hệ vá»›i chúng tôi qua số Ä'iện thoại 0375284572 hoặc email admin@crisstore.com. Chúng tôi luôn sẵn lòng lắng nghe và há»— trợ bạn.</strong></p>',22,1,'2023-07-02 10:07:27','2023-07-27 06:43:06','Liên hệ vá»›i Cris Store');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (22,'➻➥ Thêm giày đá bóng','product.add',NULL,'2023-06-09 06:53:17','2026-05-20 06:21:56'),(24,'➻➥ Cập nhật tin tức giày','post.update',NULL,'2023-06-09 06:54:51','2026-05-20 06:21:56'),(25,'➻➥ Thêm quản trị','user.add',NULL,'2023-06-09 07:52:49','2026-05-20 06:21:56'),(27,'➻➥ Cập nhật giày đá bóng','product.update',NULL,'2023-06-09 07:58:52','2026-05-20 06:21:56'),(28,'➻➥ Xóa tin tức giày','post.delete',NULL,'2023-06-09 10:01:17','2026-05-20 06:21:56'),(29,'➻➥ Xóa quản trị','user.delete',NULL,'2023-06-10 00:37:47','2026-05-20 06:21:56'),(30,'➻➥ Cập nhật quản trị','user.update',NULL,'2023-06-10 00:43:46','2026-05-20 06:21:56'),(32,'➻➥ Thêm tin tức giày','post.add',NULL,'2023-06-10 00:44:57','2026-05-20 06:21:56'),(33,'➻➥ Xóa giày đá bóng','product.delete',NULL,'2023-06-10 00:45:17','2026-05-20 06:21:56'),(35,'➻➥ Xem giày đá bóng','product.view',NULL,'2023-06-13 08:12:51','2026-05-20 06:21:56'),(36,'➻➥ Xem tin tức giày','post.view',NULL,'2023-06-13 08:13:12','2026-05-20 06:21:56'),(37,'➻➥ Xem quản trị','user.view',NULL,'2023-06-13 08:13:51','2026-05-20 06:21:56'),(39,'➻➥ Thêm vai trò','role.add',NULL,'2023-06-13 08:14:45','2026-05-20 06:21:56'),(40,'➻➥ Sửa vai trò','role.update',NULL,'2023-06-13 08:15:07','2026-05-20 06:21:56'),(41,'➻➥ Xóa vai trò','role.delete',NULL,'2023-06-13 08:15:24','2026-05-20 06:21:56'),(42,'➻➥ Thêm quyỞn','permission.add',NULL,'2023-06-13 08:38:42','2026-05-20 06:21:56'),(43,'➻➥ Cập nhật quyỞn','permission.update',NULL,'2023-06-17 05:49:13','2026-05-20 06:21:56'),(44,'➻➥ Xóa quyỞn','permission.delete',NULL,'2023-06-17 05:50:04','2026-05-20 06:21:56'),(47,'➻➥ Xem quyỞn','permission.view',NULL,'2023-06-29 16:54:12','2026-05-20 06:21:56'),(48,'➻➥ Thêm slider','slider.add',NULL,'2023-06-29 16:54:37','2026-05-20 06:21:56'),(49,'➻➥ Cập nhật slider','slider.update',NULL,'2023-06-29 16:55:05','2026-05-20 06:21:56'),(50,'➻➥ Xóa slider','slider.delete',NULL,'2023-06-29 16:55:23','2026-05-20 06:21:56'),(51,'➻➥ Xem slider','slider.view',NULL,'2023-06-29 16:55:50','2026-05-20 06:21:56'),(52,'➻➥ Thêm banner','banner.add',NULL,'2023-06-29 16:56:24','2026-05-20 06:21:56'),(53,'➻➥ Cập nhật banner','banner.update',NULL,'2023-06-29 16:56:39','2026-05-20 06:21:56'),(54,'➻➥ Xóa banner','banner.delete',NULL,'2023-06-29 16:56:51','2026-05-20 06:21:56'),(55,'➻➥ Xem banner','banner.view',NULL,'2023-06-29 16:57:02','2026-05-20 06:21:56'),(56,'➻➥ Xem vai trò','role.view',NULL,'2023-07-01 11:23:55','2026-05-20 06:21:56'),(57,'➻➥ Thêm trang','page.add',NULL,'2023-07-01 17:23:33','2026-05-20 06:21:56'),(58,'➻➥ Sửa trang','page.update',NULL,'2023-07-01 17:24:06','2026-05-20 06:21:56'),(59,'➻➥ Xóa trang','page.delete',NULL,'2023-07-01 17:24:23','2026-05-20 06:21:56'),(60,'➻➥ Xem trang','page.view',NULL,'2023-07-01 17:24:34','2026-05-20 06:21:56'),(61,'➻➥ Thêm tin tức giày','blog.add',NULL,'2023-07-01 17:24:52','2026-05-20 06:21:56'),(62,'➻➥ Sửa tin tức giày','blog.update',NULL,'2023-07-01 17:25:03','2026-05-20 06:21:56'),(63,'➻➥ Xóa tin tức giày','blog.delete',NULL,'2023-07-01 17:25:12','2026-05-20 06:21:56'),(64,'➻➥ Xem tin tức giày','blog.view',NULL,'2023-07-01 17:25:22','2026-05-20 06:21:56'),(65,'➻➥ Xem đơn giày','order.view',NULL,'2023-07-16 17:14:28','2026-05-20 06:21:56'),(66,'➻➥ Cập nhật đơn giày','order.update',NULL,'2023-07-16 17:15:00','2026-05-20 06:21:56'),(67,'➻➥ Xóa đơn giày','order.delete',NULL,'2023-07-17 19:03:56','2026-05-20 06:21:56');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\User',41,'admin-token','8b45205a9ba04e8b59aacc84fd2f5206298d0baa904ae2b79aa25a73fcdf4fd7','[\"*\"]',NULL,'2026-05-20 05:42:27','2026-05-20 05:42:27'),(2,'App\\User',41,'admin-token','4e89bc8578cb19a7420526eb0797350eee8c0323b7e309a860f66c0b2118b68f','[\"*\"]',NULL,'2026-05-20 05:44:34','2026-05-20 05:44:34'),(3,'App\\User',41,'admin-token','3059dcda272d9695236ca176d449465f653988e75cff9a1ce98f6c0ae851bbd4','[\"*\"]',NULL,'2026-05-20 05:46:30','2026-05-20 05:46:30'),(4,'App\\User',41,'admin-token','dc79276363cd58d15e25d108cf418a476a2bb8a5509091134aee4060961c685c','[\"*\"]',NULL,'2026-05-20 05:48:33','2026-05-20 05:48:33'),(5,'App\\User',41,'user-token','60cffa1452453db7b9adfc771990c67fef2e0c4835da4861cc320848bf22dc94','[\"*\"]',NULL,'2026-05-20 05:56:11','2026-05-20 05:56:11'),(6,'App\\User',41,'user-token','bbdde6e2514ea772046898f8c78320273d86dd1fa47be7d15b6ce814ae47975a','[\"*\"]',NULL,'2026-05-20 06:14:23','2026-05-20 06:14:23');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_color`
--

DROP TABLE IF EXISTS `product_color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_color` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `color_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_color_product_id_foreign` (`product_id`),
  KEY `product_color_color_id_foreign` (`color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_color`
--

LOCK TABLES `product_color` WRITE;
/*!40000 ALTER TABLE `product_color` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_config`
--

DROP TABLE IF EXISTS `product_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_config` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `config_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_config_product_id_foreign` (`product_id`),
  KEY `product_config_config_id_foreign` (`config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_config`
--

LOCK TABLES `product_config` WRITE;
/*!40000 ALTER TABLE `product_config` DISABLE KEYS */;
INSERT INTO `product_config` VALUES (1,1,4,NULL,NULL,1890000),(2,1,5,NULL,NULL,1890000),(3,1,6,NULL,NULL,1890000),(4,2,4,NULL,NULL,1850000),(5,2,5,NULL,NULL,1850000),(6,2,6,NULL,NULL,1850000);
/*!40000 ALTER TABLE `product_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_quick` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `desc_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thumb_main` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb_detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` bigint unsigned NOT NULL,
  `discount` decimal(5,0) DEFAULT NULL,
  `amount` int NOT NULL,
  `old_price` decimal(10,0) NOT NULL DEFAULT '0',
  `new_price` decimal(10,0) NOT NULL DEFAULT '0',
  `cat_id` bigint unsigned NOT NULL,
  `featured_products` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int NOT NULL DEFAULT '0',
  `purchases` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_creator_foreign` (`creator`),
  KEY `products_cat_id_foreign` (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Nike Mercurial Vapor 15 Academy TF','NIKE-MV15','Giày đá bóng sân cỞ nhân tạo cao cấp','Mẫu giày tốc độ mới nhất từ Nike với bộ đệm Zoom Air.','uploads/nike-vapor-15.jpg','[]',41,10,50,2100000,1890000,1,1,1,'2026-05-19 23:24:37','2026-05-19 23:24:37','nike-mercurial-vapor-15-tf',0,0,NULL),(2,'Adidas X Crazyfast .3 TF','ADI-XC3','Giày đá bóng siêu nhẹ cho tiỞn đạo','Thiết kế khí động hỞc giúp bứt tốc tối đa trên sân cỞ nhân tạo.','uploads/adidas-x-crazyfast.jpg','[]',41,5,40,1950000,1850000,2,1,1,'2026-05-19 23:24:37','2026-05-19 23:24:37','adidas-x-crazyfast-3-tf',0,0,NULL),(3,'Puma Future Ultimate FG/AG','PUMA-FULT','Giày đá bóng sân cỞ tự nhiên chuyên nghiệp','Công nghệ FUZIONFIT+ giúp ôm chân hoàn hảo.','uploads/puma-future.jpg','[]',41,0,30,4500000,4500000,3,0,1,'2026-05-19 23:24:37','2026-05-19 23:24:37','puma-future-ultimate-fg-ag',0,0,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_category`
--

DROP TABLE IF EXISTS `promotion_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotion_category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `promotion_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promotion_category_promotion_id_foreign` (`promotion_id`),
  KEY `promotion_category_category_id_foreign` (`category_id`),
  CONSTRAINT `promotion_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `cat_products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotion_category_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_category`
--

LOCK TABLES `promotion_category` WRITE;
/*!40000 ALTER TABLE `promotion_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotion_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_product`
--

DROP TABLE IF EXISTS `promotion_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotion_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `promotion_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promotion_product_promotion_id_foreign` (`promotion_id`),
  KEY `promotion_product_product_id_foreign` (`product_id`),
  CONSTRAINT `promotion_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotion_product_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_product`
--

LOCK TABLES `promotion_product` WRITE;
/*!40000 ALTER TABLE `promotion_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotion_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_subscribers`
--

DROP TABLE IF EXISTS `promotion_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotion_subscribers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_subscribers`
--

LOCK TABLES `promotion_subscribers` WRITE;
/*!40000 ALTER TABLE `promotion_subscribers` DISABLE KEYS */;
INSERT INTO `promotion_subscribers` VALUES (1,'Test User','test@example.com','0909123456',1,'2026-05-19 17:56:18','2026-05-19 17:56:18');
/*!40000 ALTER TABLE `promotion_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `discount_percent` tinyint unsigned NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promotions_slug_unique` (`slug`),
  KEY `promotions_creator_foreign` (`creator`),
  CONSTRAINT `promotions_creator_foreign` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotions`
--

LOCK TABLES `promotions` WRITE;
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permission` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_permission_role_id_foreign` (`role_id`),
  KEY `role_permission_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permission`
--

LOCK TABLES `role_permission` WRITE;
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
INSERT INTO `role_permission` VALUES (3,16,27,NULL,NULL),(4,16,33,NULL,NULL),(5,16,24,NULL,NULL),(6,16,28,NULL,NULL),(7,16,32,NULL,NULL),(11,17,24,NULL,NULL),(12,17,28,NULL,NULL),(14,18,22,NULL,NULL),(15,18,27,NULL,NULL),(16,18,33,NULL,NULL),(20,16,24,NULL,NULL),(21,16,28,NULL,NULL),(22,16,32,NULL,NULL),(27,16,27,NULL,NULL),(28,16,33,NULL,NULL),(29,16,24,NULL,NULL),(30,16,28,NULL,NULL),(31,16,32,NULL,NULL),(36,16,27,NULL,NULL),(37,16,33,NULL,NULL),(38,16,24,NULL,NULL),(39,16,28,NULL,NULL),(40,16,32,NULL,NULL),(45,16,27,NULL,NULL),(46,16,33,NULL,NULL),(47,16,24,NULL,NULL),(48,16,28,NULL,NULL),(49,16,32,NULL,NULL),(53,16,27,NULL,NULL),(54,16,33,NULL,NULL),(55,16,24,NULL,NULL),(56,16,28,NULL,NULL),(57,16,32,NULL,NULL),(61,17,32,NULL,NULL),(65,16,22,NULL,NULL),(67,16,35,NULL,NULL),(68,16,36,NULL,NULL),(86,17,36,NULL,NULL),(87,18,35,NULL,NULL),(89,16,25,NULL,NULL),(90,16,29,NULL,NULL),(91,16,30,NULL,NULL),(92,16,37,NULL,NULL),(94,16,43,NULL,NULL),(96,16,39,NULL,NULL),(97,16,40,NULL,NULL),(98,16,41,NULL,NULL),(99,16,42,NULL,NULL),(100,21,35,NULL,NULL),(101,21,36,NULL,NULL),(102,21,37,NULL,NULL),(105,16,44,NULL,NULL),(106,16,48,NULL,NULL),(107,16,49,NULL,NULL),(108,16,50,NULL,NULL),(109,16,51,NULL,NULL),(110,16,52,NULL,NULL),(111,16,53,NULL,NULL),(112,16,54,NULL,NULL),(113,16,55,NULL,NULL),(114,16,47,NULL,NULL),(115,21,47,NULL,NULL),(116,21,51,NULL,NULL),(117,21,55,NULL,NULL),(118,16,56,NULL,NULL),(119,16,57,NULL,NULL),(120,16,58,NULL,NULL),(121,16,59,NULL,NULL),(122,16,60,NULL,NULL),(123,16,61,NULL,NULL),(124,16,62,NULL,NULL),(125,16,63,NULL,NULL),(126,16,64,NULL,NULL),(127,16,65,NULL,NULL),(128,16,66,NULL,NULL),(129,21,60,NULL,NULL),(130,21,64,NULL,NULL),(131,21,65,NULL,NULL),(132,16,67,NULL,NULL),(133,19,65,NULL,NULL),(134,19,66,NULL,NULL),(135,19,67,NULL,NULL),(146,21,56,NULL,NULL),(147,21,66,NULL,NULL),(149,21,62,NULL,NULL);
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (16,'admin','Quản lý toàn quyỞn trên hệ thống','2023-07-19 18:06:24','2023-07-18 06:49:36'),(17,'Post manager','Quản lý bài viết','2023-07-19 18:06:44','2023-06-19 15:34:50'),(18,'Product manager','Quản lý sản phẩm','2023-07-19 18:06:50','2023-06-19 15:34:57'),(19,'Sale manager','Quản lý bán hàng','2023-07-19 18:07:56','2023-06-19 15:35:10'),(21,'Reviewer','Xem ứng dụng','2023-07-19 18:08:24','2023-06-17 09:33:42');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb_slider` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `sort` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sliders_creator_foreign` (`creator`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (8,'Slider 1','#','uploads/slider4.jpg',22,1,'2023-07-26 07:24:15','2023-07-26 07:24:15',1,NULL),(9,'Slider 2','#','uploads/slider2.jpg',22,2,'2023-07-26 07:24:32','2023-07-26 07:24:32',1,NULL),(10,'Slider 3','#','uploads/slider1.jpg',22,3,'2023-07-26 07:24:45','2023-07-26 07:24:45',1,NULL),(11,'Slider 4','#','uploads/slider3.jpg',22,4,'2023-07-26 07:25:31','2023-07-26 07:25:31',1,NULL);
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_gift`
--

DROP TABLE IF EXISTS `user_gift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_gift` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `gift_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `codeGift` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_gift_user_id_foreign` (`user_id`),
  KEY `user_gift_gift_id_foreign` (`gift_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_gift`
--

LOCK TABLES `user_gift` WRITE;
/*!40000 ALTER TABLE `user_gift` DISABLE KEYS */;
INSERT INTO `user_gift` VALUES (2,30,3,1,'TQ#27154456',NULL,'2023-07-27 08:48:09'),(3,30,1,1,'TQ#27155707',NULL,'2023-07-28 11:19:13'),(10,30,1,0,'TQ#31141059',NULL,NULL),(11,30,1,0,'TQ#31141755',NULL,NULL),(12,30,1,0,'TQ#31141809',NULL,NULL),(13,30,1,0,'TQ#31141816',NULL,NULL);
/*!40000 ALTER TABLE `user_gift` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_role` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (22,22,16,NULL,NULL),(38,35,21,NULL,NULL),(39,41,16,NULL,NULL),(40,42,16,NULL,NULL);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `points` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `group_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_group_id_foreign` (`group_id`),
  CONSTRAINT `users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `customer_groups` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (22,'Trần Quang Quý','tranquy52003@gmail.com',NULL,NULL,'$2y$10$2UPAnALTaereaNopqZwAge0FxaEUlB//kilTBAYKujMwkTc5SF8KO','2023-07-20 08:22:42','2024-01-03 01:23:00',NULL,'DevQuy1509',1,'0',NULL),(30,'Nguyễn Viết Nam',NULL,NULL,NULL,'$2y$10$6r5m5goiplSWDbQG8HoAs.etLnlr05Jlv9mufX6iEh1/BMdDtx7q2','2023-07-26 14:02:33','2026-05-20 06:20:37','2026-05-20 06:20:37','Namnguyen',0,'53000',NULL),(32,'Trần Quang Kiên',NULL,NULL,NULL,'$2y$10$h73.DWVg8X/otCxKyukTceAcn0MUZ/4ybuIAi47juDllvd.qpe2eK','2023-07-30 17:02:11','2023-07-30 17:02:11',NULL,'Quangkien',0,'0',NULL),(33,'Nguyễn Viết Tùng',NULL,NULL,NULL,'$2y$10$gIWTSJqQfWBmt5US53AU.OxDjGv8Kk3giPSIMDyMctI/jqNZSmuFu','2023-07-30 18:48:36','2023-07-30 18:48:36',NULL,'Tungbengzz',0,'0',NULL),(34,'Trần Quang Quý',NULL,NULL,NULL,'$2y$10$J8VjDvH/MmrXVj/PsKyyOuYSVN1D6lsOG1SxXdwjW7jD4ppaqkCZq','2023-12-18 17:55:16','2023-12-18 17:55:16',NULL,'Quycute2003',0,'0',NULL),(35,'Reviewer','quytran52003@gmail.com',NULL,NULL,'$2y$10$QZWdGsibPhsbLW4IEo9Oc.6yH1RzRYfOkvW5aF6Am0SzUJLwu1B1a','2024-01-03 01:19:54','2024-01-03 01:19:54',NULL,'Reviewer',1,'0',NULL),(36,'admin','admin@cris-store.com',NULL,NULL,'\\.eHpcrXKQvdd/fNowCdhuAIUt9HmicLEK','2026-05-20 00:11:48','2026-05-20 00:11:48',NULL,'admin',1,'0',NULL),(37,'admin','admin@cris-store.com',NULL,NULL,'\\.eHpcrXKQvdd/fNowCdhuAIUt9HmicLEK','2026-05-19 17:12:43','2026-05-19 17:12:43',NULL,'admin',1,'0',NULL),(39,'Administrator','admin@crisstore.com',NULL,NULL,'$2y$10$Hhaz2nPa/JgPNVuoW4WtqO8YklQEDBw/qX7aZhuOSDxTAou0HZ4ZK','2026-05-20 00:28:23','2026-05-20 06:25:45',NULL,'admin123',1,'0',NULL),(40,'Test User 2','test2@example.com','0909123456',NULL,'$2y$10$brLnfPx8bMW8.gGkgoVT/.QQUkxMkbtu0bi5.aIO.2.XgY12wsG1e','2026-05-20 00:57:31','2026-05-20 00:57:31',NULL,'testuser2',0,'0',NULL),(41,'Duc Quyen Admin','ducquyenbg123@gmail.com',NULL,NULL,'$2y$10$zM3X7020qCJpIDIywkLxhOKmXIp20TPL6DdoLoe/1IbaWGeYkXS.e','2026-05-20 05:25:20','2026-05-20 05:25:20',NULL,'ducquyentd999',1,'0',NULL),(42,'Van Quan',NULL,NULL,NULL,'$2y$10$dQAiO7.ADQS2FUSclBjv7OclZ4kHWAJLHawXbo9vJULv4Btiih9Hu','2026-06-16 00:00:00','2026-06-16 00:00:00',NULL,'Van Quan',1,'0',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-19 23:42:29
