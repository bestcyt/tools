/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : testlaravel

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2020-06-07 21:52:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for word_page_infos
-- ----------------------------
DROP TABLE IF EXISTS `word_page_infos`;
CREATE TABLE `word_page_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word_id` int(11) DEFAULT NULL,
  `page_no` int(11) DEFAULT '1' COMMENT '搜索页的第几页',
  `title` text CHARACTER SET utf8mb4 COMMENT '该页面的一条链接标题',
  `desc` text CHARACTER SET utf8mb4 COMMENT '该页面的一条链接摘要',
  `link` text CHARACTER SET utf8mb4 COMMENT '该页面的一条链接的url',
  `create_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
