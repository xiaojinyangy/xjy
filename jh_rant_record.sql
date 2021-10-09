/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50726
Source Host           : 127.0.0.1:3306
Source Database       : jianonghui

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2021-10-08 15:53:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_rant_record
-- ----------------------------
DROP TABLE IF EXISTS `jh_rant_record`;
CREATE TABLE `jh_rant_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(55) DEFAULT '' COMMENT '缴费类型',
  `money` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='缴费记录表';

-- ----------------------------
-- Records of jh_rant_record
-- ----------------------------
INSERT INTO `jh_rant_record` VALUES ('1', '1000', '1', '100', '2021-10-08 12:01:08', '2021-10-08 12:01:14');
INSERT INTO `jh_rant_record` VALUES ('2', '1000', '1', '150', '2021-10-08 14:50:59', '2021-10-08 14:51:02');
INSERT INTO `jh_rant_record` VALUES ('3', '1000', '1', '50', '2021-09-30 14:51:52', '2021-10-08 14:51:54');
