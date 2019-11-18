<?php
/**
 * @version        $Id: edit_fullinfo.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__).'/config.php');
require_once DEDEINC.'/membermodel.cls.php';
require_once(DEDEINC."/userlogin.class.php");
require_once(DEDEINC."/bb_duanxin.class.php"); 	//短信类
require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类
CheckRank(0,0);
yzmima();		//查看当前密码是否为默认的，否则跳到修改密码页面
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
	
  /*  if(!is_array($row))
    {
        showmsg("你访问的记录不存在或未经审核", '-1');
        exit();
    } */
    include('mystyles/a_info.htm');
	
    exit();
}
/*------------------------
function __Save()
------------------------*/
if($dopost=='save'){
	if(!empty($_POST)){
		//短信验证
		if($_POST['yz']!=$_SESSION['yzm']){
			ShowMsg('验证码错误！', '-1');
			exit();
		}
		unset($_SESSION['yzm']);		//删除验证码session
		
		$membermodel = new membermodel($cfg_ml->M_MbType);
		$modelform = $dsql->GetOne("SELECT * FROM #@__member_model WHERE id='$membermodel->modid' ");
		if(!is_array($modelform)){
			showmsg('模型表单不存在', '-1');
			exit();
		}
		
			
		$query = "UPDATE `#@__member` set uname='".$fullname."',sphone='".$phone."',sex='".$sex."', shengfenid='".$shengfenid."', spacesta='2',verify='1' WHERE mid='{$cfg_ml->M_ID}'";
		if($dsql->ExecuteNoneQuery($query)){
			//==-----------------------------
		if($_POST['address'] == ""){
			showmsg('请选择所在地区', '-1');
			exit();
			}
			if($diqushengtext=='' && $diqushitext==''){
				$address=$_POST['address'];
			}else{
				$address=$diqushengtext.$diqushitext;
			}
			
			$querys = "UPDATE `{$membermodel->table}` set sex='".$sex."',syear='".$syear."',fullname='".$fullname."',address='".$address."' WHERE mid='{$cfg_ml->M_ID}'";

			if(!$dsql->ExecuteNoneQuery($querys)){
				ShowMsg("更新附加表 `{$membermodel->table}`  时出错，请联系管理员！","javascript:;");
				exit();
			}else{
				/*------------------------------*/
					require_once(DEDEDATA.'/common.inc.php');		//数据库链接信息
					$dbhost=$sqltag['tuijian']['dbhost'];			//主机
					$dbuser=$sqltag['tuijian']['dbuser'];			//帐号
					$dbpass=$sqltag['tuijian']['dbpwd'];			//密码
					$dbname=$sqltag['tuijian']['dbname'];			//库名
					$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);		//new 数据库类
					$db->update("tuijian","sphone='".$phone."',id_number='".$shengfenid."' ", "`sphone`='".$ylphone."' ");		//修改手机号
				/*------------------------------*/
				
				ShowMsg('成功更新你的详细资料！','index.php',0,5000);
				exit();
			}
		}
	}
}
/*--------------------------
手机验证
--------------------------*/
if($dopost=='phone'){
	if($phone!=""){
		$_SESSION['yzm']="";			//清空session
		$num=mt_rand(100000,999999);	//获取随机数
		$_SESSION['yzm']=$num;			//设置session
		$content="您好，您的壹打工网注册验证码为：".$num."。电脑或手机访问www.1dagong.com，随时随地找工作。【壹打工网】";
		$dx=new duanxin($phone,$content);		//申明短信类
		$id=$dx->fs();							//发送短信
		if($id==1){
			echo "1";
		}else{
			echo "0";
		}
	}
}