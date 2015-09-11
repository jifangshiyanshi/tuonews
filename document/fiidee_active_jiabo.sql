/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50624
 Source Host           : localhost
 Source Database       : tuonews.com

 Target Server Type    : MySQL
 Target Server Version : 50624
 File Encoding         : utf-8

 Date: 06/13/2015 16:20:24 PM
*/

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `fiidee_active_jiabo`
-- ----------------------------
DROP TABLE IF EXISTS `fiidee_active_jiabo`;
CREATE TABLE `fiidee_active_jiabo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `company` varchar(30) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `isupdate` tinyint(1) NOT NULL,
  `isproject` tinyint(1) NOT NULL,
  `problem` varchar(20) NOT NULL,
  `isservice` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
