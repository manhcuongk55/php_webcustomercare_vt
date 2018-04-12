
DROP TABLE IF EXISTS `tbl_member_level`;
CREATE TABLE `tbl_member_level` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` tinyint(4) DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `identify` int(11) NOT NULL DEFAULT '0',
  `position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permistion` tinyint(2) NOT NULL,
  `sufixes` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cdate` datetime NOT NULL,
  `mdate` date NOT NULL,
  `isactive` int(11) DEFAULT '1',
  `avatar` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `11` (`id`),
  KEY `username` (`username`),
  KEY `isactive` (`isactive`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tbl_member_level
-- ----------------------------
INSERT INTO `tbl_member_level` VALUES ('administrator', 'd2bb9c3211ea6baed657a6c23c9c2faa', '2', null, '0989868868', 'Administrator', '168678678', 'Quản trị viên', '1', '0', '2016-05-23 00:00:00', '2016-06-12', '1', null);
INSERT INTO `tbl_member_level` VALUES ('admin', 'd2bb9c3211ea6baed657a6c23c9c2faa', '46', null, '0978666555', 'Hoàng Anh Tuấn', '0', null, '1', '', '0000-00-00 00:00:00', '0000-00-00', '1', null);

-- ----------------------------
-- Table structure for tbl_schedule
-- ----------------------------
DROP TABLE IF EXISTS `tbl_schedule`;
CREATE TABLE `tbl_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `event_subject` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `event_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `all_day` tinyint(1) NOT NULL,
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL,
  `cdate` datetime NOT NULL,
  `mdate` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_schedule
-- ----------------------------
INSERT INTO `tbl_schedule` VALUES ('80', '2', '54', '2', 'Chị Hà hẹn qua điều trị vết nám', 'Opavn xin thông bao: Chiều nay, 2h chị có lịch hẹn qua điều trị vết nám, C nhớ đến đúng giờ nhé', '0', '2017-03-09 14:00:00', '2017-03-09 15:00:00', '2017-03-08 21:49:03', '2017-03-08 21:58:43', '0');
INSERT INTO `tbl_schedule` VALUES ('81', '2', '55', '3', 'Chị Hằng hẹn qua tư vấn', 'Opa thông báo: Sáng mai vào lúc 10h chị có hẹn qua Trung tâm tư vấn. Chị nhớ đến đúng giờ nhé.', '0', '2017-03-09 10:00:00', '2017-03-09 10:30:00', '2017-03-08 23:40:54', '2017-03-08 23:40:54', '0');

-- ----------------------------
-- Table structure for tbl_service
-- ----------------------------
DROP TABLE IF EXISTS `tbl_service`;
CREATE TABLE `tbl_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `sale` int(11) NOT NULL,
  `note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_service
-- ----------------------------
INSERT INTO `tbl_service` VALUES ('1', 'Làm trắng da toàn thân', '1550000', '0', '																																');
INSERT INTO `tbl_service` VALUES ('2', 'Trị nám da mặt', '2050000', '0', '');
INSERT INTO `tbl_service` VALUES ('3', 'Tư vấn điều trị', '0', '0', '');

-- ----------------------------
-- Table structure for tbl_sms
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sms`;
CREATE TABLE `tbl_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time_send` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sms
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` int(11) NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `avatar` text COLLATE utf8_unicode_ci NOT NULL,
  `cdate` datetime NOT NULL,
  `isactive` tinyint(4) NOT NULL DEFAULT '1',
  `mem_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('54', 'Trần Thu Hà', 'Nữ', '01656241161', '874602000', 'Nhà số 1 Trần Cung', '0', '', '2017-03-08 21:13:39', '1', '2');
INSERT INTO `tbl_user` VALUES ('55', 'Nguyễn Thị Thu Hằng', 'Nữ', '0975837250', '182970000', 'Số 68 Tam Trinh - Hoàng Mai - Hà Nội', '0', '', '2017-03-08 21:14:56', '1', '2');
INSERT INTO `tbl_user` VALUES ('56', 'Trần Diệu Linh', 'Nữ', '01682118888', '724698000', 'Số 3 Ngách 28/30 Tăng Thiết Giáp HN', '1', '', '2017-03-08 21:16:29', '1', '2');
