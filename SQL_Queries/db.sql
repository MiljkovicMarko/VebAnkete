-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.31-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for vebankete
DROP DATABASE IF EXISTS `vebankete`;
CREATE DATABASE IF NOT EXISTS `vebankete` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;
USE `vebankete`;

-- Dumping structure for table vebankete.administrator
DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `administrator_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password_hash` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `admin_name` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `forename` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `surname` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`administrator_id`),
  UNIQUE KEY `uq_email` (`email`),
  UNIQUE KEY `uq_admin_name` (`admin_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table vebankete.administrator: ~0 rows (approximately)
DELETE FROM `administrator`;
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;
INSERT INTO `administrator` (`administrator_id`, `created_at`, `password_hash`, `email`, `admin_name`, `forename`, `surname`, `is_active`) VALUES
	(1, '2018-09-20 18:47:13', '$2y$10$4NhuE7KT1OFP/Gkkn3eyBuYMy8jxN2opbqr.pfobQZVqKkvK61Otm', 'marko.miljkovic.14@singimail.rs', 'admin', 'Marko', 'Miljković', 1);
/*!40000 ALTER TABLE `administrator` ENABLE KEYS */;

-- Dumping structure for table vebankete.administrator_login
DROP TABLE IF EXISTS `administrator_login`;
CREATE TABLE IF NOT EXISTS `administrator_login` (
  `administrator_login_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `administrator_id` int(11) unsigned NOT NULL,
  `ip_address` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`administrator_login_id`),
  KEY `administrator_id` (`administrator_id`),
  CONSTRAINT `fk_administrator_login_administrator_id` FOREIGN KEY (`administrator_id`) REFERENCES `administrator` (`administrator_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table vebankete.administrator_login: ~4 rows (approximately)
DELETE FROM `administrator_login`;
/*!40000 ALTER TABLE `administrator_login` DISABLE KEYS */;
INSERT INTO `administrator_login` (`administrator_login_id`, `administrator_id`, `ip_address`, `user_agent`, `login_at`) VALUES
	(1, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-24 07:12:33'),
	(2, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-25 16:21:26'),
	(3, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-25 16:59:52'),
	(4, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 21:04:48');
/*!40000 ALTER TABLE `administrator_login` ENABLE KEYS */;

-- Dumping structure for table vebankete.answer
DROP TABLE IF EXISTS `answer`;
CREATE TABLE IF NOT EXISTS `answer` (
  `answer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `answer_text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`answer_id`) USING BTREE,
  KEY `fk_answer_question_id` (`question_id`) USING BTREE,
  CONSTRAINT `fk_answer_question_id` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table vebankete.answer: ~69 rows (approximately)
DELETE FROM `answer`;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` (`answer_id`, `question_id`, `created_at`, `answer_text`, `is_active`) VALUES
	(1, 1, '2018-09-13 02:11:55', 'ne', 1),
	(2, 2, '2018-09-13 02:11:55', 'nigde', 1),
	(3, 3, '2018-09-13 02:11:55', 'nigde\r\nnigde\r\nnigde', 1),
	(4, 4, '2018-09-13 02:11:56', '10', 1),
	(5, 5, '2018-09-13 02:11:56', 'malo', 1),
	(6, 6, '2018-09-13 02:11:56', 'super', 1),
	(7, 1, '2018-09-13 02:13:11', 'da', 1),
	(8, 2, '2018-09-13 02:13:11', 'svuda', 1),
	(9, 3, '2018-09-13 02:13:12', 'svuda\r\nGrcka\r\nCg', 1),
	(10, 4, '2018-09-13 02:13:12', '5', 1),
	(11, 5, '2018-09-13 02:13:12', 'dosta', 1),
	(12, 6, '2018-09-13 02:13:12', 'dobar', 1),
	(13, 10, '2018-09-13 02:21:58', 'Kabriolete, dzipove i juga!\r\nI sve Nemacke.', 1),
	(14, 11, '2018-09-13 02:21:58', 'brzina', 1),
	(15, 10, '2018-09-17 20:59:01', 'Dzipove', 1),
	(16, 11, '2018-09-17 20:59:01', 'bezbednost', 1),
	(17, 1, '2018-09-17 22:47:37', 'da', 1),
	(18, 2, '2018-09-17 22:47:37', 'svuda', 1),
	(19, 3, '2018-09-17 22:47:37', 'ne', 1),
	(20, 4, '2018-09-17 22:47:37', '1', 1),
	(21, 5, '2018-09-17 22:47:37', 'malo', 1),
	(22, 6, '2018-09-17 22:47:37', 'dobar', 1),
	(23, 1, '2018-09-17 22:48:28', 'da', 1),
	(24, 2, '2018-09-17 22:48:28', 'svuda', 1),
	(25, 3, '2018-09-17 22:48:28', 'ne', 1),
	(26, 4, '2018-09-17 22:48:28', '1', 1),
	(27, 5, '2018-09-17 22:48:28', 'malo', 1),
	(28, 6, '2018-09-17 22:48:28', 'dobar', 1),
	(29, 10, '2018-09-17 23:24:50', 'qweqweasd', 1),
	(30, 11, '2018-09-17 23:24:50', 'brzina', 1),
	(31, 10, '2018-09-17 23:27:15', 'qweqweasd', 1),
	(32, 11, '2018-09-17 23:27:15', 'brzina', 1),
	(33, 10, '2018-09-17 23:27:31', 'qweqweasd', 1),
	(34, 11, '2018-09-17 23:27:31', 'brzina', 1),
	(35, 10, '2018-09-17 23:35:28', 'sve', 1),
	(36, 11, '2018-09-17 23:35:28', 'bezbednost', 1),
	(37, 7, '2018-09-18 00:31:51', 'ne', 1),
	(38, 8, '2018-09-18 00:31:51', 'nigde', 1),
	(39, 9, '2018-09-18 00:31:51', '1', 1),
	(40, 10, '2018-09-24 06:28:49', 'sve', 1),
	(41, 11, '2018-09-24 06:28:49', 'bezbednost', 1),
	(42, 1, '2018-09-24 10:11:22', 'ne', 1),
	(43, 2, '2018-09-24 10:11:22', 'Ne', 1),
	(44, 3, '2018-09-24 10:11:22', 'Ne', 1),
	(45, 4, '2018-09-24 10:11:22', '9', 1),
	(46, 5, '2018-09-24 10:11:22', 'malo', 1),
	(47, 6, '2018-09-24 10:11:22', 'super', 1),
	(48, 1, '2018-09-24 10:12:39', 'ne', 1),
	(49, 2, '2018-09-24 10:12:39', 'Ne', 1),
	(50, 3, '2018-09-24 10:12:39', 'Ne', 1),
	(51, 4, '2018-09-24 10:12:39', '9', 1),
	(52, 5, '2018-09-24 10:12:39', 'malo', 1),
	(53, 6, '2018-09-24 10:12:39', 'super', 1),
	(54, 1, '2018-09-24 10:13:01', 'ne', 1),
	(55, 2, '2018-09-24 10:13:01', 'Ne', 1),
	(56, 3, '2018-09-24 10:13:02', 'Ne', 1),
	(57, 4, '2018-09-24 10:13:02', '9', 1),
	(58, 5, '2018-09-24 10:13:02', 'malo', 1),
	(59, 6, '2018-09-24 10:13:02', 'super', 1),
	(60, 1, '2018-09-25 15:32:39', 'da', 1),
	(61, 2, '2018-09-25 15:32:39', 'U Grčku', 1),
	(62, 3, '2018-09-25 15:32:39', 'Srbija, Crna Gora, Grčka...', 1),
	(63, 4, '2018-09-25 15:32:39', '10', 1),
	(64, 5, '2018-09-25 15:32:39', 'malo', 1),
	(65, 6, '2018-09-25 15:32:39', 'dobar', 1),
	(66, 37, '2018-09-25 16:11:15', 'Zato', 1),
	(67, 38, '2018-09-25 16:11:15', 'ovako', 1),
	(68, 37, '2018-09-25 16:13:09', 'Eto tako', 1),
	(69, 38, '2018-09-25 16:13:09', 'onako', 1);
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;

-- Dumping structure for table vebankete.question
DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) unsigned NOT NULL,
  `nmbr_in_survey` int(11) unsigned DEFAULT NULL,
  `answer_type` enum('short','long','y/n','qualitative','quantitative','choice') COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer_choices` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'separated by new line!',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `question_text` text COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`question_id`) USING BTREE,
  UNIQUE KEY `uq_survey_id_nmbr_in_survey_is_active` (`survey_id`,`nmbr_in_survey`,`is_active`),
  KEY `idx_question_is_active` (`is_active`) USING BTREE,
  KEY `fk_survey_id` (`survey_id`) USING BTREE,
  CONSTRAINT `fk_question_survey_id` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`survey_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Dumping data for table vebankete.question: ~31 rows (approximately)
