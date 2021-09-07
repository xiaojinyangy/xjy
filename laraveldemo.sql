/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : laraveldemo

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-05-08 19:13:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
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
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', '$2y$10$ovnvcwrZQeh5ZmRTL4VeFe75OPjRpJEMGwIYDfhdNKt1.NBLrEMK.', '1', null, '1', '127.0.0.1', '127.0.0.1', '2020-05-08 19:00:00', '2019-12-18 01:59:53', null, '2020-05-08 19:00:00');
INSERT INTO `admins` VALUES ('2', '测试管理员', '$2y$10$QSIyqMWBvkvVar30sZhWqef/OlDv5Y1TZzRWb29.BVZ26GBRs3RnC', '2', '/uploads\\file_material\\1569832732c5199d31994f3d06.jpg', '1', '127.0.0.1', '127.0.0.1', null, null, '2019-09-30 08:38:58', '2019-10-12 05:43:09');

-- ----------------------------
-- Table structure for auth_groups
-- ----------------------------
DROP TABLE IF EXISTS `auth_groups`;
CREATE TABLE `auth_groups` (
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
-- Records of auth_groups
-- ----------------------------
INSERT INTO `auth_groups` VALUES ('1', '超级管理员组', '1', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49', '1', null, '2019-09-28 05:37:05');
INSERT INTO `auth_groups` VALUES ('2', '管理员组', '1', '1,2,3,4', '0', null, '2019-09-30 08:38:05');

-- ----------------------------
-- Table structure for auth_group_accesses
-- ----------------------------
DROP TABLE IF EXISTS `auth_group_accesses`;
CREATE TABLE `auth_group_accesses` (
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
-- Records of auth_group_accesses
-- ----------------------------
INSERT INTO `auth_group_accesses` VALUES ('1', '1', '1', null, null);
INSERT INTO `auth_group_accesses` VALUES ('2', '2', '2', '2019-09-30 08:39:10', '2019-09-30 08:39:10');

-- ----------------------------
-- Table structure for auth_rules
-- ----------------------------
DROP TABLE IF EXISTS `auth_rules`;
CREATE TABLE `auth_rules` (
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COMMENT='后台权限表';

-- ----------------------------
-- Records of auth_rules
-- ----------------------------
INSERT INTO `auth_rules` VALUES ('1', '0', 'admin/index/index', '首页', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('2', '1', 'admin/index/indexv1', '首页展示', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('3', '1', 'admin/index/editpass', '修改密码', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('4', '1', 'admin/index/posteditpass', '修改密码-提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('5', '1', 'admin/webuploads/index', '文件上传', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('6', '1', 'admin/webuploads/del_file', '文件删除', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('7', '0', 'admin/nav', '菜单管理', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('8', '7', 'admin/nav/index', '菜单管理-列表', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('9', '7', 'admin/nav/add', '菜单管理-添加', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('10', '7', 'admin/nav/postadd', '菜单管理-添加提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('11', '7', 'admin/nav/edit', '菜单管理-编辑', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('12', '7', 'admin/nav/postedit', '菜单管理-编辑提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('13', '7', 'admin/nav/del', '菜单管理-删除', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('14', '0', 'admin/authrule', '权限管理', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('15', '14', 'admin/authrule/index', '权限管理-列表', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('16', '14', 'admin/authrule/add', '权限管理-添加', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('17', '14', 'admin/authrule/postadd', '权限管理-添加提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('18', '14', 'admin/authrule/edit', '权限管理-编辑', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('19', '14', 'admin/authrule/postedit', '权限管理-编辑提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('20', '14', 'admin/authrule/del', '权限管理-删除', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('21', '14', 'admin/authrule/ban', '权限管理-启用', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('22', '14', 'admin/authrule/cancelban', '权限管理-禁用', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('23', '0', 'admin/authgroup', '管理组管理', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('24', '23', 'admin/authgroup/index', '管理组管理-列表', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('25', '23', 'admin/authgroup/add', '管理组管理-添加', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('26', '23', 'admin/authgroup/postadd', '管理组管理-添加提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('27', '23', 'admin/authgroup/edit', '管理组管理-编辑', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('28', '23', 'admin/authgroup/postedit', '管理组管理-编辑提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('29', '23', 'admin/authgroup/del', '管理组管理-删除', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('30', '23', 'admin/authgroup/ban', '管理组管理-启用', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('31', '23', 'admin/authgroup/cancelban', '管理组管理-禁用', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('32', '23', 'admin/authgroup/allocate', '管理组管理-分配权限', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('33', '23', 'admin/authgroup/postallocate', '管理组管理-分配权限提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('34', '23', 'admin/authgroupaccesses/index', '管理组管理-成员管理', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('35', '23', 'admin/authgroupaccesses/add', '管理组管理-成员添加', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('36', '23', 'admin/authgroupaccesses/postadd', '管理组管理-成员添加-提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('37', '23', 'admin/authgroupaccesses/del', '管理组管理-成员删除', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('38', '0', 'admin/admin', '管理员管理', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('39', '38', 'admin/admin/index', '管理员管理-列表', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('40', '38', 'admin/admin/add', '管理员管理-添加', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('41', '38', 'admin/admin/postadd', '管理员管理-添加提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('42', '38', 'admin/admin/edit', '管理员管理-编辑', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('43', '38', 'admin/admin/postedit', '管理员管理-编辑提交', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('44', '38', 'admin/admin/del', '管理员管理-删除', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('45', '38', 'admin/admin/ban', '管理员管理-启用', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('46', '38', 'admin/admin/cancelban', '管理员管理-禁用', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('47', '0', 'admin/config', '配置管理', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('48', '47', 'admin/config/edit', '配置', '1', null, null, null);
INSERT INTO `auth_rules` VALUES ('49', '47', 'admin/config/postedit', '配置提交', '1', null, null, null);

-- ----------------------------
-- Table structure for configs
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '设置id',
  `config_title` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '网页标题',
  `config_keywords` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '网页关键字',
  `config_desc` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '网页描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='配置表';

-- ----------------------------
-- Records of configs
-- ----------------------------
INSERT INTO `configs` VALUES ('1', 'demo1', 'demo1', 'demo1', '2020-03-05 10:31:26', '2019-10-21 09:47:20');

-- ----------------------------
-- Table structure for navs
-- ----------------------------
DROP TABLE IF EXISTS `navs`;
CREATE TABLE `navs` (
  `nav_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `parent_id` int(11) unsigned DEFAULT '0' COMMENT '所属菜单-上级菜单id',
  `nav_name` varchar(15) CHARACTER SET utf8 DEFAULT '' COMMENT '菜单名称',
  `nav_url` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '路径（url）模块、控制器、方法',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  `nav_order` tinyint(3) unsigned DEFAULT '255' COMMENT '排序',
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of navs
-- ----------------------------
INSERT INTO `navs` VALUES ('1', '0', '菜单管理', 'admin/nav', null, null, '255');
INSERT INTO `navs` VALUES ('2', '1', '菜单列表', 'admin/nav/index', null, null, '255');
INSERT INTO `navs` VALUES ('3', '1', '添加菜单', 'admin/nav/add', null, null, '255');
INSERT INTO `navs` VALUES ('4', '0', '权限管理', 'admin/authrule', null, null, '255');
INSERT INTO `navs` VALUES ('5', '4', '权限列表', 'admin/authrule/index', null, null, '255');
INSERT INTO `navs` VALUES ('6', '4', '权限添加', 'admin/authrule/add', null, null, '255');
INSERT INTO `navs` VALUES ('7', '0', '管理组管理', 'admin/authgroup', null, null, '255');
INSERT INTO `navs` VALUES ('8', '7', '管理组列表', 'admin/authgroup/index', null, null, '255');
INSERT INTO `navs` VALUES ('9', '7', '管理组添加', 'admin/authgroup/add', null, null, '255');
INSERT INTO `navs` VALUES ('10', '0', '管理员管理', 'admin/admin', null, null, '255');
INSERT INTO `navs` VALUES ('11', '10', '管理员列表', 'admin/admin/index', null, null, '255');
INSERT INTO `navs` VALUES ('12', '10', '管理员添加', 'admin/admin/add', null, null, '255');
INSERT INTO `navs` VALUES ('13', '0', '配置管理', 'admin/config', null, null, '255');
INSERT INTO `navs` VALUES ('14', '13', '配置', 'admin/config/edit', null, null, '255');
