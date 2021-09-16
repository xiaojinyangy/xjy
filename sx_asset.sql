/*
Navicat MySQL Data Transfer

Source Server         : www_suixingzhiyu
Source Server Version : 50734
Source Host           : 139.9.189.43:3306
Source Database       : www_suixingzhiyu

Target Server Type    : MYSQL
Target Server Version : 50734
File Encoding         : 65001

Date: 2021-09-16 10:24:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sx_asset
-- ----------------------------
DROP TABLE IF EXISTS `sx_asset`;
CREATE TABLE `sx_asset` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_size` bigint(20) unsigned DEFAULT '0' COMMENT '文件大小,单位B',
  `status` tinyint(3) unsigned DEFAULT '1' COMMENT '状态;1:可用,0:不可用',
  `filename` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '文件名',
  `file_path` varchar(100) DEFAULT '' COMMENT '文件路径,相对于upload目录,可以为url',
  `suffix` varchar(10) DEFAULT '' COMMENT '文件后缀名,不包括点',
  `created_at` datetime DEFAULT NULL COMMENT '上传时间',
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8 COMMENT='资源表';