DELETE FROM `question`;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` (`question_id`, `survey_id`, `nmbr_in_survey`, `answer_type`, `answer_choices`, `created_at`, `question_text`, `is_active`) VALUES
	(1, 5, 1, 'y/n', NULL, '2018-09-13 01:47:10', 'Da li idete na letovanje?', 1),
	(2, 5, 2, 'short', NULL, '2018-09-13 01:48:01', 'Gde idete na letovanje?', 1),
	(3, 5, 3, 'long', NULL, '2018-09-13 01:48:23', 'Gde ste sve bili na letovanju?', 1),
	(4, 5, 4, 'quantitative', NULL, '2018-09-13 01:48:57', 'Koju ocenu bi dali prethodnom letovanju?', 1),
	(5, 5, 5, 'qualitative', NULL, '2018-09-13 01:50:51', 'Izgubili ste poverenje u turističke agencije?', 1),
	(6, 5, 6, 'choice', 'super\r\nodličan\r\ndobar\r\nonako\r\nloš', '2018-09-13 01:52:37', 'Kakav je bio smestaj?', 1),
	(7, 6, 1, 'y/n', NULL, '2018-09-13 01:55:56', 'Da li idete na zimovanje?', 1),
	(8, 6, 2, 'short', NULL, '2018-09-13 01:56:26', 'Gde ste bili na zimovanju?', 1),
	(9, 6, 3, 'quantitative', NULL, '2018-09-13 01:56:45', 'Koju ocenu dajete ski stazi?', 1),
	(10, 1, 1, 'long', NULL, '2018-09-13 01:59:52', 'Kakve automobile volite?', 1),
	(11, 1, 2, 'choice', 'bezbednost\r\nizgled\r\nbrzina', '2018-09-13 02:02:20', 'Šta je, za vas, najbitnije kod automobila?', 1),
	(12, 8, 1, 'long', NULL, '2018-09-13 02:06:48', 'Que?', 1),
	(13, 9, 1, 'short', NULL, '2018-09-13 02:07:04', 'Asd?', 1),
	(14, 10, 1, 'long', NULL, '2018-09-13 02:08:01', 'Sta?', 1),
	(15, 11, 1, 'choice', 'ovako\r\nonako\r\ntako\r\nsvakako', '2018-09-13 02:09:03', 'Kako?', 1),
	(16, 12, 1, 'quantitative', NULL, '2018-09-13 02:10:13', 'Zasto?', 1),
	(17, 14, 1, 'short', NULL, '2018-09-21 01:02:23', 'qweqwe', 1),
	(18, 14, 2, 'short', NULL, '2018-09-21 01:02:34', 'asd', 1),
	(19, 14, 3, 'short', NULL, '2018-09-21 01:02:40', 'zxc', 1),
	(20, 14, 4, 'short', NULL, '2018-09-21 01:02:53', 'qwer', 1),
	(21, 14, 5, 'short', NULL, '2018-09-21 01:02:57', 'zxcv', 1),
	(22, 14, 6, 'short', NULL, '2018-09-21 01:03:01', 'qwr', 1),
	(23, 16, 1, 'y/n', NULL, '2018-09-21 03:43:16', 'El radis?', 1),
	(24, 17, 1, 'y/n', NULL, '2018-09-21 03:43:55', 'Radis li?', 1),
	(25, 17, 2, 'long', NULL, '2018-09-21 03:50:40', 'Neko veeeeeeeeeeeeeeeeeeeeceeeeeeeeeeeeeeeee pitanje?', 1),
	(26, 17, 3, 'long', NULL, '2018-09-21 04:25:38', 'asdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqweasdqwe', 1),
	(27, 17, 4, 'qualitative', NULL, '2018-09-21 05:06:41', 'que', 1),
	(28, 18, 1, 'long', NULL, '2018-09-24 01:28:52', 'Koju marku njaviše volite i zašto?', 1),
	(29, 7, 1, 'short', NULL, '2018-09-25 07:16:50', 'Шта?', 1),
	(37, 49, 1, 'long', NULL, '2018-09-25 15:42:20', 'Zašto?', 1),
	(38, 49, 2, 'choice', 'onako\r\novako', '2018-09-25 15:51:32', 'Kako?', 1);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;

-- Dumping structure for table vebankete.survey
DROP TABLE IF EXISTS `survey`;
CREATE TABLE IF NOT EXISTS `survey` (
  `survey_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `survey_link` char(43) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Radni Naslov',
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Nema opisa...',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`survey_id`) USING BTREE,
  UNIQUE KEY `uq_survey_link` (`survey_link`) USING BTREE,
  KEY `fk_user_id` (`user_id`) USING BTREE,
  CONSTRAINT `fk_survey_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Dumping data for table vebankete.survey: ~47 rows (approximately)
DELETE FROM `survey`;
/*!40000 ALTER TABLE `survey` DISABLE KEYS */;
INSERT INTO `survey` (`survey_id`, `user_id`, `survey_link`, `created_at`, `title`, `description`, `is_active`, `is_published`) VALUES
	(1, 1, 'OTZhNjZjYTFiNmRjMTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 00:38:37', 'Automobili', 'Ovo je anketa koja se bavi istraživanjem popularnosti određenih marka i modela automobila. I zašto vam se baš oni dopadaju.', 1, 1),
	(2, 2, 'NDRjZjBlYTJiNmUxMTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 01:12:07', 'Letovanje', 'Letovanja...', 0, 0),
	(3, 2, 'ODA2NTMzYWRiNmUxMTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 01:13:47', 'Letovanje', 'Letovanja...', 0, 0),
	(4, 2, 'NjM1ODQ3NTZiNmUzMTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 01:27:17', 'Zimovanje', 'Zima...', 0, 0),
	(5, 2, 'YmUwMjU4YmRiNmUzMTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 01:29:49', 'Letovanje', 'Letovanja...', 1, 1),
	(6, 2, 'M2JjZjExYjhiNmU3MTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 01:54:49', 'Zimovanje', 'Zima, zima', 1, 1),
	(7, 1, 'Nzk1YjA4ZmJiNmU4MTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 02:03:41', 'Draft', 'Nema opisa...', 1, 1),
	(8, 3, 'ZDAxODgzMTliNmU4MTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 02:06:07', 'QueBre', 'Nema opisa...', 1, 1),
	(9, 3, 'ZWUwNDFmOWFiNmU4MTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 02:06:57', 'Asd', 'Nema opisa...', 1, 1),
	(10, 3, 'MGQxZGM4NWJiNmU5MTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 02:07:49', 'Sta?', 'Nema opisa...', 1, 1),
	(11, 3, 'MjgxNzAyYTdiNmU5MTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 02:08:35', 'Kako', 'Nema opisa...', 1, 1),
	(12, 3, 'NGM3NDU3ODViNmU5MTFlODkyN2EyMDI1NjQ4ZmQzYWM', '2018-09-13 02:09:36', 'Zato', 'Nema opisa...', 1, 1),
	(13, 4, 'MjkyOWVjOGJiZDI4MTFlODgxYWQyMDI1NjQ4ZmQzYWM', '2018-09-21 00:54:42', 'Draft', 'Nema opisa...', 1, 1),
	(14, 4, 'NzNkMjljN2ZiZDI4MTFlODgxYWQyMDI1NjQ4ZmQzYWM', '2018-09-21 00:56:47', 'Draft', 'Nema opisa...', 1, 0),
	(15, 4, 'ZGQ4OGE4NWNiZDI4MTFlODgxYWQyMDI1NjQ4ZmQzYWM', '2018-09-21 00:59:44', 'Draft', 'Nema opisa...', 1, 0),
	(16, 4, 'YjU3MWUxZjliZDNmMTFlODgxYWQyMDI1NjQ4ZmQzYWM', '2018-09-21 03:43:15', 'Draft', 'Nema opisa...', 1, 0),
	(17, 4, 'Y2NjMGQwOGFiZDNmMTFlODgxYWQyMDI1NjQ4ZmQzYWM', '2018-09-21 03:43:55', 'Radni Naslov', 'Nema opisa...', 1, 0),
	(18, 1, 'NTc2MjkzYjViZjg4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 01:28:13', 'Marke mobilnih telefona', 'Koje marke najviše volite?\r\nOvo je anketa koja se bavi istraživanjem popularnosti određe...', 1, 1),
	(19, 1, 'MzBhMmU2MjliZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:09:03', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(20, 1, 'MzdiNzQ2N2FiZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:09:14', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(21, 1, 'M2NmZTY2ODdiZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:09:23', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(23, 1, 'ZWQyYzEzMzliZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:14:19', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(24, 1, 'ZWY0ZWY3MjViZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:14:23', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(25, 1, 'ZjBmYTJjMmZiZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:14:25', 'Radni Naslov', 'Ovo je anketa koja se bavi istraživanjem popularnosti određe...', 1, 1),
	(26, 1, 'ZjJhMmYwNzJiZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:14:28', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(27, 1, 'ZjQ5ZDdjNGZiZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:14:31', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(28, 1, 'ZjY4ZjI0ZWRiZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:14:35', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(29, 1, 'ZjhjMDIxYjFiZmE3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 05:14:38', 'Radni Naslov', 'Ovo je anketa koja se bavi istraživanjem popularnosti određe...', 1, 1),
	(30, 1, 'ZDkzMDEzYTJiZmI3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:08:17', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(31, 1, 'ZGMzMmUxNTFiZmI3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:08:22', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(32, 1, 'ZGYwZWRkOGNiZmI3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:08:27', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(33, 1, 'ZTkxNDMyMTViZmI3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:08:44', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(34, 1, 'ZWI1NTk2NDhiZmI3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:08:48', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(35, 1, 'ZWQwNzI2MTZiZmI3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:08:51', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(36, 1, 'ZWYxMzY0NThiZmI3MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:08:54', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(37, 1, 'MjExMDVjMGFiZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:18', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(38, 1, 'MjNhMTZlYmViZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:22', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(39, 1, 'MjVlNGQ5MTliZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:26', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(40, 1, 'MjdlZWE5YmJiZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:29', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(41, 1, 'MjlmMTM5YjBiZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:33', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(42, 1, 'MmJkZjcwNjRiZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:36', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(43, 1, 'MmQ3NjBkYzZiZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:39', 'Radni Naslov', 'Nema opisa...', 1, 1),
	(44, 1, 'MmY0OWExZTBiZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:42', 'Radni Naslov', 'Nema opisa...', 0, 1),
	(45, 1, 'MzExMTA3NDFiZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:45', 'Radni Naslov', 'Nema opisa...', 0, 1),
	(46, 1, 'MzJkOTczY2NiZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:48', 'Radni Naslov', 'Nema opisa...', 0, 1),
	(47, 1, 'MzQ2OWE2ODhiZmI4MTFlODg3MTgyMDI1NjQ4ZmQzYWM', '2018-09-24 07:10:50', 'Radni Naslov', 'Nema opisa...', 0, 1),
	(49, 9, 'OGU0OWZiYjRjMGM4MTFlODkxOTUyMDI1NjQ4ZmQzYWM', '2018-09-25 15:40:24', 'Anketa 1', 'Anketa 1', 1, 1);
/*!40000 ALTER TABLE `survey` ENABLE KEYS */;

-- Dumping structure for table vebankete.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forename` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `uq_user_username` (`username`) USING BTREE,
  UNIQUE KEY `uq_user_email` (`email`) USING BTREE,
  KEY `idx_user_is_active` (`is_active`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Dumping data for table vebankete.user: ~0 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `created_at`, `username`, `password_hash`, `email`, `forename`, `surname`, `is_active`) VALUES
	(1, '2018-09-13 00:38:07', 'markom', '$2y$10$dnjMfEoD3O.yyWWIY01kgOA80Vppc1ZvrqU1bBZucDH6s41zB2GJC', 'marko.miljkovic.14@singimail.rs', 'Marko', 'Miljkovic', 1),
	(2, '2018-09-13 00:40:25', 'k01', '$2y$10$pZPJ6pse73FY4rrn7BXPGuw561vD/emSBmEjz3a89PwL7bT35nyIu', 'k1@g.com', 'k01', 'k01', 1),
	(3, '2018-09-13 02:05:36', 'k02', '$2y$10$Vjsx3/kOq15rJ/DvidBoDOkZu3cDXGczR02Md1OIWOlJd1frC7RpG', 'k2@g.com', 'k02', 'k02', 1),
	(4, '2018-09-21 00:53:10', 'k03', '$2y$10$mGrvLUqH9yWeXtgDYWIRaOircvAmy75N7FJiMHaodWFA.OdZXak2O', 'k3@gmail.com', 'k030', 'k03', 0),
	(5, '2018-09-24 08:48:34', 'k04', '$2y$10$KrfSOqlT4NglN7QbvgZ.OubUIOlFZ8YEg8mYhYB/Szd4Dt9tOCqNq', 'k4@gmail.com', 'k04', 'k04', 1),
	(6, '2018-09-24 08:55:37', 'k05', '$2y$10$olJr2jf7Lx98wpmP1iB.HeCQ4ijgyUCkq.TuD2IE.Penf4wBuFUGK', 'k5@gmail.com', 'k05', 'k045', 1),
	(7, '2018-09-24 08:56:40', 'k06', '$2y$10$zf8Ov6tiCdp8kvyUVqmJoup/iItAIowy3tFBcR.OhAjgoxVo3CFNO', 'k6@gmail.com', 'k06', 'k06', 1),
	(8, '2018-09-24 08:57:56', 'k07', '$2y$10$yrcTgPTEV2/dhIiEPHXxl.FuXROExlv5gzJtGVOH8/jPoCPX6H/YS', 'k7@gmail.com', 'k07', 'k07', 1),
	(9, '2018-09-25 15:37:19', 'k08', '$2y$10$SWaq2u3HU163qTO2J/hgnebYpoy8.zxf88X7RCyl67cc4EzHNGDXm', 'k8@gmail.com', 'k08', 'k08', 1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table vebankete.user_login
DROP TABLE IF EXISTS `user_login`;
CREATE TABLE IF NOT EXISTS `user_login` (
  `user_login_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `ip_address` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_login_id`),
  KEY `fk_user_login_user_id` (`user_id`),
  CONSTRAINT `fk_user_login_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=COMPACT;

-- Dumping data for table vebankete.user_login: ~0 rows (approximately)
DELETE FROM `user_login`;
/*!40000 ALTER TABLE `user_login` DISABLE KEYS */;
INSERT INTO `user_login` (`user_login_id`, `user_id`, `ip_address`, `user_agent`, `login_at`) VALUES
	(1, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-24 01:26:48'),
	(2, 1, '192.168.1.100', 'Mozilla/5.0 (Linux; Android 8.1.0; Nexus 5X Build/OPM6.171019.030.H1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-24 06:59:19'),
	(3, 8, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-24 08:58:52'),
	(4, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-24 09:52:19'),
	(5, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-25 06:50:20'),
	(6, 1, '192.168.1.103', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 15:17:07'),
	(7, 2, '192.168.1.103', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 15:33:59'),
	(8, 9, '192.168.1.103', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 15:38:08'),
	(9, 9, '192.168.1.103', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 15:46:18'),
	(10, 9, '192.168.1.103', 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1', '2018-09-25 16:06:55'),
	(11, 1, '192.168.1.100', 'Mozilla/5.0 (Linux; Android 8.1.0; Nexus 5X Build/OPM6.171019.030.H1) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 17:09:04'),
	(12, 1, '192.168.1.100', 'Mozilla/5.0 (Linux; Android 8.1.0; Nexus 5X Build/OPM6.171019.030.H1) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 17:10:12'),
	(13, 1, '192.168.1.100', 'Mozilla/5.0 (Linux; Android 8.1.0; Nexus 5X Build/OPM6.171019.030.H1) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 17:11:26'),
	(14, 1, '192.168.1.100', 'Mozilla/5.0 (Linux; Android 8.1.0; Nexus 5X Build/OPM6.171019.030.H1) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 17:12:08'),
	(15, 1, '192.168.1.100', 'Mozilla/5.0 (Linux; Android 8.1.0; Nexus 5X Build/OPM6.171019.030.H1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 17:13:10'),
	(16, 1, '192.168.1.100', 'Mozilla/5.0 (Linux; Android 8.1.0; Nexus 5X Build/OPM6.171019.030.H1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36', '2018-09-25 17:30:56'),
	(17, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 11:41:12'),
	(18, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 16:04:31'),
	(19, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 16:06:21'),
	(20, 1, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 16:10:49'),
	(21, 2, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 16:14:21'),
	(22, 2, '192.168.1.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 16:20:20'),
	(23, 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 16:28:09'),
	(24, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 20:29:37'),
	(25, 8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 21:05:24'),
	(26, 9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 21:06:33'),
	(27, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36', '2018-09-26 23:05:19');
/*!40000 ALTER TABLE `user_login` ENABLE KEYS */;

-- Dumping structure for trigger vebankete.tr_survey_before_insert
DROP TRIGGER IF EXISTS `tr_survey_before_insert`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tr_survey_before_insert` BEFORE INSERT ON `survey` FOR EACH ROW BEGIN
  IF NEW.survey_link IS NULL THEN
    SET NEW.survey_link = TO_BASE64(REPLACE(UUID(),'-',''));
  END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
