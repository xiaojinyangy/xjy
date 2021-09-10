/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50726
Source Host           : 127.0.0.1:3306
Source Database       : jianonghui

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2021-09-10 18:35:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_admin
-- ----------------------------
DROP TABLE IF EXISTS `jh_admin`;
CREATE TABLE `jh_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '账号',
  `admin_pwd` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '密码',
  `admin_level` tinyint(5) DEFAULT NULL COMMENT '管理员等级1.超级管理员2.管理员',
  `admin_img` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '管理员头像',
  `admin_show` tinyint(1) DEFAULT NULL COMMENT '是否启用1.启用，2.禁用',
  `admin_ip` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '登录ip',
  `admin_last_ip` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '上次登录ip',
  `admin_time` datetime DEFAULT NULL COMMENT '登录时间',
  `admin_last_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

-- ----------------------------
-- Records of jh_admin
-- ----------------------------
INSERT INTO `jh_admin` VALUES ('1', 'admin', '$2y$10$ovnvcwrZQeh5ZmRTL4VeFe75OPjRpJEMGwIYDfhdNKt1.NBLrEMK.', '1', null, '1', '127.0.0.1', '127.0.0.1', '2021-09-10 16:08:03', '2021-09-10 09:42:52', null, '2021-09-10 16:08:03');
INSERT INTO `jh_admin` VALUES ('2', '测试管理员', '$2y$10$QSIyqMWBvkvVar30sZhWqef/OlDv5Y1TZzRWb29.BVZ26GBRs3RnC', '2', '/uploads\\file_material\\1569832732c5199d31994f3d06.jpg', '1', '127.0.0.1', '127.0.0.1', null, null, '2019-09-30 08:38:58', '2019-10-12 05:43:09');

-- ----------------------------
-- Table structure for jh_area
-- ----------------------------
DROP TABLE IF EXISTS `jh_area`;
CREATE TABLE `jh_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(100) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>启用 2=>禁用',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '权重',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COMMENT='区域管理';

-- ----------------------------
-- Records of jh_area
-- ----------------------------
INSERT INTO `jh_area` VALUES ('1', '区域415456', '2021-09-08 16:37:30', '2021-09-10 18:22:47', '1', '0');
INSERT INTO `jh_area` VALUES ('2', '浦东区', '2021-09-08 16:38:12', '2021-09-08 16:38:12', '1', '0');
INSERT INTO `jh_area` VALUES ('4', '浦东区', '2021-09-08 16:39:51', '2021-09-08 16:39:51', '1', '0');
INSERT INTO `jh_area` VALUES ('8', '5555', '2021-09-08 16:43:17', '2021-09-08 16:43:17', '1', '0');
INSERT INTO `jh_area` VALUES ('9', 'wsada', '2021-09-08 16:43:49', '2021-09-08 16:43:49', '1', '0');
INSERT INTO `jh_area` VALUES ('10', '区域', '2021-09-09 10:35:05', '2021-09-09 10:35:05', '1', '0');
INSERT INTO `jh_area` VALUES ('11', '区域', '2021-09-09 10:35:43', '2021-09-09 10:35:43', '1', '0');

-- ----------------------------
-- Table structure for jh_area_rant_ext
-- ----------------------------
DROP TABLE IF EXISTS `jh_area_rant_ext`;
CREATE TABLE `jh_area_rant_ext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rant_title` varchar(55) DEFAULT NULL COMMENT '费用名称 ',
  `rant_money` decimal(11,0) DEFAULT '0' COMMENT '费用',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=>使用 2=>不使用',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1=>删除 0=>未删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='附加费设置';

-- ----------------------------
-- Records of jh_area_rant_ext
-- ----------------------------

-- ----------------------------
-- Table structure for jh_area_rent
-- ----------------------------
DROP TABLE IF EXISTS `jh_area_rent`;
CREATE TABLE `jh_area_rent` (
  `id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `rent_money` decimal(11,2) DEFAULT '0.00' COMMENT '特定区域租金',
  `area_rent_money` decimal(11,2) DEFAULT '0.00' COMMENT '特定区域管理费',
  `incidental_money` decimal(11,2) DEFAULT '0.00' COMMENT '综合费',
  `water_money` decimal(11,2) DEFAULT '0.00' COMMENT '水费',
  `electric_money` decimal(11,2) DEFAULT '0.00' COMMENT '电费',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1=>删除 0=>未删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='费用设置';

