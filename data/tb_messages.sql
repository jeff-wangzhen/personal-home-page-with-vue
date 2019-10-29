/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : grwz-vue

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-07-10 23:09:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_vue_messages
-- ----------------------------
DROP TABLE IF EXISTS `tb_vue_messages`;
CREATE TABLE `tb_vue_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `messageContent` varchar(255) NOT NULL,
  `contactType` enum('phone','email','QQ','wechat','undefinedContactMethod') DEFAULT 'undefinedContactMethod',
  `contactMethod` varchar(255) DEFAULT NULL,
  `userAgent` varchar(255) DEFAULT NULL,
  `agentJudge` varchar(255) DEFAULT NULL,
  `IP` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `microtime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
