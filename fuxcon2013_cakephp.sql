# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.1.59)
# Datenbank: fuxcon2013_cakephp
# Erstellungsdauer: 2013-06-14 11:37:44 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Export von Tabelle projects
# ------------------------------------------------------------

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `slug` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `about` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Export von Tabelle tagged
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tagged`;

CREATE TABLE `tagged` (
  `id` varchar(36) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `tag_id` varchar(36) NOT NULL,
  `model` varchar(255) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `times_tagged` int(11) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_TAGGING` (`model`,`foreign_key`,`tag_id`,`language`),
  KEY `INDEX_TAGGED` (`model`),
  KEY `INDEX_LANGUAGE` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Export von Tabelle tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` varchar(36) NOT NULL,
  `identifier` varchar(30) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `keyname` varchar(30) NOT NULL,
  `weight` int(2) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_TAG` (`identifier`,`keyname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Export von Tabelle users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created`, `modified`)
VALUES
	(1,'tester','d2c961454540abfa43d65be013eaa4e0fd3fbbf4',NULL,'2013-05-13 08:08:33','2013-05-13 08:08:33'),
	(2,'admin','fcbd51a41a8ff68d43cfd7a2fbae8bfa6919fe7f','admin','2013-06-03 09:29:42','2013-06-03 09:29:42');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
