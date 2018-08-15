# ************************************************************
# Sequel Pro SQL dump
# Version 5224
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.11)
# Database: ResMan
# Generation Time: 2018-07-18 22:56:23 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table client
# ------------------------------------------------------------

DROP TABLE IF EXISTS `client`;

CREATE TABLE `client` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;

INSERT INTO `client` (`id`, `name`, `type`, `project_id`)
VALUES
	(66,'Freelancer','site',88),
	(67,'Justin Kempiak','site',89),
	(68,'Dave Harig','fixed',90),
	(69,'Upwork - Petrov','site',91),
	(70,'Upwork','site',92),
	(71,'Upwork','site',93),
	(72,'Freelancer','site',94),
	(74,'대표단','fixed',96),
	(77,'asdf','fixed',99);

/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table daily_pro_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `daily_pro_log`;

CREATE TABLE `daily_pro_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pro_rate_change` int(11) DEFAULT NULL,
  `prev_rate` int(11) DEFAULT NULL,
  `change_at` datetime DEFAULT NULL,
  `bus_at_pro` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `daily_pro_log` WRITE;
/*!40000 ALTER TABLE `daily_pro_log` DISABLE KEYS */;

INSERT INTO `daily_pro_log` (`id`, `project_id`, `user_id`, `pro_rate_change`, `prev_rate`, `change_at`, `bus_at_pro`)
VALUES
	(132,90,46,5,0,'2018-07-15 00:00:00','iOS프로젝트에 bitrise 추가'),
	(133,89,46,5,0,'2018-07-15 00:00:00','cognito api추가'),
	(134,91,49,50,0,'2018-07-15 00:00:00','대방이 제기한 요구사항에 대한 작업을 진행하였습니다.'),
	(148,88,45,1,0,'2018-07-16 00:00:00',''),
	(149,89,46,10,5,'2018-07-16 00:00:00','- Mac용 앱에 bitrise 추가\r\n- iPad용 앱 오유수정'),
	(150,96,48,50,0,'2018-07-16 00:00:00','- 개발성원들의 실적표 개개로 현시\r\n- 완성된 프로젝트 종합페지\r\n- 프로젝트 결제날자 선택기능'),
	(151,88,45,1,1,'2018-07-17 00:00:00','대방과의 련계가 되지 않아 아직도 기다리고 있는 상태입니다.'),
	(152,96,48,90,50,'2018-07-17 00:00:00','사용자정보 변경페지 작성'),
	(171,89,46,18,10,'2018-07-17 00:00:00','- 오유수정'),
	(172,88,45,1,1,'2018-07-18 00:00:00','아직 련계가 회복되지 못하였습니다.'),
	(173,89,46,23,18,'2018-07-18 00:00:00','- bug fix'),
	(174,96,48,92,90,'2018-07-18 00:00:00','일보작성날자 지정가능하도록 변경');

/*!40000 ALTER TABLE `daily_pro_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dailyreport
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dailyreport`;

CREATE TABLE `dailyreport` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `businessrep` text,
  `suggestion` text,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `dailyreport` WRITE;
/*!40000 ALTER TABLE `dailyreport` DISABLE KEYS */;

