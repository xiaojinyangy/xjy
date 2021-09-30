/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50726
Source Host           : 127.0.0.1:3306
Source Database       : jianonghui

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2021-09-30 16:42:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_hydropower_job
-- ----------------------------
DROP TABLE IF EXISTS `jh_hydropower_job`;
CREATE TABLE `jh_hydropower_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='水电登记员工\r\n';

-- ----------------------------
-- Records of jh_hydropower_job
-- ----------------------------
INSERT INTO `jh_hydropower_job` VALUES ('1', '10086', '9e581571d9b003257b767f5ead300e09', null, '2021-09-30 11:49:54', null, null);
