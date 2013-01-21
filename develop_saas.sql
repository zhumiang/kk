-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 09 月 03 日 12:31
-- 服务器版本: 5.1.51
-- PHP 版本: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `develop_saas`
--

-- --------------------------------------------------------

--
-- 表的结构 `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cycle` varchar(250) NOT NULL,
  `completetime` varchar(250) NOT NULL,
  `departmentid` int(11) NOT NULL,
  `usersid` int(11) NOT NULL,
  `completetime2` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

--
-- 转存表中的数据 `attendance`
--

INSERT INTO `attendance` (`id`, `cycle`, `completetime`, `departmentid`, `usersid`, `completetime2`) VALUES
(78, '1343779200', '○', 9, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `collaborative`
--

DROP TABLE IF EXISTS `collaborative`;
CREATE TABLE IF NOT EXISTS `collaborative` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `ttime` int(11) NOT NULL,
  `departmentid` int(11) NOT NULL,
  `departmentid2` int(11) NOT NULL,
  `textenter` longtext NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `collaborative`
--

INSERT INTO `collaborative` (`id`, `userid`, `content`, `ttime`, `departmentid`, `departmentid2`, `textenter`, `status`) VALUES
(4, 1, '是 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;', 1345431396, 9, 9, '谁 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;', 0);

-- --------------------------------------------------------

--
-- 表的结构 `coll_receipt`
--

DROP TABLE IF EXISTS `coll_receipt`;
CREATE TABLE IF NOT EXISTS `coll_receipt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `ttime` int(11) NOT NULL,
  `departmentid` int(11) NOT NULL,
  `textenter` longtext NOT NULL,
  `collaborativeid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `coll_receipt`
--

INSERT INTO `coll_receipt` (`id`, `userid`, `ttime`, `departmentid`, `textenter`, `collaborativeid`) VALUES
(1, 1, 1345097512, 9, '阿萨 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;', 1);

-- --------------------------------------------------------

--
-- 表的结构 `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `upcolumnid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `department`
--

INSERT INTO `department` (`id`, `name`, `upcolumnid`) VALUES
(1, '总部', 1),
(2, '行政部', 1),
(3, '采购部', 1),
(4, '客服部', 1),
(5, '编辑部', 1),
(9, '技术部', 1),
(7, '企划部', 1),
(8, 'seo', 7);

-- --------------------------------------------------------

--
-- 表的结构 `department_power`
--

DROP TABLE IF EXISTS `department_power`;
CREATE TABLE IF NOT EXISTS `department_power` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departmentid` int(11) NOT NULL,
  `positionid` int(11) NOT NULL,
  `columnids` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `department_power`
--

INSERT INTO `department_power` (`id`, `departmentid`, `positionid`, `columnids`) VALUES
(2, 9, 2, '99,100,97,96,98,95,101,103,104,105,107,109,110,111,112,113,114');

-- --------------------------------------------------------

--
-- 表的结构 `group_power`
--

DROP TABLE IF EXISTS `group_power`;
CREATE TABLE IF NOT EXISTS `group_power` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `columnid` int(11) NOT NULL,
  `usergroupid` int(11) NOT NULL,
  `operateids` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `group_power`
--

INSERT INTO `group_power` (`id`, `columnid`, `usergroupid`, `operateids`) VALUES
(1, 99, 2, '1,2,3,4,5,6'),
(2, 100, 2, '1,2,3,4,5,6'),
(3, 97, 2, '1,2,3,4,5,6'),
(4, 96, 2, '1,2,3,4,5,6'),
(5, 98, 2, '1,2,3,4,5,6'),
(6, 95, 2, '1,2,3,4,5,6'),
(7, 101, 2, '1,2,3,4,5,6'),
(9, 103, 2, '1,2,3,4,5,6'),
(10, 104, 2, '1,2,3,4,5,6'),
(11, 105, 2, '1,2,3,4,5,6'),
(12, 107, 2, '1,2'),
(15, 109, 2, '1,2,3,4,5,6'),
(16, 110, 2, '1,2,3,4,5,6'),
(17, 114, 2, '1,2,3,4,5,6'),
(18, 111, 2, '1,2,3,4,5,6'),
(19, 112, 2, '1,2,3,4,5,6'),
(20, 113, 2, '1,2,3,4,5,6');

-- --------------------------------------------------------

--
-- 表的结构 `kele_action`
--

DROP TABLE IF EXISTS `kele_action`;
CREATE TABLE IF NOT EXISTS `kele_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '名字',
  `value` varchar(50) NOT NULL COMMENT '值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `kele_action`
--

INSERT INTO `kele_action` (`id`, `name`, `value`) VALUES
(1, '查看', 'show'),
(2, '添加', 'append'),
(3, '修改', 'amend'),
(4, '删除', 'delete'),
(5, '管理操作', 'system'),
(6, '搜索', 'search');

-- --------------------------------------------------------

--
-- 表的结构 `kele_column`
--

DROP TABLE IF EXISTS `kele_column`;
CREATE TABLE IF NOT EXISTS `kele_column` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `upcolumnid` int(11) NOT NULL,
  `linkurl` varchar(250) NOT NULL,
  `tpl` varchar(255) NOT NULL,
  `classify` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=115 ;

--
-- 转存表中的数据 `kele_column`
--

INSERT INTO `kele_column` (`id`, `name`, `value`, `upcolumnid`, `linkurl`, `tpl`, `classify`) VALUES
(1, '建表系统', 'module', 7, 'kele.php?model=show&amp;contro=function&amp;view=table', 'table', 'develop'),
(2, '表单系统', 'memus', 7, 'kele.php?model=show&amp;contro=function&amp;view=memus', 'memu', 'develop'),
(4, '功能列表', 'column', 7, 'kele.php?model=show&amp;contro=function&amp;view=column', '', 'develop'),
(5, '数据表管理', 'table', 1, 'kele.php?model=show&amp;contro=function&amp;view=table', 'table', 'develop'),
(6, '字段管理', 'field', 1, 'kele.php?model=show&amp;contro=function&amp;view=field', 'field', 'develop'),
(7, '功能系统', 'function', 0, 'kele.php?model=show&amp;contro=function&amp;view=column ', '', 'develop'),
(8, '表功能关联', 'tablecolumn', 7, 'kele.php?model=show&amp;contro=function&amp;view=tablecolumn', 'tablecolumn', 'develop'),
(10, '主副表关联', 'relation', 7, 'kele.php?model=show&amp;contro=function&amp;view=relation', '', 'develop'),
(99, '行政管理', 'xingzheng', 0, '?model=show&amp;contro=function&amp;view=users', '', 'sys'),
(100, '人事管理', 'users', 99, '?model=show&amp;contro=function&amp;view=users', '', 'sys'),
(14, '系统参数', 'system', 7, 'kele.php?model=show&amp;contro=function&amp;view=system', '', 'develop'),
(15, '操作设置', 'action', 7, 'kele.php?model=show&amp;contro=function&amp;view=action', '', 'develop'),
(16, '用户管理', 'user', 7, 'kele.php?model=show&amp;contro=function&amp;view=user', 'user', 'develop'),
(17, '首页', 'index', -1, '?model=show&amp;contro=function&amp;view=', 'index', 'public'),
(18, '后台头部', 'header', -1, '?model=show&amp;contro=function&amp;view=', 'header', 'public'),
(19, '后台左部', 'left', -1, '?model=show&amp;contro=function&amp;view=', 'left', 'public'),
(20, '后台主页', 'main', -1, '?model=show&amp;contro=function&amp;view=', 'main', 'public'),
(21, '登陆', 'login', -1, '?model=show&amp;contro=function&amp;view=', 'login', 'public'),
(97, '部门权限', 'dpmtpw', 99, '?model=show&amp;contro=function&amp;view=dpmtpw', '', 'sys'),
(96, '职称管理', 'position', 99, '?model=show&amp;contro=function&amp;view=position', '', 'sys'),
(98, '用户组', 'usergroup', 99, '?model=show&amp;contro=function&amp;view=usergroup', '', 'sys'),
(95, '部门管理', 'department', 99, '?model=show&amp;contro=function&amp;view=department', '', 'sys'),
(101, '用户组权限', 'grouppower', 99, '?model=show&amp;contro=function&amp;view=grouppower', '', 'sys'),
(102, '搜索表单', 'searchmemu', 7, '?model=show&amp;contro=function&amp;view=searchmemu', 'searchmemu', 'develop'),
(103, '部门协同管理', 'collaborative', 104, '?model=show&amp;contro=function&amp;view=collaborative', 'collaborative', 'sys'),
(104, '协同管理', 'xietong', 0, '?model=show&amp;contro=function&amp;view=collaborative', '', 'sys'),
(105, '协同回执', 'receipt', 103, '?model=show&amp;contro=function&amp;view=receipt', 'receipt', 'sys'),
(106, 'oa系统栏目管理条件', 'powerselect', 7, '?model=show&amp;contro=function&amp;view=powerselect', '', 'develop'),
(107, '考勤', 'attendance', 99, '?model=show&amp;contro=do&amp;view=attendance', 'attendance', 'sys'),
(108, '特殊权限管理', 'specialpower', 99, '?model=show&amp;contro=function&amp;view=specialpower', '', 'sys'),
(109, '工作计划', 'workplan', 0, '?model=show&amp;contro=function&amp;view=weeklyplan', '', 'sys'),
(110, '项目管理', 'projectmanage', 109, '?model=show&amp;contro=function&amp;view=projectmanage', '', 'sys'),
(111, '项目计划', 'projectplan', 109, '?model=show&amp;contro=function&amp;view=projectplan', 'projectplan', 'sys'),
(112, '部门计划', 'sectoralplan', 109, '?model=show&amp;contro=function&amp;view=sectoralplan', 'sectoralplan', 'sys'),
(113, '一周计划', 'weeklyplan', 109, '?model=show&amp;contro=function&amp;view=weeklyplan', 'weeklyplan', 'sys'),
(114, '工作报告', 'workreport', 109, '?model=show&amp;contro=function&amp;view=workreport', 'workreport', 'sys');

-- --------------------------------------------------------

--
-- 表的结构 `kele_field`
--

DROP TABLE IF EXISTS `kele_field`;
CREATE TABLE IF NOT EXISTS `kele_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `size` varchar(12) NOT NULL,
  `operate` varchar(50) NOT NULL,
  `defaultvalue` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=140 ;

--
-- 转存表中的数据 `kele_field`
--

INSERT INTO `kele_field` (`id`, `name`, `value`, `type`, `size`, `operate`, `defaultvalue`) VALUES
(1, '编号', 'id', 'int', '11', 'noadd', 'empty'),
(2, '名称', 'name', 'varchar', '50', 'append', 'empty'),
(3, '值', 'value', 'varchar', '50', 'append', 'empty'),
(4, '类型', 'type', 'varchar', '50', 'append', 'empty'),
(6, '查看类型', 'attribute', 'varchar', '50', 'append', 'empty'),
(7, '存储类型', 'operate', 'varchar', '50', 'append', 'empty'),
(8, '默认存储值', 'defaultvalue', 'varchar', '250', 'append', 'empty'),
(9, '搜索类型', 'search', 'varchar', '250', 'append', 'empty'),
(10, '查询关联', 'wheres', 'varchar', '250', 'append', 'empty'),
(11, '引用表名登记编号', 'tableid', 'int', '11', 'append', 'empty'),
(12, '字段编号', 'fields', 'varchar', '250', 'append', 'empty'),
(13, '栏目编号', 'columnid', 'int', '11', 'append', 'empty'),
(14, '字段值', 'field', 'varchar', '50', 'append', 'empty'),
(15, '表单编号', 'memuid', 'int', '11', 'system', 'insertid'),
(17, '默认值', 'defaults', 'varchar', '250', 'append', 'empty'),
(19, '归类', 'classify', 'varchar', '50', 'append', 'empty'),
(114, '数据验证', 'checkdata', 'varchar', '50', 'append', 'empty'),
(44, '主表编号', 'lord', 'int', '11', 'append', 'empty'),
(43, '大小', 'size', 'int', '11', 'append', 'empty'),
(66, '副表标记', 'schedule', 'int', '11', 'append', 'empty'),
(67, '用户名', 'username', 'varchar', '250', 'system', 'different'),
(68, '密码', 'password', 'varchar', '250', 'system', 'md5'),
(69, '邮箱', 'email', 'varchar', '200', 'append', 'empty'),
(90, '链接地址', 'linkurl', 'varchar', '250', 'append', 'empty'),
(71, '是否通过', 'ispass', 'varchar', '10', 'system', 'ispass'),
(73, '用户编号', 'userid', 'int', '11', 'system', 'user'),
(77, '上线IP', 'onlineip', 'varchar', '18', 'append', 'empty'),
(78, '上线时间', 'onlinetime', 'int', '11', 'append', 'empty'),
(89, '归属上级', 'upcolumnid', 'int', '11', 'append', 'empty'),
(93, '是否主表', 'master', 'varchar', '50', 'append', 'empty'),
(94, '排序', 'taxis', 'int', '11', 'append', 'empty'),
(95, '显示页面', 'tpl', 'varchar', '255', 'append', 'empty'),
(101, '图片', 'imagepath', 'varchar', '250', 'system', 'image'),
(104, '文本内容', 'content', 'longtext', '', 'append', 'empty'),
(105, '系统参数', 'systemvalue', 'varchar', '250', 'append', 'empty'),
(123, '用户组id', 'usergroupid', 'int', '11', 'append', 'notnull'),
(118, '时间', 'ttime', 'int', '11', 'system', 'addtime'),
(124, '操作ids', 'operateids', 'varchar', '200', 'system', 'array'),
(120, '部门id', 'departmentid', 'int', '11', 'append', 'notnull'),
(121, '职位id', 'positionid', 'int', '11', 'append', 'notnull'),
(122, '栏目ids', 'columnids', 'longtext', '', 'system', 'array'),
(125, '部门id2', 'departmentid2', 'int', '11', 'append', 'notnull'),
(126, '文本输入', 'textenter', 'longtext', '', 'append', 'empty'),
(127, '状态', 'status', 'int', '2', 'append', 'empty'),
(128, '协同id', 'collaborativeid', 'int', '11', 'append', 'notnull'),
(129, '姓名', 'fullname', 'varchar', '100', 'append', 'empty'),
(130, '项目id', 'projectid', 'int', '11', 'append', 'notnull'),
(131, '周期', 'cycle', 'varchar', '250', 'append', 'empty'),
(132, '项目计划id', 'projectplanid', 'int', '11', 'append', 'empty'),
(133, '部门计划id', 'sectoralplanid', 'int', '11', 'append', 'empty'),
(134, '计划时间', 'plantime', 'varchar', '250', 'append', 'empty'),
(135, '完成时间', 'completetime', 'varchar', '250', 'append', 'empty'),
(136, '用户id', 'usersid', 'int', '11', 'append', 'empty'),
(137, '完成时间2', 'completetime2', 'varchar', '250', 'append', 'empty'),
(138, '周计划id', 'weeklyplanid', 'int', '11', 'append', 'empty'),
(139, '完成情况', 'completion', 'varchar', '100', 'append', 'empty');

-- --------------------------------------------------------

--
-- 表的结构 `kele_files`
--

DROP TABLE IF EXISTS `kele_files`;
CREATE TABLE IF NOT EXISTS `kele_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(250) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `kele_files`
--

INSERT INTO `kele_files` (`id`, `path`, `userid`) VALUES
(1, 'CGI/upload/201102091297232307imagepath.jpg', 29),
(2, 'CGI/upload/201102091297233192imagepath.jpg', 29),
(3, 'CGI/upload/201102091297233547imagepath.jpg', 29),
(4, 'CGI/upload/201102141297652608imagepath.jpg', 29),
(5, 'CGI/upload/201102141297653231imagepath.jpg', 29),
(6, 'CGI/upload/201102141297653480imagepath.jpg', 29),
(7, 'CGI/upload/201102141297653495imagepath.jpg', 29),
(8, 'CGI/upload/201102141297667068imagepath.jpg', 29),
(9, 'CGI/upload/201102141297667124imagepath.jpg', 29),
(10, 'CGI/upload/201102141297667141imagepath.jpg', 29),
(11, 'CGI/upload/201102141297667184imagepath.jpg', 29),
(12, 'CGI/upload/201102141297667210imagepath.jpg', 29),
(13, 'CGI/upload/201102141297667274imagepath.jpg', 29),
(14, 'CGI/upload/201102141297672549imagepath.jpg', 29),
(15, 'CGI/upload/201102141297672593imagepath.jpg', 29),
(16, 'CGI/upload/201102151297731922imagepath.jpg', 29),
(17, 'CGI/upload/201102151297731944imagepath.jpg', 29),
(18, 'CGI/upload/201102151297731955imagepath.jpg', 29),
(19, 'CGI/upload/201102151297731966imagepath.jpg', 29),
(20, 'CGI/upload/201102151297731978imagepath.jpg', 29),
(21, 'CGI/upload/201102151297731995imagepath.jpg', 29),
(22, 'CGI/upload/201102151297732006imagepath.jpg', 29),
(23, 'CGI/upload/201102151297732017imagepath.jpg', 29),
(24, 'CGI/upload/201206011338540816imagepath.jpg', 29);

-- --------------------------------------------------------

--
-- 表的结构 `kele_memu`
--

DROP TABLE IF EXISTS `kele_memu`;
CREATE TABLE IF NOT EXISTS `kele_memu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=181 ;

--
-- 转存表中的数据 `kele_memu`
--

INSERT INTO `kele_memu` (`id`, `name`, `value`) VALUES
(161, '建搜索表单', 'searchmemu'),
(159, '用户组权限', 'grouppower'),
(54, '主副表关联', 'relation'),
(154, '部门管理', 'department'),
(52, '表功能关联', 'tablecolumn'),
(158, '功能栏目', 'column'),
(60, '系统参数', 'system'),
(61, '操作设置', 'action'),
(152, '添加用户', 'user'),
(147, '建表单', 'memus'),
(155, '职称管理', 'position'),
(144, '建表', 'table'),
(150, '部门权限', 'dpmtpw'),
(151, '用户组', 'usergroup'),
(160, '建字段', 'field'),
(163, '部门协调表', 'collaborative'),
(165, '协调回执表', 'receipt'),
(167, 'saas系统栏目可管理条件', 'powerselect'),
(168, '人事管理', 'users'),
(171, '特殊权限管理', 'specialpower'),
(170, '考勤', 'attendance'),
(172, '项目管理', 'projectmanage'),
(173, '项目计划', 'projectplan'),
(180, '部门计划', 'sectoralplan'),
(178, '一周计划', 'weeklyplan'),
(177, '工作报告', 'workreport');

-- --------------------------------------------------------

--
-- 表的结构 `kele_memufield`
--

DROP TABLE IF EXISTS `kele_memufield`;
CREATE TABLE IF NOT EXISTS `kele_memufield` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` varchar(50) NOT NULL,
  `memuid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `defaults` varchar(250) NOT NULL,
  `classify` varchar(50) NOT NULL,
  `taxis` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `operate` varchar(50) NOT NULL,
  `attribute` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=865 ;

--
-- 转存表中的数据 `kele_memufield`
--

INSERT INTO `kele_memufield` (`id`, `field`, `memuid`, `name`, `type`, `defaults`, `classify`, `taxis`, `size`, `operate`, `attribute`) VALUES
(733, 'memuid', 161, '表单编号', 'no', '', 'searchfield', 5, 50, 'all', 'list'),
(732, 'field', 161, '字段值', 'text', '', 'searchfield', 4, 50, 'all', 'list'),
(710, 'value', 158, '英文标记', 'text', '', 'column', 3, 50, 'queen', 'list'),
(709, 'name', 158, '功能栏目名', 'text', '', 'column', 2, 50, 'queen', 'list'),
(52, 'tableid', 52, '表编号', 'select', 'sql|select id as value,name from kele_table', 'tablecolumn', 2, 50, 'queen', 'list'),
(51, 'id', 52, '编号', 'no', '', 'tablecolumn', 1, 50, 'queen', 'list'),
(53, 'columnid', 52, '功能编号', 'select', 'sql|select id as value,name from kele_column', 'tablecolumn', 3, 50, 'queen', 'list'),
(57, 'id', 54, '编号', 'no', '', 'relation', 0, 50, 'queen', 'list'),
(58, 'wheres', 54, '关联条件', 'text', '', 'relation', 0, 50, 'queen', 'list'),
(59, 'lord', 54, '主表编号', 'select', 'sql|select id as value, name from kele_table where master=&#039;yes&#039;', 'relation', 0, 50, 'queen', 'list'),
(60, 'schedule', 54, '副表编号', 'select', 'sql|select id as value, name from kele_table where master=&#039;no&#039;', 'relation', 0, 50, 'queen', 'list'),
(690, 'upcolumnid', 154, '上级部门', 'select', 'sql|select id as value, name from department', 'department', 3, 50, 'all', 'list'),
(689, 'name', 154, '部门名称', 'text', '', 'department', 2, 50, 'all', 'list'),
(718, 'operateids', 159, '操作编号', 'checkbox', 'sql|select id as value, name from kele_action', 'grouppower', 4, 50, 'all', 'list'),
(717, 'usergroupid', 159, '用户组编号', 'select', 'sql|select id as value, name from user_group', 'grouppower', 3, 50, 'all', 'list'),
(105, 'value', 60, '英文标记', 'text', '', 'system', 0, 50, 'queen', 'list'),
(104, 'name', 60, '参数名称', 'text', '', 'system', 0, 50, 'queen', 'list'),
(103, 'id', 60, '编号', 'no', '', 'system', 0, 50, 'queen', 'list'),
(106, 'systemvalue', 60, '数据', 'text', '', 'system', 0, 50, 'queen', 'list'),
(107, 'id', 61, '编号', 'no', '', 'action', 0, 50, 'queen', 'list'),
(108, 'name', 61, '操作', 'text', '', 'action', 0, 50, 'queen', 'list'),
(109, 'value', 61, '标记', 'text', '', 'action', 0, 50, 'queen', 'list'),
(679, 'username', 152, '用户名', 'text', '', 'user', 2, 50, 'all', 'list'),
(680, 'password', 152, '密码', 'password', '', 'user', 3, 50, 'all', 'noshow'),
(681, 'email', 152, 'email', 'text', '', 'user', 4, 50, 'all', 'list'),
(682, 'ispass', 152, '审核', 'select', '通过:true|不通过:false', 'user', 5, 50, 'queen', 'list'),
(676, 'id', 151, '编号', 'no', '', 'usergroup', 1, 50, 'all', 'list'),
(692, 'name', 155, '职称', 'text', '', 'position', 2, 50, 'all', 'list'),
(675, 'columnids', 150, '栏目', 'checkbox', 'sql|select id as value, name from kele_column where classify=&#039;sys&#039;;', 'dpmtpw', 4, 50, 'all', 'list'),
(715, 'id', 159, '编号', 'no', '', 'grouppower', 1, 50, 'all', 'list'),
(673, 'departmentid', 150, '部门', 'select', 'sql|select id as value, name from department', 'dpmtpw', 2, 50, 'all', 'list'),
(636, 'id', 144, '编号', 'no', '', 'table', 0, 50, 'queen', 'list'),
(637, 'name', 144, '中文', 'text', '', 'table', 0, 50, 'queen', 'list'),
(638, 'value', 144, '表名', 'text', '', 'table', 0, 50, 'queen', 'list'),
(639, 'fields', 144, '字段集', 'no', '', 'table', 0, 50, 'queen', 'whole'),
(640, 'classify', 144, '标记', 'text', '', 'table', 0, 50, 'queen', 'list'),
(641, 'master', 144, '是否主表', 'select', '主:yes|副:no', 'table', 0, 50, 'queen', 'list'),
(731, 'type', 161, '元素类型', 'select', '不搜索:no|输入框:text|下拉列表:select|日期:time', 'searchfield', 3, 50, 'all', 'list'),
(728, 'value', 161, '表单标记', 'text', '', 'searchmemu', 3, 50, 'all', 'list'),
(729, 'id', 161, '搜索元素编号', 'no', '', 'searchfield', 1, 50, 'all', 'list'),
(654, 'id', 147, '表单编号', 'no', '', 'memus', 1, 50, 'queen', 'list'),
(655, 'name', 147, '表单名', 'text', '', 'memus', 2, 50, 'queen', 'list'),
(656, 'value', 147, '表单标记', 'text', '', 'memus', 3, 50, 'queen', 'list'),
(657, 'id', 147, '元素编号', 'no', '', 'memufield', 1, 50, 'queen', 'list'),
(658, 'name', 147, '元素名', 'text', '', 'memufield', 2, 50, 'queen', 'list'),
(659, 'type', 147, '元素类型', 'select', '输入框:text|下拉列表:select|自定义:no|文本框:textarea|附件上传:file|图片上传:img|编辑器:edithtml|复选框:checkbox|密码:password|只读:readonly|时间控件:time|隐藏:hidden', 'memufield', 4, 50, 'queen', 'list'),
(660, 'attribute', 147, '显示状态', 'select', '列表:list|内容:whole|不显示:noshow', 'memufield', 5, 50, 'queen', 'list'),
(661, 'operate', 147, '前后台设置', 'select', '全:all|后台:queen', 'memufield', 6, 50, 'queen', 'list'),
(662, 'field', 147, '字段值', 'text', '', 'memufield', 3, 50, 'queen', 'list'),
(663, 'memuid', 147, '表单编号', 'no', '', 'memufield', 7, 50, 'queen', 'list'),
(664, 'defaults', 147, '默认值', 'text', '', 'memufield', 8, 50, 'queen', 'list'),
(665, 'classify', 147, '数据表标识', 'text', '', 'memufield', 9, 50, 'queen', 'list'),
(666, 'size', 147, '大小', 'text', '50', 'memufield', 11, 50, 'queen', 'list'),
(667, 'taxis', 147, '排序', 'text', '', 'memufield', 10, 50, 'queen', 'list'),
(674, 'positionid', 150, '职位', 'select', 'sql|select id as value, name from position', 'dpmtpw', 3, 50, 'all', 'list'),
(672, 'id', 150, '编号', 'no', '', 'dpmtpw', 1, 50, 'all', 'list'),
(691, 'id', 155, '职称编号', 'no', '', 'position', 1, 50, 'all', 'list'),
(730, 'name', 161, '元素名', 'text', '', 'searchfield', 2, 50, 'all', 'list'),
(727, 'name', 161, '搜索表单名', 'text', '', 'searchmemu', 2, 50, 'all', 'list'),
(726, 'id', 161, '搜索表单编号', 'no', '', 'searchmemu', 1, 50, 'all', 'list'),
(688, 'id', 154, '部门编号', 'no', '', 'department', 1, 50, 'all', 'list'),
(693, 'usergroupid', 155, '用户组', 'select', 'sql|select id as value, name from user_group', 'position', 3, 50, 'all', 'list'),
(716, 'columnid', 159, '栏目编号', 'select', 'sql|select id as value, name from kele_column where classify=&#039;sys&#039;;', 'grouppower', 2, 50, 'all', 'list'),
(711, 'classify', 158, '开发/系统', 'select', '开发:develop|系统:sys|公共:public', 'column', 4, 50, 'queen', 'list'),
(708, 'id', 158, '编号', 'no', '', 'column', 1, 50, 'queen', 'list'),
(678, 'id', 152, '编号', 'no', '', 'user', 1, 50, 'queen', 'list'),
(677, 'name', 151, '名称', 'text', '', 'usergroup', 2, 50, 'all', 'list'),
(712, 'linkurl', 158, '链接地址', 'text', '?model=show&amp;contro=function&amp;view=', 'column', 5, 50, 'queen', 'list'),
(713, 'upcolumnid', 158, '上级编号', 'text', '', 'column', 6, 50, 'queen', 'list'),
(714, 'tpl', 158, '显示页面', 'text', '', 'column', 7, 50, 'queen', 'list'),
(719, 'id', 160, '编号', 'no', '', 'field', 0, 50, 'queen', 'list'),
(720, 'name', 160, '中文', 'text', '', 'field', 1, 50, 'queen', 'list'),
(721, 'value', 160, '字段名', 'text', '', 'field', 2, 50, 'queen', 'list'),
(722, 'type', 160, '字段类型', 'select', '数字:int|字符串:varchar|文本:longtext', 'field', 3, 50, 'queen', 'list'),
(723, 'operate', 160, '字段存储类型', 'select', '添加:append|不添加:noadd|系统:system', 'field', 5, 50, 'queen', 'list'),
(724, 'defaultvalue', 160, '存储默认处理', 'select', '为空:empty|时间:time|用户:user|上一个编号:insertid|不为空:notnull|图片上传:image|附件上传:file|发布时间:addtime|上线ip:getip|通过审核:ispass|唯一:different|复选框:array|MD5:md5', 'field', 6, 50, 'queen', 'list'),
(725, 'size', 160, '字段大小', 'text', '', 'field', 7, 50, 'queen', 'list'),
(734, 'defaults', 161, '默认值', 'text', '', 'searchfield', 6, 50, 'all', 'list'),
(735, 'classify', 161, '数据表标识', 'text', '', 'searchfield', 7, 50, 'all', 'list'),
(736, 'size', 161, '大小', 'text', '20', 'searchfield', 8, 50, 'all', 'list'),
(737, 'taxis', 161, '排序', 'text', '', 'searchfield', 9, 50, 'all', 'list'),
(757, 'status', 163, '状态', 'no', '新增:0|已安排:1|已完成:2|已验收:3', 'collaborative', 8, 50, 'all', 'list'),
(756, 'textenter', 163, '需要协调问题', 'edithtml', '', 'collaborative', 7, 50, 'all', 'whole'),
(754, 'departmentid', 163, '申请部门', 'readonly', 'sql|select id as value, name from department where id=%departmentid', 'collaborative', 2, 50, 'all', 'list'),
(755, 'departmentid2', 163, '需要协调部门', 'select', 'sql|select id as value, name from department', 'collaborative', 5, 50, 'all', 'list'),
(753, 'ttime', 163, '填写日期', 'readonly', '%ttime', 'collaborative', 4, 50, 'all', 'list'),
(752, 'content', 163, '目前状况', 'edithtml', '', 'collaborative', 6, 50, 'all', 'whole'),
(751, 'userid', 163, '填写人', 'readonly', 'sql|select id as value, fullname as name from users where id=%userid', 'collaborative', 3, 50, 'all', 'list'),
(750, 'id', 163, '编号', 'no', '', 'collaborative', 1, 50, 'all', 'list'),
(773, 'value', 167, '功能栏目', 'select', 'sql|select value, name from kele_column where classify=&#039;sys&#039;;', 'powerselect', 2, 50, 'all', 'list'),
(772, 'id', 167, '编号', 'no', '', 'powerselect', 1, 50, 'all', 'list'),
(763, 'id', 165, '编号', 'no', '', 'receipt', 1, 50, 'all', 'list'),
(764, 'userid', 165, '接收人', 'readonly', 'sql|select id as value, fullname as name from users where id=%userid', 'receipt', 3, 50, 'all', 'list'),
(765, 'ttime', 165, '接收日期', 'readonly', '%ttime', 'receipt', 4, 50, 'all', 'list'),
(766, 'departmentid', 165, '接收部门', 'readonly', 'sql|select id as value, name from department where id=%departmentid', 'receipt', 2, 50, 'all', 'list'),
(767, 'textenter', 165, '处理意见', 'edithtml', '', 'receipt', 5, 50, 'all', 'whole'),
(768, 'collaborativeid', 165, '协同id', 'no', '', 'receipt', 0, 50, 'all', 'noshow'),
(774, 'wheres', 167, '条件', 'text', '', 'powerselect', 3, 50, 'all', 'list'),
(775, 'usergroupid', 167, '用户组', 'select', 'sql|select id as value, name from user_group', 'powerselect', 4, 50, 'all', 'list'),
(776, 'id', 168, '编号', 'no', '', 'users', 1, 50, 'all', 'list'),
(777, 'username', 168, '用户名', 'text', '', 'users', 2, 50, 'all', 'list'),
(778, 'password', 168, '密码', 'password', '', 'users', 3, 50, 'all', 'noshow'),
(779, 'email', 168, '邮箱', 'text', '', 'users', 4, 50, 'all', 'list'),
(780, 'ispass', 168, '审核', 'select', '通过:true|不通过:false', 'users', 5, 50, 'all', 'list'),
(781, 'departmentid', 168, '部门', 'select', 'sql|select id as value, name from department', 'users', 6, 50, 'all', 'list'),
(782, 'positionid', 168, '职位', 'select', 'sql|select id as value, name from position', 'users', 7, 50, 'all', 'list'),
(783, 'fullname', 168, '姓名', 'text', '', 'users', 8, 50, 'all', 'list'),
(795, 'columnid', 171, '栏目', 'select', 'sql|select id as value, name from kele_column where classify=&#039;sys&#039;;', 'specialpower', 2, 50, 'all', 'list'),
(794, 'id', 171, '编号', 'no', '', 'specialpower', 1, 50, 'all', 'list'),
(788, 'id', 170, '编号', 'no', '', 'attendance', 0, 50, 'all', 'noshow'),
(789, 'departmentid', 170, '', 'text', '', 'attendance', 0, 50, 'all', 'list'),
(790, 'cycle', 170, '日期', 'readonly', '', 'attendance', 0, 50, 'all', 'list'),
(791, 'completetime', 170, '上午', 'text', '', 'attendance', 0, 10, 'all', 'list'),
(792, 'usersid', 170, '', 'text', '', 'attendance', 0, 50, 'all', 'list'),
(793, 'completetime2', 170, '下午', 'text', '', 'attendance', 0, 10, 'all', 'list'),
(796, 'operateids', 171, '操作', 'checkbox', 'sql|select id as value, name from kele_action', 'specialpower', 3, 50, 'all', 'list'),
(797, 'usersid', 171, '用户', 'select', 'sql|select id as value, fullname as name from users', 'specialpower', 1, 50, 'all', 'list'),
(798, 'id', 172, '编号', 'no', '', 'projectmanage', 1, 50, 'all', 'list'),
(799, 'name', 172, '项目名称', 'text', '', 'projectmanage', 2, 50, 'all', 'list'),
(800, 'content', 172, '项目策划', 'edithtml', '', 'projectmanage', 3, 50, 'all', 'whole'),
(801, 'textenter', 172, '实施方案', 'edithtml', '', 'projectmanage', 4, 50, 'all', 'whole'),
(802, 'id', 173, '编号', 'no', '', 'projectplan', 1, 50, 'all', 'list'),
(803, 'classify', 173, '项目阶段', 'select', '项目策划:1|项目开发:2|项目运营:3|项目维护:4|项目终结:5', 'projectplan', 3, 50, 'all', 'list'),
(804, 'projectid', 173, '项目名', 'select', 'sql|select id as value,name from project_management', 'projectplan', 2, 50, 'all', 'list'),
(805, 'cycle', 173, '项目周期', 'select', '一个月:1|两个月:2|三个月:3|半年:4|一年:5|两年:6|三年:7', 'projectplan', 4, 50, 'all', 'list'),
(806, 'plantime', 173, '开始时间', 'time', '', 'projectplan', 5, 15, 'all', 'list'),
(807, 'usersid', 173, '负责人', 'select', 'sql|select id as value, fullname as name from users', 'projectplan', 6, 50, 'all', 'list'),
(861, 'projectid', 180, '项目名', 'readonly', '', 'sectoralplan', 2, 50, 'all', 'whole'),
(860, 'textenter', 180, '工作内容', 'textarea', '', 'sectoralplan', 3, 50, 'all', 'list'),
(859, 'departmentid', 180, '部门', 'select', 'sql|select id as value, name from department', 'sectoralplan', 2, 50, 'all', 'list'),
(858, 'ttime', 180, '时间', 'readonly', '%ttime', 'sectoralplan', 4, 50, 'all', 'list'),
(856, 'id', 180, '编号', 'no', '', 'sectoralplan', 1, 50, 'all', 'list'),
(844, 'projectid', 178, '项目名', 'readonly', '', 'weeklyplan', 0, 50, 'all', 'whole'),
(845, 'sectoralplanid', 178, '部门计划', 'hidden', '', 'weeklyplan', 0, 50, 'all', 'noshow'),
(843, 'textenter', 178, '备注', 'textarea', '', 'weeklyplan', 5, 50, 'all', 'whole'),
(842, 'departmentid2', 178, '部门', 'readonly', 'sql|select id as value, name from department where id=%departmentid', 'weeklyplan', 2, 50, 'all', 'list'),
(841, 'content', 178, '工作内容', 'textarea', '', 'weeklyplan', 4, 50, 'all', 'whole'),
(840, 'id', 178, '编号', 'no', '', 'weeklyplan', 1, 50, 'all', 'list'),
(832, 'id', 177, '编号', 'no', '', 'workreport', 1, 50, 'all', 'list'),
(833, 'userid', 177, '用户名', 'readonly', 'sql|select id as value, fullname as name from users where id=%userid', 'workreport', 2, 50, 'all', 'list'),
(834, 'content', 177, '工作内容', 'textarea', '', 'workreport', 3, 50, 'all', 'whole'),
(835, 'ttime', 177, '完成时间', 'readonly', '%ttime', 'workreport', 4, 50, 'all', 'list'),
(836, 'textenter', 177, '工作总结', 'textarea', '', 'workreport', 5, 50, 'all', 'whole'),
(837, 'projectid', 177, '项目名', 'readonly', '', 'workreport', 2, 50, 'all', 'noshow'),
(838, 'weeklyplanid', 177, '一周计划id', 'hidden', '', 'workreport', 0, 50, 'all', 'noshow'),
(839, 'completion', 177, '完成情况', 'text', '', 'workreport', 6, 50, 'all', 'list'),
(846, 'plantime', 178, '计划时间', 'time', '', 'weeklyplan', 3, 15, 'all', 'list'),
(847, 'usersid', 178, '负责人', 'select', 'sql|select id as value,fullname as name from users', 'weeklyplan', 6, 50, 'all', 'list'),
(857, 'classify', 180, '项目阶段', 'readonly', '项目策划:1|项目开发:2|项目运营:3|项目维护:4|项目终结:5', 'sectoralplan', 3, 50, 'all', 'whole'),
(862, 'cycle', 180, '周期', 'select', '一周:1|两周:2|三周:3|一个月:4|一个半月:5|两个月:6|三个月:7|持续:8', 'sectoralplan', 4, 50, 'all', 'list'),
(863, 'projectplanid', 180, '项目计划', 'hidden', '', 'sectoralplan', 5, 50, 'all', 'noshow'),
(864, 'usersid', 180, '负责人', 'select', 'sql|select id as value, fullname as name from users', 'sectoralplan', 6, 50, 'all', 'list');

-- --------------------------------------------------------

--
-- 表的结构 `kele_monitor`
--

DROP TABLE IF EXISTS `kele_monitor`;
CREATE TABLE IF NOT EXISTS `kele_monitor` (
  `name` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `kele_power_select`
--

DROP TABLE IF EXISTS `kele_power_select`;
CREATE TABLE IF NOT EXISTS `kele_power_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) NOT NULL,
  `wheres` varchar(250) NOT NULL,
  `usergroupid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `kele_power_select`
--

INSERT INTO `kele_power_select` (`id`, `value`, `wheres`, `usergroupid`) VALUES
(1, 'collaborative', 'departmentid=%departmentid or departmentid2=%departmentid', 1);

-- --------------------------------------------------------

--
-- 表的结构 `kele_relation`
--

DROP TABLE IF EXISTS `kele_relation`;
CREATE TABLE IF NOT EXISTS `kele_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lord` int(11) NOT NULL,
  `schedule` int(11) NOT NULL,
  `wheres` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `kele_relation`
--

INSERT INTO `kele_relation` (`id`, `lord`, `schedule`, `wheres`) VALUES
(1, 20, 21, 'kele_memufield.memuid=kele_memu.id'),
(3, 124, 125, 'kele_searchfield.memuid=kele_searchmemu.id');

-- --------------------------------------------------------

--
-- 表的结构 `kele_searchfield`
--

DROP TABLE IF EXISTS `kele_searchfield`;
CREATE TABLE IF NOT EXISTS `kele_searchfield` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `memuid` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `defaults` varchar(250) NOT NULL,
  `classify` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `taxis` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `kele_searchfield`
--

INSERT INTO `kele_searchfield` (`id`, `name`, `field`, `memuid`, `type`, `defaults`, `classify`, `size`, `taxis`) VALUES
(17, '部门', 'departmentid', 3, 'select', 'sql|select id as value, name from department|0:请选择', 'users', 20, 0),
(16, '审核状态', 'ispass', 3, 'select', '通过:true|不通过:false', 'users', 20, 0),
(14, '', 'password', 3, 'no', '', 'users', 20, 0),
(15, '', 'email', 3, 'no', '', 'users', 20, 0),
(12, '', 'id', 3, 'no', '', 'users', 20, 0),
(13, '用户名', 'username', 3, 'text', '', 'users', 20, 0),
(8, '', 'id', 2, 'no', '', 'grouppower', 20, 0),
(9, '栏目', 'columnid', 2, 'select', 'sql|select id as value, name from kele_column where classify=&#039;sys&#039;', 'grouppower', 20, 0),
(10, '用户组', 'usergroupid', 2, 'select', 'sql|select id as value, name from user_group', 'grouppower', 20, 0),
(11, '', 'operateids', 2, 'no', '', 'grouppower', 20, 0),
(18, '职位', 'positionid', 3, 'select', 'sql|select id as value, name from position|0:请选择', 'users', 20, 0),
(19, '姓名', 'fullname', 3, 'text', '', 'users', 20, 0);

-- --------------------------------------------------------

--
-- 表的结构 `kele_searchmemu`
--

DROP TABLE IF EXISTS `kele_searchmemu`;
CREATE TABLE IF NOT EXISTS `kele_searchmemu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `kele_searchmemu`
--

