SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DROP TABLE IF EXISTS `rates`;
CREATE TABLE `rates` (
  `rate_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET cp1250 COLLATE cp1250_croatian_ci NOT NULL,
  `day` decimal(5,2) NOT NULL DEFAULT '0.00',
  `night` decimal(5,2) NOT NULL DEFAULT '0.00',
  `sunday` decimal(5,2) NOT NULL DEFAULT '0.00',
  `sunday_night` decimal(5,2) NOT NULL DEFAULT '0.00',
  `holiday` decimal(5,2) NOT NULL DEFAULT '0.00',
  `holiday_night` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`rate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

DROP TABLE IF EXISTS `shifts`;
CREATE TABLE `shifts` (
  `shift_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `start` varchar(5) COLLATE utf8_slovenian_ci NOT NULL DEFAULT '0',
  `end` varchar(5) COLLATE utf8_slovenian_ci NOT NULL DEFAULT '0',
  `bonus` decimal(7,2) NOT NULL DEFAULT '0.00',
  `note` varchar(250) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `total` decimal(7,2) NOT NULL DEFAULT '0.00',
  `day` smallint(2) NOT NULL DEFAULT '0',
  `night` smallint(2) NOT NULL DEFAULT '0',
  `sunday` smallint(2) NOT NULL DEFAULT '0',
  `sunday_night` smallint(2) NOT NULL DEFAULT '0',
  `holiday` smallint(2) NOT NULL DEFAULT '0',
  `holiday_night` smallint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`shift_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `code` varchar(10) DEFAULT NULL,
  `user_type` enum('admin','user') NOT NULL DEFAULT 'user',
  `rate_id_fk` int(11) unsigned NOT NULL,
  `language` varchar(15) NOT NULL DEFAULT 'english',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `rate_id_fk` (`rate_id_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`rate_id_fk`) REFERENCES `rates` (`rate_id`);
