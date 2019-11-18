<?php

require_once(dirname(__FILE__).'/config.php');
require_once DEDEINC.'/membermodel.cls.php';
require_once(DEDEINC."/userlogin.class.php");

require_once(DEDEINC."/bb_duanxin.class.php"); 	//短信类
require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类

CheckRank(0,0);
require_once(DEDEINC.'/enums.func.php');
$menutype = 'config';
if(!isset($dopost)) $dopost = '';

if($dopost=='')
{
    $dede_fields = empty($dede_fields) ? '' : trim($dede_fields);
    if(!empty($dede_fields))
    {
        if($dede_fieldshash != md5($dede_fields.$cfg_cookie_encode))
        {
            showMsg('数据校验不对，程序返回', '-1');
            exit();
        }
    }
	
    $dede_fieldshash = empty($dede_fieldshash) ? '' : trim($dede_fieldshash);
    $membermodel = new membermodel($cfg_ml->M_MbType);
    $modelform = $dsql->GetOne("SELECT * FROM #@__member_model WHERE id='$membermodel->modid' ");
    if(!is_array($modelform))
    {
        showmsg('模型表单不存在', '-1');
        exit();
    }
    $row = $dsql->GetOne("SELECT * FROM ".$modelform['table']." WHERE mid=$cfg_ml->M_ID");
	
    if(!is_array($row))
    {
        showmsg("你访问的记录不存在或未经审核", '-1');
        exit();
    }
	
	//----------------------------------------------------
	require_once(DEDEDATA.'/common.inc.php');		//数据库链接信息
	$dbhost=$sqltag['tuijian']['dbhost'];			//主机
	$dbuser=$sqltag['tuijian']['dbuser'];			//帐号
	$dbpass=$sqltag['tuijian']['dbpwd'];			//密码
	$dbname=$sqltag['tuijian']['dbname'];			//库名
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);		//new 数据库类
	$baodanzhongxin=$db->getall("select * from adminuser where priv='2' ");			//查询数据库
	
	$data=$db->getone("select * from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");
	
	if(!empty($data)){
		showmsg('已经加入过“1+2事业平台了”，', '/home/12tuijian/gerenxinxi.php',0,5000);
		exit();
	}else{
		$db->close();		//关闭链接
		
		if($cfg_ml->fields['sphone']=='' || $cfg_ml->fields['sphone']==' ' || $cfg_ml->fields['shengfenid']=='' || $cfg_ml->fields['shengfenid']==' '){
			showmsg('本人身份证号码和正在使用的手机号不能为空！ <br/>请补充完整！<br>....正在为你跳转修改页面！', '/home/info.php',0,8000);
			exit();
		}
		//-----------------------------------------------------
		include('mystyles/reg_12.htm');
		exit();
	}
}
/*------------------------
function __Save()
------------------------*/
if($dopost=='save'){
	
	if($guanxi==''){
		showmsg('打工区域未选择！', '-1');
		 exit();
	}
	if($hyname==''){
		showmsg('姓名到 个人资料里填写！', '-1');
		 exit();
	}
	if($hyaddress==''){
		showmsg('地址到 个人资料里填写！', '-1');
		 exit();
	}
	if($hytel==''){
		showmsg('联系电话到 个人资料里填写！', '-1');
		 exit();
	}
	if($hycardno==''){
		showmsg('身份证号码到 个人资料里填写！', '-1');
		 exit();
	}
	
	//-----------------------------------------------
	//随机编号
	$bianhao="s".rand(100000,999999);
	//使用死循环防止纯在重复的随机数
	$i=1;
	while($i){
		$data=$db->getone("select * from tuijian where bianhao='".$bianhao."' ");
		if(!empty($data)){
			$bianhao="s".rand(100000,999999);
			$i=1;
		}else{
			break;
		}
	}
	//----------------------------------------------------
	require_once(DEDEDATA.'/common.inc.php');
	$dbhost=$sqltag['tuijian']['dbhost'];
	$dbuser=$sqltag['tuijian']['dbuser'];
	$dbpass=$sqltag['tuijian']['dbpwd'];
	$dbname=$sqltag['tuijian']['dbname'];
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	
	$data=$db->getone("select * from tuijian where sphone='".$hytel."' ");
	if(!empty($data)){
		showmsg('已经加入过“1+2事业平台”，', '/home/12tuijian/gerenxinxi.php',0,10000);
		exit();
	}else{
		
		$user=$db->getone("select * from tuijian where bianhao='".$guanxi."' ");
		if(!empty($user)){
			$add_time=time();
			$f_bianghao=$user['bianhao'];
			$f_name=$user['name'];
			$pid=$user['id'];
			$path=$user['path'].$user['id'].',';
			$sql=" INSERT INTO tuijian
				(guanxi,bianhao,name,sex,sphone,qq,id_number,address,add_time,f_bianghao,f_name,pid,jibie,path,hujiaozhongxin) VALUES 
				('','".$bianhao."','".$hyname."','".$sex."','".$hytel."','".$hyqqmsn."','".$hycardno."','".$hyaddress."','".$add_time."','".$f_bianghao."','".$f_name."','".$pid."','2','".$path."','1')";
			$id=$db->insetbb($sql);
			if($id > 0){
				showmsg('祝贺你！ 成功加入“1+2事业平台”。', '/home/12tuijian/gerenxinxi.php',0,10000);
				exit();
			}
		}
	}	
	//关闭数据库链接
	$db->close();
}