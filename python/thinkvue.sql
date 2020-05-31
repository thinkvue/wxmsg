SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `tv_admin_access`;
CREATE TABLE IF NOT EXISTS `tv_admin_access` (
  `user_id` int(11) DEFAULT NULL COMMENT '账号表主键',
  `group_id` int(11) DEFAULT NULL COMMENT '权限组主键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='【账号表】和【权限组】中间表，多对多';

DROP TABLE IF EXISTS `tv_admin_comment`;
CREATE TABLE IF NOT EXISTS `tv_admin_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `customer_id` int(11) NOT NULL COMMENT '客户ID',
  `nickname` varchar(20) DEFAULT NULL COMMENT '昵称',
  `content` varchar(200) DEFAULT NULL COMMENT '评论内容',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `sign` int(4) NOT NULL DEFAULT '0' COMMENT '标志位',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='评论表，用于客户进度跟进情况';

DROP TABLE IF EXISTS `tv_admin_commission`;
CREATE TABLE IF NOT EXISTS `tv_admin_commission` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户ID',
  `user_id` int(11) DEFAULT NULL COMMENT '归属用户ID',
  `money` double DEFAULT NULL COMMENT '金额',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `status` int(11) DEFAULT NULL COMMENT '状态，0为待打款，1为已结算',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='佣金表';

DROP TABLE IF EXISTS `tv_admin_customer`;
CREATE TABLE IF NOT EXISTS `tv_admin_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `sex` varchar(2) DEFAULT NULL COMMENT '性别',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号',
  `company` varchar(100) DEFAULT NULL COMMENT '公司',
  `business` varchar(40) DEFAULT NULL COMMENT '主营业务',
  `city` varchar(50) DEFAULT NULL COMMENT '城市',
  `contact` int(4) DEFAULT NULL COMMENT '联系选项',
  `sign` int(11) DEFAULT NULL COMMENT '标志位',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='客户表';

DROP TABLE IF EXISTS `tv_admin_customer_show`;
CREATE TABLE IF NOT EXISTS `tv_admin_customer_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `customer_id` int(11) DEFAULT NULL COMMENT '客户ID',
  `user_id` int(11) NOT NULL COMMENT '归属用户ID',
  `name` varchar(50) DEFAULT NULL COMMENT '显示的客户名称，下线的客户显示为【下线客户23432】',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='客户显示表';

DROP TABLE IF EXISTS `tv_admin_group`;
CREATE TABLE IF NOT EXISTS `tv_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) DEFAULT NULL COMMENT '显示标题（账户组名称）',
  `rules` varchar(4000) DEFAULT NULL COMMENT '权限规则清单，1个数字代表1项thinkphp操作，用逗号分隔',
  `pid` int(11) DEFAULT NULL COMMENT '父ID',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  `status` tinyint(3) DEFAULT '1' COMMENT '是否启用，0不启用，1启用',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='权限组';

INSERT INTO `tv_admin_group` (`id`, `title`, `rules`, `pid`, `remark`, `status`, `delete_time`) VALUES
(15, '普通会员', '1,2,3,4,5,6,7,8,9,10,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,59,61,62,63,28,29', 0, '最厉害的组别', 1, NULL),
(16, '普通会员2', '1,2,3,4,5,6,7,8,9,10,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,59,61,62,63,28,29,20,21,64,66,67,68', 0, '最厉害的组别2', 1, NULL),
(17, '管理员', '10,11,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,59,61,62,63', 0, '所有权限', 1, NULL),
(18, '合作伙伴', '10,64,66,67,68', 0, '合作伙伴所属', 1, NULL);

