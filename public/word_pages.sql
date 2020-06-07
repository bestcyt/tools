/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : testlaravel

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2020-06-07 21:52:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for word_pages
-- ----------------------------
DROP TABLE IF EXISTS `word_pages`;
CREATE TABLE `word_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word_id` int(11) DEFAULT NULL,
  `page_no` int(11) DEFAULT '1',
  `search_link` text CHARACTER SET utf8mb4 COMMENT '页面搜索链接',
  `html` longtext CHARACTER SET utf8mb4 COMMENT '页面html',
  `if_has` tinyint(4) DEFAULT '1' COMMENT '是否页面有内容，有为1，没有为0',
  `if_done` tinyint(4) DEFAULT '0' COMMENT '是否处理过HTML，0没有，1有',
  `create_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
