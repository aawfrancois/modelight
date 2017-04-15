CREATE DATABASE  IF NOT EXISTS `db_test`;
USE `db_test`;

DROP TABLE IF EXISTS `test_model`;
CREATE TABLE `test_model` (
  `id_test_model` int(11) NOT NULL AUTO_INCREMENT,
  `field_int` int(11) DEFAULT NULL,
  `field_varchar` varchar(45) DEFAULT NULL,
  `field_text` text,
  `field_datetime` datetime DEFAULT NULL,
  `john_doe_is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_test_model`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `test_model` VALUES
  (1,12,'toto','toto','2016-02-22 22:22:22',0),
  (2,14,'tata','tata','2016-02-22 22:22:23',1),
  (3,16,'tutu','tutu','2016-02-22 22:22:24',0),
  (4,18,'tete','tete','2016-02-22 22:22:25',1),
  (5,20,'tyty','tyty','2016-02-22 22:22:26',0),
  (6,22,'mama','mama','2016-02-22 22:22:27',1),
  (7,24,'meme','meme','2016-02-22 22:22:28',0),
  (8,26,'mimi','mimi','2016-02-22 22:22:29',0);

DROP TABLE IF EXISTS `test_model_upsert`;
CREATE TABLE `test_model_upsert` (
  `id_test_model_upsert` int(11) NOT NULL AUTO_INCREMENT,
  `field_int` int(11) DEFAULT NULL,
  `field_varchar` varchar(45) DEFAULT NULL,
  `field_text` text,
  `field_datetime` datetime DEFAULT NULL,
  `john_doe_is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_test_model_upsert`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