DROP TABLE IF EXISTS `tv_admin_menu`;
CREATE TABLE IF NOT EXISTS `tv_admin_menu` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `pid` int(11) UNSIGNED DEFAULT '0' COMMENT '上级菜单ID',
  `title` varchar(32) DEFAULT '' COMMENT '菜单名称',
  `url` varchar(127) DEFAULT '' COMMENT '链接地址',
  `icon` varchar(64) DEFAULT '' COMMENT '图标',
  `menu_type` tinyint(4) DEFAULT NULL COMMENT '菜单类型',
  `sort` tinyint(4) UNSIGNED DEFAULT '0' COMMENT '排序（同级有效）',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `rule_id` int(11) DEFAULT NULL COMMENT '权限id',
  `module` varchar(50) DEFAULT NULL COMMENT '模块',
  `menu` varchar(50) DEFAULT NULL COMMENT '三级菜单吗',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='【配置】后台菜单表';

INSERT INTO `tv_admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`, `delete_time`) VALUES
(52, 0, '管理', '', '', 1, 0, 1, 59, 'Administrative', '', NULL),
(53, 52, '系统配置', '', '', 1, 0, 1, 61, 'Administrative', '', NULL),
(54, 53, '菜单管理', '/home/menu/list', '', 1, 0, 1, 21, 'Administrative', 'menu', NULL),
(55, 53, '系统参数', '/home/config/add', '', 1, 0, 1, 29, 'Administrative', 'systemConfig', NULL),
(56, 53, '权限规则', '/home/rule/list', '', 1, 0, 1, 13, 'Administrative', 'rule', NULL),
(57, 52, '组织架构', '', '', 1, 0, 1, 63, 'Administrative', '', NULL),
(58, 57, '岗位管理', '/home/position/list', '', 1, 0, 1, 31, 'Administrative', 'position', NULL),
(59, 57, '部门管理', '/home/structures/list', '', 1, 0, 1, 39, 'Administrative', 'structures', NULL),
(60, 57, '用户组管理', '/home/groups/list', '', 1, 0, 1, 47, 'Administrative', 'groups', NULL),
(61, 52, '账户管理', '', '', 1, 0, 1, 62, 'Administrative', '', NULL),
(62, 61, '账户列表', '/home/users/list', '', 1, 0, 1, 55, 'Administrative', 'users', NULL);

DROP TABLE IF EXISTS `tv_admin_openid`;
CREATE TABLE IF NOT EXISTS `tv_admin_openid` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) DEFAULT NULL COMMENT '用户表主键',
  `openid` varchar(80) DEFAULT NULL COMMENT 'OPENID',
  `typeof` int(5) DEFAULT NULL COMMENT '类型，0其他浏览器,1微信小程序,2微信,3QQ小程序,4支付宝小程序,5百度小程序,6头条小程序',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `remark` varchar(80) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='第三方登录绑定openid，兼容绑定多个微信';

DROP TABLE IF EXISTS `tv_admin_post`;
CREATE TABLE IF NOT EXISTS `tv_admin_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(200) DEFAULT NULL COMMENT '岗位名称',
  `remark` varchar(200) DEFAULT NULL COMMENT '岗位备注',
  `create_time` int(11) DEFAULT NULL COMMENT '数据创建时间',
  `status` tinyint(5) DEFAULT '1' COMMENT '状态1启用,0禁用',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='岗位表';

INSERT INTO `tv_admin_post` (`id`, `name`, `remark`, `create_time`, `status`, `delete_time`) VALUES
(5, '后端开发工程师', '', 1484706862, 1, NULL),
(6, '前端开发工程师', '', 1484706863, 1, NULL),
(7, '设计师', '', 1484706863, 1, NULL),
(11, '文案策划', '', 1484706863, 1, NULL),
(12, '产品助理', '', 1484706863, 1, NULL),
(15, '总经理', '', 1484706863, 1, NULL),
(20, '项目经理', '', 1484706863, 1, NULL),
(25, '职能', '', 1484706863, 1, NULL),
(26, '项目助理', '', 1484706863, 1, NULL),
(27, '测试工程师', '', 1484706863, 1, NULL),
(28, '人事经理', '', 1484706863, 1, NULL),
(29, 'CEO', '', 1484706863, 1, NULL),
(30, '品牌策划', '', 1484706863, 1, NULL),
(31, '前端研发工程师', '', 1484706863, 1, NULL),
(32, '后端研发工程师', '', 1484706863, 1, NULL),
(33, '合作伙伴', '', 1586482009, 1, NULL);

DROP TABLE IF EXISTS `tv_admin_rule`;
CREATE TABLE IF NOT EXISTS `tv_admin_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) DEFAULT '' COMMENT '名称',
  `name` varchar(100) DEFAULT '' COMMENT '定义',
  `level` tinyint(5) DEFAULT NULL COMMENT '级别。1模块,2控制器,3操作',
  `pid` int(11) DEFAULT '0' COMMENT '父id，默认0',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态，1启用，0禁用',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COMMENT='模块/控制器/操作清单表';