INSERT INTO `kele_searchmemu` (`id`, `name`, `value`) VALUES
(3, '人事管理', 'users'),
(2, '用户组权限', 'grouppower');

-- --------------------------------------------------------

--
-- 表的结构 `kele_system`
--

DROP TABLE IF EXISTS `kele_system`;
CREATE TABLE IF NOT EXISTS `kele_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `systemvalue` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `kele_system`
--

INSERT INTO `kele_system` (`id`, `name`, `value`, `systemvalue`) VALUES
(1, '网站标题', 'title', 'oa办公系统'),
(2, '上传文件夹', 'upload', 'CGI/upload'),
(3, '会员默认头像', 'memberlog', 'CGI/images/default/defaultimage.png'),
(4, '字符编码', 'charset_kele', 'utf-8');

-- --------------------------------------------------------

--
-- 表的结构 `kele_table`
--

DROP TABLE IF EXISTS `kele_table`;
CREATE TABLE IF NOT EXISTS `kele_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `fields` varchar(250) NOT NULL,
  `classify` varchar(50) NOT NULL,
  `master` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=136 ;

--
-- 转存表中的数据 `kele_table`
--

INSERT INTO `kele_table` (`id`, `name`, `value`, `fields`, `classify`, `master`) VALUES
(21, '元素登记', 'kele_memufield', '1,14,15,2,4,17,19,94,43,7,6', 'memufield', 'no'),
(20, '表单登记', 'kele_memu', '1,2,3', 'memus', 'yes'),
(19, '字段登记', 'kele_field', '1,2,3,4,43,7,8', 'field', 'yes'),
(18, '功能栏目', 'kele_column', '90,89,1,2,3,95,19', 'column', 'yes'),
(17, '操作', 'kele_action', '1,2,3', 'action', 'yes'),
(22, '系统', 'kele_system', '1,2,3,105', 'system', 'yes'),
(23, '表名登记', 'kele_table', '1,2,3,12,19,93', 'table', 'yes'),
(24, '栏目关联', 'kele_tablecolumn', '1,11,13', 'tablecolumn', 'yes'),
(122, '人事管理', 'users', '1,71,69,68,67,121,120,129', 'users', 'yes'),
(27, '主副表关联', 'kele_relation', '1,44,66,10', 'relation', 'yes'),
(28, '用户', 'kele_user', '1,67,68,69,71', 'user', 'yes'),
(123, '用户组权限', 'group_power', '1,13,123,124', 'grouppower', 'yes'),
(30, '在线登记', 'kele_useron', '73,67,77,78', 'useron', 'yes'),
(31, '临时表', 'kele_monitor', '2,3', 'monitor', 'yes'),
(118, '部门', 'department', '1,2,89', 'department', 'yes'),
(119, '职称', 'position', '1,2,123', 'position', 'yes'),
(120, '部门权限', 'department_power', '1,122,121,120', 'dpmtpw', 'yes'),
(121, '用户组', 'user_group', '1,2', 'usergroup', 'yes'),
(124, '搜索表单登记', 'kele_searchmemu', '1,3,2', 'searchmemu', 'yes'),
(125, '搜索元素登记', 'kele_searchfield', '1,14,2,15,43,19,17,4,94', 'searchfield', 'no'),
(126, '部门协调表', 'collaborative', '1,120,118,73,104,126,125,127', 'collaborative', 'yes'),
(127, '协调回执表', 'coll_receipt', '1,120,118,73,126,128', 'receipt', 'yes'),
(128, 'saas系统栏目可管理条件', 'kele_power_select', '1,3,10,123', 'powerselect', 'yes'),
(129, '项目管理', 'project_management', '1,2,126,104', 'projectmanage', 'yes'),
(131, '部门计划', 'sectoral_plan', '1,130,126,120,131,132,136,19,118', 'sectoralplan', 'yes'),
(130, '项目计划', 'project_plan', '1,19,131,130,134,136', 'projectplan', 'yes'),
(132, '一周计划', 'weekly_plan', '1,130,126,125,104,133,134,136', 'weeklyplan', 'yes'),
(133, '考勤管理', 'attendance', '1,135,131,120,136,137', 'attendance', 'yes'),
(134, '特殊权限管理', 'special_power', '1,136,124,13', 'specialpower', 'yes'),
(135, '工作报告', 'work_report', '1,73,118,130,126,104,138,139', 'workreport', 'yes');

