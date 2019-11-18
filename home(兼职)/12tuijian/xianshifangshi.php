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
	
if(!isset($dopost)) $dopost = '';

if($dopost=='')
{		
	
	if(!empty($user)){
		$num="SELECT id,bianhao,name,sphone,tj_num,f_bianghao,f_name,pid,path FROM tuijian WHERE jihuo='1' AND path LIKE '%,".$user['id'].",%' ORDER BY concat(path,id)";
		$num=$db->get_total($num);
		$page=new page($num,20);
		$sql="SELECT id,bianhao,name,sphone,tj_num,f_bianghao,f_name,pid,path FROM tuijian WHERE jihuo='1' AND path LIKE '%,".$user['id'].",%' ORDER BY concat(path,id) LIMIT ".$page->limit;
		$tujiandata=$db->getall($sql);
		$nummc=1;
		foreach($tujiandata as $k => $v){
			$v['path']=strstr($v['path'],$user['id'].",");
			$m=substr_count($v['path'],",");
			$strpad = str_pad("",$m*6*4,"&nbsp;");
			$tujiandata[$k]['kg']=$strpad.$m."┨";			
			$tujiandata[$k]['m']=$m;
			if($m >= 1 and $m <= 3){
				$tujiandata[$k]['q']=100;
			}elseif($m >= 4 and $m <= 7){
				$tujiandata[$k]['q']=30;
			}elseif($m >= 8 and $m <= 10){
				$tujiandata[$k]['q']=25;
			}elseif($m >= 11 and $m <= 12){
				$tujiandata[$k]['q']=20;
			}else{
				$tujiandata[$k]['q']=0;
			}
			if($nummc==1){
				if($m > 1){
					$nummc=2;
				}
			}
		}
		$db->close();		//关闭数据库连接
		
		require_once(dirname(__FILE__)."/style/wodebiao.htm");		//模版
	
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}

//我的推荐图	
}elseif($dopost=='tu'){

	if(!empty($user)){
		
		$sql="SELECT id,bianhao,name,sphone,pid,path,jihuo_time FROM tuijian WHERE jihuo='1' AND path LIKE '%,".$user['id'].",%' ORDER BY id asc,concat(path,id)";
		$tujiandata=$db->getall($sql);
		$db->close();
		require_once(dirname(__FILE__)."/style/wodetu.htm");		//模版
	
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}
	
}	