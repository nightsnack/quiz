/*
 Navicat Premium Data Transfer

 Source Server         : Iocalhost
 Source Server Type    : MySQL
 Source Server Version : 50710
 Source Host           : localhost
 Source Database       : quiz

 Target Server Type    : MySQL
 Target Server Version : 50710
 File Encoding         : utf-8

 Date: 03/18/2016 15:27:13 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `Accesscode`
-- ----------------------------
DROP TABLE IF EXISTS `Accesscode`;
CREATE TABLE `Accesscode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accesscode` varchar(10) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Accesscode`
-- ----------------------------
BEGIN;
INSERT INTO `Accesscode` VALUES ('1', '050861', '1', '2016-03-15 16:57:42', '2016-03-15 22:57:51'), ('2', '134474', '1', '2016-03-16 16:58:37', '2016-03-16 21:58:41'), ('3', '054842', '1', '2016-03-17 20:21:27', '2016-03-19 23:25:15'), ('4', '266181', '1', '2016-03-18 09:56:21', '2016-03-18 10:25:15'), ('5', '284605', '1', '2016-03-18 15:03:25', '2016-03-18 20:25:15'), ('6', '284852', '1', '2016-03-18 15:07:32', '2016-03-18 20:25:15');
COMMIT;

-- ----------------------------
--  Table structure for `Answer`
-- ----------------------------
DROP TABLE IF EXISTS `Answer`;
CREATE TABLE `Answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(80) NOT NULL,
  `accesscode` varchar(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `answer` varchar(80) NOT NULL,
  `judge` tinyint(4) NOT NULL COMMENT '评判。0为错误',
  `correct` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Answer`
-- ----------------------------
BEGIN;
INSERT INTO `Answer` VALUES ('1', 'admin', '050861', '1', 'A', '0', 'D'), ('2', 'admin', '050861', '2', 'A', '1', 'A'), ('3', 'admin', '050861', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('4', 'admin', '050861', '6', 'D', '1', 'D'), ('5', 'admin', '050861', '7', 'A', '1', 'A'), ('6', 'admin', '050861', '8', 'D', '1', 'D'), ('7', 'admin', '054842', '1', 'A', '0', 'D'), ('8', 'admin', '054842', '2', 'A', '1', 'A'), ('9', 'admin', '054842', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('10', 'admin', '054842', '6', 'D', '1', 'D'), ('11', 'admin', '054842', '7', 'A', '1', 'A'), ('12', 'admin', '054842', '8', 'D', '1', 'D'), ('13', 'admin', '110979', '1', 'A', '0', 'D'), ('14', 'admin', '110979', '2', 'A', '1', 'A'), ('15', 'admin', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('16', 'admin', '110979', '6', 'D', '1', 'D'), ('17', 'admin', '110979', '7', 'A', '1', 'A'), ('18', 'admin', '110979', '8', 'D', '1', 'D'), ('19', 'B88888888', '110979', '1', 'A', '0', 'D'), ('20', 'B88888888', '110979', '2', 'A', '1', 'A'), ('21', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('22', 'B88888888', '110979', '6', 'D', '1', 'D'), ('23', 'B88888888', '110979', '7', 'A', '1', 'A'), ('24', 'B88888888', '110979', '8', 'D', '1', 'D'), ('25', 'B88888888', '110979', '1', 'A', '0', 'D'), ('26', 'B88888888', '110979', '2', 'A', '1', 'A'), ('27', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('28', 'B88888888', '110979', '6', 'D', '1', 'D'), ('29', 'B88888888', '110979', '7', 'A', '1', 'A'), ('30', 'B88888888', '110979', '8', 'D', '1', 'D'), ('31', 'B88888888', '110979', '1', 'A', '0', 'D'), ('32', 'B88888888', '110979', '2', 'A', '1', 'A'), ('33', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('34', 'B88888888', '110979', '6', 'D', '1', 'D'), ('35', 'B88888888', '110979', '7', 'A', '1', 'A'), ('36', 'B88888888', '110979', '8', 'D', '1', 'D'), ('37', 'B88888888', '110979', '1', 'A', '0', 'D'), ('38', 'B88888888', '110979', '2', 'A', '1', 'A'), ('39', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('40', 'B88888888', '110979', '6', 'D', '1', 'D'), ('41', 'B88888888', '110979', '7', 'A', '1', 'A'), ('42', 'B88888888', '110979', '8', 'D', '1', 'D'), ('43', 'B88888888', '110979', '1', 'A', '0', 'D'), ('44', 'B88888888', '110979', '2', 'A', '1', 'A'), ('45', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('46', 'B88888888', '110979', '6', 'D', '1', 'D'), ('47', 'B88888888', '110979', '7', 'A', '1', 'A'), ('48', 'B88888888', '110979', '8', 'D', '1', 'D'), ('49', 'B88888888', '110979', '1', 'A', '0', 'D'), ('50', 'B88888888', '110979', '2', 'A', '1', 'A'), ('51', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('52', 'B88888888', '110979', '6', 'D', '1', 'D'), ('53', 'B88888888', '110979', '7', 'A', '1', 'A'), ('54', 'B88888888', '110979', '8', 'D', '1', 'D'), ('55', 'B88888888', '110979', '1', 'A', '0', 'D'), ('56', 'B88888888', '110979', '2', 'A', '1', 'A'), ('57', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('58', 'B88888888', '110979', '6', 'D', '1', 'D'), ('59', 'B88888888', '110979', '7', 'G', '0', 'A'), ('60', 'B88888888', '110979', '8', 'D', '1', 'D'), ('61', 'B88888888', '110979', '1', 'A', '0', 'D'), ('62', 'B88888888', '110979', '2', 'A', '1', 'A'), ('63', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('64', 'B88888888', '110979', '6', 'D', '1', 'D'), ('65', 'B88888888', '110979', '7', 'G', '0', 'A'), ('66', 'B88888888', '110979', '8', 'D', '1', 'D'), ('67', 'B88888888', '110979', '1', 'A', '1', 'D'), ('68', 'B88888888', '110979', '2', 'A', '1', 'A'), ('69', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('70', 'B88888888', '110979', '6', 'D', '1', 'D'), ('71', 'B88888888', '110979', '7', 'G', '0', 'A'), ('72', 'B88888888', '110979', '8', 'D', '1', 'D'), ('73', 'B88888888', '110979', '1', 'A', '0', 'D'), ('74', 'B88888888', '110979', '2', 'A', '1', 'A'), ('75', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('76', 'B88888888', '110979', '6', 'D', '1', 'D'), ('77', 'B88888888', '110979', '7', 'G', '0', 'A'), ('78', 'B88888888', '110979', '8', 'D', '1', 'D'), ('79', 'B88888888', '110979', '1', 'A', '0', 'D'), ('80', 'B88888888', '110979', '2', 'A', '1', 'A'), ('81', 'B88888888', '110979', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('82', 'B88888888', '110979', '6', 'D', '1', 'D'), ('83', 'B88888888', '110979', '7', 'G', '0', 'A'), ('84', 'B88888888', '110979', '8', 'D', '1', 'D'), ('85', 'B88888888', '134474', '1', 'A', '0', 'D'), ('86', 'B88888888', '134474', '2', 'A', '1', 'A'), ('87', 'B88888888', '134474', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('88', 'B88888888', '134474', '6', 'D', '1', 'D'), ('89', 'B88888888', '134474', '7', 'G', '0', 'A'), ('90', 'B88888888', '134474', '8', 'D', '1', 'D'), ('91', 'B88888888', '134474', '1', 'A', '0', 'D'), ('92', 'B88888888', '134474', '2', 'A', '1', 'A'), ('93', 'B88888888', '134474', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('94', 'B88888888', '134474', '6', 'D', '1', 'D'), ('95', 'B88888888', '134474', '7', 'G', '0', 'A'), ('96', 'B88888888', '134474', '8', 'D', '1', 'D'), ('98', 'B88888888', '266181', '1', 'A', '0', 'D'), ('99', 'B88888888', '266181', '2', 'A', '1', 'A'), ('100', 'B88888888', '266181', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('101', 'B88888888', '266181', '6', 'D', '1', 'D'), ('102', 'B88888888', '266181', '7', 'G', '0', 'A'), ('103', 'B88888888', '266181', '8', 'D', '1', 'D'), ('104', 'B88888888', '266181', '9', 'A', '0', 'D'), ('105', 'B88888888', '284852', '1', 'A', '0', 'D'), ('106', 'B88888888', '284852', '2', 'A', '1', 'A'), ('107', 'B88888888', '284852', '3', '动态规划', '1', '动态规划,动态规划法,规划法动态'), ('108', 'B88888888', '284852', '6', 'D', '1', 'D'), ('109', 'B88888888', '284852', '7', 'G', '0', 'A'), ('110', 'B88888888', '284852', '8', 'D', '1', 'D'), ('111', 'B88888888', '284852', '9', 'A', '0', 'D');
COMMIT;

-- ----------------------------
--  Table structure for `Chapter`
-- ----------------------------
DROP TABLE IF EXISTS `Chapter`;
CREATE TABLE `Chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Chapter_Chapter_1` (`course_id`),
  CONSTRAINT `fk_Chapter_Chapter_1` FOREIGN KEY (`course_id`) REFERENCES `Course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Chapter`
-- ----------------------------
BEGIN;
INSERT INTO `Chapter` VALUES ('1', '第一章绪论', '1'), ('2', '第二章算法基础', '1'), ('3', '原子弹制造第一课时', '1'), ('5', '原子弹制造第一课时', '3');
COMMIT;

-- ----------------------------
--  Table structure for `Course`
-- ----------------------------
DROP TABLE IF EXISTS `Course`;
CREATE TABLE `Course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Course`
-- ----------------------------
BEGIN;
INSERT INTO `Course` VALUES ('1', '算法设计', 'admin'), ('2', '软件工程', 'admin'), ('3', '原子弹制造', 'admin'), ('5', '抢劫银行的基本方法', 'admin');
COMMIT;

-- ----------------------------
--  Table structure for `Question`
-- ----------------------------
DROP TABLE IF EXISTS `Question`;
CREATE TABLE `Question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) NOT NULL,
  `type` int(10) NOT NULL DEFAULT '0' COMMENT '题目类型：0选择1判断2填空',
  `content_type` int(10) NOT NULL DEFAULT '0' COMMENT '题目的展现形式，0为文字，1为图片',
  `content` text NOT NULL COMMENT '题目的描述，图片填图片名称，文字就填文字',
  `answer` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Question_Question_1` (`chapter_id`),
  CONSTRAINT `fk_Question_Question_1` FOREIGN KEY (`chapter_id`) REFERENCES `Chapter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Question`
-- ----------------------------
BEGIN;
INSERT INTO `Question` VALUES ('1', '1', '0', '0', '以下算法的时间复杂度为（ ）。void fun(int n) {\n    int i=l;\n    while(i<=n)\n        i=i*2;\n} A. O(n)    B. O(n2)    C. O(nlog2n)    D. O(log2n)', 'D'), ('2', '1', '0', '1', '129.jpg', 'A'), ('3', '1', '2', '0', '最长公共子序列算法利用的算法是____', '动态规划,动态规划法,规划法动态'), ('5', '2', '0', '1', '129.jpg', 'A'), ('6', '1', '0', '0', '以下算法的时间复杂度为（ ）。void fun(int n) {\n    int i=l;\n    while(i<=n)\n        i=i*2;\n} A. O(n)    B. O(n2)    C. O(nlog2n)    D. O(log2n)', 'D'), ('7', '1', '0', '0', '+---------+------+----------+\n| species | sex  | COUNT(*) |\n+---------+------+----------+\n| cat     | f    |        1 |\n| cat     | m    |        1 |\n| dog     | f    |        1 |\n| dog     | m    |        2 |\n+---------+------+----------+', 'A'), ('8', '1', '0', '0', '以下算法的时间复杂度为（ ）。void fun(int n) {\n    int i=l;\n    while(i<=n)\n        i=i*2;\n} A. O(n)    B. O(n2)    C. O(nlog2n)    D. O(log2n)', 'D'), ('9', '1', '0', '0', '以下算法的时间复杂度为（ ）。void fun(int n) {\n    int i=l;\n    while(i<=n)\n        i=i*2;\n} A. O(n)    B. O(n2)    C. O(nlog2n)    D. O(log2n)', 'D');
COMMIT;

-- ----------------------------
--  Table structure for `Testresult`
-- ----------------------------
DROP TABLE IF EXISTS `Testresult`;
CREATE TABLE `Testresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(255) NOT NULL,
  `chapter_id` int(10) NOT NULL,
  `accesscode` varchar(10) NOT NULL,
  `time` datetime NOT NULL,
  `right` int(10) NOT NULL,
  `all` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Testresult`
-- ----------------------------
BEGIN;
INSERT INTO `Testresult` VALUES ('1', 'admin', '1', '050861', '0000-00-00 00:00:00', '5', '6'), ('2', 'admin', '1', '054842', '0000-00-00 00:00:00', '5', '6'), ('3', 'admin', '1', '134474', '2016-03-15 00:00:00', '1', '6'), ('6', 'B66666666', '1', '134474', '2016-03-16 00:00:00', '4', '6'), ('7', 'B11111111', '1', '134474', '2016-03-16 07:00:00', '6', '6'), ('14', 'B03030303', '1', '134474', '2016-03-16 16:55:56', '6', '6'), ('19', 'B88888888', '1', '134474', '2016-03-16 21:25:16', '4', '6'), ('20', 'B88888888', '1', '266181', '2016-03-18 10:00:10', '4', '7'), ('21', 'B88888888', '1', '284852', '2016-03-18 15:10:07', '4', '7');
COMMIT;

-- ----------------------------
--  Table structure for `ci_sessions`
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `ci_sessions`
-- ----------------------------
BEGIN;
INSERT INTO `ci_sessions` VALUES ('037ad3be99df4539fbcb1760df4903a3b0c4b2cf', '127.0.0.1', '1458134885', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383133343731363b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('0f911b184cd19bd5ea8ed1c999275466e2c3af5d', '127.0.0.1', '1458208067', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383230373935373b757365725f69647c733a353a2261646d696e223b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('14c7d52403f21bada40b26dc7059ed714f932f4e', '127.0.0.1', '1458114784', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383131343439373b6f70656e5f69647c733a343a2231323031223b73747564656e745f69647c733a393a22423838383838383838223b), ('1c782a5063049c37b035a7dd01ecf4724906d6ef', '127.0.0.1', '1458140692', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383134303434373b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b757365725f69647c733a353a2261646d696e223b), ('1fcd4f01adfd6ac92a69e074b8ac05e365f73ed2', '127.0.0.1', '1458116274', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383131363137373b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('2175fdabdcce7a2036ff4fe3994a10aca5d38a35', '127.0.0.1', '1458200800', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383230303532303b757365725f69647c733a353a2261646d696e223b), ('229f687aa1c959cf67fa8df4e5e28331ecc590fb', '127.0.0.1', '1458125755', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383132353636383b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('28efe28429cfbadd73d7a92aee04160a1cdb497c', '127.0.0.1', '1458263683', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383236333430333b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('44899853f1bbb2166002b98d06248b6c126759aa', '127.0.0.1', '1458277915', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383237373836383b), ('44eceaaee29a57ac2b47ffe6a7f6931f3cf1a115', '127.0.0.1', '1458139260', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383133393032333b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b757365725f69647c733a353a2261646d696e223b), ('56644ceb9ce5247eb28d30b9fa24a37671cbb5e0', '127.0.0.1', '1458266449', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383236363238333b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('60e309b16ae92eb6a882e23795ba1ade9859b11c', '127.0.0.1', '1458200451', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383230303137313b757365725f69647c733a353a2261646d696e223b), ('642d4c82c6cd89c33a70c87a913487418ccf7265', '127.0.0.1', '1458134503', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383133343339333b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('753c2fd451cb681ec602500dfac4a9754c23127e', '127.0.0.1', '1458201031', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383230303834353b757365725f69647c733a353a2261646d696e223b), ('7ebaba78f28e68c3bd100a7f045c8d5a74bd651a', '127.0.0.1', '1458285736', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383238353733363b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('803bff4146375138fdac441b27c3ab78fdb734ef', '127.0.0.1', '1458284860', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383238343630353b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('812ab26207bea8f591b19da88d74f232d1109d0a', '127.0.0.1', '1458266250', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383236353935353b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('823211d2227222d30ce3df1f157953f187b327ed', '127.0.0.1', '1458117675', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383131373438323b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('83893f0fafe0b5a3a2e1317679a5df921102104a', '127.0.0.1', '1458283206', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383238323932323b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('8c828b4eb43b78aa2afccc793c9f4c5721d462b9', '127.0.0.1', '1458139582', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383133393332353b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b757365725f69647c733a353a2261646d696e223b), ('91263f8add63777740a8b4f2352ffba4902fde21', '127.0.0.1', '1458199366', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383139393336363b757365725f69647c733a353a2261646d696e223b), ('956569b943875ad048c1ea30f22d5bb0f75d3b13', '127.0.0.1', '1458217591', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383231373432333b757365725f69647c733a353a2261646d696e223b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('9a82c3a51dd364c9316550242483f743f3f7f5ad', '127.0.0.1', '1458201379', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383230313136343b757365725f69647c733a353a2261646d696e223b), ('9d06bc38342661566bee48140eb6ef2c02376416', '127.0.0.1', '1458203254', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383230333232353b757365725f69647c733a353a2261646d696e223b), ('a219a3b3577be3fcdffa4accf02c64f647d5c5f7', '127.0.0.1', '1458178965', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383137383933313b757365725f69647c733a353a2261646d696e223b), ('a4dc166e6c7d11fbb0f6c3708f3938234e2dc7e0', '127.0.0.1', '1458282351', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383238323039363b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('ad4c3d6283e2ca87e488c9f1fab4a5eb805985fb', '127.0.0.1', '1458265627', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383236353531383b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('aed4ca8567dcf01891b87a46229ac5cca807708d', '127.0.0.1', '1458217297', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383231373039393b757365725f69647c733a353a2261646d696e223b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('b018e84aa129a02a5c4d95bc0ac64916f88f98e5', '127.0.0.1', '1458267963', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383236373931303b), ('b3509a3d7e09662c2d219580b2fb3d211cf07b72', '127.0.0.1', '1458140362', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383134303133393b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b757365725f69647c733a353a2261646d696e223b), ('bc06207b243e07b3ea7a9d2fdfdd30f436e51c40', '127.0.0.1', '1458204279', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383230343037363b757365725f69647c733a353a2261646d696e223b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('bd0867fa7a3aee6c7b7330b0b505724ae0a6e719', '127.0.0.1', '1458138999', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383133383731323b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b757365725f69647c733a353a2261646d696e223b), ('c427dbf887f3f3013a22fbd2d3fcab0434b2ed4d', '127.0.0.1', '1458201722', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383230313438343b757365725f69647c733a353a2261646d696e223b), ('cc3de15af77b8f1f1c4b580871d1f4560b677314', '127.0.0.1', '1458207435', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383230373134343b757365725f69647c733a353a2261646d696e223b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('d178faa11f7b9fa27c9e1c4ea2593d9c0bd9c33e', '127.0.0.1', '1458121554', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383132313535343b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('d951f8987ae59d6252c83c3b0e1c374f56bd8581', '127.0.0.1', '1458115014', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383131343833353b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('e3c84b3076ef292f4bcc1725de589ba63dfd1ba9', '127.0.0.1', '1458283607', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383238333434353b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('e4b8716c690d8388867e97a42621133de0ad94da', '127.0.0.1', '1458282730', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383238323537393b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('e7f2e5600c910694bda1c3e6bf273af0b1a43b22', '127.0.0.1', '1458118716', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383131383731363b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('ec761de1c3fe3f091571db4c18b9e6da49e59351', '127.0.0.1', '1458119487', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383131393335343b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('ed72546a7a1ecffd19ba060f59ca97e68b544e46', '127.0.0.1', '1458263774', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383236333737343b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b), ('ef1e20598722a1efc7c965db58f02a12b08f8a7d', '127.0.0.1', '1458199828', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383139393832383b757365725f69647c733a353a2261646d696e223b), ('f3664fae532b574a4c38a9c9f0fe25db15ee0624', '127.0.0.1', '1458199016', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383139393031363b757365725f69647c733a353a2261646d696e223b), ('f743b887977803851ce354b724584d322bbb1266', '127.0.0.1', '1458284250', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383238343036353b6f70656e5f69647c733a353a2261646d696e223b73747564656e745f69647c733a393a22423630303030303030223b), ('fecccf675ced7c7589a4e4d86b7143a5cc5aae6a', '127.0.0.1', '1458285007', 0x5f5f63695f6c6173745f726567656e65726174657c693a313435383238353030373b6f70656e5f69647c733a343a2231313131223b73747564656e745f69647c733a393a22423838383838383838223b);
COMMIT;

-- ----------------------------
--  Table structure for `user_info`
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `open_id` varchar(100) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`open_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `user_info`
-- ----------------------------
BEGIN;
INSERT INTO `user_info` VALUES ('1111', 'B88888888', '吃夜宵'), ('1201', 'admin', '大柱'), ('1301', 'B66666666', '二狗'), ('1101', 'B11111111', '蔡宇轩'), ('16163513', 'B03030303', '毛驴'), ('admin', 'B60000000', '猪蹄'), ('1899', 'B14020229', '蔡宇轩');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