-- --------------------------------------------------------

--
-- 表的结构 `kele_tablecolumn`
--

DROP TABLE IF EXISTS `kele_tablecolumn`;
CREATE TABLE IF NOT EXISTS `kele_tablecolumn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tableid` int(11) NOT NULL,
  `columnid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=95 ;

--
-- 转存表中的数据 `kele_tablecolumn`
--

INSERT INTO `kele_tablecolumn` (`id`, `tableid`, `columnid`) VALUES
(7, 23, 1),
(8, 23, 5),
(6, 20, 2),
(9, 19, 6),
(10, 18, 4),
(11, 24, 8),
(12, 28, 16),
(13, 27, 10),
(82, 123, 101),
(15, 22, 14),
(16, 17, 15),
(83, 122, 100),
(84, 124, 102),
(78, 119, 96),
(77, 118, 95),
(80, 121, 98),
(79, 120, 97),
(85, 126, 103),
(86, 127, 105),
(87, 128, 106),
(88, 133, 107),
(89, 134, 108),
(90, 129, 110),
(91, 130, 111),
(92, 131, 112),
(93, 132, 113),
(94, 135, 114);

-- --------------------------------------------------------

--
-- 表的结构 `kele_user`
--

DROP TABLE IF EXISTS `kele_user`;
CREATE TABLE IF NOT EXISTS `kele_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `ispass` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=43 ;

