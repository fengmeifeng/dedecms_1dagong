/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : collect

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2014-10-09 21:06:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `collect_node`
-- ----------------------------
DROP TABLE IF EXISTS `collect_node`;
CREATE TABLE `collect_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(20) NOT NULL,
  `controller` varchar(30) NOT NULL,
  `method` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `nav` varchar(50) NOT NULL,
  `display` enum('action','nav') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of collect_node
-- ----------------------------

-- ----------------------------
-- Table structure for `collect_role`
-- ----------------------------
DROP TABLE IF EXISTS `collect_role`;
CREATE TABLE `collect_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '后台组名',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '是否激活 1：是 0：否',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序权重',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注说明',
  `dateline` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of collect_role
-- ----------------------------
INSERT INTO `collect_role` VALUES ('2', '管理员', '0', '1', '0', '管理员', '1412336950');
INSERT INTO `collect_role` VALUES ('3', '规则编辑员123', '0', '1', '0', '规则编辑员1123', '1412336963');

-- ----------------------------
-- Table structure for `collect_sgroup`
-- ----------------------------
DROP TABLE IF EXISTS `collect_sgroup`;
CREATE TABLE `collect_sgroup` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `dateline` int(10) NOT NULL,
  `pid` smallint(6) NOT NULL DEFAULT '0',
  `remark` varchar(100) NOT NULL,
  `source` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of collect_sgroup
-- ----------------------------
INSERT INTO `collect_sgroup` VALUES ('1', '体育11', '1412402450', '0', '体育111', '0');
INSERT INTO `collect_sgroup` VALUES ('2', '健康资讯', '1412404051', '0', '健康资讯', '0');
INSERT INTO `collect_sgroup` VALUES ('3', '汽车沙龙', '1412404066', '0', '汽车沙龙', '0');
INSERT INTO `collect_sgroup` VALUES ('8', '新浪NBA', '1412516107', '1', '新浪NBA新浪NBA', '0');
INSERT INTO `collect_sgroup` VALUES ('9', '新安驾校', '1412516136', '3', '新安驾校', '0');
INSERT INTO `collect_sgroup` VALUES ('10', '奥万大', '1412516166', '2', '挖到', '0');

-- ----------------------------
-- Table structure for `collect_source`
-- ----------------------------
DROP TABLE IF EXISTS `collect_source`;
CREATE TABLE `collect_source` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sourcename` varchar(100) NOT NULL,
  `sourcelink` varchar(255) NOT NULL,
  `xpath` varchar(100) NOT NULL,
  `titletag` varchar(20) NOT NULL,
  `linktag` varchar(20) NOT NULL,
  `configs` varchar(1000) NOT NULL,
  `dateline` int(10) NOT NULL,
  `sid` smallint(6) NOT NULL,
  `maxpage` tinyint(1) NOT NULL,
  `lastpost` int(10) NOT NULL,
  `uuid` char(32) NOT NULL,
  `host` varchar(30) NOT NULL,
  `urlcontains` varchar(20) NOT NULL,
  `urlexcept` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `searchIdx` (`sid`,`lastpost`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of collect_source
-- ----------------------------

-- ----------------------------
-- Table structure for `collect_user`
-- ----------------------------
DROP TABLE IF EXISTS `collect_user`;
CREATE TABLE `collect_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `role` smallint(6) unsigned NOT NULL COMMENT '组ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 1:启用 0:禁止',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注说明',
  `last_login_time` int(11) unsigned NOT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(15) DEFAULT NULL COMMENT '最后登录IP',
  `last_location` varchar(100) DEFAULT NULL COMMENT '最后登录位置',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of collect_user
-- ----------------------------
INSERT INTO `collect_user` VALUES ('10', '测试', 'e10adc3949ba59abbe56e057f20f883e', '3', '2', '测试', '1412403811', '127.0.0.1', '新建用户');
INSERT INTO `collect_user` VALUES ('11', '管理员', '7fa8282ad93047a4d6fe6111c93b308a', '2', '1', '挖到奥万大奥万大', '1412404462', '127.0.0.1', '新建用户');
