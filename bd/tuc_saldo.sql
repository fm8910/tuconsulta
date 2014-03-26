/*
MySQL Backup
Source Server Version: 5.6.16
Source Database: tuc_saldo
Date: 26/03/2014 15:33:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `contador`
-- ----------------------------
DROP TABLE IF EXISTS `contador`;
CREATE TABLE `contador` (
  `numero_tarjeta` varchar(8) NOT NULL,
  `contador` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`numero_tarjeta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `historial`
-- ----------------------------
DROP TABLE IF EXISTS `historial`;
CREATE TABLE `historial` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `numero_tarjeta` varchar(8) DEFAULT NULL,
  `saldo` decimal(5,2) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id_historial`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records 
-- ----------------------------

