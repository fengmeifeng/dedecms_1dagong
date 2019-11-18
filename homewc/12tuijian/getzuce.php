<?php 
/* 
	根据url 传递过来的手机号 注册壹打工网 
	curl 坊问
*/

	require_once(dirname(__FILE__)."/../config.php");
	require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类
	//----------------------------------------------------
	require_once(DEDEDATA.'/common.inc.php');		//数据库链接信息
	$dbhost=$sqltag['tuijian']['dbhost'];			//主机
	$dbuser=$sqltag['tuijian']['dbuser'];			//帐号
	$dbpass=$sqltag['tuijian']['dbpwd'];			//密码
	$dbname=$sqltag['tuijian']['dbname'];			//库名
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);		//new 数据库类

if(!isset($dopost)) $dopost = '';

if($dopost=='')
{
	exit('不可以访问!');
	
}

elseif($dopost=='curl'){

	print_r($_GET);
	
	if($_GET['us']!='' && $_GET['sj']!=''){
		$user=$db->getone("select * from tuijian where bianhao='".$_GET['us']."' ");			//查询数据库

		//判断是否存在用户
		if(!empty($user)){
			$sphone=$_GET['sj'];
			$data = $dsql->GetOne("SELECT * FROM #@__member WHERE sphone='$sphone' ");
			if(empty($data)){
				//--壹打工网注册----and----------------------------------------------
				$userid = trim($sphone);							//userid
				$uname = trim($sphone);							//用户名。
				$pwd = trim(substr($sphone, -4));				//取手机尾数4号做密码
				$userpwd=$pwdc = trim(substr($sphone, -4));		//取手机尾数4号做密码
				//会员的默认金币
				$dfscores = 0;
				$dfmoney = 0;
				$dfrank = $dsql->GetOne("SELECT money,scores FROM `#@__arcrank` WHERE rank='10' ");
				if(is_array($dfrank))
				{
					$dfmoney = $dfrank['money'];
					$dfscores = $dfrank['scores'];
				}
				$jointime = time();
				$logintime = time();
				$joinip = GetIP();
				$loginip = GetIP();
				$pwd = md5($userpwd);
				$mtype='个人';
				//如果意向公司为空就把意向公司为无--
				if(empty($qym)){
					$qym="推荐注册";
				}
				//--------------------end------------
				$inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`uname` ,`sphone` ,`qym` ,`sex` ,`rank` ,`money` ,`email` ,`scores` ,
				`matt`, `spacesta` ,`face`,`safequestion`,`safeanswer` ,`jointime` ,`joinip` ,`logintime` ,`loginip`,`form`)
			   VALUES ('$mtype','$userid','$pwd','$userid','$userid','$qym','$sex','10','$dfmoney','$email','$dfscores',
			   '0','$spaceSta','','$safequestion','$safeanswer','$jointime','$joinip','$logintime','$loginip','2'); ";
				if($dsql->ExecuteNoneQuery($inQuery)){
					
					$mid = $dsql->GetLastID();
					//写入默认统计数据
					$membertjquery = "INSERT INTO `#@__member_tj` (`mid`,`article`,`album`,`archives`,`homecount`,`pagecount`,`feedback`,`friend`,`stow`)
						   VALUES ('$mid','0','0','0','0','0','0','0','0'); ";
					$dsql->ExecuteNoneQuery($membertjquery);
			
					//写入默认空间配置数据
					$spacequery = "INSERT INTO `#@__member_space`(`mid` ,`pagesize` ,`matt` ,`spacename` ,`spacelogo` ,`spacestyle`, `sign` ,`spacenews`)
							VALUES('{$mid}','10','0','{$uname}的空间','','person','',''); ";
					$dsql->ExecuteNoneQuery($spacequery);
			
					//写入其它默认数据
					$dsql->ExecuteNoneQuery("INSERT INTO `#@__member_flink`(mid,title,url) VALUES('$mid','壹打工','http://www.1dagong.com'); ");
				}
				//--壹打工网注册----end----------------------------------------------
			}else{
				exit('存在!');
			}
		}
		
	}
}