--
-- 转存表中的数据 `kele_user`
--

INSERT INTO `kele_user` (`id`, `username`, `password`, `email`, `ispass`) VALUES
(29, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', 'true'),
(41, 'zhumiang', 'a66d92cacbcb69c63a629611a1558195', 'zhumiang@gmail.com', 'true');

-- --------------------------------------------------------

--
-- 表的结构 `kele_useron`
--

DROP TABLE IF EXISTS `kele_useron`;
CREATE TABLE IF NOT EXISTS `kele_useron` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `onlineip` varchar(18) NOT NULL,
  `onlinetime` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `kele_useron`
--

INSERT INTO `kele_useron` (`userid`, `username`, `onlineip`, `onlinetime`) VALUES
(29, 'admin', '127.0.0.1', 1346646622),
(38, 'zhuming', '127.0.0.1', 1342235975),
(33, 'zhumiang', '127.0.0.1', 1343899320),
(39, '聂明', '127.0.0.1', 1343897613),
(3, '袁健飞', '117.90.243.251', 1345442473),
(41, 'zhumiang', '127.0.0.1', 1345454789),
(1, '聂明', '127.0.0.1', 1346646586);

-- --------------------------------------------------------

--
-- 表的结构 `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `usergroupid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `position`
--

INSERT INTO `position` (`id`, `name`, `usergroupid`) VALUES
(1, '总经理', 1),
(2, '经理', 2),
(3, '副经理', 2),
(4, '组长', 3),
(6, '员工', 4);

-- --------------------------------------------------------

--
-- 表的结构 `project_management`
--

DROP TABLE IF EXISTS `project_management`;
CREATE TABLE IF NOT EXISTS `project_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` longtext NOT NULL,
  `textenter` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `project_management`
--

INSERT INTO `project_management` (`id`, `name`, `content`, `textenter`) VALUES
(1, 'www.impresshow.com', ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;', ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;');

-- --------------------------------------------------------

--
-- 表的结构 `project_plan`
--

DROP TABLE IF EXISTS `project_plan`;
CREATE TABLE IF NOT EXISTS `project_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classify` varchar(50) NOT NULL,
  `projectid` int(11) NOT NULL,
  `cycle` varchar(250) NOT NULL,
  `plantime` varchar(250) NOT NULL,
  `usersid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `project_plan`
--

INSERT INTO `project_plan` (`id`, `classify`, `projectid`, `cycle`, `plantime`, `usersid`) VALUES
(1, '4', 1, '5', '2012-08-01', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sectoral_plan`
--

DROP TABLE IF EXISTS `sectoral_plan`;
CREATE TABLE IF NOT EXISTS `sectoral_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departmentid` int(11) NOT NULL,
  `textenter` longtext NOT NULL,
  `projectid` int(11) NOT NULL,
  `cycle` varchar(250) NOT NULL,
  `projectplanid` int(11) NOT NULL,
  `usersid` int(11) NOT NULL,
  `classify` varchar(50) NOT NULL,
  `ttime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sectoral_plan`
--

INSERT INTO `sectoral_plan` (`id`, `departmentid`, `textenter`, `projectid`, `cycle`, `projectplanid`, `usersid`, `classify`, `ttime`) VALUES
(2, 9, '种子下载', 1, '1', 1, 1, '4', 1346220413);

-- --------------------------------------------------------

--
-- 表的结构 `special_power`
--

DROP TABLE IF EXISTS `special_power`;
CREATE TABLE IF NOT EXISTS `special_power` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `columnid` int(11) NOT NULL,
  `operateids` varchar(200) NOT NULL,
  `usersid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `special_power`
--

INSERT INTO `special_power` (`id`, `columnid`, `operateids`, `usersid`) VALUES
(1, 108, '1,2,3,4,5,6', 1);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `ispass` varchar(10) NOT NULL,
  `departmentid` int(11) NOT NULL,
  `positionid` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `ispass`, `departmentid`, `positionid`, `fullname`) VALUES
(1, '聂明', '202cb962ac59075b964b07152d234b70', 'zhumiang@gmail.com', 'true', 9, 2, '聂明'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', 'true', 1, 1, '管理员');

-- --------------------------------------------------------

--
-- 表的结构 `user_group`
--

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `user_group`
--

INSERT INTO `user_group` (`id`, `name`) VALUES
(1, '总管理员'),
(2, '管理员'),
(3, '组管理员'),
(4, '成员');

-- --------------------------------------------------------

--
-- 表的结构 `weekly_plan`
--

DROP TABLE IF EXISTS `weekly_plan`;
CREATE TABLE IF NOT EXISTS `weekly_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `departmentid2` int(11) NOT NULL,
  `textenter` longtext NOT NULL,
  `projectid` int(11) NOT NULL,
  `sectoralplanid` int(11) NOT NULL,
  `plantime` varchar(250) NOT NULL,
  `usersid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `weekly_plan`
--

INSERT INTO `weekly_plan` (`id`, `content`, `departmentid2`, `textenter`, `projectid`, `sectoralplanid`, `plantime`, `usersid`) VALUES
(1, 'asa', 9, 'asd', 1, 2, '2012-09-03', 1);

-- --------------------------------------------------------

--
-- 表的结构 `work_report`
--

DROP TABLE IF EXISTS `work_report`;
CREATE TABLE IF NOT EXISTS `work_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `ttime` int(11) NOT NULL,
  `textenter` longtext NOT NULL,
  `projectid` int(11) NOT NULL,
  `weeklyplanid` int(11) NOT NULL,
  `completion` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `work_report`
--

INSERT INTO `work_report` (`id`, `userid`, `content`, `ttime`, `textenter`, `projectid`, `weeklyplanid`, `completion`) VALUES
(2, 1, 'asa', 1346645894, 'asas', 1, 1, '1%');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