INSERT INTO `dailyreport` (`id`, `businessrep`, `suggestion`, `user_id`, `created_at`)
VALUES
	(130,'오전: 계정을 받기 위한 사업\r\n오후: 과제탐색(Upwork, Freelancer, Guru)','없습니다.',45,'2018-07-15 00:00:00'),
	(131,'Freelancer.com, Peopleperhour.com, guru.com, remote.com. stackoverflow.com 에서 과제비드를 진행하였습니다.','없습니다.',47,'2018-07-15 00:00:00'),
	(132,'- mystride개발\r\n- bitrise작업','없음',46,'2018-07-15 00:00:00'),
	(133,'Sudoku App프로젝트에 대한 작업을 진행하고 Upwork에서 과제입찰을 진행하였습니다.','없습니다.',49,'2018-07-15 00:00:00'),
	(142,'오전: 과제입찰사업 진행(Upwork, Freelancer, Guru, PPH)\r\n오후: Freelancer계정 인증하기 위한 사업, 미샤아바이 콤퓨터 재설치','없습니다.',45,'2018-07-16 00:00:00'),
	(143,'Freelancer.com, Peopleperhour.com, guru.com 에서 과제비드를 진행하였습니다.','없습니다.',47,'2018-07-16 00:00:00'),
	(144,'SudokuApp프로젝트를 완료하고 Upwork에서 과제입찰을 진행하였습니다.','없습니다.',49,'2018-07-16 00:00:00'),
	(145,'- 과제비드\r\n- mystride대방과 통신','없음\r\n',46,'2018-07-16 00:00:00'),
	(146,'내부 싸이트 기능마감작업을 진행하였습니다.','없습니다.',48,'2018-07-16 00:00:00'),
	(147,'오전: 과제입찰(Upwork, Freelancer), 대방과의 면담\r\n오후: 과제입찰(Upwork, Freelancer)','없습니다.',45,'2018-07-17 00:00:00'),
	(148,'Upwork, Freelancer, PeoplePerHour에서 과제조사를 진행하였습니다.\r\n','없습니다.',48,'2018-07-17 00:00:00'),
	(166,'Upwork에서 과제입찰을 진행하였습니다.','없습니다.',49,'2018-07-17 00:00:00'),
	(167,'-iOS and Mac App help needed 과제 작업\r\n-과제비드\r\n','없음',46,'2018-07-17 00:00:00'),
	(168,'Freelancer.com, Guru.com에서 비드를 진행하였습니다.','없습니다.',47,'2018-07-17 00:00:00'),
	(169,'오전: 과제입찰(Upwork) 2건진행, 중국시장 식품구입, 우스쩨 노트콤구입, Freelancer계정(jovan Savic) 복구하기 위한 사업, 단동 과제 주는 사업 진행\r\n오후: 과제입찰(Upwork) 한건 진행, Upwork계정(Nebojsa Savic) 과제 넣기 위한 사업, 대련 계정주기 위한 사업\r\n저녁: 과제입찰(Upwork) 한건 진행','없습니다.',45,'2018-07-18 00:00:00'),
	(170,'- iOS and Mac App help needed bug fix\r\n- 과제비드\r\n','없음\r\n',46,'2018-07-18 00:00:00'),
	(171,'Upwork에서 과제입찰을 진행하였습니다.','없습니다.',49,'2018-07-18 00:00:00'),
	(172,'Freelancer.com, Upwork.com에서 비드를 진행하였습니다.','없습니다.',47,'2018-07-18 00:00:00'),
	(173,' - 내부싸이트 오유수정작업 진행\r\n - UpWork 계정창조를 위한 준비사업 진행','없습니다.',48,'2018-07-18 00:00:00');

/*!40000 ALTER TABLE `dailyreport` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phone
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phone`;

CREATE TABLE `phone` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `phone` WRITE;
/*!40000 ALTER TABLE `phone` DISABLE KEYS */;

INSERT INTO `phone` (`id`, `phone_number`, `user_id`)
VALUES
	(38,'(+)381-061-299-8136',45),
	(39,'(+)381-061-224-5698',46),
	(40,'(+)381-061-224-7128',47),
	(41,'(+)381-061-224-7510',48),
	(42,'(+)381-061-224-5806',49),
	(43,'(+)381-061-123-3333',50),
	(48,'(+)381-061-224-7511',48),
	(49,'(+)381-061-224-7512',NULL);

