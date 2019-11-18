<?php
/**
 * 文档编辑器
 * 
 * @version        $Id: archives_edit.php 1 13:52 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
$mid = isset($mid) && is_numeric($mid) ? $mid : 0;
$mtype = isset($mtype) && trim($mtype) ? $mtype : '企业';
$menutype = 'config';

/*-------------
function _ShowForm(){  }
--------------*/
if(empty($dopost))
{
    //读取归档信息
   $equery = "SELECT m.mid,m.jointime,m.uname,m.sphone,m.sphone2,c.*,m.spacesta FROM `#@__member` as  m
               LEFT JOIN `#@__member_company` as c  ON m.mid=c.mid WHERE m.mid='$mid'; ";
	
    $row = $dsql->GetOne($equery);
	//print_r($row);exit;
    //$row = $dsql->GetOne("SELECT * FROM `#@__member_company` WHERE mid='$mid'; ");
	//echo "<pre>";print_r($row);exit;
   
    include(DEDEMEMBER."/mystyles/sh_edit_c.htm");
    exit();
}

/*------------------------------
function _SaveArticle(){  }
------------------------------*/

else if($dopost=='save')
{
	
	//echo $sphone."<br>";echo $mobile."<br>";exit;
   //include(dirname(__FILE__).'/inc/archives_check.php');
	//--------------------------冯
	//处理上传的缩略图
	$comface = MemberUploads('comface', '', $cfg_ml->M_ID, 'image', '', $cfg_ddimg_width, $cfg_ddimg_height, FALSE);
	if($comface!='') SaveUploadInfo($title,$comface,1);
	
	if(!empty($_POST)){

		/*$membermodel = new membermodel($cfg_ml->M_MbType);echo $cfg_ml->M_MbType;exit;
		$modelform = $dsql->GetOne("SELECT * FROM #@__member_model WHERE id='$membermodel->modid' ");
		if(!is_array($modelform)){
			showmsg('模型表单不存在', '-1');
			exit();
		}*/
		
		//echo $phone;echo $comface;exit; 
		//--------------------spacesta='2'-------------------------------------------------------------
		$query = "UPDATE `#@__member` set uname='".$linkman."',sphone='".$sphone."',sphone2='".$mobile."',sex='".$sex."', shengfenid='".$shengfenid."',verify='1',xiaoshou='".$xiaoshou."',nativeplace='".$nativeplace."' WHERE mid='$mid'";
		//echo $query;exit;
		if($dsql->ExecuteNoneQuery($query)){

			/*if($diqushengtext=='' && $diqushitext==''){
				$address=$_POST['address'];
			}else{
				$address=$diqushengtext.$diqushitext;
			}*/

			//-----------------------------------冯
			//处理图片文档的自定义属性
			if($litpic!='') $flag = 'p';
			//------------------------同步修改公司名称-冯------------------------------------------
			//$dsql->ExecuteNoneQuery("UPDATE `#@__addgongzuo81` set gzname='".$company."' WHERE mid='$mid'");
			$dsql->ExecuteNoneQuery("UPDATE `#@__archives` set writer='".$company."' WHERE mid='$mid'");
			$dsql->ExecuteNoneQuery("UPDATE `#@__member_stow` set company='".$company."' WHERE company_id='$mid'");
			//-----------------------------------------------------------------------------------
			
			$querys = "UPDATE `#@__member_company` set sex='".$sex."',linkman='".$linkman."',email='".$email."',zhiwei='".$zhiwei."',company='".$company."',mobile='".$mobile."',nativeplace='".$nativeplace."',comface='".$comface."',xiaoshou='".$xiaoshou."',vocation='".$vocation."',cosize='".$cosize."',address='".$address."',introduce='".$introduce."',gsxingzhi='".$gsxingzhi."' WHERE mid='$mid'";
			//echo $querys;exit;
			if(!$dsql->ExecuteNoneQuery($querys)){
				ShowMsg("更新附加表 `#@__member_company`  时出错，请联系管理员！","javascript:;");
				exit();
			}else{
				
				ShowMsg('成功更新详细资料！','sh_company.php?channelid=81',0,5000);
				exit();
			}
		}
	}
}