INSERT INTO `tv_admin_rule` (`id`, `title`, `name`, `level`, `pid`, `status`, `delete_time`) VALUES
(10, '系统基础功能', 'admin', 1, 0, 1, NULL),
(11, '权限规则', 'rules', 2, 10, 1, NULL),
(13, '规则列表', 'index', 3, 11, 1, NULL),
(14, '权限详情', 'read', 3, 11, 1, NULL),
(15, '编辑权限', 'update', 3, 11, 1, NULL),
(16, '删除权限', 'delete', 3, 11, 1, NULL),
(17, '添加权限', 'save', 3, 11, 1, NULL),
(18, '批量删除权限', 'deletes', 3, 11, 1, NULL),
(19, '批量启用/禁用权限', 'enables', 3, 11, 1, NULL),
(20, '菜单管理', 'menus', 2, 10, 1, NULL),
(21, '菜单列表', 'index', 3, 20, 1, NULL),
(22, '添加菜单', 'save', 3, 20, 1, NULL),
(23, '菜单详情', 'read', 3, 20, 1, NULL),
(24, '编辑菜单', 'update', 3, 20, 1, NULL),
(25, '删除菜单', 'delete', 3, 20, 1, NULL),
(26, '批量删除菜单', 'deletes', 3, 20, 1, NULL),
(27, '批量启用/禁用菜单', 'enables', 3, 20, 1, NULL),
(28, '系统管理', 'systemConfigs', 2, 10, 1, NULL),
(29, '修改系统配置', 'save', 3, 28, 1, NULL),
(30, '岗位管理', 'posts', 2, 10, 1, NULL),
(31, '岗位列表', 'index', 3, 30, 1, NULL),
(32, '岗位详情', 'read', 3, 30, 1, NULL),
(33, '编辑岗位', 'update', 3, 30, 1, NULL),
(34, '删除岗位', 'delete', 3, 30, 1, NULL),
(35, '添加岗位', 'save', 3, 30, 1, NULL),
(36, '批量删除岗位', 'deletes', 3, 30, 1, NULL),
(37, '批量启用/禁用岗位', 'enables', 3, 30, 1, NULL),
(38, '部门管理', 'structures', 2, 10, 1, NULL),
(39, '部门列表', 'index', 3, 38, 1, NULL),
(40, '部门详情', 'read', 3, 38, 1, NULL),
(41, '编辑部门', 'update', 3, 38, 1, NULL),
(42, '删除部门', 'delete', 3, 38, 1, NULL),
(43, '添加部门', 'save', 3, 38, 1, NULL),
(44, '批量删除部门', 'deletes', 3, 38, 1, NULL),
(45, '批量启用/禁用部门', 'enables', 3, 38, 1, NULL),
(46, '用户组管理', 'groups', 2, 10, 1, NULL),
(47, '用户组列表', 'index', 3, 46, 1, NULL),
(48, '用户组详情', 'read', 3, 46, 1, NULL),
(49, '编辑用户组', 'update', 3, 46, 1, NULL),
(50, '删除用户组', 'delete', 3, 46, 1, NULL),
(51, '添加用户组', 'save', 3, 46, 1, NULL),
(52, '批量删除用户组', 'deletes', 3, 46, 1, NULL),
(53, '批量启用/禁用用户组', 'enables', 3, 46, 1, NULL),
(54, '成员管理', 'users', 2, 10, 1, NULL),
(55, '成员列表', 'index', 3, 54, 1, NULL),
(56, '成员详情', 'read', 3, 54, 1, NULL),
(57, '删除成员', 'delete', 3, 54, 1, NULL),
(59, '管理菜单', 'Adminstrative', 2, 10, 1, NULL),
(61, '系统管理二级菜单', 'systemConfig', 1, 59, 1, NULL),
(62, '账户管理二级菜单', 'personnel', 3, 59, 1, NULL),
(63, '组织架构二级菜单', 'structures', 3, 59, 1, NULL),
(64, '客户管理', 'customer', 2, 10, 1, NULL),
(66, '新建', 'save', 3, 64, 1, NULL),
(67, '查看客户', 'list', 3, 64, 1, NULL),
(68, '下线管理', 'member', 2, 10, 1, NULL);

