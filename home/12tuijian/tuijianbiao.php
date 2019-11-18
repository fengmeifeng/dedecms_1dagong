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
	$user=$db->getone("select id,name,jiangjin from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");			//查询数据库
	
if(!isset($_GET['do'])) $_GET['do'] = '';

if($_GET['do']==''){

	if(!empty($user)){
	
		$num="SELECT id,bianhao,name,sphone,tj_num,status,jihuo,f_bianghao,f_name,pid,path FROM tuijian WHERE path LIKE '%,".$user['id'].",%' ";
		$num=$db->get_total($num);
		$page=new page($num,20);
		$sql="SELECT id,bianhao,name,sphone,tj_num,status,jihuo,f_bianghao,f_name,pid,path FROM tuijian WHERE path LIKE '%,".$user['id'].",%' ORDER BY add_time desc LIMIT ".$page->limit;
		$tujiandata=$db->getall($sql);
		require_once(dirname(__FILE__)."/style/tuijianbiao.htm");		//模版
		
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}
	
//删除推荐的用户列表
}elseif($_GET['do']=='shibaiuser'){

	if(!empty($user)){
	
		$num="SELECT id,bianhao,name,sphone,tj_num,f_bianghao,f_name,pid,path FROM tuijiandel WHERE path LIKE '%,".$user['id'].",%' ";
		$num=$db->get_total($num);
		$page=new page($num,20,"?do=shibaiuser");
		$sql="SELECT id,bianhao,name,sphone,tj_num,f_bianghao,f_name,pid,path FROM tuijiandel WHERE path LIKE '%,".$user['id'].",%' ORDER BY add_time desc LIMIT ".$page->limit;
		$tujiandata=$db->getall($sql);
		require_once(dirname(__FILE__)."/style/tuijiandel.htm");		//模版
	
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}
	
//删除自己推荐的用户
}elseif($_GET['do']=='deluser'){
	
	if(!empty($user)){
		if(!empty($_GET['delid'])){
			$sqluser="select id,bianhao,name,sex,address,sphone,id_number,qq,jiangjin,tj_num,add_time,f_bianghao,f_name,pid,jibie,path from tuijian	WHERE id='".$_GET['delid']."' ";
			$deluser=$db->getone($sqluser);
			$deluser['deltime']=time();
			$delid=$db->insert("deltuijian",$deluser);	//添加被删除的用户
			if($delid > 0){
				$delsql="DELETE FROM `tuijian` WHERE `id`='".$_GET['delid']."' ";
				$id=$db->query($delsql);
				if($id){
					showmsg('删除成功！ ', '/home/12tuijian/tuijianbiao.php');
					exit();
				}else{
					$del="DELETE FROM `deltuijian` WHERE `id`='".$delid."' ";
					$db->query($del);
					showmsg('删除失败！ ', '/home/12tuijian/tuijianbiao.php');
					exit();
				}
			}
		}
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}
	
}