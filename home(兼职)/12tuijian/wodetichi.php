<?php
	require_once(dirname(__FILE__)."/../config.php");
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
	$user=$db->getone("select id,name,jiangjin from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");			//查询数据库
	
if(!isset($dopost)) $dopost = '';

if($dopost=='')
{	
	
	if(!empty($user)){
		$sql="SELECT id,bianhao,name,sphone,tj_num,f_bianghao,f_name,pid,path FROM tuijian WHERE jihuo='1' AND path LIKE '%,".$user['id'].",%' ORDER BY concat(path,id)";
		$tujiandata=$db->getall($sql);
		
		$dy=0;
		$use=array();
		foreach($tujiandata as $k => $v){
			$v['path']=strstr($v['path'],$user['id'].",");
			$m=substr_count($v['path'],",");
			$tujiandata[$k]['m']=$m;
			if($m < 13){
				if($m >= $tujiandata[$k-1]['m'] ){
					if($dy < $m){
						$dy=$m;
					}
				}
				if($m==$dy){
					$use[$m]['name'][]=$v['name'];
					$use[$m]['id'][]=$v['id'];
				}else{
					$use[$m]['name'][]=$v['name'];
					$use[$m]['id'][]=$v['id'];
				}
			}
			
		}
		
		require_once(dirname(__FILE__)."/style/wodetichi.htm");		//模版
	
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}

}elseif($dopost=='dj'){	
	
	if($_GET['pid']!=''){
	
		$pid = $_GET['pid'];
		
		$sql="SELECT id,bianhao,name,sphone,tj_num,jihuo_time,f_bianghao,f_name,pid,path FROM tuijian WHERE jihuo='1' AND path LIKE '%,".$user['id'].",%' ORDER BY concat(path,id)";
		$tujiandata=$db->getall($sql);
		
		$use=array();
		foreach($tujiandata as $k => $v){
			$v['path']=strstr($v['path'],$user['id'].",");
			$m=substr_count($v['path'],",");
			if($m==$pid){
				$use['name'][]=$v['name'];
				$use['id'][]=$v['id'];
				$use['jihuo_time'][]=$v['jihuo_time'];
			}
		}
		
		require_once(dirname(__FILE__)."/style/wodetichiji.htm");		//模版
	}
	
}elseif($dopost=='user'){

	if($_GET['pid']!=''){
		$pid = $_GET['pid'];

		$sql="SELECT id,bianhao,name,sphone,tj_num,f_bianghao,f_name,pid,path FROM tuijian WHERE jihuo='1' AND path LIKE '%,".$pid.",%' ORDER BY concat(path,id)";
		$tujiandata=$db->getall($sql);
		
		$dy=0;
		$use=array();
		foreach($tujiandata as $k => $v){
			$v['path']=strstr($v['path'],$pid.",");
			$m=substr_count($v['path'],",");
			$tujiandata[$k]['m']=$m;
			if($m < 13){
				if($m >= $tujiandata[$k-1]['m'] ){
					$dy=$m;
				}
				if($m==$dy){
					$use[$m]['name'][]=$v['name'];
					$use[$m]['id'][]=$v['id'];
				}else{
					$use[$m]['name'][]=$v['name'];
					$use[$m]['id'][]=$v['id'];
				}
			}
			
		}
		
		require_once(dirname(__FILE__)."/style/wodetichi.htm");		//模版
	}
}