DROP TABLE IF EXISTS `tv_admin_structure`;
CREATE TABLE IF NOT EXISTS `tv_admin_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(200) DEFAULT '' COMMENT '部门名称',
  `pid` int(11) DEFAULT '0' COMMENT '父部门ID',
  `status` tinyint(3) DEFAULT '1' COMMENT '是否启用',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='部门表';

INSERT INTO `tv_admin_structure` (`id`, `name`, `pid`, `status`, `delete_time`) VALUES
(1, 'ThinkVue', 0, 1, NULL),
(5, '设计部', 1, 1, NULL),
(6, '职能部', 1, 1, NULL),
(37, '总经办', 1, 1, NULL),
(52, '项目部', 1, 1, NULL),
(53, '测试部', 1, 1, NULL),
(54, '开发部', 1, 1, NULL),
(55, '市场部', 1, 1, NULL),
(56, '研发部', 1, 1, NULL),
(57, '企业微信', 0, 1, NULL),
(58, '测试部', 0, 1, NULL);

DROP TABLE IF EXISTS `tv_admin_user`;
CREATE TABLE IF NOT EXISTS `tv_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(50) DEFAULT NULL COMMENT '管理后台账号',
  `password` varchar(50) DEFAULT NULL COMMENT '管理后台密码',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号',
  `alipay` varchar(100) DEFAULT NULL COMMENT '支付宝账号',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱地址',
  `remark` varchar(100) DEFAULT NULL COMMENT '用户备注',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间时间戳',
  `realname` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `sex` varchar(2) DEFAULT NULL COMMENT '性别',
  `company` varchar(100) DEFAULT NULL COMMENT '公司',
  `business` varchar(20) DEFAULT NULL COMMENT '主营',
  `city` varchar(50) DEFAULT NULL COMMENT '城市',
  `structure_id` int(11) DEFAULT NULL COMMENT '部门',
  `post_id` int(11) DEFAULT NULL COMMENT '岗位',
  `pid` int(11) DEFAULT '1' COMMENT '父ID',
  `gid` int(11) DEFAULT NULL COMMENT '祖父ID',
  `status` tinyint(3) DEFAULT NULL COMMENT '状态,1启用0禁用',
  `delete_time` int(14) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO `tv_admin_user` (`id`, `username`, `password`, `mobile`, `alipay`, `email`, `remark`, `create_time`, `realname`, `sex`, `company`, `business`, `city`, `structure_id`, `post_id`, `pid`, `gid`, `status`, `delete_time`) VALUES
(14, 'admin', '9a9746d53945a4962910b17a572e68fd', NULL, NULL, NULL, '', NULL, '超级管理员', NULL, NULL, NULL, NULL, 1, 5, NULL, NULL, 1, NULL);

DROP TABLE IF EXISTS `tv_api_user`;
CREATE TABLE IF NOT EXISTS `tv_api_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `password` varchar(32) DEFAULT NULL COMMENT '密码',
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后登录时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `level` tinyint(4) DEFAULT '1' COMMENT '会员等级',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `repetitive_mobile` (`mobile`) USING BTREE,
  KEY `mobile` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户表';

DROP TABLE IF EXISTS `tv_api_user_openid`;
CREATE TABLE IF NOT EXISTS `tv_api_user_openid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `wechat_id` int(11) NOT NULL COMMENT '公众号ID',
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户访问令牌';

