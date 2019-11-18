<?php
	require_once(dirname(__FILE__)."/../config.php");
	require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类
	CheckRank(0,0);		//查看是否登录
	yzmima();			//查看当前密码是否为默认的，否则跳到修改密码页面
	require_once(dirname(__FILE__)."/page.class.php");	//分页类
	
	//----------------------------------------------------
	require_once(DEDEDATA.'/common.inc.php');		//数据库链接信息
	$dbhost=$sqltag['tuijian']['dbhost'];			//主机
	$dbuser=$sqltag['tuijian']['dbuser'];			//帐号
	$dbpass=$sqltag['tuijian']['dbpwd'];			//密码
	$dbname=$sqltag['tuijian']['dbname'];			//库名
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);		//new 数据库类
	$user=$db->getone("select bianhao from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");			//查询数据库
	
	
	if(!empty($user)){
	
		$num="SELECT * FROM recordmoney WHERE hyhumber='".$user['bianhao']."' ";
		$num=$db->get_total($num);
		$page=new page($num,10);
		$sql="SELECT * FROM recordmoney WHERE hyhumber='".$user['bianhao']."' ORDER BY `addtime` DESC  LIMIT ".$page->limit;
		$tujiandata=$db->getall($sql);
		require_once(dirname(__FILE__)."/style/jingjinjilu.htm");		//模版
	
	
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}
	