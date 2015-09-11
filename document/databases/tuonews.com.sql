/*Navicat MySQL Data TransferSource Server         : 192.168.1.2Source Server Version : 50621Source Host           : 192.168.1.2:3306Source Database       : tuonews.comTarget Server Type    : MYSQLTarget Server Version : 50621File Encoding         : 65001Date: 2015-05-13 20:43:59*/SET FOREIGN_KEY_CHECKS=0;-- ------------------------------ Table structure for fiidee_admin_menu-- ----------------------------DROP TABLE IF EXISTS `fiidee_admin_menu`;CREATE TABLE `fiidee_admin_menu` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `group_id` smallint(3) DEFAULT '0' COMMENT '菜单分组ID',  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '名称',  `url` varchar(150) NOT NULL DEFAULT '' COMMENT '链接地址',  `pid` smallint(4) DEFAULT '0' COMMENT '父菜单',  `ishow` tinyint(1) DEFAULT '1' COMMENT '0：不显示，1：显示，默认为1',  `sort_num` varchar(3) DEFAULT '00' COMMENT '排序',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统后台菜单表';-- ------------------------------ Records of fiidee_admin_menu-- ------------------------------ ------------------------------ Table structure for fiidee_admin_menu_group-- ----------------------------DROP TABLE IF EXISTS `fiidee_admin_menu_group`;CREATE TABLE `fiidee_admin_menu_group` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(20) DEFAULT '' COMMENT '分组名称',  `icon` varchar(16) DEFAULT '' COMMENT '分组图标',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台菜单分组';-- ------------------------------ Records of fiidee_admin_menu_group-- ------------------------------ ------------------------------ Table structure for fiidee_admin_role-- ----------------------------DROP TABLE IF EXISTS `fiidee_admin_role`;CREATE TABLE `fiidee_admin_role` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',  `name` varchar(20) DEFAULT '' COMMENT '角色名称',  `summary` varchar(100) DEFAULT '' COMMENT '角色简介',  `permissions` text COMMENT '角色权限的序列表数组',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  `sort_num` tinyint(3) DEFAULT '0' COMMENT '排序数字',  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员角色';-- ------------------------------ Records of fiidee_admin_role-- ----------------------------INSERT INTO `fiidee_admin_role` VALUES ('1', '超级管理员', '超级管理员，具有最高权限。', null, '1431505208', '1');INSERT INTO `fiidee_admin_role` VALUES ('2', '运营总监', '管理网站运营相关的操作', null, '1431505348', '2');INSERT INTO `fiidee_admin_role` VALUES ('3', '网站编辑', '管理系统平台上面的内容资讯', null, '1431505365', '3');-- ------------------------------ Table structure for fiidee_admin_user-- ----------------------------DROP TABLE IF EXISTS `fiidee_admin_user`;CREATE TABLE `fiidee_admin_user` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',  `role_id` int(11) unsigned DEFAULT '0' COMMENT '角色ID',  `username` varchar(30) DEFAULT '' COMMENT '用户名',  `password` varchar(32) DEFAULT '' COMMENT '密码',  `last_login_time` int(11) DEFAULT '0' COMMENT '最后一次登录时间',  `last_login_ip` varchar(15) DEFAULT '' COMMENT '最后一次登录ip',  `add_time` int(11) DEFAULT '0' COMMENT '注册时间',  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '当前状态(0=>禁用，1=>启用)',  `isystem` tinyint(1) DEFAULT '0' COMMENT '是否系统管理员(系统管理员不准许删除)',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员表';-- ------------------------------ Records of fiidee_admin_user-- ------------------------------ ------------------------------ Table structure for fiidee_article-- ----------------------------DROP TABLE IF EXISTS `fiidee_article`;CREATE TABLE `fiidee_article` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `userid` bigint(20) DEFAULT '0' COMMENT '用户ID',  `chanel_id` int(11) DEFAULT '0' COMMENT '频道ID',  `media_id` bigint(20) DEFAULT '0' COMMENT '所属媒体ID',  `media_mid` bigint(20) DEFAULT '0' COMMENT '媒体栏目ID',  `catid` int(11) DEFAULT '0' COMMENT '分类ID',  `title` varchar(100) DEFAULT '' COMMENT '文章标题',  `kwords` varchar(100) DEFAULT '' COMMENT '关键字',  `bcontent` varchar(255) DEFAULT '' COMMENT '简介',  `author` varchar(10) DEFAULT '' COMMENT '作者',  `source` varchar(16) DEFAULT '' COMMENT '文章来源',  `source_url` varchar(160) DEFAULT '' COMMENT '来源链接',  `tags` varchar(60) DEFAULT '' COMMENT '文章标签ids，逗号串接',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',  `publish_time` varchar(30) DEFAULT '' COMMENT '发布者',  `share_times` int(11) DEFAULT '0' COMMENT '被的分享次数',  `hits` int(11) DEFAULT '0' COMMENT '查看次数',  `collect_times` int(11) DEFAULT '0' COMMENT '收藏次数',  `zan_times` int(11) DEFAULT '0' COMMENT '点赞次数',  `comment_times` int(11) DEFAULT '0' COMMENT '评论次数',  `thumb` varchar(120) DEFAULT '' COMMENT '文章缩略图',  `rec_position` varchar(60) DEFAULT '' COMMENT '文章推荐位置，逗号连接',  `trash` tinyint(1) DEFAULT '0' COMMENT '是否在回收站',  `sort_num` int(11) DEFAULT '0' COMMENT '排序数字',  `ischeck` tinyint(1) DEFAULT '1' COMMENT '是否审核，默认审核',  `admin_rec` tinyint(1) DEFAULT '0' COMMENT '管理员推荐（0：不推荐，1：推荐）',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='图文模块表';-- ------------------------------ Records of fiidee_article-- ------------------------------ ------------------------------ Table structure for fiidee_article_data_0-- ----------------------------DROP TABLE IF EXISTS `fiidee_article_data_0`;CREATE TABLE `fiidee_article_data_0` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `aid` bigint(20) DEFAULT '0' COMMENT '文章id',  `content` text COMMENT '文章内容',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章内容表节点0';-- ------------------------------ Records of fiidee_article_data_0-- ------------------------------ ------------------------------ Table structure for fiidee_article_data_1-- ----------------------------DROP TABLE IF EXISTS `fiidee_article_data_1`;CREATE TABLE `fiidee_article_data_1` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `aid` bigint(20) DEFAULT '0' COMMENT '文章id',  `content` text COMMENT '文章内容',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='文章内容表节点1';-- ------------------------------ Records of fiidee_article_data_1-- ------------------------------ ------------------------------ Table structure for fiidee_article_data_2-- ----------------------------DROP TABLE IF EXISTS `fiidee_article_data_2`;CREATE TABLE `fiidee_article_data_2` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `aid` bigint(20) DEFAULT '0' COMMENT '文章id',  `content` text COMMENT '文章内容',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='文章内容表节点2';-- ------------------------------ Records of fiidee_article_data_2-- ------------------------------ ------------------------------ Table structure for fiidee_article_data_3-- ----------------------------DROP TABLE IF EXISTS `fiidee_article_data_3`;CREATE TABLE `fiidee_article_data_3` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `aid` bigint(20) DEFAULT '0' COMMENT '文章id',  `content` text COMMENT '文章内容',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='文章内容表节点3';-- ------------------------------ Records of fiidee_article_data_3-- ------------------------------ ------------------------------ Table structure for fiidee_article_rec-- ----------------------------DROP TABLE IF EXISTS `fiidee_article_rec`;CREATE TABLE `fiidee_article_rec` (  `id` smallint(6) NOT NULL AUTO_INCREMENT,  `name` varchar(16) DEFAULT '' COMMENT '推荐位名称',  `position` varchar(30) DEFAULT '' COMMENT '用来表示推荐位置',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章推荐位';-- ------------------------------ Records of fiidee_article_rec-- ------------------------------ ------------------------------ Table structure for fiidee_article_tags-- ----------------------------DROP TABLE IF EXISTS `fiidee_article_tags`;CREATE TABLE `fiidee_article_tags` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `name` varchar(20) DEFAULT '' COMMENT '标签名称',  `aid` bigint(20) DEFAULT '0' COMMENT '文章ID',  `hits` int(11) DEFAULT '0' COMMENT '点击次数',  `intro` varchar(300) DEFAULT '' COMMENT '标签简介',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章标签';-- ------------------------------ Records of fiidee_article_tags-- ------------------------------ ------------------------------ Table structure for fiidee_artone-- ----------------------------DROP TABLE IF EXISTS `fiidee_artone`;CREATE TABLE `fiidee_artone` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `media_id` bigint(20) DEFAULT '0' COMMENT '媒体用户ID,如果是系统文章则此项为0',  `title` varchar(100) DEFAULT '' COMMENT '文章标题',  `content` text COMMENT '文章内容',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',  `hits` int(11) DEFAULT '0' COMMENT '查看次数',  `position` varchar(30) DEFAULT '' COMMENT '显示的位置',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单文章系统';-- ------------------------------ Records of fiidee_artone-- ------------------------------ ------------------------------ Table structure for fiidee_chanel-- ----------------------------DROP TABLE IF EXISTS `fiidee_chanel`;CREATE TABLE `fiidee_chanel` (  `id` smallint(6) NOT NULL AUTO_INCREMENT,  `pid` smallint(6) DEFAULT '0' COMMENT '上级频道ID，如果是顶级频道则pid=0',  `name` varchar(20) DEFAULT '' COMMENT '频道名称',  `sort_num` smallint(3) DEFAULT '0' COMMENT '排序数字',  `seo_title` varchar(100) DEFAULT '' COMMENT 'seo标题',  `seo_kword` varchar(100) DEFAULT '' COMMENT 'seo关键字',  `seo_desc` varchar(150) DEFAULT '' COMMENT 'seo描述',  `show_top` tinyint(1) DEFAULT '1' COMMENT '是否允许在顶部显示',  `show_bottom` tinyint(1) DEFAULT '0' COMMENT '是否允许在底部显示',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='频道表';-- ------------------------------ Records of fiidee_chanel-- ------------------------------ ------------------------------ Table structure for fiidee_config-- ----------------------------DROP TABLE IF EXISTS `fiidee_config`;CREATE TABLE `fiidee_config` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `group` varchar(10) DEFAULT NULL COMMENT '配置分组',  `type` varchar(10) DEFAULT NULL COMMENT '变量类型（input：输入框，text：长文本框）',  `varname` varchar(30) DEFAULT NULL COMMENT '变量key',  `varval` varchar(500) DEFAULT NULL COMMENT '变量值',  `name` varchar(60) DEFAULT NULL COMMENT '变量名',  `help_txt` varchar(100) DEFAULT NULL COMMENT '提示内容',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表';-- ------------------------------ Records of fiidee_config-- ------------------------------ ------------------------------ Table structure for fiidee_friendlink-- ----------------------------DROP TABLE IF EXISTS `fiidee_friendlink`;CREATE TABLE `fiidee_friendlink` (  `id` smallint(6) NOT NULL AUTO_INCREMENT,  `chanel_id` smallint(6) DEFAULT '0' COMMENT '所属频道',  `name` varchar(20) DEFAULT '' COMMENT '友情链接名称',  `url` varchar(160) DEFAULT '' COMMENT '友情链接地址',  `ishow` tinyint(1) DEFAULT '1' COMMENT '是否显示(默认不显示)',  `nofollow` tinyint(1) DEFAULT '0' COMMENT '是否让搜索引擎抓取(0：抓取，1：不抓取)',  `style` tinyint(1) DEFAULT '0' COMMENT '友链的样式(0：文字，1：图片)',  `src` varchar(120) DEFAULT '' COMMENT '友链图片地址',  `sort_num` smallint(3) DEFAULT '0' COMMENT '排序',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接表';-- ------------------------------ Records of fiidee_friendlink-- ------------------------------ ------------------------------ Table structure for fiidee_image-- ----------------------------DROP TABLE IF EXISTS `fiidee_image`;CREATE TABLE `fiidee_image` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `userid` bigint(20) DEFAULT '0' COMMENT '用户ID',  `aid` bigint(20) DEFAULT '0' COMMENT '文章ID(用于更新远程地址使用)',  `url` varchar(160) DEFAULT '' COMMENT '图片地址',  `filename` varchar(60) DEFAULT '' COMMENT '文件名称',  `type` varchar(10) DEFAULT '' COMMENT '类型 image：图片， file：文件',  `filesize` varchar(16) DEFAULT '' COMMENT '文件大小（单位KB,MB,GB）',  `width` smallint(4) DEFAULT '0' COMMENT '宽度(px)',  `height` smallint(4) DEFAULT '0' COMMENT '高度(px)',  `add_time` int(11) DEFAULT '0' COMMENT '上传时间',  `grabed` tinyint(1) DEFAULT '1' COMMENT '是否已经抓取(0：未抓取，1：抓取成功，2：抓取失败)',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片空间表';-- ------------------------------ Records of fiidee_image-- ------------------------------ ------------------------------ Table structure for fiidee_media-- ----------------------------DROP TABLE IF EXISTS `fiidee_media`;CREATE TABLE `fiidee_media` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `name` varchar(20) DEFAULT '' COMMENT '媒体名称',  `nickname` varchar(20) DEFAULT '' COMMENT '昵称',  `userid` bigint(20) DEFAULT '0' COMMENT '申请人用户ID',  `logo` varchar(160) DEFAULT '' COMMENT '媒体logo',  `media_type` smallint(6) DEFAULT '0' COMMENT '媒体类型',  `reg_name` varchar(20) DEFAULT '' COMMENT '登记人',  `reg_id` char(18) DEFAULT '' COMMENT '登记人身份证号码',  `id_img` varchar(160) DEFAULT '' COMMENT '身份证照片',  `company` varchar(20) DEFAULT '' COMMENT '组织机构全称',  `company_code` varchar(30) DEFAULT '' COMMENT '组织机构代码',  `company_img` varchar(160) DEFAULT '' COMMENT '组织机构代码扫描件',  `address` varchar(80) DEFAULT '' COMMENT '公司地址',  `telephone` varchar(20) DEFAULT '' COMMENT '固定电话',  `mobile` char(11) DEFAULT '' COMMENT '手机号码',  `email` varchar(30) DEFAULT '' COMMENT '电子邮箱',  `qq` int(11) DEFAULT '0' COMMENT 'qq号码',  `weibo` varchar(30) DEFAULT '' COMMENT '微博账号',  `weixin` varchar(30) DEFAULT '' COMMENT '微信账号',  `add_time` int(11) DEFAULT '0' COMMENT '申请时间',  `check_time` int(11) DEFAULT '0' COMMENT '审核时间',  `check_id` int(11) DEFAULT '0' COMMENT '审核人ID',  `domain` varchar(30) DEFAULT '' COMMENT '域名',  `province_id` smallint(6) DEFAULT '0' COMMENT '省份ID',  `city_id` smallint(6) DEFAULT '0' COMMENT '城市ID',  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='媒体用户';-- ------------------------------ Records of fiidee_media-- ----------------------------INSERT INTO `fiidee_media` VALUES ('1', '', '', '0', '', '0', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0', '0', '0', '', '0', '0');-- ------------------------------ Table structure for fiidee_media_chanel-- ----------------------------DROP TABLE IF EXISTS `fiidee_media_chanel`;CREATE TABLE `fiidee_media_chanel` (  `id` smallint(6) NOT NULL AUTO_INCREMENT,  `pid` smallint(6) DEFAULT '0' COMMENT '上级频道，如果是顶级频道则pid=0',  `name` varchar(20) DEFAULT '' COMMENT '频道名称',  `url` varchar(160) DEFAULT '' COMMENT '跳转地址',  `isystem` tinyint(1) DEFAULT '0' COMMENT '是否系统内置频道，内置频道不能删除',  `show_top` tinyint(1) DEFAULT '1' COMMENT '是否在头部显示',  `show_bottom` tinyint(1) DEFAULT '0' COMMENT '是否允许在底部显示',  `seo_title` varchar(100) DEFAULT '' COMMENT 'seo标题',  `seo_kword` varchar(100) DEFAULT '' COMMENT 'seo关键字',  `seo_desc` varchar(120) DEFAULT '' COMMENT 'seo描述',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户自定义频道表';-- ------------------------------ Records of fiidee_media_chanel-- ------------------------------ ------------------------------ Table structure for fiidee_media_data-- ----------------------------DROP TABLE IF EXISTS `fiidee_media_data`;CREATE TABLE `fiidee_media_data` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `itemid` bigint(20) DEFAULT '0' COMMENT '媒体ID',  `intro` text COMMENT '媒体简介',  `configs` text COMMENT '媒体网站配置信息（json数组格式）',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体用户数据表';-- ------------------------------ Records of fiidee_media_data-- ------------------------------ ------------------------------ Table structure for fiidee_media_friendlink-- ----------------------------DROP TABLE IF EXISTS `fiidee_media_friendlink`;CREATE TABLE `fiidee_media_friendlink` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `name` varchar(20) DEFAULT '' COMMENT '友情链接名称',  `url` varchar(160) DEFAULT '' COMMENT '友情链接url',  `ishow` tinyint(1) DEFAULT '1' COMMENT '是否显示（0：不显示，1：显示）',  `intro` varchar(255) DEFAULT '' COMMENT '简介',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体用户的友情链接表';-- ------------------------------ Records of fiidee_media_friendlink-- ------------------------------ ------------------------------ Table structure for fiidee_media_manager-- ----------------------------DROP TABLE IF EXISTS `fiidee_media_manager`;CREATE TABLE `fiidee_media_manager` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `userid` bigint(20) DEFAULT '0' COMMENT '用户ID',  `role_id` bigint(20) DEFAULT '0' COMMENT '媒体管理员角色ID',  `media_id` bigint(20) DEFAULT '0' COMMENT '媒体ID',  `add_time` int(11) DEFAULT '0' COMMENT '授权时间',  `status` tinyint(1) DEFAULT '1' COMMENT '当前状态(1：授权中，0：禁用)',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体管理员';-- ------------------------------ Records of fiidee_media_manager-- ------------------------------ ------------------------------ Table structure for fiidee_media_manager_role-- ----------------------------DROP TABLE IF EXISTS `fiidee_media_manager_role`;CREATE TABLE `fiidee_media_manager_role` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `userid` bigint(20) DEFAULT '0' COMMENT '用户ID',  `media_id` bigint(20) DEFAULT '0' COMMENT '媒体ID',  `name` varchar(20) DEFAULT '' COMMENT '角色名称',  `permission` text COMMENT '角色权限(json格式数组)',  `add_time` int(11) DEFAULT '0' COMMENT '创建时间',  `add_userid` bigint(20) DEFAULT '0' COMMENT '创建人',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体管理员角色';-- ------------------------------ Records of fiidee_media_manager_role-- ------------------------------ ------------------------------ Table structure for fiidee_media_rec-- ----------------------------DROP TABLE IF EXISTS `fiidee_media_rec`;CREATE TABLE `fiidee_media_rec` (  `id` smallint(6) NOT NULL AUTO_INCREMENT,  `name` varchar(20) DEFAULT '' COMMENT '推荐位名称',  `position` varchar(30) DEFAULT '' COMMENT '用来表示推荐位置',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体推荐位';-- ------------------------------ Records of fiidee_media_rec-- ------------------------------ ------------------------------ Table structure for fiidee_media_rec_assoc-- ----------------------------DROP TABLE IF EXISTS `fiidee_media_rec_assoc`;CREATE TABLE `fiidee_media_rec_assoc` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `media_id` bigint(20) DEFAULT '0' COMMENT '媒体ID',  `rec_id` smallint(6) DEFAULT '0' COMMENT '推荐位ID',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体推荐位关联表';-- ------------------------------ Records of fiidee_media_rec_assoc-- ------------------------------ ------------------------------ Table structure for fiidee_media_template-- ----------------------------DROP TABLE IF EXISTS `fiidee_media_template`;CREATE TABLE `fiidee_media_template` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `media_id` bigint(20) DEFAULT '0' COMMENT '媒体ID',  `template_id` int(11) DEFAULT '0' COMMENT '模板ID',  `version` varchar(10) DEFAULT '' COMMENT '模板版本',  `skin` varchar(20) DEFAULT '' COMMENT '模板皮肤',  `template_mark` varchar(32) DEFAULT '' COMMENT '模板标识',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体模板';-- ------------------------------ Records of fiidee_media_template-- ------------------------------ ------------------------------ Table structure for fiidee_message_template-- ----------------------------DROP TABLE IF EXISTS `fiidee_message_template`;CREATE TABLE `fiidee_message_template` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(20) DEFAULT '' COMMENT '模板名称',  `type` varchar(10) DEFAULT NULL COMMENT '模板类型(message：短信模板，email：邮件模板)',  `tkey` varchar(30) DEFAULT '' COMMENT '模板的key，必须唯一，调用的时候需要',  `content` text COMMENT '模板内容',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息模板(邮件，短信)';-- ------------------------------ Records of fiidee_message_template-- ------------------------------ ------------------------------ Table structure for fiidee_template-- ----------------------------DROP TABLE IF EXISTS `fiidee_template`;CREATE TABLE `fiidee_template` (  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `mark` varchar(32) NOT NULL COMMENT '模板标识,同一个标识的说明是同一个模板',  `name` varchar(50) NOT NULL COMMENT '模板名称',  `thumbnail` varchar(200) DEFAULT NULL COMMENT '模板封面',  `version` varchar(10) DEFAULT NULL COMMENT '版本号',  `change_notes` text COMMENT '版本更新说明',  `price` double(5,2) DEFAULT NULL COMMENT '价钱',  `sales` smallint(6) NOT NULL DEFAULT '0' COMMENT '销售量',  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0:未审核  -1:禁用 1:启用',  `description` text COMMENT '模板描述',  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',  `sort_num` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序顺序',  `is_rec` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐 0:不推荐 1:推荐',  PRIMARY KEY (`id`),  UNIQUE KEY `mark` (`mark`),  KEY `recommend` (`is_rec`),  KEY `status` (`status`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='媒体站群模板表';-- ------------------------------ Records of fiidee_template-- ------------------------------ ------------------------------ Table structure for fiidee_tipoff-- ----------------------------DROP TABLE IF EXISTS `fiidee_tipoff`;CREATE TABLE `fiidee_tipoff` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `userid` bigint(20) DEFAULT '0' COMMENT '爆料用户',  `contact` varchar(30) DEFAULT '' COMMENT '联系方式',  `content` varchar(500) DEFAULT '' COMMENT '爆料内容',  `add_time` int(11) DEFAULT '0' COMMENT '爆料时间',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户爆料';-- ------------------------------ Records of fiidee_tipoff-- ------------------------------ ------------------------------ Table structure for fiidee_user-- ----------------------------DROP TABLE IF EXISTS `fiidee_user`;CREATE TABLE `fiidee_user` (  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键',  `group` tinyint(2) DEFAULT '0' COMMENT '会员分组(0：普通会员，1：驼牛网认证会员)',  `username` varchar(20) DEFAULT '' COMMENT '用户名4-20',  `password` varchar(32) DEFAULT '' COMMENT '密码',  `nickname` varchar(20) DEFAULT '' COMMENT '昵称',  `email` varchar(30) DEFAULT '' COMMENT '电子邮箱',  `sex` tinyint(1) DEFAULT '0' COMMENT '性别(0=>男，1=>女)',  `head` varchar(120) DEFAULT '' COMMENT '头像',  `mobile` varchar(11) DEFAULT '' COMMENT '手机号码',  `qq` varchar(11) DEFAULT '' COMMENT 'qq',  `weibo` varchar(30) DEFAULT '' COMMENT '微博',  `weixin` varchar(30) DEFAULT '' COMMENT '微信',  `last_login_ip` varchar(15) DEFAULT '' COMMENT '最后一次登录IP',  `last_login_time` int(11) DEFAULT '0' COMMENT '最后登录时间',  `add_time` int(11) DEFAULT '0' COMMENT '创建时间',  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',  `ischeck` tinyint(1) DEFAULT '0' COMMENT '是否审核(0：未审核，1：已审核，2：被封号)',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='网站会员表';-- ------------------------------ Records of fiidee_user-- ------------------------------ ------------------------------ Table structure for fiidee_user_data-- ----------------------------DROP TABLE IF EXISTS `fiidee_user_data`;CREATE TABLE `fiidee_user_data` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `userid` bigint(20) DEFAULT '0' COMMENT '用户ID',  `intro` text COMMENT '用户简介',  `check_note` varchar(255) DEFAULT NULL COMMENT '审核备注',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户数据表';-- ------------------------------ Records of fiidee_user_data-- ------------------------------ ------------------------------ Table structure for fiidee_user_group-- ----------------------------DROP TABLE IF EXISTS `fiidee_user_group`;CREATE TABLE `fiidee_user_group` (  `id` smallint(6) NOT NULL AUTO_INCREMENT,  `name` varchar(20) DEFAULT '' COMMENT '会员分组名称',  `mark` tinyint(2) DEFAULT '0' COMMENT '会员分组标识(0：普通会员，1：驼牛网认证会员)',  `summary` varchar(255) DEFAULT '' COMMENT '会员分组简介',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员分组';-- ------------------------------ Records of fiidee_user_group-- ------------------------------ ------------------------------ Table structure for fiidee_user_message-- ----------------------------DROP TABLE IF EXISTS `fiidee_user_message`;CREATE TABLE `fiidee_user_message` (  `id` bigint(20) NOT NULL AUTO_INCREMENT,  `sender` bigint(20) DEFAULT '0' COMMENT '发信人用户id（如果是系统发送的则发件人ID为0）',  `receiver` bigint(20) DEFAULT '0' COMMENT '收信人ID',  `content` varchar(500) DEFAULT '' COMMENT '信息内容',  `send_time` int(11) DEFAULT '0' COMMENT '发送时间',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户短消息';-- ------------------------------ Records of fiidee_user_message-- ------------------------------ ------------------------------ Table structure for fiidee_user_role-- ----------------------------DROP TABLE IF EXISTS `fiidee_user_role`;CREATE TABLE `fiidee_user_role` (  `id` smallint(6) NOT NULL AUTO_INCREMENT,  `name` varchar(20) DEFAULT '' COMMENT '类型名称',  `summary` varchar(255) DEFAULT '' COMMENT '类型简介',  `permission_tpl` varchar(20) DEFAULT NULL COMMENT '权限模板key，不同的类型的媒体权限体系不一样',  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员类型';-- ------------------------------ Records of fiidee_user_role-- ----------------------------