DROP TABLE IF EXISTS `tv_api_user_token`;
CREATE TABLE IF NOT EXISTS `tv_api_user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `openid_id` int(11) NOT NULL COMMENT 'openid ID',
  `token` varchar(32) NOT NULL COMMENT '用户访问令牌',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='用户访问令牌';

DROP TABLE IF EXISTS `tv_api_wechat_account`;
CREATE TABLE IF NOT EXISTS `tv_api_wechat_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `username` varchar(50) NOT NULL COMMENT '微信账号原始ID',
  `appid` varchar(50) NOT NULL COMMENT 'appid',
  `appsecret` varchar(50) NOT NULL COMMENT 'appsecret',
  `access_token` varchar(512) DEFAULT NULL COMMENT '该账号访问令牌',
  `token_time` int(11) DEFAULT '0' COMMENT '令牌有效时间时间戳',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `remark` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='公众号信息（支持多公众号）';

INSERT INTO `tv_api_wechat_account` (`id`, `username`, `appid`, `appsecret`, `access_token`, `token_time`, `status`, `delete_time`, `create_time`, `remark`) VALUES
(1, 'ThinkVue', '<appID1>', '<appsecret1>', NULL, 0, 1, NULL, '2019-07-29 13:18:51', 'ThinkVue'),
(2, 'bymidofa', '<appID2>', '<appsecret2>', NULL, 0, 1, NULL, '2019-07-30 12:18:53', '米多花科技'),
(3, 'midofa_test', '<appID3>', '<appsecret3>', NULL, 0, 1, NULL, '2019-08-11 09:52:12', '测试号');

DROP TABLE IF EXISTS `tv_api_wechat_msg`;
CREATE TABLE IF NOT EXISTS `tv_api_wechat_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `openid` varchar(100) NOT NULL COMMENT '接收微信open_ID',
  `is_send` int(11) DEFAULT '0' COMMENT '发送状态，0为未发送，1为已发送',
  `title` varchar(300) DEFAULT '新消息' COMMENT '标题',
  `color` varchar(10) DEFAULT '#FF00FF' COMMENT '标题颜色，默认洋红',
  `keyword1` varchar(300) DEFAULT '服务提醒' COMMENT '微信消息keyword1',
  `keyword2` varchar(300) DEFAULT 'By ThinkVue' COMMENT '微信消息keywor2',
  `keyword3` varchar(300) DEFAULT '待处理' COMMENT '微信消息keyword3',
  `url` varchar(300) DEFAULT '' COMMENT '跳转链接',
  `remark` varchar(800) DEFAULT '如果添加了URL参数，点击消息可跳转至URL' COMMENT '微信消息remark',
  `wechat_id` int(11) DEFAULT NULL COMMENT '微信公众号账号id主键',
  `template_id` int(11) NOT NULL COMMENT '消息模板ID',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `send_time` timestamp NULL DEFAULT NULL COMMENT '发送时间',
  `settime` int(14) DEFAULT '0' COMMENT '预定义发送时间戳',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='发送微信服务号模板消息';

DROP TABLE IF EXISTS `tv_api_wechat_template`;
CREATE TABLE IF NOT EXISTS `tv_api_wechat_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `wechat_id` int(11) NOT NULL COMMENT '所属微信公众号账号',
  `template_id` varchar(80) DEFAULT NULL COMMENT '模板ID',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `remark` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='微信公众号模板信息模板ID（支持多公众号）';

INSERT INTO `tv_api_wechat_template` (`id`, `wechat_id`, `template_id`, `status`, `delete_time`, `create_time`, `remark`) VALUES
(1, 1, '<wechat_template_id1>', 1, NULL, '2020-05-04 00:32:49', ''),
(2, 2, '<wechat_template_id2>', 1, NULL, '2020-05-03 02:18:58', ''),
(3, 3, '<wechat_template_id3>', 1, NULL, '2020-05-03 02:18:58', '');

