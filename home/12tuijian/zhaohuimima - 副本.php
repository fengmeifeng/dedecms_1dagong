<?php

require_once(dirname(__FILE__)."/../config.php");
require_once(DEDEINC."/bb_duanxin.class.php"); 	//短信类
	
if(!isset($dopost)) $dopost = '';

if($dopost==''){
	//模版---
	require_once(dirname(__FILE__)."/style/zhaohuimima.htm");
	exit();
}if($dopost=='save'){

	if(!empty($_POST)){
		if($_POST['sphone']!==""){
			//---------------------------------------------------------------------------冯----个人
			$user = $dsql->GetOne("SELECT * FROM `#@__member` WHERE userid LIKE '$sphone' ");
			if(!empty($user)){
				$mima=rand(100000,999999);	$pwd=MD5($mima);
				$query1 = "UPDATE `#@__member` SET pwd='$pwd' where userid='".$sphone."' or sphone='".$sphone."' ";
				if($dsql->ExecuteNoneQuery($query1)){
					$content="您好，您的壹打工网新的密码为：".$mima."。电脑或手机访问www.1dagong.com，随时随地找工作。【壹打工网】";
					$dx=new duanxin($sphone,$content);		//申明短信类
					$id=$dx->fs();							//发送短信
					showmsg('密码修改成功！密码为随机6位数，稍后密码会以短信的方式发送给您！ ', '-1', 0,5000);
					exit();
				}else{
					showmsg('密码修改失败！ ', '-1');
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