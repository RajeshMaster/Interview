/*
Navicat MySQL Data Transfer

Source Server         : invoice
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : asset_db

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2020-09-23 16:24:22
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `ams_address`
-- ----------------------------
DROP TABLE IF EXISTS `ams_address`;
CREATE TABLE `ams_address` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `userId` varchar(10) NOT NULL,
  `houseId` varchar(10) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `buildingName` varchar(100) NOT NULL,
  `houseName` varchar(100) DEFAULT NULL,
  `houseNo` varchar(10) DEFAULT NULL,
  `createdBy` varchar(30) NOT NULL,
  `createdDateTime` datetime NOT NULL,
  `updatedBy` varchar(30) DEFAULT NULL,
  `updatedDateTime` datetime DEFAULT NULL,
  `delFlg` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_address
-- ----------------------------
INSERT INTO ams_address VALUES ('10', 'AD0000', 'HOUSE001', '532-0012', '西中島南方', '1', '大京ビルマンション - 606号', '606', 'Admin', '2020-09-11 11:26:06', 'Admin', '2020-09-11 11:26:06', '0');
INSERT INTO ams_address VALUES ('11', 'AD0000', 'HOUSE002', '532-0011', '大阪市西中島東淀川９－７－１４　２０７号', '2', 'チサンマンション - 207', null, 'Admin', '2020-09-09 06:11:23', 'Admin', '2020-09-09 06:11:23', '0');
INSERT INTO ams_address VALUES ('12', 'AD0000', 'HOUSE003', '532-1011', 'だいとうりょう', '2', 'チサンマンション -  204号', ' 204', 'Admin', '2020-09-14 00:57:30', 'Admin', '2020-09-14 00:57:30', '0');
INSERT INTO ams_address VALUES ('13', 'AD0000', 'HOUSE004', 'we', 'wwrw', '3', '大文ビルマンション - 401号', '401', 'Admin', '2020-09-14 00:45:58', 'Admin', '2020-09-14 00:45:58', '0');
INSERT INTO ams_address VALUES ('14', 'AD0000', 'HOUSE005', '532-0111', '新大阪駅前', '4', 'Osaka Mansion - 404号', '404', 'Admin', '2020-09-11 09:46:29', 'Admin', '2020-09-11 09:46:29', '0');
INSERT INTO ams_address VALUES ('15', 'AD0000', 'HOUSE006', '5320999', '西中島南方', '1', '大京ビルマンション - 904号', '904', 'Admin', '2020-09-11 09:32:36', 'Admin', '2020-09-11 09:32:36', '0');
INSERT INTO ams_address VALUES ('16', 'AD0000', 'HOUSE007', '7645637', '西中島南方', '1', '大京ビルマンション - 608 号', null, 'Admin', '2020-09-09 07:09:11', 'Admin', '2020-09-09 07:09:11', '0');

-- ----------------------------
-- Table structure for `ams_assets_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_assets_details`;
CREATE TABLE `ams_assets_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(20) DEFAULT NULL,
  `houseId` varchar(20) DEFAULT NULL,
  `belongsTo` varchar(50) DEFAULT '0',
  `Date` varchar(20) DEFAULT NULL,
  `Month` varchar(20) DEFAULT NULL,
  `Year` varchar(20) DEFAULT NULL,
  `assetsAmount` varchar(30) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(50) DEFAULT NULL,
  `updatedDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` varchar(50) DEFAULT NULL,
  `delFlg` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_assets_details
-- ----------------------------
INSERT INTO ams_assets_details VALUES ('1', 'AD0000', 'HOUSE004', '1', '1', '9', '2020', '1200', 'House', '2020-09-18 18:57:27', 'Admin', '2020-09-18 18:57:27', null, '0');
INSERT INTO ams_assets_details VALUES ('2', 'AD0000', 'HOUSE004', '1', '1', '10', '2020', '1300', 'House', '2020-09-18 18:57:27', 'Admin', '2020-09-18 18:59:16', null, '0');
INSERT INTO ams_assets_details VALUES ('3', 'AD0000', 'HOUSE005', '1', '1', '9', '2020', '1500', '', '2020-09-18 18:58:57', 'Admin', '2020-09-18 18:58:57', null, '0');
INSERT INTO ams_assets_details VALUES ('4', 'AD0000', 'HOUSE005', '1', '1', '10', '2020', '1500', '', '2020-09-18 18:58:57', 'Admin', '2020-09-18 18:58:57', null, '0');
INSERT INTO ams_assets_details VALUES ('5', 'AD0000', 'HOUSE004', '1', '1', '8', '2020', '1300', 'House', '2020-09-18 18:59:27', 'Admin', '2020-09-18 18:59:27', null, '0');

-- ----------------------------
-- Table structure for `ams_balsheet_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_balsheet_details`;
CREATE TABLE `ams_balsheet_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` varchar(10) NOT NULL,
  `totalAsset` varchar(30) DEFAULT NULL,
  `totalLiability` varchar(30) DEFAULT NULL,
  `netAsset` varchar(30) DEFAULT NULL,
  `increasedAsset` varchar(30) DEFAULT NULL,
  `increasedPercent` varchar(10) DEFAULT NULL,
  `year` int(5) DEFAULT NULL,
  `month` int(5) DEFAULT NULL,
  `createdBy` varchar(30) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` varchar(30) DEFAULT NULL,
  `updatedDateTime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `delFlg` int(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_balsheet_details
-- ----------------------------
INSERT INTO ams_balsheet_details VALUES ('1', 'AD0000', '1600', '2627', '-1027', '0', '0', '2020', '8', 'Admin', '2020-09-18 19:00:15', null, null, '0');
INSERT INTO ams_balsheet_details VALUES ('2', 'AD0000', '0', '2649', '-2649', '0', '0', '2020', '7', 'Admin', '2020-09-18 19:40:37', null, null, '0');
INSERT INTO ams_balsheet_details VALUES ('3', 'AD0000', '4037', '5594', '-1557', '-530', '52', '2020', '9', 'Admin', '2020-09-18 19:42:28', null, null, '0');

-- ----------------------------
-- Table structure for `ams_bankname_master`
-- ----------------------------
DROP TABLE IF EXISTS `ams_bankname_master`;
CREATE TABLE `ams_bankname_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `bankName` varchar(100) DEFAULT NULL,
  `nickName` varchar(100) DEFAULT NULL,
  `createdBy` varchar(10) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(10) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` datetime DEFAULT NULL COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0' COMMENT '0 - Use , 1 - Not In Use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_bankname_master
-- ----------------------------
INSERT INTO ams_bankname_master VALUES ('1', '1', '東京UFJ銀行', 'UFJ', 'Admin', '2020-08-27 14:48:38', 'Admin', '2020-08-27 14:48:46', '0');
INSERT INTO ams_bankname_master VALUES ('2', '2', '北おおさか信用金庫', '北おおさか', 'Admin', '2020-08-27 14:52:21', 'Admin', '2020-08-27 14:52:26', '0');
INSERT INTO ams_bankname_master VALUES ('3', '3', '大阪信用金庫', '大阪信用金庫', 'Admin', '2020-08-27 14:53:06', 'Admin', '2020-08-27 14:53:12', '0');

-- ----------------------------
-- Table structure for `ams_bank_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_bank_details`;
CREATE TABLE `ams_bank_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(100) DEFAULT NULL,
  `bankUserName` varchar(50) DEFAULT NULL,
  `kanaName` varchar(50) DEFAULT NULL,
  `accountNo` varchar(100) DEFAULT NULL,
  `bankName` varchar(100) DEFAULT NULL,
  `bankNickName` varchar(100) DEFAULT NULL,
  `branchName` varchar(100) DEFAULT NULL,
  `branchNo` varchar(100) DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` varchar(50) DEFAULT NULL,
  `updatedDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delflg` int(11) NOT NULL DEFAULT '0',
  `mainFlg` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_bank_details
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_expenses_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_expenses_details`;
CREATE TABLE `ams_expenses_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(20) DEFAULT NULL,
  `houseId` varchar(20) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `mainExpenseId` int(5) DEFAULT '0',
  `subExpenseId` int(5) DEFAULT '0',
  `Month` varchar(20) DEFAULT NULL,
  `expenseAmount` varchar(30) DEFAULT NULL,
  `bill_Image` varchar(30) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(50) DEFAULT NULL,
  `updatedDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` varchar(50) DEFAULT NULL,
  `activeFlg` int(3) NOT NULL DEFAULT '0',
  `delFlg` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_expenses_details
-- ----------------------------
INSERT INTO ams_expenses_details VALUES ('1', 'AD0000', 'HOUSE001', '2020-07-01', '1', '1', '7', '5000', '2020-07_1.PNG', '', '2020-08-29 21:04:05', 'Admin', '2020-08-29 21:04:05', null, '0', '0');
INSERT INTO ams_expenses_details VALUES ('2', 'AD0000', 'HOUSE002', '2020-08-29', '2', '2', '5', '16680', '2020-08_2.jpg', '', '2020-08-29 21:52:37', 'Admin', '2020-08-29 22:25:04', 'Admin', '0', '0');
INSERT INTO ams_expenses_details VALUES ('3', 'AD0000', 'HOUSE003', '2020-08-29', '1', '3', '5', '5555', '', '', '2020-08-30 12:11:49', 'Admin', '2020-08-31 22:58:09', 'Admin', '0', '0');
INSERT INTO ams_expenses_details VALUES ('4', 'AD0000', 'HOUSE001', '2020-08-28', '2', '1', '6', '5874', '', '', '2020-08-30 12:12:12', 'Admin', '2020-08-30 12:12:12', null, '0', '0');
INSERT INTO ams_expenses_details VALUES ('5', 'AD0000', 'HOUSE002', '2020-01-10', '3', '4', '1', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('6', 'AD0000', 'HOUSE002', '2020-02-10', '3', '4', '2', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('7', 'AD0000', 'HOUSE002', '2020-03-10', '3', '4', '3', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('8', 'AD0000', 'HOUSE002', '2020-04-10', '3', '4', '4', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('9', 'AD0000', 'HOUSE002', '2020-05-10', '3', '4', '5', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('10', 'AD0000', 'HOUSE002', '2020-06-10', '3', '4', '6', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('11', 'AD0000', 'HOUSE002', '2020-07-10', '3', '4', '7', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('12', 'AD0000', 'HOUSE002', '2020-08-10', '3', '4', '8', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('13', 'AD0000', 'HOUSE002', '2020-09-10', '3', '4', '9', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('14', 'AD0000', 'HOUSE002', '2020-10-10', '3', '4', '10', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('15', 'AD0000', 'HOUSE002', '2020-11-10', '3', '4', '11', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');
INSERT INTO ams_expenses_details VALUES ('16', 'AD0000', 'HOUSE002', '2020-12-10', '3', '4', '12', '9500', null, null, '2020-09-10 14:35:13', 'Admin', '2020-09-10 14:35:13', null, '1', '0');

-- ----------------------------
-- Table structure for `ams_expenses_master`
-- ----------------------------
DROP TABLE IF EXISTS `ams_expenses_master`;
CREATE TABLE `ams_expenses_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `createdBy` varchar(10) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(10) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` datetime DEFAULT NULL COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0' COMMENT '0 - Use , 1 - Not In Use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_expenses_master
-- ----------------------------

-- ----------------------------
-- Table structure for `ams_family_master`
-- ----------------------------
DROP TABLE IF EXISTS `ams_family_master`;
CREATE TABLE `ams_family_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `familyName` varchar(100) DEFAULT NULL,
  `createdBy` varchar(10) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(10) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` datetime DEFAULT NULL COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0' COMMENT '0 - Use , 1 - Not In Use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_family_master
-- ----------------------------
INSERT INTO ams_family_master VALUES ('1', '1', 'Father', 'Admin', '2020-08-27 05:44:42', 'Admin', '2020-08-27 05:44:42', '0');
INSERT INTO ams_family_master VALUES ('2', '2', 'Mother', 'Admin', '2020-08-27 05:44:52', 'Admin', '2020-08-27 05:44:52', '0');
INSERT INTO ams_family_master VALUES ('3', '3', 'Son', 'Admin', '2020-08-27 05:44:57', 'Admin', '2020-08-27 05:44:57', '0');

-- ----------------------------
-- Table structure for `ams_house_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_house_details`;
CREATE TABLE `ams_house_details` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `userId` varchar(10) NOT NULL,
  `houseId` varchar(10) DEFAULT NULL,
  `belongsTo` varchar(30) DEFAULT NULL,
  `purchaseDate` date NOT NULL,
  `purchaseAmount` varchar(30) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `buildingName` varchar(50) DEFAULT NULL,
  `houseNo` varchar(10) DEFAULT NULL,
  `houseName` varchar(100) DEFAULT NULL,
  `image1` varchar(30) DEFAULT NULL,
  `houseSize` varchar(30) DEFAULT NULL,
  `houseType` varchar(30) DEFAULT NULL,
  `balaconySize` varchar(30) DEFAULT NULL,
  `houseBuildOn` varchar(12) DEFAULT NULL,
  `maintFees` varchar(20) DEFAULT NULL,
  `currentValue` varchar(30) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `bankId` int(3) DEFAULT NULL,
  `loanFlg` int(3) NOT NULL DEFAULT '0',
  `createdBy` varchar(30) NOT NULL,
  `createdDateTime` datetime NOT NULL,
  `updatedBy` varchar(30) DEFAULT NULL,
  `updatedDateTime` datetime DEFAULT NULL,
  `delFlg` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_house_details
-- ----------------------------
INSERT INTO ams_house_details VALUES ('1', 'AD0000', 'HOUSE001', '1', '2020-08-26', '500', '532-0012', '西中島南方', '1', '606', '大京ビルマンション - 606号', 'HOUSE001.jpg', '', '', '', '', '', '720', '', '0', '0', 'Admin', '2020-08-26 01:07:57', 'Admin', '2020-09-11 11:26:06', '0');
INSERT INTO ams_house_details VALUES ('2', 'AD0000', 'HOUSE002', '2', '2020-08-26', '500', '532-0011', '大阪市西中島東淀川９－７－１４　２０７号', '2', null, 'チサンマンション - 207', 'HOUSE002.png', '', '', '', '', null, null, null, '0', '0', 'Admin', '2020-08-26 02:10:07', 'Admin', '2020-09-09 06:11:23', '0');
INSERT INTO ams_house_details VALUES ('7', 'AD0000', 'HOUSE003', '3', '2020-08-13', '434', '532-1011', 'だいとうりょう', '2', ' 204', 'チサンマンション -  204号', 'HOUSE003.JPG', '', '', '', '', '', '700', '', '0', '0', 'Admin', '2020-08-27 04:39:00', 'Admin', '2020-09-14 00:57:30', '0');
INSERT INTO ams_house_details VALUES ('8', 'AD0000', 'HOUSE004', '1', '2020-08-04', '123', 'we', 'wwrw', '3', '401', '大文ビルマンション - 401号', 'HOUSE004.jpg', '', '', '', '', '', '1200', '', '0', '0', 'Admin', '2020-08-27 04:56:14', 'Admin', '2020-09-14 00:45:58', '0');
INSERT INTO ams_house_details VALUES ('9', 'AD0000', 'HOUSE005', '1', '2020-09-01', '500', '532-0111', '新大阪駅前', '4', '404', 'Osaka Mansion - 404号', 'HOUSE005.jpg', '', '', '', '', '', '720', '', '0', '0', 'Admin', '2020-09-09 02:26:16', 'Admin', '2020-09-11 09:46:29', '0');
INSERT INTO ams_house_details VALUES ('10', 'AD0000', 'HOUSE006', '1', '2020-09-10', '100', '5320999', '西中島南方', '1', '904', '大京ビルマンション - 904号', 'HOUSE006.jpg', '', '', '', '', '1000', '120', '10000', '3', '1', 'Admin', '2020-09-09 07:00:03', 'Admin', '2020-09-11 09:32:36', '0');
INSERT INTO ams_house_details VALUES ('11', 'AD0000', 'HOUSE007', '2', '2020-09-12', '200', '7645637', '西中島南方', '1', null, '大京ビルマンション - 608 号', 'HOUSE007.jpg', '', '', '', '', null, null, null, '3', '1', 'Admin', '2020-09-09 07:09:11', null, null, '0');

-- ----------------------------
-- Table structure for `ams_house_images`
-- ----------------------------
DROP TABLE IF EXISTS `ams_house_images`;
CREATE TABLE `ams_house_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(30) DEFAULT NULL,
  `houseId` varchar(30) DEFAULT NULL,
  `mainCategory` varchar(100) DEFAULT NULL,
  `subCategory` varchar(100) DEFAULT NULL,
  `fileName` varchar(100) DEFAULT NULL,
  `createdBy` varchar(30) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(30) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_house_images
-- ----------------------------
INSERT INTO ams_house_images VALUES ('1', 'AD0000', 'HOUSE006', '1', '1', 'HAll 1_1.jpg', 'Admin', '2020-09-11 14:49:31', null, '2020-09-11 23:49:31', '0');

-- ----------------------------
-- Table structure for `ams_income_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_income_details`;
CREATE TABLE `ams_income_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(20) DEFAULT NULL,
  `houseId` varchar(20) DEFAULT NULL,
  `subject` varchar(50) DEFAULT '0',
  `others` varchar(50) DEFAULT '0',
  `Date` varchar(20) DEFAULT NULL,
  `Month` varchar(20) DEFAULT NULL,
  `Year` varchar(20) DEFAULT NULL,
  `incomeAmount` varchar(30) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(50) DEFAULT NULL,
  `updatedDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` varchar(50) DEFAULT NULL,
  `delFlg` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_income_details
-- ----------------------------
INSERT INTO ams_income_details VALUES ('1', 'AD0000', 'HOUSE001', 'Rent', '', '13', '1', '2020', '5000', '2020-09-08 21:09:35', 'Admin', '2020-09-08 21:09:35', null, '0');
INSERT INTO ams_income_details VALUES ('2', 'AD0000', 'HOUSE001', 'Rent', '', '13', '2', '2020', '5000', '2020-09-08 21:09:35', 'Admin', '2020-09-08 21:09:35', null, '0');
INSERT INTO ams_income_details VALUES ('3', 'AD0000', 'HOUSE002', 'Rent', '', '11', '3', '2020', '6000', '2020-09-08 21:10:00', 'Admin', '2020-09-08 21:10:00', null, '0');
INSERT INTO ams_income_details VALUES ('4', 'AD0000', 'HOUSE002', 'Rent', '', '11', '4', '2020', '6000', '2020-09-08 21:10:00', 'Admin', '2020-09-08 21:10:00', null, '0');
INSERT INTO ams_income_details VALUES ('5', 'AD0000', 'HOUSE002', 'Rent', '', '11', '5', '2020', '6000', '2020-09-08 21:10:00', 'Admin', '2020-09-08 21:10:00', null, '0');
INSERT INTO ams_income_details VALUES ('6', 'AD0000', 'HOUSE003', 'Others', 'EB Bill', '12', '4', '2020', '7000', '2020-09-08 21:10:29', 'Admin', '2020-09-08 21:10:29', null, '0');
INSERT INTO ams_income_details VALUES ('7', 'AD0000', 'HOUSE003', 'Others', 'EB Bill', '12', '6', '2020', '7000', '2020-09-08 21:10:29', 'Admin', '2020-09-08 21:10:29', null, '0');
INSERT INTO ams_income_details VALUES ('8', 'AD0000', 'HOUSE003', 'Others', 'EB Bill', '12', '7', '2020', '7000', '2020-09-08 21:10:29', 'Admin', '2020-09-08 21:10:29', null, '0');
INSERT INTO ams_income_details VALUES ('9', 'AD0000', 'HOUSE001', 'Others', 'EB Bill', '2', '1', '2021', '8000', '2020-09-08 21:30:05', 'Admin', '2020-09-08 21:30:05', null, '0');
INSERT INTO ams_income_details VALUES ('10', 'AD0000', 'HOUSE001', 'Others', 'EB Bill', '2', '2', '2021', '8000', '2020-09-08 21:30:05', 'Admin', '2020-09-08 21:30:05', null, '0');
INSERT INTO ams_income_details VALUES ('11', 'AD0000', '1', 'Rent', '', '8', '4', '2020', '10000', '2020-09-09 15:17:08', 'Admin', '2020-09-09 15:17:08', null, '0');

-- ----------------------------
-- Table structure for `ams_loan_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_loan_details`;
CREATE TABLE `ams_loan_details` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userId` varchar(10) DEFAULT NULL,
  `loanId` varchar(10) DEFAULT NULL,
  `loanName` varchar(100) DEFAULT NULL,
  `houseAddress` varchar(100) DEFAULT NULL,
  `loanAmount` int(30) DEFAULT NULL,
  `interestRate` varchar(10) DEFAULT NULL,
  `loanTerm` int(3) DEFAULT NULL,
  `paymentCount` int(3) DEFAULT NULL,
  `perMonthTotal` int(3) NOT NULL,
  `perMonthAmount` int(30) NOT NULL,
  `startDate` varchar(12) DEFAULT NULL,
  `emiDate` varchar(12) DEFAULT NULL,
  `endDate` varchar(12) DEFAULT NULL,
  `belongsTo` int(3) DEFAULT NULL,
  `bank` int(3) DEFAULT NULL,
  `createdBy` varchar(30) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL,
  `updatedBy` varchar(30) DEFAULT NULL,
  `updatedDateTime` datetime DEFAULT NULL,
  `activeFlg` int(3) NOT NULL DEFAULT '0',
  `delFlg` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_loan_details
-- ----------------------------
INSERT INTO ams_loan_details VALUES ('1', 'AD0000', 'LOAN001', 'チサンマンション - 305号', 'HOUSE001', '1200', '12', '12', '12', '0', '0', '2020-01-07', '2020-01-10', '2020-09-23', '1', '1', 'Admin', '2020-09-15 13:33:29', 'Admin', '2020-09-17 07:28:16', '1', '0');
INSERT INTO ams_loan_details VALUES ('2', 'AD0000', 'LOAN002', 'Others', 'Others', '1000', '10', '12', '12', '0', '0', '2020-06-01', '2020-06-10', null, '1', '1', 'Admin', '2020-09-15 13:35:34', null, null, '0', '0');
INSERT INTO ams_loan_details VALUES ('3', 'AD0000', 'LOAN003', 'チサンマンション - 207号', 'HOUSE005', '500', '3.1', '3', '12', '2', '138000', '2020-07-09', '2020-07-10', null, '2', '3', 'Admin', '2020-09-17 07:11:34', 'Admin', '2020-09-17 07:13:22', '0', '0');
INSERT INTO ams_loan_details VALUES ('4', 'AD0000', 'LOAN004', 'Osaka Mansion - 608号', 'HOUSE004', '400', '10', '8', '12', '0', '0', '2020-09-26', '2020-09-28', '2020-08-31', '1', '1', 'Admin', '2020-09-17 15:34:10', 'Admin', '2020-09-23 02:50:02', '1', '0');
INSERT INTO ams_loan_details VALUES ('5', 'AD0000', 'LOAN005', '大京ビルマンション - 904号', 'HOUSE002', '2000', '5', '7', '12', '0', '0', '2020-09-01', '2021-03-02', null, '1', '1', 'Admin', '2020-09-17 23:53:02', 'Admin', '2020-09-17 23:54:08', '0', '0');
INSERT INTO ams_loan_details VALUES ('6', 'AD0000', 'LOAN006', 'Others', 'Others', '600', '4', '4', '4', '1', '100000', '2020-01-01', '2020-01-01', null, '3', '1', 'Admin', '2020-09-17 23:58:59', 'Admin', '2020-09-23 05:50:33', '0', '0');
INSERT INTO ams_loan_details VALUES ('7', 'AD0000', 'LOAN007', 'Jewel loan', 'Others', '100', '10', '1', '12', '0', '0', '2019-01-01', '2019-01-01', null, '2', '2', 'Admin', '2020-09-23 02:46:25', 'Admin', '2020-09-23 07:11:17', '0', '0');

-- ----------------------------
-- Table structure for `ams_loan_emidetails`
-- ----------------------------
DROP TABLE IF EXISTS `ams_loan_emidetails`;
CREATE TABLE `ams_loan_emidetails` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `loanId` varchar(10) DEFAULT NULL,
  `userId` varchar(10) DEFAULT NULL,
  `bank` int(3) DEFAULT NULL,
  `belongsTo` int(3) DEFAULT NULL,
  `emiDate` varchar(12) DEFAULT NULL,
  `year` int(6) DEFAULT NULL,
  `month` int(3) DEFAULT NULL,
  `monthPayment` varchar(30) NOT NULL,
  `monthPrinciple` varchar(30) DEFAULT NULL,
  `monthInterest` varchar(30) DEFAULT NULL,
  `monthAmount` varchar(30) DEFAULT NULL,
  `loanBalance` varchar(30) DEFAULT NULL,
  `createdBy` varchar(30) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` varchar(30) DEFAULT NULL,
  `updatedDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `editFlg` int(3) NOT NULL DEFAULT '0',
  `delFlg` int(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1441 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_loan_emidetails
-- ----------------------------
INSERT INTO ams_loan_emidetails VALUES ('145', 'LOAN002', 'AD0000', '1', '1', '2020-06-10', '2020', '6', '119508', '36174', '83333', '119508', '9963826', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('146', 'LOAN002', 'AD0000', '1', '1', '2020-07-10', '2020', '7', '119508', '36476', '83032', '239016', '9927350', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('147', 'LOAN002', 'AD0000', '1', '1', '2020-08-10', '2020', '8', '119508', '36780', '82728', '358523', '9890570', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('148', 'LOAN002', 'AD0000', '1', '1', '2020-09-10', '2020', '9', '119508', '37086', '82421', '478031', '9853483', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('149', 'LOAN002', 'AD0000', '1', '1', '2020-10-10', '2020', '10', '119508', '37395', '82112', '597539', '9816088', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('150', 'LOAN002', 'AD0000', '1', '1', '2020-11-10', '2020', '11', '119508', '37707', '81801', '717047', '9778381', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('151', 'LOAN002', 'AD0000', '1', '1', '2020-12-10', '2020', '12', '119508', '38021', '81487', '836555', '9740359', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('152', 'LOAN002', 'AD0000', '1', '1', '2021-01-10', '2021', '1', '119508', '38338', '81170', '956063', '9702021', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('153', 'LOAN002', 'AD0000', '1', '1', '2021-02-10', '2021', '2', '119508', '38658', '80850', '1075570', '9663364', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('154', 'LOAN002', 'AD0000', '1', '1', '2021-03-10', '2021', '3', '119508', '38980', '80528', '1195078', '9624384', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('155', 'LOAN002', 'AD0000', '1', '1', '2021-04-10', '2021', '4', '119508', '39305', '80203', '1314586', '9585079', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('156', 'LOAN002', 'AD0000', '1', '1', '2021-05-10', '2021', '5', '119508', '39632', '79876', '1434094', '9545447', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('157', 'LOAN002', 'AD0000', '1', '1', '2021-06-10', '2021', '6', '119508', '39962', '79545', '1553602', '9505485', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('158', 'LOAN002', 'AD0000', '1', '1', '2021-07-10', '2021', '7', '119508', '40295', '79212', '1673110', '9465189', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('159', 'LOAN002', 'AD0000', '1', '1', '2021-08-10', '2021', '8', '119508', '40631', '78877', '1792617', '9424558', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('160', 'LOAN002', 'AD0000', '1', '1', '2021-09-10', '2021', '9', '119508', '40970', '78538', '1912125', '9383588', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('161', 'LOAN002', 'AD0000', '1', '1', '2021-10-10', '2021', '10', '119508', '41311', '78197', '2031633', '9342277', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('162', 'LOAN002', 'AD0000', '1', '1', '2021-11-10', '2021', '11', '119508', '41656', '77852', '2151141', '9300621', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('163', 'LOAN002', 'AD0000', '1', '1', '2021-12-10', '2021', '12', '119508', '42003', '77505', '2270649', '9258619', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('164', 'LOAN002', 'AD0000', '1', '1', '2022-01-10', '2022', '1', '119508', '42353', '77155', '2390157', '9216266', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('165', 'LOAN002', 'AD0000', '1', '1', '2022-02-10', '2022', '2', '119508', '42706', '76802', '2509664', '9173560', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('166', 'LOAN002', 'AD0000', '1', '1', '2022-03-10', '2022', '3', '119508', '43061', '76446', '2629172', '9130499', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('167', 'LOAN002', 'AD0000', '1', '1', '2022-04-10', '2022', '4', '119508', '43420', '76087', '2748680', '9087078', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('168', 'LOAN002', 'AD0000', '1', '1', '2022-05-10', '2022', '5', '119508', '43782', '75726', '2868188', '9043296', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('169', 'LOAN002', 'AD0000', '1', '1', '2022-06-10', '2022', '6', '119508', '44147', '75361', '2987696', '8999149', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('170', 'LOAN002', 'AD0000', '1', '1', '2022-07-10', '2022', '7', '119508', '44515', '74993', '3107203', '8954634', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('171', 'LOAN002', 'AD0000', '1', '1', '2022-08-10', '2022', '8', '119508', '44886', '74622', '3226711', '8909748', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('172', 'LOAN002', 'AD0000', '1', '1', '2022-09-10', '2022', '9', '119508', '45260', '74248', '3346219', '8864489', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('173', 'LOAN002', 'AD0000', '1', '1', '2022-10-10', '2022', '10', '119508', '45637', '73871', '3465727', '8818851', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('174', 'LOAN002', 'AD0000', '1', '1', '2022-11-10', '2022', '11', '119508', '46017', '73490', '3585235', '8772834', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('175', 'LOAN002', 'AD0000', '1', '1', '2022-12-10', '2022', '12', '119508', '46401', '73107', '3704743', '8726433', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('176', 'LOAN002', 'AD0000', '1', '1', '2023-01-10', '2023', '1', '119508', '46788', '72720', '3824250', '8679646', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('177', 'LOAN002', 'AD0000', '1', '1', '2023-02-10', '2023', '2', '119508', '47177', '72330', '3943758', '8632468', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('178', 'LOAN002', 'AD0000', '1', '1', '2023-03-10', '2023', '3', '119508', '47571', '71937', '4063266', '8584898', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('179', 'LOAN002', 'AD0000', '1', '1', '2023-04-10', '2023', '4', '119508', '47967', '71541', '4182774', '8536931', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('180', 'LOAN002', 'AD0000', '1', '1', '2023-05-10', '2023', '5', '119508', '48367', '71141', '4302282', '8488564', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('181', 'LOAN002', 'AD0000', '1', '1', '2023-06-10', '2023', '6', '119508', '48770', '70738', '4421790', '8439794', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('182', 'LOAN002', 'AD0000', '1', '1', '2023-07-10', '2023', '7', '119508', '49176', '70332', '4541297', '8390618', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('183', 'LOAN002', 'AD0000', '1', '1', '2023-08-10', '2023', '8', '119508', '49586', '69922', '4660805', '8341032', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('184', 'LOAN002', 'AD0000', '1', '1', '2023-09-10', '2023', '9', '119508', '49999', '69509', '4780313', '8291033', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('185', 'LOAN002', 'AD0000', '1', '1', '2023-10-10', '2023', '10', '119508', '50416', '69092', '4899821', '8240617', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('186', 'LOAN002', 'AD0000', '1', '1', '2023-11-10', '2023', '11', '119508', '50836', '68672', '5019329', '8189781', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('187', 'LOAN002', 'AD0000', '1', '1', '2023-12-10', '2023', '12', '119508', '51260', '68248', '5138837', '8138521', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('188', 'LOAN002', 'AD0000', '1', '1', '2024-01-10', '2024', '1', '119508', '51687', '67821', '5258344', '8086834', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('189', 'LOAN002', 'AD0000', '1', '1', '2024-02-10', '2024', '2', '119508', '52118', '67390', '5377852', '8034717', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('190', 'LOAN002', 'AD0000', '1', '1', '2024-03-10', '2024', '3', '119508', '52552', '66956', '5497360', '7982165', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('191', 'LOAN002', 'AD0000', '1', '1', '2024-04-10', '2024', '4', '119508', '52990', '66518', '5616868', '7929175', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('192', 'LOAN002', 'AD0000', '1', '1', '2024-05-10', '2024', '5', '119508', '53431', '66076', '5736376', '7875744', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('193', 'LOAN002', 'AD0000', '1', '1', '2024-06-10', '2024', '6', '119508', '53877', '65631', '5855883', '7821867', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('194', 'LOAN002', 'AD0000', '1', '1', '2024-07-10', '2024', '7', '119508', '54326', '65182', '5975391', '7767541', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('195', 'LOAN002', 'AD0000', '1', '1', '2024-08-10', '2024', '8', '119508', '54778', '64730', '6094899', '7712763', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('196', 'LOAN002', 'AD0000', '1', '1', '2024-09-10', '2024', '9', '119508', '55235', '64273', '6214407', '7657528', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('197', 'LOAN002', 'AD0000', '1', '1', '2024-10-10', '2024', '10', '119508', '55695', '63813', '6333915', '7601833', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('198', 'LOAN002', 'AD0000', '1', '1', '2024-11-10', '2024', '11', '119508', '56159', '63349', '6453423', '7545674', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('199', 'LOAN002', 'AD0000', '1', '1', '2024-12-10', '2024', '12', '119508', '56627', '62881', '6572930', '7489047', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('200', 'LOAN002', 'AD0000', '1', '1', '2025-01-10', '2025', '1', '119508', '57099', '62409', '6692438', '7431948', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('201', 'LOAN002', 'AD0000', '1', '1', '2025-02-10', '2025', '2', '119508', '57575', '61933', '6811946', '7374373', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('202', 'LOAN002', 'AD0000', '1', '1', '2025-03-10', '2025', '3', '119508', '58055', '61453', '6931454', '7316318', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('203', 'LOAN002', 'AD0000', '1', '1', '2025-04-10', '2025', '4', '119508', '58539', '60969', '7050962', '7257780', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('204', 'LOAN002', 'AD0000', '1', '1', '2025-05-10', '2025', '5', '119508', '59026', '60481', '7170470', '7198753', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('205', 'LOAN002', 'AD0000', '1', '1', '2025-06-10', '2025', '6', '119508', '59518', '59990', '7289977', '7139235', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('206', 'LOAN002', 'AD0000', '1', '1', '2025-07-10', '2025', '7', '119508', '60014', '59494', '7409485', '7079221', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('207', 'LOAN002', 'AD0000', '1', '1', '2025-08-10', '2025', '8', '119508', '60514', '58994', '7528993', '7018706', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('208', 'LOAN002', 'AD0000', '1', '1', '2025-09-10', '2025', '9', '119508', '61019', '58489', '7648501', '6957688', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('209', 'LOAN002', 'AD0000', '1', '1', '2025-10-10', '2025', '10', '119508', '61527', '57981', '7768009', '6896161', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('210', 'LOAN002', 'AD0000', '1', '1', '2025-11-10', '2025', '11', '119508', '62040', '57468', '7887517', '6834121', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('211', 'LOAN002', 'AD0000', '1', '1', '2025-12-10', '2025', '12', '119508', '62557', '56951', '8007024', '6771564', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('212', 'LOAN002', 'AD0000', '1', '1', '2026-01-10', '2026', '1', '119508', '63078', '56430', '8126532', '6708486', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('213', 'LOAN002', 'AD0000', '1', '1', '2026-02-10', '2026', '2', '119508', '63604', '55904', '8246040', '6644882', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('214', 'LOAN002', 'AD0000', '1', '1', '2026-03-10', '2026', '3', '119508', '64134', '55374', '8365548', '6580748', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('215', 'LOAN002', 'AD0000', '1', '1', '2026-04-10', '2026', '4', '119508', '64668', '54840', '8485056', '6516080', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('216', 'LOAN002', 'AD0000', '1', '1', '2026-05-10', '2026', '5', '119508', '65207', '54301', '8604563', '6450873', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('217', 'LOAN002', 'AD0000', '1', '1', '2026-06-10', '2026', '6', '119508', '65751', '53757', '8724071', '6385122', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('218', 'LOAN002', 'AD0000', '1', '1', '2026-07-10', '2026', '7', '119508', '66298', '53209', '8843579', '6318824', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('219', 'LOAN002', 'AD0000', '1', '1', '2026-08-10', '2026', '8', '119508', '66851', '52657', '8963087', '6251973', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('220', 'LOAN002', 'AD0000', '1', '1', '2026-09-10', '2026', '9', '119508', '67408', '52100', '9082595', '6184565', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('221', 'LOAN002', 'AD0000', '1', '1', '2026-10-10', '2026', '10', '119508', '67970', '51538', '9202103', '6116595', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('222', 'LOAN002', 'AD0000', '1', '1', '2026-11-10', '2026', '11', '119508', '68536', '50972', '9321610', '6048059', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('223', 'LOAN002', 'AD0000', '1', '1', '2026-12-10', '2026', '12', '119508', '69107', '50400', '9441118', '5978952', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('224', 'LOAN002', 'AD0000', '1', '1', '2027-01-10', '2027', '1', '119508', '69683', '49825', '9560626', '5909268', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('225', 'LOAN002', 'AD0000', '1', '1', '2027-02-10', '2027', '2', '119508', '70264', '49244', '9680134', '5839004', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('226', 'LOAN002', 'AD0000', '1', '1', '2027-03-10', '2027', '3', '119508', '70849', '48658', '9799642', '5768155', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('227', 'LOAN002', 'AD0000', '1', '1', '2027-04-10', '2027', '4', '119508', '71440', '48068', '9919150', '5696715', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('228', 'LOAN002', 'AD0000', '1', '1', '2027-05-10', '2027', '5', '119508', '72035', '47473', '10038657', '5624680', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('229', 'LOAN002', 'AD0000', '1', '1', '2027-06-10', '2027', '6', '119508', '72635', '46872', '10158165', '5552044', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('230', 'LOAN002', 'AD0000', '1', '1', '2027-07-10', '2027', '7', '119508', '73241', '46267', '10277673', '5478804', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('231', 'LOAN002', 'AD0000', '1', '1', '2027-08-10', '2027', '8', '119508', '73851', '45657', '10397181', '5404953', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('232', 'LOAN002', 'AD0000', '1', '1', '2027-09-10', '2027', '9', '119508', '74467', '45041', '10516689', '5330486', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('233', 'LOAN002', 'AD0000', '1', '1', '2027-10-10', '2027', '10', '119508', '75087', '44421', '10636197', '5255399', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('234', 'LOAN002', 'AD0000', '1', '1', '2027-11-10', '2027', '11', '119508', '75713', '43795', '10755704', '5179686', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('235', 'LOAN002', 'AD0000', '1', '1', '2027-12-10', '2027', '12', '119508', '76344', '43164', '10875212', '5103342', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('236', 'LOAN002', 'AD0000', '1', '1', '2028-01-10', '2028', '1', '119508', '76980', '42528', '10994720', '5026362', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('237', 'LOAN002', 'AD0000', '1', '1', '2028-02-10', '2028', '2', '119508', '77621', '41886', '11114228', '4948741', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('238', 'LOAN002', 'AD0000', '1', '1', '2028-03-10', '2028', '3', '119508', '78268', '41240', '11233736', '4870472', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('239', 'LOAN002', 'AD0000', '1', '1', '2028-04-10', '2028', '4', '119508', '78921', '40587', '11353243', '4791552', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('240', 'LOAN002', 'AD0000', '1', '1', '2028-05-10', '2028', '5', '119508', '79578', '39930', '11472751', '4711974', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('241', 'LOAN002', 'AD0000', '1', '1', '2028-06-10', '2028', '6', '119508', '80241', '39266', '11592259', '4631732', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('242', 'LOAN002', 'AD0000', '1', '1', '2028-07-10', '2028', '7', '119508', '80910', '38598', '11711767', '4550822', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('243', 'LOAN002', 'AD0000', '1', '1', '2028-08-10', '2028', '8', '119508', '81584', '37924', '11831275', '4469238', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('244', 'LOAN002', 'AD0000', '1', '1', '2028-09-10', '2028', '9', '119508', '82264', '37244', '11950783', '4386974', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('245', 'LOAN002', 'AD0000', '1', '1', '2028-10-10', '2028', '10', '119508', '82950', '36558', '12070290', '4304024', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('246', 'LOAN002', 'AD0000', '1', '1', '2028-11-10', '2028', '11', '119508', '83641', '35867', '12189798', '4220383', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('247', 'LOAN002', 'AD0000', '1', '1', '2028-12-10', '2028', '12', '119508', '84338', '35170', '12309306', '4136045', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('248', 'LOAN002', 'AD0000', '1', '1', '2029-01-10', '2029', '1', '119508', '85041', '34467', '12428814', '4051004', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('249', 'LOAN002', 'AD0000', '1', '1', '2029-02-10', '2029', '2', '119508', '85749', '33758', '12548322', '3965255', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('250', 'LOAN002', 'AD0000', '1', '1', '2029-03-10', '2029', '3', '119508', '86464', '33044', '12667830', '3878791', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('251', 'LOAN002', 'AD0000', '1', '1', '2029-04-10', '2029', '4', '119508', '87185', '32323', '12787337', '3791606', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('252', 'LOAN002', 'AD0000', '1', '1', '2029-05-10', '2029', '5', '119508', '87911', '31597', '12906845', '3703695', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('253', 'LOAN002', 'AD0000', '1', '1', '2029-06-10', '2029', '6', '119508', '88644', '30864', '13026353', '3615051', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('254', 'LOAN002', 'AD0000', '1', '1', '2029-07-10', '2029', '7', '119508', '89382', '30125', '13145861', '3525669', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('255', 'LOAN002', 'AD0000', '1', '1', '2029-08-10', '2029', '8', '119508', '90127', '29381', '13265369', '3435542', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('256', 'LOAN002', 'AD0000', '1', '1', '2029-09-10', '2029', '9', '119508', '90878', '28630', '13384877', '3344664', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('257', 'LOAN002', 'AD0000', '1', '1', '2029-10-10', '2029', '10', '119508', '91636', '27872', '13504384', '3253028', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('258', 'LOAN002', 'AD0000', '1', '1', '2029-11-10', '2029', '11', '119508', '92399', '27109', '13623892', '3160629', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('259', 'LOAN002', 'AD0000', '1', '1', '2029-12-10', '2029', '12', '119508', '93169', '26339', '13743400', '3067459', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('260', 'LOAN002', 'AD0000', '1', '1', '2030-01-10', '2030', '1', '119508', '93946', '25562', '13862908', '2973514', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('261', 'LOAN002', 'AD0000', '1', '1', '2030-02-10', '2030', '2', '119508', '94729', '24779', '13982416', '2878785', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('262', 'LOAN002', 'AD0000', '1', '1', '2030-03-10', '2030', '3', '119508', '95518', '23990', '14101924', '2783267', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('263', 'LOAN002', 'AD0000', '1', '1', '2030-04-10', '2030', '4', '119508', '96314', '23194', '14221431', '2686953', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('264', 'LOAN002', 'AD0000', '1', '1', '2030-05-10', '2030', '5', '119508', '97117', '22391', '14340939', '2589837', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('265', 'LOAN002', 'AD0000', '1', '1', '2030-06-10', '2030', '6', '119508', '97926', '21582', '14460447', '2491911', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('266', 'LOAN002', 'AD0000', '1', '1', '2030-07-10', '2030', '7', '119508', '98742', '20766', '14579955', '2393169', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('267', 'LOAN002', 'AD0000', '1', '1', '2030-08-10', '2030', '8', '119508', '99565', '19943', '14699463', '2293604', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('268', 'LOAN002', 'AD0000', '1', '1', '2030-09-10', '2030', '9', '119508', '100394', '19113', '14818970', '2193210', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('269', 'LOAN002', 'AD0000', '1', '1', '2030-10-10', '2030', '10', '119508', '101231', '18277', '14938478', '2091979', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('270', 'LOAN002', 'AD0000', '1', '1', '2030-11-10', '2030', '11', '119508', '102075', '17433', '15057986', '1989904', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('271', 'LOAN002', 'AD0000', '1', '1', '2030-12-10', '2030', '12', '119508', '102925', '16583', '15177494', '1886979', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('272', 'LOAN002', 'AD0000', '1', '1', '2031-01-10', '2031', '1', '119508', '103783', '15725', '15297002', '1783196', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('273', 'LOAN002', 'AD0000', '1', '1', '2031-02-10', '2031', '2', '119508', '104648', '14860', '15416510', '1678548', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('274', 'LOAN002', 'AD0000', '1', '1', '2031-03-10', '2031', '3', '119508', '105520', '13988', '15536017', '1573028', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('275', 'LOAN002', 'AD0000', '1', '1', '2031-04-10', '2031', '4', '119508', '106399', '13109', '15655525', '1466629', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('276', 'LOAN002', 'AD0000', '1', '1', '2031-05-10', '2031', '5', '119508', '107286', '12222', '15775033', '1359343', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('277', 'LOAN002', 'AD0000', '1', '1', '2031-06-10', '2031', '6', '119508', '108180', '11328', '15894541', '1251163', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('278', 'LOAN002', 'AD0000', '1', '1', '2031-07-10', '2031', '7', '119508', '109081', '10426', '16014049', '1142081', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('279', 'LOAN002', 'AD0000', '1', '1', '2031-08-10', '2031', '8', '119508', '109990', '9517', '16133557', '1032091', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('280', 'LOAN002', 'AD0000', '1', '1', '2031-09-10', '2031', '9', '119508', '110907', '8601', '16253064', '921184', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('281', 'LOAN002', 'AD0000', '1', '1', '2031-10-10', '2031', '10', '119508', '111831', '7677', '16372572', '809352', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('282', 'LOAN002', 'AD0000', '1', '1', '2031-11-10', '2031', '11', '119508', '112763', '6745', '16492080', '696589', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('283', 'LOAN002', 'AD0000', '1', '1', '2031-12-10', '2031', '12', '119508', '113703', '5805', '16611588', '582886', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('284', 'LOAN002', 'AD0000', '1', '1', '2032-01-10', '2032', '1', '119508', '114650', '4857', '16731096', '468236', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('285', 'LOAN002', 'AD0000', '1', '1', '2032-02-10', '2032', '2', '119508', '115606', '3902', '16850604', '352630', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('286', 'LOAN002', 'AD0000', '1', '1', '2032-03-10', '2032', '3', '119508', '116569', '2939', '16970111', '236061', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('287', 'LOAN002', 'AD0000', '1', '1', '2032-04-10', '2032', '4', '119508', '117541', '1967', '17089619', '118520', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('288', 'LOAN002', 'AD0000', '1', '1', '2032-05-10', '2032', '5', '119508', '118520', '988', '17209127', '-0', 'Admin', '2020-09-15 22:35:34', null, '2020-09-15 22:35:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('578', 'LOAN003', 'AD0000', '3', '2', '2020-07-10', '2020', '7', '182716', '170000', '12716', '', '4830000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '1', '0');
INSERT INTO ams_loan_emidetails VALUES ('579', 'LOAN003', 'AD0000', '3', '2', '2020-08-10', '2020', '8', '150478', '138000', '12478', '', '4692000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('580', 'LOAN003', 'AD0000', '3', '2', '2020-09-10', '2020', '9', '150121', '138000', '12121', '', '4554000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('581', 'LOAN003', 'AD0000', '3', '2', '2020-10-10', '2020', '10', '149765', '138000', '11765', '', '4416000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('582', 'LOAN003', 'AD0000', '3', '2', '2020-11-10', '2020', '11', '149408', '138000', '11408', '', '4278000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('583', 'LOAN003', 'AD0000', '3', '2', '2020-12-10', '2020', '12', '149052', '138000', '11052', '', '4140000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('584', 'LOAN003', 'AD0000', '3', '2', '2021-01-10', '2021', '1', '148695', '138000', '10695', '', '4002000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('585', 'LOAN003', 'AD0000', '3', '2', '2021-02-10', '2021', '2', '148339', '138000', '10339', '', '3864000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('586', 'LOAN003', 'AD0000', '3', '2', '2021-03-10', '2021', '3', '147982', '138000', '9982', '', '3726000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('587', 'LOAN003', 'AD0000', '3', '2', '2021-04-10', '2021', '4', '147626', '138000', '9626', '', '3588000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('588', 'LOAN003', 'AD0000', '3', '2', '2021-05-10', '2021', '5', '147269', '138000', '9269', '', '3450000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('589', 'LOAN003', 'AD0000', '3', '2', '2021-06-10', '2021', '6', '146913', '138000', '8913', '', '3312000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('590', 'LOAN003', 'AD0000', '3', '2', '2021-07-10', '2021', '7', '146556', '138000', '8556', '', '3174000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('591', 'LOAN003', 'AD0000', '3', '2', '2021-08-10', '2021', '8', '146200', '138000', '8200', '', '3036000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('592', 'LOAN003', 'AD0000', '3', '2', '2021-09-10', '2021', '9', '145843', '138000', '7843', '', '2898000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('593', 'LOAN003', 'AD0000', '3', '2', '2021-10-10', '2021', '10', '145487', '138000', '7487', '', '2760000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('594', 'LOAN003', 'AD0000', '3', '2', '2021-11-10', '2021', '11', '145130', '138000', '7130', '', '2622000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('595', 'LOAN003', 'AD0000', '3', '2', '2021-12-10', '2021', '12', '144774', '138000', '6774', '', '2484000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('596', 'LOAN003', 'AD0000', '3', '2', '2022-01-10', '2022', '1', '144417', '138000', '6417', '', '2346000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('597', 'LOAN003', 'AD0000', '3', '2', '2022-02-10', '2022', '2', '144061', '138000', '6061', '', '2208000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('598', 'LOAN003', 'AD0000', '3', '2', '2022-03-10', '2022', '3', '143704', '138000', '5704', '', '2070000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('599', 'LOAN003', 'AD0000', '3', '2', '2022-04-10', '2022', '4', '143348', '138000', '5348', '', '1932000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('600', 'LOAN003', 'AD0000', '3', '2', '2022-05-10', '2022', '5', '142991', '138000', '4991', '', '1794000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('601', 'LOAN003', 'AD0000', '3', '2', '2022-06-10', '2022', '6', '142635', '138000', '4635', '', '1656000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('602', 'LOAN003', 'AD0000', '3', '2', '2022-07-10', '2022', '7', '142278', '138000', '4278', '', '1518000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('603', 'LOAN003', 'AD0000', '3', '2', '2022-08-10', '2022', '8', '141922', '138000', '3922', '', '1380000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('604', 'LOAN003', 'AD0000', '3', '2', '2022-09-10', '2022', '9', '141565', '138000', '3565', '', '1242000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('605', 'LOAN003', 'AD0000', '3', '2', '2022-10-10', '2022', '10', '141209', '138000', '3209', '', '1104000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('606', 'LOAN003', 'AD0000', '3', '2', '2022-11-10', '2022', '11', '140852', '138000', '2852', '', '966000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('607', 'LOAN003', 'AD0000', '3', '2', '2022-12-10', '2022', '12', '140496', '138000', '2496', '', '828000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('608', 'LOAN003', 'AD0000', '3', '2', '2023-01-10', '2023', '1', '140139', '138000', '2139', '', '690000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('609', 'LOAN003', 'AD0000', '3', '2', '2023-02-10', '2023', '2', '139783', '138000', '1783', '', '552000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('610', 'LOAN003', 'AD0000', '3', '2', '2023-03-10', '2023', '3', '139426', '138000', '1426', '', '414000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('611', 'LOAN003', 'AD0000', '3', '2', '2023-04-10', '2023', '4', '139070', '138000', '1070', '', '276000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('612', 'LOAN003', 'AD0000', '3', '2', '2023-05-10', '2023', '5', '138713', '138000', '713', '', '138000', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('613', 'LOAN003', 'AD0000', '3', '2', '2023-06-10', '2023', '6', '138357', '138000', '357', '', '0', 'Admin', '2020-09-17 16:14:57', null, '2020-09-17 16:14:57', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('938', 'LOAN005', 'AD0000', '1', '1', '2021-03-02', '2021', '3', '282678', '199345', '83333', '282678', '19800655', 'Admin', '2020-09-18 08:54:08', null, '2020-09-18 08:54:08', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('939', 'LOAN005', 'AD0000', '1', '1', '2021-04-02', '2021', '4', '282678', '200175', '82503', '565356', '19600480', 'Admin', '2020-09-18 08:54:08', null, '2020-09-18 08:54:08', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('940', 'LOAN005', 'AD0000', '1', '1', '2021-05-02', '2021', '5', '282678', '201010', '81669', '848035', '19399470', 'Admin', '2020-09-18 08:54:08', null, '2020-09-18 08:54:08', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('941', 'LOAN005', 'AD0000', '1', '1', '2021-06-02', '2021', '6', '282678', '201847', '80831', '1130713', '19197623', 'Admin', '2020-09-18 08:54:08', null, '2020-09-18 08:54:08', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('942', 'LOAN005', 'AD0000', '1', '1', '2021-07-02', '2021', '7', '282678', '202688', '79990', '1413391', '18994935', 'Admin', '2020-09-18 08:54:08', null, '2020-09-18 08:54:08', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('943', 'LOAN005', 'AD0000', '1', '1', '2021-08-02', '2021', '8', '282678', '203533', '79146', '1696069', '18791402', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('944', 'LOAN005', 'AD0000', '1', '1', '2021-09-02', '2021', '9', '282678', '204381', '78298', '1978747', '18587022', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('945', 'LOAN005', 'AD0000', '1', '1', '2021-10-02', '2021', '10', '282678', '205232', '77446', '2261425', '18381789', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('946', 'LOAN005', 'AD0000', '1', '1', '2021-11-02', '2021', '11', '282678', '206087', '76591', '2544104', '18175702', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('947', 'LOAN005', 'AD0000', '1', '1', '2021-12-02', '2021', '12', '282678', '206946', '75732', '2826782', '17968756', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('948', 'LOAN005', 'AD0000', '1', '1', '2022-01-02', '2022', '1', '282678', '207808', '74870', '3109460', '17760948', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('949', 'LOAN005', 'AD0000', '1', '1', '2022-02-02', '2022', '2', '282678', '208674', '74004', '3392138', '17552273', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('950', 'LOAN005', 'AD0000', '1', '1', '2022-03-02', '2022', '3', '282678', '209544', '73134', '3674816', '17342730', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('951', 'LOAN005', 'AD0000', '1', '1', '2022-04-02', '2022', '4', '282678', '210417', '72261', '3957495', '17132313', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('952', 'LOAN005', 'AD0000', '1', '1', '2022-05-02', '2022', '5', '282678', '211294', '71385', '4240173', '16921019', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('953', 'LOAN005', 'AD0000', '1', '1', '2022-06-02', '2022', '6', '282678', '212174', '70504', '4522851', '16708845', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('954', 'LOAN005', 'AD0000', '1', '1', '2022-07-02', '2022', '7', '282678', '213058', '69620', '4805529', '16495787', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('955', 'LOAN005', 'AD0000', '1', '1', '2022-08-02', '2022', '8', '282678', '213946', '68732', '5088207', '16281842', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('956', 'LOAN005', 'AD0000', '1', '1', '2022-09-02', '2022', '9', '282678', '214837', '67841', '5370885', '16067005', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('957', 'LOAN005', 'AD0000', '1', '1', '2022-10-02', '2022', '10', '282678', '215732', '66946', '5653564', '15851272', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('958', 'LOAN005', 'AD0000', '1', '1', '2022-11-02', '2022', '11', '282678', '216631', '66047', '5936242', '15634641', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('959', 'LOAN005', 'AD0000', '1', '1', '2022-12-02', '2022', '12', '282678', '217534', '65144', '6218920', '15417107', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('960', 'LOAN005', 'AD0000', '1', '1', '2023-01-02', '2023', '1', '282678', '218440', '64238', '6501598', '15198667', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('961', 'LOAN005', 'AD0000', '1', '1', '2023-02-02', '2023', '2', '282678', '219350', '63328', '6784276', '14979316', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('962', 'LOAN005', 'AD0000', '1', '1', '2023-03-02', '2023', '3', '282678', '220264', '62414', '7066955', '14759052', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('963', 'LOAN005', 'AD0000', '1', '1', '2023-04-02', '2023', '4', '282678', '221182', '61496', '7349633', '14537870', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('964', 'LOAN005', 'AD0000', '1', '1', '2023-05-02', '2023', '5', '282678', '222104', '60574', '7632311', '14315766', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('965', 'LOAN005', 'AD0000', '1', '1', '2023-06-02', '2023', '6', '282678', '223029', '59649', '7914989', '14092737', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('966', 'LOAN005', 'AD0000', '1', '1', '2023-07-02', '2023', '7', '282678', '223958', '58720', '8197667', '13868779', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('967', 'LOAN005', 'AD0000', '1', '1', '2023-08-02', '2023', '8', '282678', '224892', '57787', '8480345', '13643887', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('968', 'LOAN005', 'AD0000', '1', '1', '2023-09-02', '2023', '9', '282678', '225829', '56850', '8763024', '13418058', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('969', 'LOAN005', 'AD0000', '1', '1', '2023-10-02', '2023', '10', '282678', '226770', '55909', '9045702', '13191289', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('970', 'LOAN005', 'AD0000', '1', '1', '2023-11-02', '2023', '11', '282678', '227714', '54964', '9328380', '12963574', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('971', 'LOAN005', 'AD0000', '1', '1', '2023-12-02', '2023', '12', '282678', '228663', '54015', '9611058', '12734911', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('972', 'LOAN005', 'AD0000', '1', '1', '2024-01-02', '2024', '1', '282678', '229616', '53062', '9893736', '12505295', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('973', 'LOAN005', 'AD0000', '1', '1', '2024-02-02', '2024', '2', '282678', '230573', '52105', '10176415', '12274722', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('974', 'LOAN005', 'AD0000', '1', '1', '2024-03-02', '2024', '3', '282678', '231534', '51145', '10459093', '12043189', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('975', 'LOAN005', 'AD0000', '1', '1', '2024-04-02', '2024', '4', '282678', '232498', '50180', '10741771', '11810690', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('976', 'LOAN005', 'AD0000', '1', '1', '2024-05-02', '2024', '5', '282678', '233467', '49211', '11024449', '11577224', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('977', 'LOAN005', 'AD0000', '1', '1', '2024-06-02', '2024', '6', '282678', '234440', '48238', '11307127', '11342784', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('978', 'LOAN005', 'AD0000', '1', '1', '2024-07-02', '2024', '7', '282678', '235417', '47262', '11589805', '11107367', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('979', 'LOAN005', 'AD0000', '1', '1', '2024-08-02', '2024', '8', '282678', '236397', '46281', '11872484', '10870970', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('980', 'LOAN005', 'AD0000', '1', '1', '2024-09-02', '2024', '9', '282678', '237382', '45296', '12155162', '10633587', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('981', 'LOAN005', 'AD0000', '1', '1', '2024-10-02', '2024', '10', '282678', '238372', '44307', '12437840', '10395216', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('982', 'LOAN005', 'AD0000', '1', '1', '2024-11-02', '2024', '11', '282678', '239365', '43313', '12720518', '10155851', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('983', 'LOAN005', 'AD0000', '1', '1', '2024-12-02', '2024', '12', '282678', '240362', '42316', '13003196', '9915489', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('984', 'LOAN005', 'AD0000', '1', '1', '2025-01-02', '2025', '1', '282678', '241364', '41315', '13285875', '9674125', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('985', 'LOAN005', 'AD0000', '1', '1', '2025-02-02', '2025', '2', '282678', '242369', '40309', '13568553', '9431756', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('986', 'LOAN005', 'AD0000', '1', '1', '2025-03-02', '2025', '3', '282678', '243379', '39299', '13851231', '9188377', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('987', 'LOAN005', 'AD0000', '1', '1', '2025-04-02', '2025', '4', '282678', '244393', '38285', '14133909', '8943983', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('988', 'LOAN005', 'AD0000', '1', '1', '2025-05-02', '2025', '5', '282678', '245412', '37267', '14416587', '8698572', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('989', 'LOAN005', 'AD0000', '1', '1', '2025-06-02', '2025', '6', '282678', '246434', '36244', '14699265', '8452138', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('990', 'LOAN005', 'AD0000', '1', '1', '2025-07-02', '2025', '7', '282678', '247461', '35217', '14981944', '8204677', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('991', 'LOAN005', 'AD0000', '1', '1', '2025-08-02', '2025', '8', '282678', '248492', '34186', '15264622', '7956185', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('992', 'LOAN005', 'AD0000', '1', '1', '2025-09-02', '2025', '9', '282678', '249527', '33151', '15547300', '7706657', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('993', 'LOAN005', 'AD0000', '1', '1', '2025-10-02', '2025', '10', '282678', '250567', '32111', '15829978', '7456090', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('994', 'LOAN005', 'AD0000', '1', '1', '2025-11-02', '2025', '11', '282678', '251611', '31067', '16112656', '7204479', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('995', 'LOAN005', 'AD0000', '1', '1', '2025-12-02', '2025', '12', '282678', '252660', '30019', '16395335', '6951819', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('996', 'LOAN005', 'AD0000', '1', '1', '2026-01-02', '2026', '1', '282678', '253712', '28966', '16678013', '6698107', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('997', 'LOAN005', 'AD0000', '1', '1', '2026-02-02', '2026', '2', '282678', '254769', '27909', '16960691', '6443338', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('998', 'LOAN005', 'AD0000', '1', '1', '2026-03-02', '2026', '3', '282678', '255831', '26847', '17243369', '6187507', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('999', 'LOAN005', 'AD0000', '1', '1', '2026-04-02', '2026', '4', '282678', '256897', '25781', '17526047', '5930610', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1000', 'LOAN005', 'AD0000', '1', '1', '2026-05-02', '2026', '5', '282678', '257967', '24711', '17808725', '5672643', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1001', 'LOAN005', 'AD0000', '1', '1', '2026-06-02', '2026', '6', '282678', '259042', '23636', '18091404', '5413600', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1002', 'LOAN005', 'AD0000', '1', '1', '2026-07-02', '2026', '7', '282678', '260122', '22557', '18374082', '5153479', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1003', 'LOAN005', 'AD0000', '1', '1', '2026-08-02', '2026', '8', '282678', '261205', '21473', '18656760', '4892274', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1004', 'LOAN005', 'AD0000', '1', '1', '2026-09-02', '2026', '9', '282678', '262294', '20384', '18939438', '4629980', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1005', 'LOAN005', 'AD0000', '1', '1', '2026-10-02', '2026', '10', '282678', '263387', '19292', '19222116', '4366593', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1006', 'LOAN005', 'AD0000', '1', '1', '2026-11-02', '2026', '11', '282678', '264484', '18194', '19504795', '4102109', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1007', 'LOAN005', 'AD0000', '1', '1', '2026-12-02', '2026', '12', '282678', '265586', '17092', '19787473', '3836523', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1008', 'LOAN005', 'AD0000', '1', '1', '2027-01-02', '2027', '1', '282678', '266693', '15986', '20070151', '3569830', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1009', 'LOAN005', 'AD0000', '1', '1', '2027-02-02', '2027', '2', '282678', '267804', '14874', '20352829', '3302027', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1010', 'LOAN005', 'AD0000', '1', '1', '2027-03-02', '2027', '3', '282678', '268920', '13758', '20635507', '3033107', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1011', 'LOAN005', 'AD0000', '1', '1', '2027-04-02', '2027', '4', '282678', '270040', '12638', '20918185', '2763067', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1012', 'LOAN005', 'AD0000', '1', '1', '2027-05-02', '2027', '5', '282678', '271165', '11513', '21200864', '2491901', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1013', 'LOAN005', 'AD0000', '1', '1', '2027-06-02', '2027', '6', '282678', '272295', '10383', '21483542', '2219606', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1014', 'LOAN005', 'AD0000', '1', '1', '2027-07-02', '2027', '7', '282678', '273430', '9248', '21766220', '1946176', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1015', 'LOAN005', 'AD0000', '1', '1', '2027-08-02', '2027', '8', '282678', '274569', '8109', '22048898', '1671607', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1016', 'LOAN005', 'AD0000', '1', '1', '2027-09-02', '2027', '9', '282678', '275713', '6965', '22331576', '1395894', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1017', 'LOAN005', 'AD0000', '1', '1', '2027-10-02', '2027', '10', '282678', '276862', '5816', '22614255', '1119032', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1018', 'LOAN005', 'AD0000', '1', '1', '2027-11-02', '2027', '11', '282678', '278016', '4663', '22896933', '841016', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1019', 'LOAN005', 'AD0000', '1', '1', '2027-12-02', '2027', '12', '282678', '279174', '3504', '23179611', '561842', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1020', 'LOAN005', 'AD0000', '1', '1', '2028-01-02', '2028', '1', '282678', '280337', '2341', '23462289', '281505', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1021', 'LOAN005', 'AD0000', '1', '1', '2028-02-02', '2028', '2', '282678', '281505', '1173', '23744967', '-0', 'Admin', '2020-09-18 08:54:09', null, '2020-09-18 08:54:09', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1228', 'LOAN004', 'AD0000', '1', '1', '2020-08-31', '2020', '8', '3972637', '3972637', '0', '3972637', '0', 'Admin', '2020-09-23 11:50:25', null, '2020-09-23 11:50:25', '1', '0');
INSERT INTO ams_loan_emidetails VALUES ('1229', 'LOAN001', 'AD0000', '1', '1', '2020-01-10', '2020', '1', '157610', '37610', '120000', '157610', '11962390', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1230', 'LOAN001', 'AD0000', '1', '1', '2020-02-10', '2020', '2', '157610', '37986', '119624', '315221', '11924403', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1231', 'LOAN001', 'AD0000', '1', '1', '2020-03-10', '2020', '3', '157610', '38366', '119244', '472831', '11886037', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1232', 'LOAN001', 'AD0000', '1', '1', '2020-04-10', '2020', '4', '157610', '38750', '118860', '630441', '11847287', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1233', 'LOAN001', 'AD0000', '1', '1', '2020-05-10', '2020', '5', '157610', '39137', '118473', '788051', '11808150', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1234', 'LOAN001', 'AD0000', '1', '1', '2020-06-10', '2020', '6', '157610', '39529', '118081', '945662', '11768621', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1235', 'LOAN001', 'AD0000', '1', '1', '2020-07-10', '2020', '7', '157610', '39924', '117686', '1103272', '11728697', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1236', 'LOAN001', 'AD0000', '1', '1', '2020-08-10', '2020', '8', '157610', '40323', '117287', '1260882', '11688373', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1237', 'LOAN001', 'AD0000', '1', '1', '2020-09-10', '2020', '9', '157610', '40727', '116884', '1418493', '11647647', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1238', 'LOAN001', 'AD0000', '1', '1', '2020-09-23', '2020', '9', '11606513', '11606513', '0', '11606513', '0', 'Admin', '2020-09-23 13:04:24', null, '2020-09-23 13:04:24', '1', '0');
INSERT INTO ams_loan_emidetails VALUES ('1307', 'LOAN006', 'AD0000', '1', '3', '2020-01-01', '2020', '1', '100000', '80000', '20000', '', '5920000', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1308', 'LOAN006', 'AD0000', '1', '3', '2020-04-01', '2020', '4', '100000', '80267', '19733', '', '5839733', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1309', 'LOAN006', 'AD0000', '1', '3', '2020-07-01', '2020', '7', '100000', '80534', '19466', '', '5759199', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1310', 'LOAN006', 'AD0000', '1', '3', '2020-10-01', '2020', '10', '100000', '80803', '19197', '', '5678396', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1311', 'LOAN006', 'AD0000', '1', '3', '2021-01-01', '2021', '1', '100000', '81072', '18928', '', '5597324', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1312', 'LOAN006', 'AD0000', '1', '3', '2021-04-01', '2021', '4', '100000', '81342', '18658', '', '5515982', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1313', 'LOAN006', 'AD0000', '1', '3', '2021-07-01', '2021', '7', '100000', '81613', '18387', '', '5434369', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1314', 'LOAN006', 'AD0000', '1', '3', '2021-10-01', '2021', '10', '100000', '81885', '18115', '', '5352483', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1315', 'LOAN006', 'AD0000', '1', '3', '2022-01-01', '2022', '1', '100000', '82158', '17842', '', '5270325', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1316', 'LOAN006', 'AD0000', '1', '3', '2022-04-01', '2022', '4', '100000', '82432', '17568', '', '5187893', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1317', 'LOAN006', 'AD0000', '1', '3', '2022-07-01', '2022', '7', '100000', '82707', '17293', '', '5105186', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1318', 'LOAN006', 'AD0000', '1', '3', '2022-10-01', '2022', '10', '100000', '82983', '17017', '', '5022203', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1319', 'LOAN006', 'AD0000', '1', '3', '2023-01-01', '2023', '1', '100000', '83259', '16741', '', '4938944', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1320', 'LOAN006', 'AD0000', '1', '3', '2023-04-01', '2023', '4', '100000', '83537', '16463', '', '4855407', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1321', 'LOAN006', 'AD0000', '1', '3', '2023-07-01', '2023', '7', '100000', '83815', '16185', '', '4771591', 'Admin', '2020-09-23 14:50:33', null, '2020-09-23 14:50:33', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1322', 'LOAN006', 'AD0000', '1', '3', '2023-10-01', '2023', '10', '100000', '84095', '15905', '', '4687497', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1323', 'LOAN006', 'AD0000', '1', '3', '2024-01-01', '2024', '1', '100000', '84375', '15625', '', '4603122', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1324', 'LOAN006', 'AD0000', '1', '3', '2024-04-01', '2024', '4', '100000', '84656', '15344', '', '4518466', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1325', 'LOAN006', 'AD0000', '1', '3', '2024-07-01', '2024', '7', '100000', '84938', '15062', '', '4433527', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1326', 'LOAN006', 'AD0000', '1', '3', '2024-10-01', '2024', '10', '100000', '85222', '14778', '', '4348305', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1327', 'LOAN006', 'AD0000', '1', '3', '2025-01-01', '2025', '1', '100000', '85506', '14494', '', '4262800', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1328', 'LOAN006', 'AD0000', '1', '3', '2025-04-01', '2025', '4', '100000', '85791', '14209', '', '4177009', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1329', 'LOAN006', 'AD0000', '1', '3', '2025-07-01', '2025', '7', '100000', '86077', '13923', '', '4090933', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1330', 'LOAN006', 'AD0000', '1', '3', '2025-10-01', '2025', '10', '100000', '86364', '13636', '', '4004569', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1331', 'LOAN006', 'AD0000', '1', '3', '2026-01-01', '2026', '1', '100000', '86651', '13349', '', '3917918', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1332', 'LOAN006', 'AD0000', '1', '3', '2026-04-01', '2026', '4', '100000', '86940', '13060', '', '3830977', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1333', 'LOAN006', 'AD0000', '1', '3', '2026-07-01', '2026', '7', '100000', '87230', '12770', '', '3743747', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1334', 'LOAN006', 'AD0000', '1', '3', '2026-10-01', '2026', '10', '100000', '87521', '12479', '', '3656226', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1335', 'LOAN006', 'AD0000', '1', '3', '2027-01-01', '2027', '1', '100000', '87813', '12187', '', '3568414', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1336', 'LOAN006', 'AD0000', '1', '3', '2027-04-01', '2027', '4', '100000', '88105', '11895', '', '3480308', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1337', 'LOAN006', 'AD0000', '1', '3', '2027-07-01', '2027', '7', '100000', '88399', '11601', '', '3391910', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1338', 'LOAN006', 'AD0000', '1', '3', '2027-10-01', '2027', '10', '100000', '88694', '11306', '', '3303216', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1339', 'LOAN006', 'AD0000', '1', '3', '2028-01-01', '2028', '1', '100000', '88989', '11011', '', '3214227', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1340', 'LOAN006', 'AD0000', '1', '3', '2028-04-01', '2028', '4', '100000', '89286', '10714', '', '3124941', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1341', 'LOAN006', 'AD0000', '1', '3', '2028-07-01', '2028', '7', '100000', '89584', '10416', '', '3035357', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1342', 'LOAN006', 'AD0000', '1', '3', '2028-10-01', '2028', '10', '100000', '89882', '10118', '', '2945475', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1343', 'LOAN006', 'AD0000', '1', '3', '2029-01-01', '2029', '1', '100000', '90182', '9818', '', '2855293', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1344', 'LOAN006', 'AD0000', '1', '3', '2029-04-01', '2029', '4', '100000', '90482', '9518', '', '2764811', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1345', 'LOAN006', 'AD0000', '1', '3', '2029-07-01', '2029', '7', '100000', '90784', '9216', '', '2674027', 'Admin', '2020-09-23 14:50:34', null, '2020-09-23 14:50:34', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1346', 'LOAN006', 'AD0000', '1', '3', '2029-10-01', '2029', '10', '100000', '91087', '8913', '', '2582940', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1347', 'LOAN006', 'AD0000', '1', '3', '2030-01-01', '2030', '1', '100000', '91390', '8610', '', '2491550', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1348', 'LOAN006', 'AD0000', '1', '3', '2030-04-01', '2030', '4', '100000', '91695', '8305', '', '2399855', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1349', 'LOAN006', 'AD0000', '1', '3', '2030-07-01', '2030', '7', '100000', '92000', '8000', '', '2307855', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1350', 'LOAN006', 'AD0000', '1', '3', '2030-10-01', '2030', '10', '100000', '92307', '7693', '', '2215548', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1351', 'LOAN006', 'AD0000', '1', '3', '2031-01-01', '2031', '1', '100000', '92615', '7385', '', '2122933', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1352', 'LOAN006', 'AD0000', '1', '3', '2031-04-01', '2031', '4', '100000', '92924', '7076', '', '2030009', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1353', 'LOAN006', 'AD0000', '1', '3', '2031-07-01', '2031', '7', '100000', '93233', '6767', '', '1936776', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1354', 'LOAN006', 'AD0000', '1', '3', '2031-10-01', '2031', '10', '100000', '93544', '6456', '', '1843232', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1355', 'LOAN006', 'AD0000', '1', '3', '2032-01-01', '2032', '1', '100000', '93856', '6144', '', '1749376', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1356', 'LOAN006', 'AD0000', '1', '3', '2032-04-01', '2032', '4', '100000', '94169', '5831', '', '1655207', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1357', 'LOAN006', 'AD0000', '1', '3', '2032-07-01', '2032', '7', '100000', '94483', '5517', '', '1560725', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1358', 'LOAN006', 'AD0000', '1', '3', '2032-10-01', '2032', '10', '100000', '94798', '5202', '', '1465927', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1359', 'LOAN006', 'AD0000', '1', '3', '2033-01-01', '2033', '1', '100000', '95114', '4886', '', '1370813', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1360', 'LOAN006', 'AD0000', '1', '3', '2033-04-01', '2033', '4', '100000', '95431', '4569', '', '1275383', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1361', 'LOAN006', 'AD0000', '1', '3', '2033-07-01', '2033', '7', '100000', '95749', '4251', '', '1179634', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1362', 'LOAN006', 'AD0000', '1', '3', '2033-10-01', '2033', '10', '100000', '96068', '3932', '', '1083566', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1363', 'LOAN006', 'AD0000', '1', '3', '2034-01-01', '2034', '1', '100000', '96388', '3612', '', '987178', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1364', 'LOAN006', 'AD0000', '1', '3', '2034-04-01', '2034', '4', '100000', '96709', '3291', '', '890469', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1365', 'LOAN006', 'AD0000', '1', '3', '2034-07-01', '2034', '7', '100000', '97032', '2968', '', '793437', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1366', 'LOAN006', 'AD0000', '1', '3', '2034-10-01', '2034', '10', '100000', '97355', '2645', '', '696082', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1367', 'LOAN006', 'AD0000', '1', '3', '2035-01-01', '2035', '1', '100000', '97680', '2320', '', '598402', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1368', 'LOAN006', 'AD0000', '1', '3', '2035-04-01', '2035', '4', '100000', '98005', '1995', '', '500397', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1369', 'LOAN006', 'AD0000', '1', '3', '2035-07-01', '2035', '7', '100000', '98332', '1668', '', '402065', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1370', 'LOAN006', 'AD0000', '1', '3', '2035-10-01', '2035', '10', '100000', '98660', '1340', '', '303405', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1371', 'LOAN006', 'AD0000', '1', '3', '2036-01-01', '2036', '1', '100000', '98989', '1011', '', '204416', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1372', 'LOAN006', 'AD0000', '1', '3', '2036-04-01', '2036', '4', '100000', '99319', '681', '', '105098', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1373', 'LOAN006', 'AD0000', '1', '3', '2036-07-01', '2036', '7', '100000', '99650', '350', '', '5448', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1374', 'LOAN006', 'AD0000', '1', '3', '2036-10-01', '2036', '10', '100000', '99982', '18', '', '0', 'Admin', '2020-09-23 14:50:35', null, '2020-09-23 14:50:35', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1429', 'LOAN007', 'AD0000', '2', '2', '2019-01-01', '2019', '1', '87916', '79577', '8339', '87916', '920423', 'Admin', '2020-09-23 16:11:17', null, '2020-09-23 16:11:17', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1430', 'LOAN007', 'AD0000', '2', '2', '2019-02-01', '2019', '2', '87916', '80241', '7676', '175832', '840182', 'Admin', '2020-09-23 16:11:17', null, '2020-09-23 16:11:17', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1431', 'LOAN007', 'AD0000', '2', '2', '2019-03-01', '2019', '3', '87917', '80911', '7006', '263749', '759272', 'Admin', '2020-09-23 16:11:17', null, '2020-09-23 16:11:17', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1432', 'LOAN007', 'AD0000', '2', '2', '2019-04-01', '2019', '4', '87918', '81586', '6332', '351667', '677686', 'Admin', '2020-09-23 16:11:17', null, '2020-09-23 16:11:17', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1433', 'LOAN007', 'AD0000', '2', '2', '2019-05-01', '2019', '5', '87918', '82267', '5651', '439585', '595419', 'Admin', '2020-09-23 16:11:17', null, '2020-09-23 16:11:17', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1434', 'LOAN007', 'AD0000', '2', '2', '2019-06-01', '2019', '6', '87919', '82953', '4965', '527504', '512466', 'Admin', '2020-09-23 16:11:17', null, '2020-09-23 16:11:17', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1435', 'LOAN007', 'AD0000', '2', '2', '2019-07-01', '2019', '7', '87919', '83646', '4274', '615423', '428820', 'Admin', '2020-09-23 16:11:17', null, '2020-09-23 16:11:17', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1436', 'LOAN007', 'AD0000', '2', '2', '2019-08-01', '2019', '8', '87920', '84344', '3576', '703343', '344476', 'Admin', '2020-09-23 16:11:18', null, '2020-09-23 16:11:18', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1437', 'LOAN007', 'AD0000', '2', '2', '2019-09-01', '2019', '9', '87921', '85048', '2873', '791263', '259428', 'Admin', '2020-09-23 16:11:18', null, '2020-09-23 16:11:18', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1438', 'LOAN007', 'AD0000', '2', '2', '2019-10-01', '2019', '10', '87921', '85758', '2163', '879185', '173670', 'Admin', '2020-09-23 16:11:18', null, '2020-09-23 16:11:18', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1439', 'LOAN007', 'AD0000', '2', '2', '2019-11-01', '2019', '11', '87922', '86474', '1448', '967107', '87196', 'Admin', '2020-09-23 16:11:18', null, '2020-09-23 16:11:18', '0', '0');
INSERT INTO ams_loan_emidetails VALUES ('1440', 'LOAN007', 'AD0000', '2', '2', '2019-12-01', '2019', '12', '87923', '87196', '727', '1055030', '1', 'Admin', '2020-09-23 16:11:18', null, '2020-09-23 16:11:18', '0', '0');

-- ----------------------------
-- Table structure for `ams_login`
-- ----------------------------
DROP TABLE IF EXISTS `ams_login`;
CREATE TABLE `ams_login` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `userId` varchar(100) DEFAULT NULL COMMENT 'ユーザID',
  `email` varchar(100) DEFAULT NULL COMMENT 'メール',
  `password` varchar(100) DEFAULT NULL COMMENT 'パスワード',
  `remember_token` varchar(100) DEFAULT NULL,
  `userType` int(1) DEFAULT NULL COMMENT 'User Type',
  `delFlg` int(1) DEFAULT '0' COMMENT 'Delete Flag',
  `loginStatus` int(1) DEFAULT '0',
  `verifyFlg` int(2) NOT NULL DEFAULT '0',
  `langFlg` int(1) DEFAULT '0',
  `createdBy` varchar(100) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_login
-- ----------------------------
INSERT INTO ams_login VALUES ('1', 'AD0000', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', '7TI3R3fY3RtmUBJDoi6ot7CoNvEpyvkWQIP1J18AmDOhRcYHV1xjJc8WKtut', '1', '0', '1', '0', '1', 'Admin', '2020-08-18 17:08:08', 'Admin', '2020-09-18 19:48:10');
INSERT INTO ams_login VALUES ('2', 'AMS0001', 'madasamy838@gmail.com', '96e79218965eb72c92a549dd5a330112', 'I4XnFJzmTDUZEW3z329OtBJgDmT0aXqoJhK4HYbB0DPL7wbtOVawDseE0t8K', '2', '0', '0', '0', '1', 'Madasamy', '2020-08-24 19:25:59', 'Murugan  Madasamy', '2020-08-24 19:38:09');

-- ----------------------------
-- Table structure for `ams_mailcontent`
-- ----------------------------
DROP TABLE IF EXISTS `ams_mailcontent`;
CREATE TABLE `ams_mailcontent` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `mailId` varchar(10) DEFAULT NULL,
  `mailName` varchar(100) DEFAULT NULL,
  `mailType` int(1) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `header` varchar(50) DEFAULT NULL,
  `content` text,
  `defaultMail` int(1) DEFAULT '0',
  `createdBy` varchar(200) DEFAULT NULL,
  `createdDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` varchar(200) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delFlg` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_mailcontent
-- ----------------------------
INSERT INTO ams_mailcontent VALUES ('1', 'MAIL0001', 'User Register', '1', 'Registration Successfully', 'Dear', 'Welcome to Microbit Pvt Ltd..! \r\n\r\n        Your User Details has been Successfully Registered.   \r\n  Now you can Login by using the details given below. \r\n\r\nLoginId   : LLLLL\r\nPassword  : PPPPP\r\nMobile    : MMMMM', '0', 'Admin', '2017-04-13 13:12:39', 'Admin', '2020-08-20 13:02:01', '0');

-- ----------------------------
-- Table structure for `ams_mailstatus`
-- ----------------------------
DROP TABLE IF EXISTS `ams_mailstatus`;
CREATE TABLE `ams_mailstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Autoincrement id',
  `userId` text,
  `toMail` text,
  `subject` varchar(200) DEFAULT NULL,
  `content` text,
  `sendFlg` int(1) DEFAULT NULL,
  `createdBy` varchar(200) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` varchar(200) DEFAULT NULL,
  `updatedDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `delFlg` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_mailstatus
-- ----------------------------
INSERT INTO ams_mailstatus VALUES ('1', 'AMS0001', 'madasamy838@gmail.com', 'Registration Successfully', '<div style=\"padding-bottom:10px\">\r\n	<table style=\"border:#f6f2f2 solid 5px;font-family:Calibri\" width=\"670\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\">\r\n		<tbody>\r\n			<tr>\r\n				<td colspan=\"2\" style=\"padding:15px 5px 15px 5px;border-bottom:#ccc solid 1px\">\r\n					<table style=\"font-family:Arial,Helvetica,sans-serif;font-size:12px\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n						<tbody>\r\n							<tr>\r\n								<td style=\"padding-right:10px\" width=\"187\" align=\"left\">\r\n									<img src=\"http://cvgendev.sathisys.com/larakyujin/public/images/MB_logo.png\" alt=\"Microbit\" class=\"CToWUd\">\r\n								</td>\r\n							</tr>\r\n							<tr>\r\n								<td colspan=\"2\" style=\"font-family:Calibri;text-align:left;color:#959595;padding:10px;line-height:18px;font-size:13px\"><span class=\"il\">\r\n									</span>To Login directly to the Employer, please click on Login button\r\n								</td>\r\n							</tr>\r\n							<tr>\r\n								<td colspan=\"2\" style=\"padding:20px;color:#5a5a5a;font-family:Calibri;font-size:16px\" bgcolor=\"#d8e8f5\">\r\n									<div><b>Welcome to Microbit Pvt Ltd..! </b></div>\r\n								</td>\r\n							</tr>\r\n							<tr>\r\n								<td colspan=\"2\" style=\"padding:20px 20px 0 20px;color:#5a5a5a;line-height:22px;font-family:Calibri;font-size:14px\" bgcolor=\"#FFFFFF\">\r\n									<p>Dear &nbsp;Murugan  Madasamy</p>Welcome to Microbit Pvt Ltd..! <br />\r\n<br />\r\n        Your User Details has been Successfully Registered.   <br />\r\n  Now you can Login by using the details given below. <br />\r\n<br />\r\nLoginId   : AMS0001<br />\r\nPassword  : 111111<br />\r\nMobile    : 8098609298\r\n								</td>\r\n							</tr>\r\n							<tr>\r\n								<td colspan=\"2\" bgcolor=\"#FFFFFF\">\r\n									<table width=\"650\" style=\"font-family:Calibri;text-align:left;padding:10px 5px 0;line-height:18px;font-size:14px\" cellspacing=\"0\" cellpadding=\"5\" border=\"0\" align=\"center\">\r\n										<colgroup>\r\n											<col width=\"5%\">\r\n											<col width=\"4%\">\r\n											<col>\r\n										</colgroup>\r\n										<tbody>\r\n											<tr>\r\n												<td colspan=\"3\" height=\"54\" bgcolor=\"#E4E4E4\" align=\"center\">\r\n													<a href=\"http://localhost/AssetManagement/User/verifyLogin?userId=AMS0001&amp;name=Murugan  Madasamy\" target=\"_blank\" style=\"background:#bf4237;font-size:18px;color:#fff;text-decoration:none;border-radius:2px;padding:7px 30px;display:inline-block\">Verify Login</a>\r\n												</td>\r\n											</tr>\r\n											<tr>\r\n												<td colspan=\"3\" style=\"padding:20px 20px 0 20px;color:#5a5a5a;line-height:22px;font-family:Calibri;font-size:16px\" bgcolor=\"#FFFFFF\">\r\n													Thanks & Regards <br>Click Here To Visit  <a target=\"_blank\" href=\"http://www.microbit.co.jp\">Microbit.com</a> Team												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n								</td>\r\n							</tr>\r\n						</tbody>\r\n					</table>\r\n				</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>', '0', 'Madasamy', '2020-08-24 19:26:00', 'Madasamy', '2020-08-24 19:26:00', '0');

-- ----------------------------
-- Table structure for `ams_master_assetstypes`
-- ----------------------------
DROP TABLE IF EXISTS `ams_master_assetstypes`;
CREATE TABLE `ams_master_assetstypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `assetsTypes` varchar(100) DEFAULT NULL,
  `createdBy` varchar(10) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(10) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` datetime DEFAULT NULL COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0' COMMENT '0 - Use , 1 - Not In Use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_master_assetstypes
-- ----------------------------
INSERT INTO ams_master_assetstypes VALUES ('1', '1', 'Record', 'Admin', '2020-09-15 15:03:53', 'Admin', '2020-09-15 15:03:53', '0');
INSERT INTO ams_master_assetstypes VALUES ('2', '2', 'Gold', 'Admin', '2020-09-16 00:03:36', 'Admin', '2020-09-16 00:10:31', '0');
INSERT INTO ams_master_assetstypes VALUES ('3', '3', 'Fixed Deposit', 'Admin', '2020-09-16 00:03:47', 'Admin', '2020-09-16 00:11:03', '0');
INSERT INTO ams_master_assetstypes VALUES ('4', '4', 'Cash', 'Admin', '2020-09-16 00:10:10', 'Admin', '2020-09-16 00:10:10', '0');

-- ----------------------------
-- Table structure for `ams_master_buildingname`
-- ----------------------------
DROP TABLE IF EXISTS `ams_master_buildingname`;
CREATE TABLE `ams_master_buildingname` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `buildingName` varchar(100) DEFAULT NULL,
  `createdBy` varchar(10) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(10) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` datetime DEFAULT NULL COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0' COMMENT '0 - Use , 1 - Not In Use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_master_buildingname
-- ----------------------------
INSERT INTO ams_master_buildingname VALUES ('1', '1', '大京ビルマンション', 'Admin', '2020-09-09 13:31:44', null, null, '0');
INSERT INTO ams_master_buildingname VALUES ('2', '2', 'チサンマンション', 'Admin', '2020-09-09 13:32:23', null, null, '0');
INSERT INTO ams_master_buildingname VALUES ('3', '3', '大文ビルマンション', 'Admin', '2020-09-09 13:43:48', null, null, '0');
INSERT INTO ams_master_buildingname VALUES ('4', '4', 'Osaka Mansion', 'Admin', '2020-09-09 13:44:15', null, null, '0');

-- ----------------------------
-- Table structure for `ams_master_expenses_main`
-- ----------------------------
DROP TABLE IF EXISTS `ams_master_expenses_main`;
CREATE TABLE `ams_master_expenses_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `createdBy` varchar(10) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(10) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` datetime DEFAULT NULL COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0' COMMENT '0 - Use , 1 - Not In Use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_master_expenses_main
-- ----------------------------
INSERT INTO ams_master_expenses_main VALUES ('1', '1', 'House Purchase', 'Admin', '2020-08-29 12:03:00', 'Admin', '2020-08-29 12:50:35', '0');
INSERT INTO ams_master_expenses_main VALUES ('2', '2', 'House Related', 'Admin', '2020-08-29 12:50:23', 'Admin', '2020-08-29 12:50:23', '0');
INSERT INTO ams_master_expenses_main VALUES ('3', '3', 'Fixed', 'Admin', '2020-09-10 05:30:17', 'Admin', '2020-09-10 05:30:17', '0');

-- ----------------------------
-- Table structure for `ams_master_expenses_sub`
-- ----------------------------
DROP TABLE IF EXISTS `ams_master_expenses_sub`;
CREATE TABLE `ams_master_expenses_sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `categoryId` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `createdBy` varchar(10) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(10) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` datetime DEFAULT NULL COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0' COMMENT '0 - Use , 1 - Not In Use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_master_expenses_sub
-- ----------------------------
INSERT INTO ams_master_expenses_sub VALUES ('1', '1', null, 'Gas', 'Admin', '2020-08-29 12:03:12', 'Admin', '2020-08-29 12:03:12', '0');
INSERT INTO ams_master_expenses_sub VALUES ('2', '2', null, '管理費', 'Admin', '2020-08-29 12:51:03', 'Admin', '2020-08-29 12:51:03', '0');
INSERT INTO ams_master_expenses_sub VALUES ('3', '3', null, '電気代', 'Admin', '2020-08-29 12:51:36', 'Admin', '2020-08-29 12:51:36', '0');
INSERT INTO ams_master_expenses_sub VALUES ('4', '4', '3', '管理費', 'Admin', '0000-00-00 00:00:00', '2020-09-10', '2020-09-10 05:30:51', '0');
INSERT INTO ams_master_expenses_sub VALUES ('5', '5', '3', 'Tax', 'Admin', '0000-00-00 00:00:00', '2020-09-10', '2020-09-10 05:31:06', '0');

-- ----------------------------
-- Table structure for `ams_master_houseimg_main`
-- ----------------------------
DROP TABLE IF EXISTS `ams_master_houseimg_main`;
CREATE TABLE `ams_master_houseimg_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `imageName` varchar(100) DEFAULT NULL,
  `createdBy` varchar(10) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(10) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` datetime DEFAULT NULL COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0' COMMENT '0 - Use , 1 - Not In Use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_master_houseimg_main
-- ----------------------------
INSERT INTO ams_master_houseimg_main VALUES ('1', '1', 'Hall', 'Admin', '2020-09-04 04:26:56', 'Admin', '2020-09-04 04:27:19', '0');

-- ----------------------------
-- Table structure for `ams_master_houseimg_sub`
-- ----------------------------
DROP TABLE IF EXISTS `ams_master_houseimg_sub`;
CREATE TABLE `ams_master_houseimg_sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `imageId` varchar(100) DEFAULT NULL,
  `imageName` varchar(100) DEFAULT NULL,
  `createdBy` varchar(10) DEFAULT NULL,
  `createdDateTime` datetime DEFAULT NULL COMMENT 'Record Inserted DateTime',
  `updatedBy` varchar(10) DEFAULT NULL COMMENT 'Login UserName',
  `updatedDateTime` datetime DEFAULT NULL COMMENT 'Record Update DateTime',
  `delFlg` int(1) DEFAULT '0' COMMENT '0 - Use , 1 - Not In Use',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_master_houseimg_sub
-- ----------------------------
INSERT INTO ams_master_houseimg_sub VALUES ('1', '1', '1', 'HAll 1', 'Admin', '0000-00-00 00:00:00', '2020-09-11', '2020-09-11 14:48:54', '0');

-- ----------------------------
-- Table structure for `ams_otherasset_details`
-- ----------------------------
DROP TABLE IF EXISTS `ams_otherasset_details`;
CREATE TABLE `ams_otherasset_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(20) DEFAULT NULL,
  `assetId` int(10) DEFAULT NULL,
  `belongsTo` int(10) DEFAULT NULL,
  `mainSubject` varchar(30) DEFAULT '0',
  `remarks` varchar(100) DEFAULT NULL,
  `otherAssetsAmount` varchar(30) DEFAULT NULL,
  `registerDate` varchar(30) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(50) DEFAULT NULL,
  `updatedDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` varchar(50) DEFAULT NULL,
  `editFlg` int(1) NOT NULL DEFAULT '0',
  `copyFlg` int(3) NOT NULL DEFAULT '0',
  `prvMnthFlg` int(3) NOT NULL DEFAULT '0',
  `delFlg` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_otherasset_details
-- ----------------------------
INSERT INTO ams_otherasset_details VALUES ('1', 'AD0000', '4', '1', 'UFJ', '', '300', '2020-09-15', '2020-09-16 00:04:23', 'Admin', '2020-09-18 19:43:17', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('2', 'AD0000', '4', '1', 'Risona', '', '200', '2020-09-15', '2020-09-16 00:05:00', 'Admin', '2020-09-18 18:50:32', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('3', 'AD0000', '4', '2', 'UFJ', '', '50', '2020-09-15', '2020-09-16 00:05:32', 'Admin', '2020-09-18 18:50:32', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('4', 'AD0000', '2', '1', 'Chain 80 gm', '', '57', '2020-09-16', '2020-09-16 09:04:53', 'Admin', '2020-09-18 19:18:46', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('5', 'AD0000', '3', '2', 'SBI INDIA', '.', '100', '2020-09-16', '2020-09-16 09:11:58', 'Admin', '2020-09-18 18:50:32', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('6', 'AD0000', '2', '2', 'chain 120gm', '.', '80', '2020-09-16', '2020-09-16 09:14:29', 'Admin', '2020-09-18 18:50:32', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('7', 'AD0000', '3', '1', 'Advance House 207号', '.', '150', '2020-09-16', '2020-09-16 09:15:55', 'Admin', '2020-09-18 19:43:45', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('8', 'AD0000', '4', '1', 'UFJ', '', '300', '2020-08-15', '2020-08-16 00:04:23', 'Admin', '2020-09-18 19:36:35', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('9', 'AD0000', '2', '1', 'Chain 80 gm', '', '57', '2020-10-16', '2020-09-17 22:43:50', 'Admin', '2020-09-18 19:18:46', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('10', 'AD0000', '2', '2', 'chain 120gm', '.', '80', '2020-10-16', '2020-09-17 22:43:50', 'Admin', '2020-09-18 18:50:32', 'Admin', '0', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('11', 'AD0000', '3', '1', 'Advance House 207号', '.', '150', '2020-10-16', '2020-09-17 22:43:50', 'Admin', '2020-09-18 19:43:45', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('12', 'AD0000', '3', '2', 'SBI INDIA', '.', '100', '2020-10-16', '2020-09-17 22:43:50', 'Admin', '2020-09-18 18:50:32', 'Admin', '0', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('13', 'AD0000', '4', '1', 'UFJ', '', '300', '2020-10-15', '2020-09-17 22:43:50', 'Admin', '2020-09-18 19:43:17', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('14', 'AD0000', '4', '1', 'Risona', '', '200', '2020-10-15', '2020-09-17 22:43:50', 'Admin', '2020-09-18 18:50:32', 'Admin', '0', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('15', 'AD0000', '4', '2', 'UFJ', '', '50', '2020-10-15', '2020-09-17 22:43:50', 'Admin', '2020-09-18 18:50:32', 'Admin', '0', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('16', 'AD0000', '2', '1', 'Chain 80 gm', '', '57', '2020-11-16', '2020-09-17 22:48:41', 'Admin', '2020-09-18 19:18:46', 'Admin', '1', '0', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('17', 'AD0000', '2', '2', 'chain 120gm', '.', '80', '2020-11-16', '2020-09-17 22:48:41', 'Admin', '2020-09-18 18:50:32', null, '0', '0', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('18', 'AD0000', '3', '1', 'Advance House 207号', '.', '150', '2020-11-16', '2020-09-17 22:48:42', 'Admin', '2020-09-18 19:43:45', 'Admin', '1', '0', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('19', 'AD0000', '3', '2', 'SBI INDIA', '.', '100', '2020-11-16', '2020-09-17 22:48:42', 'Admin', '2020-09-18 18:50:32', null, '0', '0', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('20', 'AD0000', '4', '1', 'UFJ', '', '300', '2020-11-15', '2020-09-17 22:48:42', 'Admin', '2020-09-18 19:43:17', 'Admin', '1', '0', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('21', 'AD0000', '4', '1', 'Risona', '', '200', '2020-11-15', '2020-09-17 22:48:42', 'Admin', '2020-09-18 18:50:32', null, '0', '0', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('22', 'AD0000', '4', '2', 'UFJ', '', '50', '2020-11-15', '2020-09-17 22:48:42', 'Admin', '2020-09-18 18:50:32', null, '0', '0', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('23', 'AD0000', '4', '1', 'CashAmount', '', '60', '2020-09-18', '2020-09-18 19:20:06', 'Admin', '2020-09-18 19:49:40', 'Admin', '1', '1', '0', '0');
INSERT INTO ams_otherasset_details VALUES ('24', 'AD0000', '4', '1', 'CashAmount', '', '60', '2020-10-18', '2020-09-18 19:35:16', 'Admin', '2020-09-18 19:49:40', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('25', 'AD0000', '4', '3', 'UFJ', '', '200', '2020-09-15', '2020-09-18 19:36:35', 'Admin', '2020-09-18 19:40:48', 'Admin', '1', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('26', 'AD0000', '4', '3', 'UFJ', '', '200', '2020-10-15', '2020-09-18 19:40:48', 'Admin', '2020-09-18 19:40:55', 'Admin', '0', '1', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('27', 'AD0000', '4', '1', 'CashAmount', '', '60', '2020-11-18', '2020-09-18 19:40:55', 'Admin', '2020-09-18 19:49:40', 'Admin', '1', '0', '1', '0');
INSERT INTO ams_otherasset_details VALUES ('28', 'AD0000', '4', '3', 'UFJ', '', '200', '2020-11-15', '2020-09-18 19:40:55', 'Admin', '2020-09-18 19:40:55', null, '0', '0', '1', '0');

-- ----------------------------
-- Table structure for `ams_users`
-- ----------------------------
DROP TABLE IF EXISTS `ams_users`;
CREATE TABLE `ams_users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `userId` varchar(10) DEFAULT NULL COMMENT 'ユーザID',
  `firstName` varchar(100) DEFAULT NULL COMMENT '名',
  `lastName` varchar(100) DEFAULT NULL COMMENT '姓',
  `email` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` int(1) DEFAULT NULL COMMENT '性別',
  `mobileNo` varchar(18) DEFAULT NULL,
  `userType` int(1) DEFAULT NULL,
  `createdBy` varchar(100) DEFAULT NULL,
  `createdDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` varchar(30) DEFAULT NULL,
  `updatedDateTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delFlg` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ams_users
-- ----------------------------
INSERT INTO ams_users VALUES ('1', 'AD0000', 'Admin', 'Admin', 'admin@gmail.com', '1994-02-21', '1', '1234567891', '1', 'Admin', '2020-08-19 12:02:21', '', '2020-08-22 20:14:59', '0');
INSERT INTO ams_users VALUES ('2', 'AMS0001', 'Murugan', 'Madasamy', 'madasamy838@gmail.com', '1994-09-13', '1', '2147483647', '2', 'Madasamy', '2020-08-24 19:25:59', '', '2020-08-24 19:25:59', '0');

-- ----------------------------
-- Table structure for `chart_data_column`
-- ----------------------------
DROP TABLE IF EXISTS `chart_data_column`;
CREATE TABLE `chart_data_column` (
  `month` varchar(10) NOT NULL,
  `sale` int(3) NOT NULL,
  `profit` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of chart_data_column
-- ----------------------------
INSERT INTO chart_data_column VALUES ('Jan', '1000', '150');
INSERT INTO chart_data_column VALUES ('Feb', '200', '130');
INSERT INTO chart_data_column VALUES ('Mar', '300', '200');
INSERT INTO chart_data_column VALUES ('April', '400', '300');
INSERT INTO chart_data_column VALUES ('May', '300', '200');
INSERT INTO chart_data_column VALUES ('Jun', '200', '100');
INSERT INTO chart_data_column VALUES ('July', '200', '150');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