-- ----------------------------
-- Records of jh_area_rent
-- ----------------------------

-- ----------------------------
-- Table structure for jh_auth_groups
-- ----------------------------
DROP TABLE IF EXISTS `jh_auth_groups`;
CREATE TABLE `jh_auth_groups` (
  `group_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id',
  `group_name` char(100) CHARACTER SET utf8 DEFAULT '' COMMENT '用户组名称',
  `group_status` tinyint(1) DEFAULT '1' COMMENT '状态 0禁用 1启用',
  `rule_id` text CHARACTER SET utf8 COMMENT '用户组拥有的规则id',
  `level` tinyint(1) DEFAULT '0' COMMENT '是否可以删除 0是 1否',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='后台管理组表';

-- ----------------------------
-- Records of jh_auth_groups
-- ----------------------------
INSERT INTO `jh_auth_groups` VALUES ('1', '超级管理员组', '1', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71', '1', null, '2021-09-10 16:19:05');
INSERT INTO `jh_auth_groups` VALUES ('2', '管理员组', '1', '1,2,3,4', '0', null, '2019-09-30 08:38:05');

-- ----------------------------
-- Table structure for jh_auth_group_accesses
-- ----------------------------
DROP TABLE IF EXISTS `jh_auth_group_accesses`;
CREATE TABLE `jh_auth_group_accesses` (
  `accesses_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关系id',
  `admin_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `group_id` int(11) unsigned NOT NULL COMMENT '用户组id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`accesses_id`),
  UNIQUE KEY `uid_group_id` (`admin_id`,`group_id`),
  KEY `uid` (`admin_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='后台管理组明细表';

-- ----------------------------
-- Records of jh_auth_group_accesses
-- ----------------------------
INSERT INTO `jh_auth_group_accesses` VALUES ('1', '1', '1', null, null);
INSERT INTO `jh_auth_group_accesses` VALUES ('2', '2', '2', '2019-09-30 08:39:10', '2019-09-30 08:39:10');

-- ----------------------------
-- Table structure for jh_auth_rules
-- ----------------------------
DROP TABLE IF EXISTS `jh_auth_rules`;
CREATE TABLE `jh_auth_rules` (
  `rule_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id',
  `parent_id` int(11) unsigned DEFAULT '0' COMMENT '上级id',
  `rule_url` char(80) CHARACTER SET utf8 DEFAULT NULL COMMENT '路径（url）模块、控制器、方法',
  `rule_name` char(20) CHARACTER SET utf8 DEFAULT NULL COMMENT '规则中文名称',
  `rule_status` tinyint(1) DEFAULT '1' COMMENT '状态：0禁用 1启用',
  `rule_condition` char(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`rule_id`),
  UNIQUE KEY `name` (`rule_url`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COMMENT='后台权限表';

-- ----------------------------
-- Records of jh_auth_rules
-- ----------------------------
INSERT INTO `jh_auth_rules` VALUES ('1', '0', 'admin/index/index', '首页', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('2', '1', 'admin/index/indexv1', '首页展示', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('3', '1', 'admin/index/editpass', '修改密码', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('4', '1', 'admin/index/posteditpass', '修改密码-提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('5', '1', 'admin/webuploads/index', '文件上传', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('6', '1', 'admin/webuploads/del_file', '文件删除', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('7', '0', 'admin/nav', '菜单管理', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('8', '7', 'admin/nav/index', '菜单管理-列表', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('9', '7', 'admin/nav/add', '菜单管理-添加', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('10', '7', 'admin/nav/postadd', '菜单管理-添加提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('11', '7', 'admin/nav/edit', '菜单管理-编辑', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('12', '7', 'admin/nav/postedit', '菜单管理-编辑提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('13', '7', 'admin/nav/del', '菜单管理-删除', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('14', '0', 'admin/authrule', '权限管理', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('15', '14', 'admin/authrule/index', '权限管理-列表', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('16', '14', 'admin/authrule/add', '权限管理-添加', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('17', '14', 'admin/authrule/postadd', '权限管理-添加提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('18', '14', 'admin/authrule/edit', '权限管理-编辑', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('19', '14', 'admin/authrule/postedit', '权限管理-编辑提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('20', '14', 'admin/authrule/del', '权限管理-删除', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('21', '14', 'admin/authrule/ban', '权限管理-启用', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('22', '14', 'admin/authrule/cancelban', '权限管理-禁用', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('23', '0', 'admin/authgroup', '管理组管理', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('24', '23', 'admin/authgroup/index', '管理组管理-列表', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('25', '23', 'admin/authgroup/add', '管理组管理-添加', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('26', '23', 'admin/authgroup/postadd', '管理组管理-添加提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('27', '23', 'admin/authgroup/edit', '管理组管理-编辑', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('28', '23', 'admin/authgroup/postedit', '管理组管理-编辑提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('29', '23', 'admin/authgroup/del', '管理组管理-删除', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('30', '23', 'admin/authgroup/ban', '管理组管理-启用', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('31', '23', 'admin/authgroup/cancelban', '管理组管理-禁用', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('32', '23', 'admin/authgroup/allocate', '管理组管理-分配权限', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('33', '23', 'admin/authgroup/postallocate', '管理组管理-分配权限提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('34', '23', 'admin/authgroupaccesses/index', '管理组管理-成员管理', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('35', '23', 'admin/authgroupaccesses/add', '管理组管理-成员添加', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('36', '23', 'admin/authgroupaccesses/postadd', '管理组管理-成员添加-提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('37', '23', 'admin/authgroupaccesses/del', '管理组管理-成员删除', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('38', '0', 'admin/admin', '管理员管理', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('39', '38', 'admin/admin/index', '管理员管理-列表', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('40', '38', 'admin/admin/add', '管理员管理-添加', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('41', '38', 'admin/admin/postadd', '管理员管理-添加提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('42', '38', 'admin/admin/edit', '管理员管理-编辑', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('43', '38', 'admin/admin/postedit', '管理员管理-编辑提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('44', '38', 'admin/admin/del', '管理员管理-删除', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('45', '38', 'admin/admin/ban', '管理员管理-启用', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('46', '38', 'admin/admin/cancelban', '管理员管理-禁用', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('47', '0', 'admin/config', '配置管理', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('48', '47', 'admin/config/edit', '配置', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('49', '47', 'admin/config/postedit', '配置提交', '1', null, null, null);
INSERT INTO `jh_auth_rules` VALUES ('50', '50', 'admin/area', '区域档口', '1', null, '2021-09-08 15:21:44', '2021-09-08 15:22:24');
INSERT INTO `jh_auth_rules` VALUES ('51', '0', 'admin/area/index', '区域列表', '1', null, '2021-09-08 15:24:50', '2021-09-08 15:24:50');
INSERT INTO `jh_auth_rules` VALUES ('52', '51', 'admin/area/add', '区域添加功能', '1', null, '2021-09-08 16:17:13', '2021-09-08 16:17:13');
INSERT INTO `jh_auth_rules` VALUES ('53', '51', 'admin/area/set', '区域修改', '1', null, '2021-09-08 17:30:07', '2021-09-08 17:30:07');
INSERT INTO `jh_auth_rules` VALUES ('54', '51', 'admin/area/del', '区域删除', '1', null, '2021-09-08 17:30:18', '2021-09-08 17:30:18');
INSERT INTO `jh_auth_rules` VALUES ('55', '51', 'admin/shop_mouth/index', '档口列表', '1', null, '2021-09-08 18:05:10', '2021-09-08 18:05:10');
INSERT INTO `jh_auth_rules` VALUES ('56', '51', 'admin/shop_mouth/set', '档口修改', '1', null, '2021-09-08 18:05:45', '2021-09-08 18:05:45');
INSERT INTO `jh_auth_rules` VALUES ('57', '51', 'admin/shop_mouth/add', '添加档口', '1', null, '2021-09-08 18:06:02', '2021-09-08 18:06:45');
INSERT INTO `jh_auth_rules` VALUES ('58', '51', 'admin/shop_mouth/del', '删除档口', '1', null, '2021-09-08 18:08:45', '2021-09-08 18:08:45');
INSERT INTO `jh_auth_rules` VALUES ('59', '0', 'admin/user', '用户管理', '1', null, '2021-09-09 18:08:48', '2021-09-09 18:08:48');
INSERT INTO `jh_auth_rules` VALUES ('60', '59', 'admin/users/index', '用户列表', '1', null, '2021-09-09 18:09:27', '2021-09-09 18:09:27');
INSERT INTO `jh_auth_rules` VALUES ('61', '59', 'admin/users/info', '用户详细', '1', null, '2021-09-10 10:23:19', '2021-09-10 10:23:52');
INSERT INTO `jh_auth_rules` VALUES ('62', '59', 'admin/users/del', '删除', '1', null, '2021-09-10 10:55:35', '2021-09-10 10:55:35');
INSERT INTO `jh_auth_rules` VALUES ('63', '59', 'admin/job/index', '员工管理', '1', null, '2021-09-10 11:08:56', '2021-09-10 11:11:47');
INSERT INTO `jh_auth_rules` VALUES ('64', '0', 'shop/index', '商铺管理', '1', null, '2021-09-10 16:09:18', '2021-09-10 16:15:15');
INSERT INTO `jh_auth_rules` VALUES ('65', '64', 'admin/shop/index', '商品列表', '1', null, '2021-09-10 16:14:55', '2021-09-10 16:14:55');
INSERT INTO `jh_auth_rules` VALUES ('66', '64', 'admin/shop/add', '商铺添加', '1', null, '2021-09-10 16:15:40', '2021-09-10 16:17:00');
INSERT INTO `jh_auth_rules` VALUES ('67', '64', 'admin/shop/set', '商铺修改', '1', null, '2021-09-10 16:16:09', '2021-09-10 16:16:09');
INSERT INTO `jh_auth_rules` VALUES ('68', '64', 'admin/shop/del', '商铺删除', '1', null, '2021-09-10 16:16:28', '2021-09-10 16:16:28');
INSERT INTO `jh_auth_rules` VALUES ('69', '59', 'admin/job/add', '添加员工', '1', null, '2021-09-10 16:18:33', '2021-09-10 16:18:33');
INSERT INTO `jh_auth_rules` VALUES ('70', '59', 'admin/job/set', '员工修改', '1', null, '2021-09-10 16:18:51', '2021-09-10 16:18:51');
INSERT INTO `jh_auth_rules` VALUES ('71', '59', 'admin/job/del', '员工删除', '1', null, '2021-09-10 16:19:05', '2021-09-10 16:19:05');

-- ----------------------------
-- Table structure for jh_config
-- ----------------------------
DROP TABLE IF EXISTS `jh_config`;
CREATE TABLE `jh_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '设置id',
  `config_title` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '网页标题',
  `config_keywords` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '网页关键字',
  `config_desc` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '网页描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='配置表';

-- ----------------------------
-- Records of jh_config
-- ----------------------------
INSERT INTO `jh_config` VALUES ('1', '加秾汇', '加秾汇', '加秾汇', '2020-03-05 10:31:26', '2021-09-07 15:49:37');

-- ----------------------------
-- Table structure for jh_home_image
-- ----------------------------
DROP TABLE IF EXISTS `jh_home_image`;
CREATE TABLE `jh_home_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `sort` tinyint(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '1=>显示 2=>隐藏',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='轮播图';

-- ----------------------------
-- Records of jh_home_image
-- ----------------------------

-- ----------------------------
-- Table structure for jh_job
-- ----------------------------
DROP TABLE IF EXISTS `jh_job`;
CREATE TABLE `jh_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `job_number` varchar(30) DEFAULT '' COMMENT '员工编号',
  `password` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='员工列表';

-- ----------------------------
-- Records of jh_job
-- ----------------------------
INSERT INTO `jh_job` VALUES ('1', '1000', '1556456699999', '123456', '1', '2021-09-10 16:23:33', '2021-09-10 17:44:08');
INSERT INTO `jh_job` VALUES ('7', null, '123456', '2444c11ebcecb0ed400ef87efc5db852', '1', '2021-09-10 17:27:08', null);
INSERT INTO `jh_job` VALUES ('8', null, '1239999', '7bdc0d204f65807a14d4c52470ea6a08', '1', '2021-09-10 17:28:03', '2021-09-10 17:56:36');
INSERT INTO `jh_job` VALUES ('9', null, '1231231239999999', 'fd59ac8032cca772b0e22c1c656cd1ac', '1', '2021-09-10 17:31:44', '2021-09-10 17:49:36');
INSERT INTO `jh_job` VALUES ('10', null, '9999999', '9e581571d9b003257b767f5ead300e09', '1', '2021-09-10 17:57:16', null);

-- ----------------------------
-- Table structure for jh_message
-- ----------------------------
DROP TABLE IF EXISTS `jh_message`;
CREATE TABLE `jh_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL COMMENT '消息',
  `goto_user` varchar(255) DEFAULT NULL COMMENT '发送人群',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='发送消息列表';

-- ----------------------------
-- Records of jh_message
-- ----------------------------

-- ----------------------------
-- Table structure for jh_navs
-- ----------------------------
DROP TABLE IF EXISTS `jh_navs`;
CREATE TABLE `jh_navs` (
  `nav_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `parent_id` int(11) unsigned DEFAULT '0' COMMENT '所属菜单-上级菜单id',
  `nav_name` varchar(15) CHARACTER SET utf8 DEFAULT '' COMMENT '菜单名称',
  `nav_url` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '路径（url）模块、控制器、方法',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  `nav_order` tinyint(3) unsigned DEFAULT '255' COMMENT '排序',
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of jh_navs
-- ----------------------------
INSERT INTO `jh_navs` VALUES ('1', '0', '菜单管理', 'admin/nav', null, null, '255');
INSERT INTO `jh_navs` VALUES ('2', '1', '菜单列表', 'admin/nav/index', null, null, '255');
INSERT INTO `jh_navs` VALUES ('3', '1', '添加菜单', 'admin/nav/add', null, null, '255');
INSERT INTO `jh_navs` VALUES ('4', '0', '权限管理', 'admin/authrule', null, null, '255');
INSERT INTO `jh_navs` VALUES ('5', '4', '权限列表', 'admin/authrule/index', null, null, '255');
INSERT INTO `jh_navs` VALUES ('6', '4', '权限添加', 'admin/authrule/add', null, null, '255');
INSERT INTO `jh_navs` VALUES ('7', '0', '管理组管理', 'admin/authgroup', null, null, '255');
INSERT INTO `jh_navs` VALUES ('8', '7', '管理组列表', 'admin/authgroup/index', null, null, '255');
INSERT INTO `jh_navs` VALUES ('9', '7', '管理组添加', 'admin/authgroup/add', null, null, '255');
INSERT INTO `jh_navs` VALUES ('10', '0', '管理员管理', 'admin/admin', null, null, '255');
INSERT INTO `jh_navs` VALUES ('11', '10', '管理员列表', 'admin/admin/index', null, null, '255');
INSERT INTO `jh_navs` VALUES ('12', '10', '管理员添加', 'admin/admin/add', null, null, '255');
INSERT INTO `jh_navs` VALUES ('13', '0', '配置管理', 'admin/config', null, null, '255');
INSERT INTO `jh_navs` VALUES ('14', '13', '配置', 'admin/config/edit', null, null, '255');
INSERT INTO `jh_navs` VALUES ('15', '0', '区域档口', 'admin/area', '2021-09-08 15:20:28', '2021-09-08 15:21:07', '255');
INSERT INTO `jh_navs` VALUES ('16', '15', '区域列表', 'admin/area/index', '2021-09-08 15:21:20', '2021-09-08 15:21:20', '255');
INSERT INTO `jh_navs` VALUES ('17', '15', '档口列表', 'admin/shop_mouth/index', '2021-09-08 17:57:04', '2021-09-08 17:57:04', '255');
INSERT INTO `jh_navs` VALUES ('18', '0', '用户管理', 'admin/user', '2021-09-09 18:08:29', '2021-09-09 18:08:29', '255');
INSERT INTO `jh_navs` VALUES ('19', '18', '用户列表', 'admin/users/index', '2021-09-09 18:09:10', '2021-09-09 18:09:10', '255');
INSERT INTO `jh_navs` VALUES ('20', '18', '员工管理', 'admin/job/index', '2021-09-10 11:01:37', '2021-09-10 11:37:13', '255');
INSERT INTO `jh_navs` VALUES ('21', '0', '商铺', 'shop/index', '2021-09-10 16:09:03', '2021-09-10 16:09:03', '255');
INSERT INTO `jh_navs` VALUES ('22', '21', '商铺列表', 'admin/shop/index', '2021-09-10 16:09:41', '2021-09-10 16:09:41', '255');

-- ----------------------------
-- Table structure for jh_shop_job
-- ----------------------------
DROP TABLE IF EXISTS `jh_shop_job`;
CREATE TABLE `jh_shop_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>通过 0=>待审核 2=>拒绝',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='员工加入表';

-- ----------------------------
-- Records of jh_shop_job
-- ----------------------------

-- ----------------------------
-- Table structure for jh_shop_mouth
-- ----------------------------
DROP TABLE IF EXISTS `jh_shop_mouth`;
CREATE TABLE `jh_shop_mouth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mouth_name` varchar(255) DEFAULT NULL COMMENT '档口名',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1=>删除 0=>未删除',
  `status` tinyint(1) DEFAULT '1' COMMENT '1=>使用 2=>禁用',
  `sort` tinyint(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COMMENT='档口名';

-- ----------------------------
-- Records of jh_shop_mouth
-- ----------------------------
INSERT INTO `jh_shop_mouth` VALUES ('1', 'A012444', '2021-09-08 18:16:52', '2021-09-10 18:25:10', '0', '1', '0', null);
INSERT INTO `jh_shop_mouth` VALUES ('2', 'A02', '2021-09-08 18:16:58', '2021-09-08 18:16:58', '0', '1', '0', '2');
INSERT INTO `jh_shop_mouth` VALUES ('3', 'A03', '2021-09-08 18:17:03', '2021-09-09 10:44:34', '1', '1', '0', '8');
INSERT INTO `jh_shop_mouth` VALUES ('4', '测试', '2021-09-09 09:53:39', '2021-09-09 09:53:39', '0', '1', '0', '2');
INSERT INTO `jh_shop_mouth` VALUES ('5', 'A186', '2021-09-09 10:52:53', '2021-09-09 10:52:53', '0', '1', '0', '2');
INSERT INTO `jh_shop_mouth` VALUES ('6', 'A10086', '2021-09-09 10:53:04', '2021-09-09 10:53:04', '0', '1', '0', '2');
INSERT INTO `jh_shop_mouth` VALUES ('7', 'C75430', '2021-09-09 10:53:17', '2021-09-09 10:53:17', '0', '1', '0', '1');
INSERT INTO `jh_shop_mouth` VALUES ('8', 'A796', '2021-09-09 10:53:31', '2021-09-09 10:53:31', '0', '1', '0', '2');
INSERT INTO `jh_shop_mouth` VALUES ('9', 'A007', '2021-09-09 10:53:38', '2021-09-09 10:53:38', '0', '1', '0', '8');
INSERT INTO `jh_shop_mouth` VALUES ('10', 'A9666', '2021-09-09 10:53:46', '2021-09-09 10:53:46', '0', '1', '0', '4');
INSERT INTO `jh_shop_mouth` VALUES ('11', 'B021', '2021-09-09 10:53:58', '2021-09-09 10:53:58', '0', '1', '0', '2');
INSERT INTO `jh_shop_mouth` VALUES ('12', 'A701', '2021-09-09 10:54:33', '2021-09-09 10:54:33', '0', '1', '0', '9');
INSERT INTO `jh_shop_mouth` VALUES ('13', 'A701', '2021-09-09 10:55:26', '2021-09-09 10:55:26', '0', '1', '0', '9');
INSERT INTO `jh_shop_mouth` VALUES ('14', 'A701', '2021-09-09 10:56:08', '2021-09-09 10:56:08', '0', '1', '0', '9');
INSERT INTO `jh_shop_mouth` VALUES ('15', '撒大声地', '2021-09-09 11:29:12', '2021-09-09 11:29:12', '0', '1', '0', '4');
INSERT INTO `jh_shop_mouth` VALUES ('16', 'sadasda', '2021-09-09 11:29:17', '2021-09-09 11:29:17', '0', '1', '0', '4');
INSERT INTO `jh_shop_mouth` VALUES ('17', 'sadasdas', '2021-09-09 11:29:22', '2021-09-09 11:29:22', '0', '1', '0', '10');
INSERT INTO `jh_shop_mouth` VALUES ('18', 'dasdasdas', '2021-09-09 11:30:03', '2021-09-09 11:30:03', '0', '1', '0', '4');

-- ----------------------------
-- Table structure for jh_shop_pay_rant
-- ----------------------------
DROP TABLE IF EXISTS `jh_shop_pay_rant`;
CREATE TABLE `jh_shop_pay_rant` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL COMMENT '商铺id',
  `area_rant_ext_id` int(11) DEFAULT '0' COMMENT '附加费id',
  `pay_status` tinyint(1) DEFAULT '0' COMMENT '0=>未缴费 1=>已缴费',
  `status` tinyint(1) DEFAULT '0' COMMENT '0=>待缴费 1=>已缴费 2=>超时',
  `year` int(5) DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月',
  `pay_user` int(11) DEFAULT '0' COMMENT '缴费人员(线上)',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '0=>未删除 1=>已删除',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='缴费列表';

-- ----------------------------
-- Records of jh_shop_pay_rant
-- ----------------------------

-- ----------------------------
-- Table structure for jh_system
-- ----------------------------
DROP TABLE IF EXISTS `jh_system`;
CREATE TABLE `jh_system` (
  `key` varchar(50) DEFAULT NULL,
  `value` text,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='基础设置';

-- ----------------------------
-- Records of jh_system
-- ----------------------------

-- ----------------------------
-- Table structure for jh_users
-- ----------------------------
DROP TABLE IF EXISTS `jh_users`;
CREATE TABLE `jh_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `nick_name` varchar(100) DEFAULT NULL COMMENT '微信名',
  `phone` varchar(12) DEFAULT NULL COMMENT '电话号',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别 1=>男 2=>女',
  `headpic` varchar(255) DEFAULT NULL COMMENT '头像',
  `regist_time` int(11) DEFAULT '0',
  `identity` tinyint(1) DEFAULT '0' COMMENT '身份 1=>员工 2=>店长 0=>普通用户',
  `region` varchar(255) DEFAULT '' COMMENT '地址',
  `openid` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0' COMMENT '0=>未删除 1=>删除',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of jh_users
-- ----------------------------
INSERT INTO `jh_users` VALUES ('1000', 'xjy', '18774265532', '1', 'https://img0.baidu.com/it/u=1514002029,2035215441&fm=26&fmt=auto&gp=0.jpg', '1631183139', '1', '广州', 'XJY778899', '2021-09-09 18:25:28', '2021-09-10 11:00:16', '0');

-- ----------------------------
-- Table structure for jh_user_message
-- ----------------------------
DROP TABLE IF EXISTS `jh_user_message`;
CREATE TABLE `jh_user_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='消息阅读记录';

-- ----------------------------
-- Records of jh_user_message
-- ----------------------------

-- ----------------------------
-- Table structure for jh_user_shop
-- ----------------------------
DROP TABLE IF EXISTS `jh_user_shop`;
CREATE TABLE `jh_user_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `area_id` int(11) DEFAULT NULL COMMENT '区域id',
  `mouth_id` int(11) DEFAULT NULL COMMENT '档口id',
  `name` varchar(40) DEFAULT '' COMMENT '用户姓名',
  `sex` tinyint(1) DEFAULT '0' COMMENT '性别 1=>男 2=>女',
  `phone` varchar(20) DEFAULT '' COMMENT '手机号',
  `id_no` varchar(20) DEFAULT '' COMMENT '身份证',
  `id_no_image` varchar(255) DEFAULT '' COMMENT '身份证照片',
  `license` varchar(255) DEFAULT '' COMMENT '营业执照',
  `now_user_name` varchar(40) DEFAULT '' COMMENT '实际控制人',
  `now_user_phone` varchar(20) DEFAULT '' COMMENT '实际控制人手机号',
  `increasing` int(11) DEFAULT '0' COMMENT '递增',
  `company_name` varchar(50) DEFAULT '' COMMENT '公司名称',
  `contract_time` int(11) DEFAULT '0' COMMENT '月数',
  `company_type` varchar(30) DEFAULT '' COMMENT '经营类型',
  `status` tinyint(1) DEFAULT '0' COMMENT '审核状态 0=>待审核 1=>通过 2拒绝',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '1=>删除 0=>未删除',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='商铺信息';

-- ----------------------------
-- Records of jh_user_shop
-- ----------------------------
INSERT INTO `jh_user_shop` VALUES ('1', '1000', '2', '2', 'xjy', '1', '187742655321', '54654213', '', '1', '小金羊', '18774265532', '0', '杭州', '0', '赚钱', '1', '1', '2021-09-10 18:09:33', '2021-09-10 18:30:47');

-- ----------------------------
-- Table structure for jh_warte_electric_rant
-- ----------------------------
DROP TABLE IF EXISTS `jh_warte_electric_rant`;
CREATE TABLE `jh_warte_electric_rant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL COMMENT '水/电表编号',
  `last_month` decimal(11,2) DEFAULT '0.00' COMMENT '上个月度数',
  `this_month` decimal(11,2) DEFAULT '0.00' COMMENT '这个月度数',
  `this_number` decimal(11,2) DEFAULT '0.00' COMMENT '消耗度数',
  `money` decimal(11,2) DEFAULT '0.00' COMMENT '费用',
  `type` tinyint(1) DEFAULT NULL COMMENT '1=>电费 2=>水费',
  `status` tinyint(1) DEFAULT '0' COMMENT '0=>为缴费 1=>已缴费',
  `year` tinyint(5) DEFAULT NULL COMMENT '年',
  `month` tinyint(2) DEFAULT NULL COMMENT '月',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商铺 水电费';

-- ----------------------------
-- Records of jh_warte_electric_rant
-- ----------------------------
