<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. (http://www.xixihe.com)
 * @author zhumingվ (www.xixihe.com)
 * @package kelecms
 * @subpackage static/cache
 * @version $Id: url.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
  global $gourl;
 $gourl = array(
	'error'=>array(
		'default'		=>'失败',
		'default_url'	=>'-1',
		'dataless'		=>'失败',
		'different'		=>'失败',
		'modelwrong'	=>'失败',
		'model'			=>'失败',
		'idwrong'		=>'失败',
		'lidwrong'		=>'失败',
		'systemwrong'	=>'失败',
		'datanodid'		=>'失败',
		'columnwrong'	=>'访问了无效的栏目',
		'nodata'		=>'失败',
		'datanofinder'	=>'失败',
		'markwrong'		=>'失败',
		'powerwrong'	=>'没有权限',
		'wrongcontro'	=>'失败',
		'cordwrong'		=>'失败',
		'unauthor'		=>'失败',
		'passwordwrong'	=>'密码错误',
		'nouser'		=>'没有此用户',
		'notrule'		=>'格式错误',
		'loginagain'	=>'重复登录',
		'havelogin'		=>'此帐户正在别处登录',
		'unknown'		=>'失败',
		'nologin'		=>'没有登录',
		'filewrong'		=>'文件不存在',
		'datawrong'		=>'失败',
		'upwrong'		=>'失败',
		'updirwrong'	=>'失败',
		'powerless'		=>'失败',
		'loginfirst'	=>'失败',
		'userdidwrong'	=>'失败',
		'powersetwrong'	=>'失败',
		'tablename'		=>'失败',
		'fieldsame'		=>'失败',
		'fieldwrong'	=>'失败',
		'checkcode'		=>'验证失败',
		'updateorder'	=>'获取订单结束',
		'nofiletodown'	=>'没有文件可下载',
		'xlsovercell'	=>'xls下载时，超出列宽',
	),
	'login'=>array(
		'default'		=>'登录成功',
		'default_url'	=>http_dir.'member',
		'kele'		=>'登录成功',
		'kele_url'	=>http_dir.'kele',
		'member'		=>'登录成功',
		'member_url'	=>http_dir.'member',
		'index'		=>'登录成功',
		'index_url'	=>http_dir,
	),
	'logout'=>array(
		'default'		=>'退出成功',
		'default_url'	=>http_dir,
		'kele'			=>'退出成功',
		'kele_url'		=>http_dir.'kele',
		'index'		=>'退出成功',
		'index_url'	=>http_dir,
	),
	'append'=>array(
		'default'		=>'成功',
		'default_url'	=>'goback',
		'table'			=>'成功',
		'table_url'		=>'goback',
		'friend'		=>'成功',
		'friend_url'	=>'back',
	),
	'amend'=>array(
		'default'		=>'成功',
		'default_url'	=>'goback',
		'field'			=>'成功',
		'field_url'		=>'goback',
	),
	'delete'=>array(
		'default'		=>'成功',
		'default_url'	=>'back',
	),
	'system'=>array(
		'default'		=>'成功',
		'default_url'	=>'back',
	),
	
 );
?>