DROP TABLE IF EXISTS `tv_system_config`;
CREATE TABLE IF NOT EXISTS `tv_system_config` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(50) DEFAULT '' COMMENT '配置名称',
  `value` varchar(100) DEFAULT '' COMMENT '配置值',
  `group` tinyint(4) UNSIGNED DEFAULT '0' COMMENT '配置分组，0为系统配置，1为第三方登录相关配置，2为短信邮件相关配置',
  `need_auth` tinyint(4) DEFAULT '1' COMMENT '1需要登录后才能获取，0不需要登录即可获取',
  `remark` varchar(50) DEFAULT NULL COMMENT '备注名',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `参数名` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='【配置】系统配置表';

INSERT INTO `tv_system_config` (`id`, `name`, `value`, `group`, `need_auth`, `remark`, `delete_time`) VALUES
(1, 'SYSTEM_NAME', 'ThinkVue', 0, 0, '系统名称', NULL),
(2, 'SYSTEM_LOGO', '', 0, 0, '系统LOGO', NULL),
(3, 'LOGIN_SESSION_VALID', '7777', 0, 0, '登录过期时间（单位：秒)', NULL),
(4, 'IDENTIFYING_CODE', '1', 0, 0, '验证方式，0为不验证，1为图片验证，2为短信验证', NULL),
(5, 'LOGO_TYPE', '2', 0, 0, '显示LOGO类型，1为图片，2为文字', NULL),
(6, 'APPID_WEIXIN', '<appID1>', 1, 1, '微信公众号appid', NULL),
(7, 'SECRET_WEIXIN', '<appsecret1>', 1, 1, '微信公众号secret', NULL),
(8, 'APPID_QQ', 'APPID_QQ', 1, 1, 'QQ appid', NULL),
(9, 'SECRET_QQ', 'SECRET_QQ', 1, 1, 'QQ secret', NULL),
(10, 'APPID_ALIPAY', 'APPID_ALIPAY', 1, 1, '支付宝appid', NULL),
(11, 'SECRET_ALIPAY', 'SECRET_ALIPAY', 1, 1, '支付宝secret', NULL),
(12, 'APPID_WXXCX', 'APPID_WXXCX', 1, 1, '微信小程序appid', NULL),
(13, 'SECRET_WXXCX', 'SECRET_WXXCX', 1, 1, '微信小程序secret', NULL),
(14, 'APPID_BAIDU', 'APPID_BAIDU', 1, 1, '百度小程序appid', NULL),
(15, 'SECRET_BAIDU', 'SECRET_BAIDU', 1, 1, '百度secret', NULL),
(16, 'APPID_BYTE', 'APPID_BYTE', 1, 1, '字节跳动appid', NULL),
(17, 'SECRET_BYTE', 'SECRET_BYTE', 1, 1, '字节跳动secret', NULL),
(18, 'SMSBAO_USERNAME', '<smsbao_username>', 0, 1, '短信宝用户名', NULL),
(19, 'SMSBAO_PASSWORD', '<smsbao_password>', 0, 1, '短信宝密码', NULL),
(20, 'SMSBAO_VERIFY_SMS_CONTENT', '<smsbao_verify_sms_content>', 0, 1, '短信宝验证码短信内容', NULL),
(21, 'Ali_AccessKeyId', '<ali_accesskeyid>', 0, 1, '阿里云AccessKeyId', NULL),
(22, 'Ali_AccessSecret', '<ali_accesssecret>', 0, 1, '阿里云AccessSecret', NULL),
(23, 'Ali_SignName', '<ali_signname>', 0, 1, '阿里云短信签名', NULL),
(24, 'Ali_Verify_TemplateCode', '<ali_verify_templatecode>', 0, 1, '阿里云验证码短信模板号', NULL),
(25, 'SMS_Interface_Type', '<sms_interface_type>', 0, 1, '短信接口，1为阿里云，2为短信宝', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
