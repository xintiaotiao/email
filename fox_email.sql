/*
Navicat MySQL Data Transfer

Source Server         : xintiaotiao
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : fox_email

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-06-06 17:11:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `em_auth`
-- ----------------------------
DROP TABLE IF EXISTS `em_auth`;
CREATE TABLE `em_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '权限信息字符串',
  `rpath` varchar(255) NOT NULL DEFAULT ' ',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=272 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of em_auth
-- ----------------------------
INSERT INTO `em_auth` VALUES ('8', '用户添加', 'userAdd', '0');
INSERT INTO `em_auth` VALUES ('9', '用户列表', 'userList', '0');
INSERT INTO `em_auth` VALUES ('10', '用户详情', 'imgLarge', '0');
INSERT INTO `em_auth` VALUES ('11', '用户编辑', 'userEdit', '0');
INSERT INTO `em_auth` VALUES ('12', '用户删除', 'userDel', '0');
INSERT INTO `em_auth` VALUES ('13', '修改密码', 'password', '0');
INSERT INTO `em_auth` VALUES ('14', '部门批量删除', 'deptDell', '0');
INSERT INTO `em_auth` VALUES ('15', '部门添加', 'deptAdd', '0');
INSERT INTO `em_auth` VALUES ('16', '用户批量删除', 'userDell', '0');
INSERT INTO `em_auth` VALUES ('17', '部门列表', 'deptList', '0');
INSERT INTO `em_auth` VALUES ('18', '部门编辑', 'deptEdit', '0');
INSERT INTO `em_auth` VALUES ('19', '部门删除', 'deptDel', '0');
INSERT INTO `em_auth` VALUES ('20', '邮件发送', 'emailAdd', '0');
INSERT INTO `em_auth` VALUES ('21', '发件箱', 'emailSendBox', '0');
INSERT INTO `em_auth` VALUES ('22', '收件箱', 'emailResiveBox', '0');
INSERT INTO `em_auth` VALUES ('23', '删除邮件', 'emailDel', '0');
INSERT INTO `em_auth` VALUES ('24', '下载邮件', 'download', '0');
INSERT INTO `em_auth` VALUES ('25', '转发邮件', 'emailTransForm', '0');
INSERT INTO `em_auth` VALUES ('26', '查看收件箱', 'emailRead1', '0');
INSERT INTO `em_auth` VALUES ('28', '角色管理', 'roleList', '0');
INSERT INTO `em_auth` VALUES ('29', '权限管理', 'authList', '0');
INSERT INTO `em_auth` VALUES ('30', '邮件批量删除', 'emailDell', '0');
INSERT INTO `em_auth` VALUES ('27', '查看发件箱', 'emailRead', '0');

-- ----------------------------
-- Table structure for `em_dept`
-- ----------------------------
DROP TABLE IF EXISTS `em_dept`;
CREATE TABLE `em_dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '��������',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '���Ÿ���id��0��ʾ��������',
  `spath` varchar(255) NOT NULL DEFAULT '' COMMENT '���������ֶΣ��ɸ���·�����ϸ���id���',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '�������ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of em_dept
-- ----------------------------
INSERT INTO `em_dept` VALUES ('1', '顶级部门', '0', '0', '1111111111');
INSERT INTO `em_dept` VALUES ('2', '产品安全部', '1', '0,1', '1527147147');
INSERT INTO `em_dept` VALUES ('3', '权限系统课', '2', '0,1,2', '1527147174');
INSERT INTO `em_dept` VALUES ('4', '门禁管控课', '2', '0,1,2', '1527147193');
INSERT INTO `em_dept` VALUES ('5', '监控技防课', '2', '0,1,2', '1527147219');
INSERT INTO `em_dept` VALUES ('6', 'EPM', '1', '0,1', '1527147231');
INSERT INTO `em_dept` VALUES ('16', '新专案管控', '6', '0,1,6', '1527210962');
INSERT INTO `em_dept` VALUES ('9', '换证权限组', '3', '0,1,2,3', '1527147541');
INSERT INTO `em_dept` VALUES ('10', '卡机维护组', '3', '0,1,2,3', '1527147557');
INSERT INTO `em_dept` VALUES ('11', 'TT&物品放行', '3', '0,1,2,3', '1527147576');
INSERT INTO `em_dept` VALUES ('12', '其它人员', '3', '0,1,2,3', '1527149743');
INSERT INTO `em_dept` VALUES ('19', 'RR专案', '16', '0,1,6,16', '1527229500');

-- ----------------------------
-- Table structure for `em_email`
-- ----------------------------
DROP TABLE IF EXISTS `em_email`;
CREATE TABLE `em_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL DEFAULT '8' COMMENT '记录发送者的id',
  `to_id` int(11) NOT NULL DEFAULT '9' COMMENT '记录收件者的id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '邮件的标题信息',
  `file_num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '邮件的附件数量',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '附件的名字，供显示何下载的时候调用',
  `file_path` varchar(255) NOT NULL DEFAULT '' COMMENT '附件的路径，下载附件的时候需要',
  `is_read` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0表示未读，1表示已读',
  `content` text NOT NULL COMMENT '邮件的文本内容',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '邮件发送时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of em_email
-- ----------------------------
INSERT INTO `em_email` VALUES ('23', '8', '18', '从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853307');
INSERT INTO `em_email` VALUES ('24', '8', '13', '从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853307');
INSERT INTO `em_email` VALUES ('22', '8', '23', '转发：管理员发送邮件测试邮件！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！', '1527852595');
INSERT INTO `em_email` VALUES ('11', '8', '13', '管理员发送邮件测试邮件！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '1', '管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！', '1527764823');
INSERT INTO `em_email` VALUES ('25', '8', '9', '从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853307');
INSERT INTO `em_email` VALUES ('19', '8', '10', '转发：管理员发送邮件测试邮件！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！', '1527852595');
INSERT INTO `em_email` VALUES ('20', '8', '13', '转发：管理员发送邮件测试邮件！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！', '1527852595');
INSERT INTO `em_email` VALUES ('16', '8', '23', '管理员发送邮件测试邮件！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！', '1527764823');
INSERT INTO `em_email` VALUES ('17', '8', '1', '管理员发送邮件测试邮件！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '1', '管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！', '1527764823');
INSERT INTO `em_email` VALUES ('21', '8', '16', '转发：管理员发送邮件测试邮件！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！', '1527852595');
INSERT INTO `em_email` VALUES ('26', '8', '25', '从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853307');
INSERT INTO `em_email` VALUES ('27', '8', '27', '从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853307');
INSERT INTO `em_email` VALUES ('28', '8', '22', '从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '1', '从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853307');
INSERT INTO `em_email` VALUES ('29', '8', '23', '从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853307');
INSERT INTO `em_email` VALUES ('30', '8', '17', '从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853307');
INSERT INTO `em_email` VALUES ('31', '8', '13', '从收件人杨*艳--G4912404处转发：从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人杨*艳--G4912404处转发：从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853863');
INSERT INTO `em_email` VALUES ('32', '8', '9', '从收件人杨*艳--G4912404处转发：从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人杨*艳--G4912404处转发：从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853863');
INSERT INTO `em_email` VALUES ('33', '8', '23', '从收件人杨*艳--G4912404处转发：从收件人管理员--xintiaotiao处转发：这是转发邮件功能测试！', '4', '152776482366913.xlsx,152776482334005.xlsx,152776482362372.xlsx,152776482364035.jpg', '/upload/2018-05-31/152776482366913.xlsx,/upload/2018-05-31/152776482334005.xlsx,/upload/2018-05-31/152776482362372.xlsx,/upload/2018-05-31/152776482364035.jpg', '0', '从收件人杨*艳--G4912404处转发：从收件人管理员--xintiaotiao处转发：管理员测试邮件，较thinkphp3.2.3邮件系统，增加了群发功能，实现了部门的无限极分类，完善了用户按部门进行分类显示，以便群发的时候进行选择！\r\n转发功能测试！', '1527853863');
INSERT INTO `em_email` VALUES ('34', '8', '9', '收件箱测试', '0', '', '', '1', '收件箱测试收件箱测试收件箱测试', '1528075295');
INSERT INTO `em_email` VALUES ('35', '8', '9', '收件箱测试1', '1', '152807532515041.jpg', '/upload/2018-06-04/152807532515041.jpg', '0', '收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试111', '1528075325');
INSERT INTO `em_email` VALUES ('36', '8', '9', '收件箱测试2', '1', '152807535059326.jpg', '/upload/2018-06-04/152807535059326.jpg', '1', '收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试2', '1528075350');
INSERT INTO `em_email` VALUES ('37', '8', '20', '收件箱测试2', '1', '152807535059326.jpg', '/upload/2018-06-04/152807535059326.jpg', '0', '收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试2', '1528075350');
INSERT INTO `em_email` VALUES ('40', '8', '13', '收件箱测试3', '1', '152807541454068.jpg', '/upload/2018-06-04/152807541454068.jpg', '1', '收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试3', '1528075414');
INSERT INTO `em_email` VALUES ('41', '8', '9', '收件箱测试3', '1', '152807541454068.jpg', '/upload/2018-06-04/152807541454068.jpg', '0', '收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试3', '1528075414');
INSERT INTO `em_email` VALUES ('42', '9', '10', '从收件人胡*林--G4812159处转发：收件箱测试1', '1', '152807532515041.jpg', '/upload/2018-06-04/152807532515041.jpg', '1', '从收件人胡*林--G4812159处转发：收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试111', '1528075515');
INSERT INTO `em_email` VALUES ('43', '9', '13', '从收件人胡*林--G4812159处转发：收件箱测试1', '1', '152807532515041.jpg', '/upload/2018-06-04/152807532515041.jpg', '0', '从收件人胡*林--G4812159处转发：收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试111', '1528075515');
INSERT INTO `em_email` VALUES ('44', '9', '8', '从收件人胡*林--G4812159处转发：收件箱测试1', '1', '152807532515041.jpg', '/upload/2018-06-04/152807532515041.jpg', '0', '从收件人胡*林--G4812159处转发：收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试111', '1528075515');
INSERT INTO `em_email` VALUES ('46', '9', '20', '从收件人胡*林--G4812159处转发：收件箱测试1', '1', '152807532515041.jpg', '/upload/2018-06-04/152807532515041.jpg', '0', '从收件人胡*林--G4812159处转发：收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试111', '1528075515');
INSERT INTO `em_email` VALUES ('47', '9', '24', '从收件人胡*林--G4812159处转发：收件箱测试1', '1', '152807532515041.jpg', '/upload/2018-06-04/152807532515041.jpg', '1', '从收件人胡*林--G4812159处转发：收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试111', '1528075515');
INSERT INTO `em_email` VALUES ('48', '9', '21', '从收件人胡*林--G4812159处转发：收件箱测试1', '1', '152807532515041.jpg', '/upload/2018-06-04/152807532515041.jpg', '0', '从收件人胡*林--G4812159处转发：收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试111', '1528075515');
INSERT INTO `em_email` VALUES ('49', '9', '23', '从收件人胡*林--G4812159处转发：收件箱测试1', '1', '152807532515041.jpg', '/upload/2018-06-04/152807532515041.jpg', '0', '从收件人胡*林--G4812159处转发：收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试111', '1528075515');
INSERT INTO `em_email` VALUES ('50', '9', '1', '从收件人胡*林--G4812159处转发：收件箱测试1', '1', '152807532515041.jpg', '/upload/2018-06-04/152807532515041.jpg', '0', '从收件人胡*林--G4812159处转发：收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试收件箱测试111', '1528075515');
INSERT INTO `em_email` VALUES ('51', '9', '8', '回发邮件测试', '0', '', '', '0', '回发邮件测试回发邮件测试回发邮件测试回发邮件测试回发邮件测试回发邮件测试回发邮件测试', '1528075557');
INSERT INTO `em_email` VALUES ('52', '9', '1', '回发邮件测试', '0', '', '', '0', '回发邮件测试回发邮件测试回发邮件测试回发邮件测试回发邮件测试回发邮件测试回发邮件测试', '1528075557');

-- ----------------------------
-- Table structure for `em_role`
-- ----------------------------
DROP TABLE IF EXISTS `em_role`;
CREATE TABLE `em_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '用户角色名称',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of em_role
-- ----------------------------
INSERT INTO `em_role` VALUES ('1', '超级管理员', '1528108342');
INSERT INTO `em_role` VALUES ('2', '管理员', '1528108499');
INSERT INTO `em_role` VALUES ('3', '普通用户', '1528108518');
INSERT INTO `em_role` VALUES ('5', '测试账号1', '1528244899');
INSERT INTO `em_role` VALUES ('6', '测试账号2', '1528244905');

-- ----------------------------
-- Table structure for `em_role_auth`
-- ----------------------------
DROP TABLE IF EXISTS `em_role_auth`;
CREATE TABLE `em_role_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '1' COMMENT '对应的角色id',
  `auth_id` varchar(255) DEFAULT ' ' COMMENT '对应的权限信息',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of em_role_auth
-- ----------------------------
INSERT INTO `em_role_auth` VALUES ('3', '1', 'test', '1528274490');
INSERT INTO `em_role_auth` VALUES ('5', '2', 'roleList,authList', '1528267495');
INSERT INTO `em_role_auth` VALUES ('6', '3', 'userAdd,userEdit,userDel,deptDell,deptAdd,userDell,deptEdit,deptDel,roleList,authList', '1528267534');
INSERT INTO `em_role_auth` VALUES ('7', '5', 'userAdd,userList,deptList,deptEdit,deptDel,emailResiveBox,emailTransForm,roleList', '1528267555');
INSERT INTO `em_role_auth` VALUES ('8', '6', 'imgLarge,userDell,deptList,deptDel,emailSendBox,download,emailTransForm,emailRead,roleList', '1528267576');

-- ----------------------------
-- Table structure for `em_user`
-- ----------------------------
DROP TABLE IF EXISTS `em_user`;
CREATE TABLE `em_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `truename` varchar(255) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `sex` int(11) NOT NULL DEFAULT '1' COMMENT '1表示男，2表示女，3表示保密',
  `img` varchar(100) NOT NULL DEFAULT '' COMMENT '用户头像',
  `dept_id` int(11) NOT NULL DEFAULT '1' COMMENT '用户所属部分，1表示待分发',
  `role_id` int(11) NOT NULL DEFAULT '1' COMMENT '用户所属权限，1表示普通用户，2表示管理员',
  `is_use` int(11) NOT NULL DEFAULT '1' COMMENT '0表示禁用，1表示启用',
  `intro` text NOT NULL COMMENT '用户个人介绍',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '用户注册时间',
  PRIMARY KEY (`id`),
  KEY `username` (`username`,`password`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of em_user
-- ----------------------------
INSERT INTO `em_user` VALUES ('1', '管理员', 'xintiaotiao', '111111', '1', '/upload/2018-05-30/152766436192068.jpg', '19', '2', '1', '本网站开发作者 2018-5-30', '1528268709');
INSERT INTO `em_user` VALUES ('8', '杨小超', 'G4869784', '123456', '3', '/upload/2018-05-30/152767204252395.jpg', '9', '1', '1', '网站原作者。。。', '1527672042');
INSERT INTO `em_user` VALUES ('10', '陶鹏程', 'G4229486', '123456', '3', '/upload/2018-05-30/152767227037958.jpg', '10', '3', '1', 'boss  一枚......', '1527745761');
INSERT INTO `em_user` VALUES ('11', '寇雷雷', 'G4286358', '123456', '1', '/upload/2018-05-30/152767240646918.JPG', '11', '3', '0', 'TT系统负责人.......', '1527730777');
INSERT INTO `em_user` VALUES ('12', '郭金钟', 'G4286559', '123456', '1', '/upload/2018-05-30/152767248685582.jpg', '10', '3', '1', '卡机BOSS一枚./......', '1527730792');
INSERT INTO `em_user` VALUES ('9', '胡*林', 'G4812159', '123456', '2', '/upload/2018-05-30/152767216018185.jpg', '9', '5', '1', '湖南辣妹子一枚...', '1528269121');
INSERT INTO `em_user` VALUES ('13', '牛*丽', 'G4280617', '123456', '2', '/upload/2018-05-30/152767255036235.jpg', '12', '3', '1', '老牛一只，咩咩.....', '1527672550');
INSERT INTO `em_user` VALUES ('14', '焦*芳', 'G4279409', '123456', '2', '/upload/2018-05-31/152772952288330.png', '4', '3', '0', '妹子。。。', '1527730822');
INSERT INTO `em_user` VALUES ('15', '沈道霸', 'G4614747', '123456', '1', '/upload/2018-05-31/152772973614260.png', '10', '3', '0', '霸气男一枚。。。。', '1527762245');
INSERT INTO `em_user` VALUES ('16', '罗*芬', 'G4440999', '123456', '2', '/upload/2018-05-31/152772981048573.png', '9', '3', '1', '辣妈一枚/.....', '1527746923');
INSERT INTO `em_user` VALUES ('17', '谷林军', 'G4769404', '123456', '1', '/upload/2018-05-31/152772991642382.png', '19', '3', '1', '湖南男汉子.....', '1527729916');
INSERT INTO `em_user` VALUES ('18', '王德武', 'G4787370', '123456', '1', '/upload/2018-05-31/152772999464325.png', '10', '3', '1', '南阳大神.........', '1527729994');
INSERT INTO `em_user` VALUES ('19', '刘吉涛', 'G4820555', '123456', '3', '/upload/2018-05-31/152773005780737.png', '12', '3', '1', '逗比一枚........', '1527730057');
INSERT INTO `em_user` VALUES ('20', '郭志明', 'G4880356', '123456', '1', '/upload/2018-05-31/152773011975385.png', '9', '3', '1', '小鲜肉一只.........', '1527730119');
INSERT INTO `em_user` VALUES ('21', '王世扬', 'G4600515', '123456', '1', '/upload/2018-05-31/152773018075474.png', '4', '3', '1', '小姚明..........', '1527730180');
INSERT INTO `em_user` VALUES ('22', '杨*艳', 'G4912404', '123456', '2', '/upload/2018-05-31/152773029394954.png', '5', '3', '0', '小妹子一只.............', '1527730490');
INSERT INTO `em_user` VALUES ('23', '测试账号', 'test', 'test', '3', '/upload/2018-05-31/152773103758688.png', '6', '4', '1', '测试员账号，对外公布，用于体验网站功能，但是会受到权限控制......', '1528112801');
INSERT INTO `em_user` VALUES ('24', '111', '111', '111', '1', '/upload/2018-05-31/152774746977964.png', '9', '3', '1', '111', '1527747469');
INSERT INTO `em_user` VALUES ('25', '222', '222', '222', '2', '/upload/2018-05-31/152774748476925.png', '9', '3', '1', '222', '1527747484');
INSERT INTO `em_user` VALUES ('26', '333', '333', '333', '2', '/upload/2018-05-31/152774749932044.png', '9', '3', '1', '333', '1527747499');
INSERT INTO `em_user` VALUES ('27', '444', '444', '444', '2', '/upload/2018-05-31/152774760876755.png', '9', '3', '1', '444', '1527747608');
