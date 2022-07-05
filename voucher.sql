/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.21-MariaDB : Database - voucher
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`voucher` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `voucher`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) DEFAULT NULL,
  `user_pass` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `admin` */

insert  into `admin`(`id`,`user_name`,`user_pass`) values 
(1,'admin','40bd001563085fc35165329ea1ff5c5ecbdbbeef');

/*Table structure for table `committee_meetings` */

DROP TABLE IF EXISTS `committee_meetings`;

CREATE TABLE `committee_meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `committee_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `hours` int(2) DEFAULT NULL,
  `miles` int(4) DEFAULT NULL,
  `hourspay` int(11) DEFAULT NULL,
  `hourspay_more` int(11) DEFAULT 0,
  `mileagepay` float(6,2) DEFAULT NULL,
  `totalpay` float(6,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `committee_meetings` */

insert  into `committee_meetings`(`id`,`ticket_id`,`committee_id`,`date`,`hours`,`miles`,`hourspay`,`hourspay_more`,`mileagepay`,`totalpay`,`created_at`,`updated_at`) values 
(21,9,1,'2022-02-24',5,0,50,0,0.00,50.00,'2022-02-24 21:08:24',NULL),
(22,9,1,'2022-02-24',6,0,60,5,0.00,65.00,'2022-02-24 21:08:28',NULL),
(23,10,1,'2022-02-25',5,2000,50,0,1050.00,1100.00,'2022-02-25 19:54:38',NULL),
(24,10,1,'2022-02-25',6,0,60,5,0.00,60.00,'2022-02-25 19:54:44',NULL),
(25,11,1,'2022-02-28',5,4,50,0,2.10,52.10,'2022-02-28 21:49:54',NULL),
(26,11,1,'2022-02-28',6,2000,60,5,1050.00,1110.00,'2022-02-28 21:50:02',NULL);

/*Table structure for table `committees` */

DROP TABLE IF EXISTS `committees`;

CREATE TABLE `committees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `committee` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `committees` */

insert  into `committees`(`id`,`committee`) values 
(1,'County Board\r\n'),
(2,'Economic Development\r\n'),
(3,'Extension/Forestry'),
(4,'Fair\r\n'),
(5,'Governor’s Conference');

/*Table structure for table `events` */

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `event_name` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `breakfast` enum('y','n') DEFAULT 'n',
  `lunch` enum('y','n') DEFAULT 'n',
  `dinner` enum('y','n') DEFAULT 'n',
  `other_amount` float(6,2) DEFAULT NULL,
  `totalpay` float(8,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `events` */

/*Table structure for table `hourspay` */

DROP TABLE IF EXISTS `hourspay`;

CREATE TABLE `hourspay` (
  `hours` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay` int(5) DEFAULT NULL,
  PRIMARY KEY (`hours`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `hourspay` */

insert  into `hourspay`(`hours`,`pay`) values 
(1,50),
(2,50),
(3,50),
(4,50),
(5,50),
(6,65),
(7,80),
(8,95),
(9,110),
(10,110),
(11,110),
(12,110),
(13,110),
(14,110),
(15,110),
(16,110),
(17,110),
(18,110),
(19,110),
(20,110),
(21,110),
(22,110),
(23,110),
(24,110);

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `mileagerate` float(5,3) DEFAULT NULL,
  `payrollemail` varchar(50) DEFAULT NULL,
  `breakfast` float(4,2) DEFAULT NULL,
  `lunch` float(4,2) DEFAULT NULL,
  `dinner` float(4,2) DEFAULT NULL,
  `smtp_server` varchar(50) DEFAULT NULL,
  `smtp_userid` varchar(50) DEFAULT NULL,
  `smtp_pass` varchar(50) DEFAULT NULL,
  `sending_email` varchar(50) DEFAULT NULL,
  `daily_limit` int(11) DEFAULT 110,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `settings` */

insert  into `settings`(`id`,`mileagerate`,`payrollemail`,`breakfast`,`lunch`,`dinner`,`smtp_server`,`smtp_userid`,`smtp_pass`,`sending_email`,`daily_limit`) values 
(1,0.525,'test.test@gmail.com',5.00,8.00,12.00,'mail.smtp2go.com','mcoleson','dearbornFlashfinder..2000','BoardSupervisor@sawyercountygov.org',110);

/*Table structure for table `supervisor` */

DROP TABLE IF EXISTS `supervisor`;

CREATE TABLE `supervisor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `district` varchar(5) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `supervisor` */

insert  into `supervisor`(`id`,`first_name`,`last_name`,`district`,`email`) values 
(1,'Al','Adams','99','vytgudzinevicius@gmail.com'),
(2,'Bob','Boettcher','98','bob.boettcher@sawyercountygov.org');

/*Table structure for table `ticket` */

DROP TABLE IF EXISTS `ticket`;

CREATE TABLE `ticket` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supervisor_id` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `payperiod_total` float(8,2) DEFAULT NULL,
  `is_corrected` enum('y','n') DEFAULT 'n',
  `initial` varchar(5) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `submit_date` date DEFAULT NULL,
  `is_submited` enum('y','n') DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `ticket` */

insert  into `ticket`(`id`,`supervisor_id`,`note`,`payperiod_total`,`is_corrected`,`initial`,`created_date`,`submit_date`,`is_submited`) values 
(9,1,NULL,NULL,'n',NULL,NULL,'2022-02-24','n'),
(10,1,NULL,NULL,'n',NULL,NULL,'2022-02-25','n'),
(11,1,'',1162.10,'n','OK',NULL,'2022-02-28','y');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
