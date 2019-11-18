<?php

require_once(dirname(__FILE__)."/../config.php");
require_once(DEDEINC."/bb_duanxin.class.php"); 	//短信类
require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类
	CheckRank(0,0);		//查看是否登录
	yzmima();			//查看当前密码是否为默认的，否则跳到修改密码页面
	//----------------------------------------------------
	require_once(DEDEDATA.'/common.inc.php');		//数据库链接信息
	$dbhost=$sqltag['tuijian']['dbhost'];			//主机
	$dbuser=$sqltag['tuijian']['dbuser'];			//帐号
	$dbpass=$sqltag['tuijian']['dbpwd'];			//密码
	$dbname=$sqltag['tuijian']['dbname'];			//库名
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);		//new 数据库类
		
if(!isset($dopost)) $dopost = '';

if($dopost==''){
	//模版---
	require_once(dirname(__FILE__)."/style/gettxmima.htm");
	exit();
}if($dopost=='save'){

	if(!empty($_POST)){
		if($_POST['sphone']!==""){
		
			$user=$db->getone("select * from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");
			
			if(!empty($user)){
				$mima=rand(100000,999999);	$pwd=MD5('1+2huidong'.$mima);
				$query1 = "UPDATE `tuijian`  SET pasword2='$pwd' where  sphone='".$user['sphone']."' ";
				
				$sd=$db->query($query1);
			if($sd){
			$content="您好，您的壹打工网提现密码重置为：".$mima."。电脑或手机访问www.1dagong.com，随时随地找工作。【壹打工网】";
					$dx=new duanxin($user['sphone'],$content);		//申明短信类
					$id=$dx->fs();							//发送短信
					showmsg('密码重置成功！密码为随机6位数，稍后密码会以短信的方式发送给您！ ', '-1', 0,5000);
					exit();
				
			
			}else{
				showmsg('操作失败！ ', '-1');
				exit();
			}
			
				
			}else{
				showmsg('没有找到您的账户，请重试！ ', '-1');
				exit();
			}
			
		
		}else{
			showmsg('手机号不能为空！ ', '-1');
			exit();
		}
	}
	
}