/*!40000 ALTER TABLE `phone` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `project_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `project_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `contract_price` int(11) DEFAULT NULL,
  `hour_week` int(11) DEFAULT NULL,
  `taxed_price` double DEFAULT NULL,
  `taxed_date` datetime DEFAULT NULL,
  `project_owner` int(11) DEFAULT NULL,
  `progress_rate` int(11) DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `taxed_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_ci DEFAULT NULL,
  `pending_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_ci DEFAULT NULL,
  `is_progress` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_ci;

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;

INSERT INTO `project` (`id`, `project_title`, `project_description`, `project_type`, `contract_price`, `hour_week`, `taxed_price`, `taxed_date`, `project_owner`, `progress_rate`, `start_at`, `end_at`, `created_at`, `taxed_status`, `pending_status`, `is_progress`)
VALUES
	(88,'Lehra Studio갱신','Lehra Studio에서 음악서고를 변경하기 위한 프로젝트','hourly',25,5,0,NULL,45,1,'2018-07-15 22:35:38',NULL,'2018-07-16 22:51:45','None taxed','None pending',1),
	(89,'iOS and Mac App help needed','iOS, Mac원천코드에 Bitrise SDK를 추가하는 프로젝트','hourly',30,30,0,NULL,46,23,'2018-07-15 22:38:57',NULL,'2018-07-18 22:40:46','None taxed','None pending',1),
	(90,'Mystride iPhone App','기마수들을 위한 Social app작성','hourly',40,30,770.88,'2018-07-16 00:00:00',46,0,'2018-07-15 22:44:51',NULL,'2018-07-16 23:26:30','Fully taxed','None pending',0),
	(91,'Small Sudoku App','Sudoku(iOS)앱의 기본적인 기능만을 구현한다.\r\n- difficulty level\r\neasy, medium, hard\r\n- candidate for cell\r\n- set or remove cell number','fixed',100,0,0,'2018-07-16 00:00:00',49,0,'2018-07-14 00:00:00','2018-07-15 23:59:59','2018-07-16 22:58:16','None taxed','Fully pending',0),
	(92,'Virtualbox Assistance | Mac','Virtualbox에 MacOS 10.6을 설치하여야 합니다.','fixed',50,0,47,'2018-06-28 00:00:00',47,0,'2018-06-23 00:00:00','2018-06-26 23:59:59','2018-07-16 09:43:22','Fully taxed','None pending',0),
	(93,'Port C++ OCR library to Android and iOS','Android, iOS용 Tesseract OCR서고를 3.0에서 4.0으로 갱신하여야 합니다.','fixed',1200,0,0,'2018-07-16 00:00:00',47,0,'2018-07-09 00:00:00','2018-07-11 23:59:59','2018-07-16 23:25:10','None taxed','Fully pending',0),
	(94,'To develop a ultility to convert multi-page tiff/pdf to bmp via command line','TIFF, PDF문서를 BMP화상자료로 변환하는 프로그람입니다.','fixed',200,0,0,'2018-07-16 00:00:00',47,0,'2018-07-11 00:00:00','2018-07-21 23:59:59','2018-07-16 23:25:10','None taxed','Fully pending',0),
	(96,'Internal WebSite','일보 및 프로젝트관리를 진행합니다.','fixed',100,0,0,'2018-07-17 00:00:00',48,92,'2018-07-15 23:16:52','2018-07-21 23:20:48','2018-07-18 23:46:50','None taxed','None pending',1);

/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table project_change_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project_change_log`;

CREATE TABLE `project_change_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` text,
  `price` int(11) DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `hour_week` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `project_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table project_taxed_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project_taxed_log`;

CREATE TABLE `project_taxed_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `taxed_price` double DEFAULT NULL,
  `taxed_date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `project_taxed_log` WRITE;
/*!40000 ALTER TABLE `project_taxed_log` DISABLE KEYS */;

INSERT INTO `project_taxed_log` (`id`, `project_id`, `taxed_price`, `taxed_date`, `user_id`)
VALUES
	(25,92,47,'2018-06-28 00:00:00',47),
	(38,90,770.88,'2018-07-16 00:00:00',46);

/*!40000 ALTER TABLE `project_taxed_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sysuser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sysuser`;

CREATE TABLE `sysuser` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `sysuser` WRITE;
/*!40000 ALTER TABLE `sysuser` DISABLE KEYS */;

INSERT INTO `sysuser` (`id`, `username`, `password`, `status`, `picture`)
VALUES
	(45,'jovan','e10adc3949ba59abbe56e057f20f883e',2,'jovan.jpg'),
	(46,'alek','e10adc3949ba59abbe56e057f20f883e',1,'Alexandar.jpg'),
	(47,'vlad','a67436fd21d32f75b490404db4f9fdce',1,'Photo_4.jpg'),
	(48,'bozo','202cb962ac59075b964b07152d234b70',2,'bozo1.jpg'),
	(49,'petar','202cb962ac59075b964b07152d234b70',1,'face_copy.jpeg');

/*!40000 ALTER TABLE `sysuser` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
