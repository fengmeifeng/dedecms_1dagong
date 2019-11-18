<?php
return array(
	//项目相关
	'URL_MODEL' => 2,
	'APPNAME' => '管理系统',
	'APPLOGONAME' => 'urlpattern管理系统',
	'PAGENODE_NOT_METHOD' => '__construct,__set,__get,__isset,__call,__destruct,get,_initialize',

	//自动加载
	'AUTOLOAD_NAMESPACE' => array(
		'Library' => "./",
	),
	
	'WEBPAGE' => 15,
		
	//数据库配置信息
	'DB_TYPE' => 'mysql',
	'DB_HOST' => '127.0.0.1', 
	'DB_NAME' => 'collect', 
	'DB_USER' => 'root', 
	'DB_PWD' => '', 
	'DB_PORT' => 3306, 
	'DB_PREFIX' => 'collect_', 
	'DB_CHARSET' => 'utf8',
		
	'DB_FIELDS_CACHE' => true,
		
	//xpath config description
	'XPATHLAB' => '获取html列表的xpath信息<br>例：//*[@id=content-list]',
	'TITLELAB' => '填写匹配标题的html标签 <br>例：a,p',
	'LINKLAB' => '填写匹配详细URL的html标签 <br>例：a,p',
	
	//权限配置
	'USER_AUTH_ON' => true,
	'USER_AUTH_GATEWAY' => '/Home/Login',
	'NOT_AUTH_MODULE' => 'Home/Login',
	'USER_AUTH_MODEL' => 'User',
	'FOUNDER' => 'admin',
	'USER_AUTH_KEY' => 'authId',
		
	//业务通用字段
	'SOURCEFIELD' => array(
		array('field' => 'title','name' => '标题'),
		array('field' => 'dateline','name' => '时间'),
		array('field' => 'content','name' => '内容'),
		array('field' => 'author','name' => '作者'),
	),
	
	//Thrift
	'THRIFTHOST' => '192.168.86.39',
	'THRIFTPORT' => '8099',
	'SENDTIMEOUT' => '6000',
	'RECVTIMEOUT' => '6000',
	'HADOOPPATH' => array(
		"/work/hpma/urlpattern/garbagePagePattern",
		"/work/hpma/urlpattern/themepagePatte_web",
	),
	'HADOOPPATHNEW' => array(
		"/work/hpma/urlpattern",
	),
	'HOSTDESC' => array(
		'_invalid' => '<font color="#FF0000">无效页</font>',
		'_comment' => '评论页',
		'_commodit' => '<font color="green">可用页</font>'
	),
);