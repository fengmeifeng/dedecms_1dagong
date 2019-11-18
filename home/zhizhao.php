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
require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类
CheckRank(0,0);
yzmima();		//查看当前密码是否为默认的，否则跳到修改密码页面
require_once(DEDEINC.'/enums.func.php');
//-------------------------------------------------------------------------冯
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
//-----------------------------------------------------------------------------

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

	$row = $dsql->GetOne("SELECT spacesta FROM #@__member WHERE mid=$cfg_ml->M_ID");//---会员的信息
    $row_company = $dsql->GetOne("SELECT * FROM ".$modelform['table']." WHERE mid=$cfg_ml->M_ID");//---企业会员的信息
	$row_zhizhao = $dsql->GetOne("SELECT * FROM #@__diyzhizhao WHERE mid='$cfg_ml->M_ID' ");//------营业执照的信息
	//echo $row['spacesta'];echo "<pre>";print_r($row);echo "<pre>";print_r($row_zhizhao);exit;
  /*  if(!is_array($row))
    {
        showmsg("你访问的记录不存在或未经审核", '-1');
        exit();
    } */

	if(!is_array($row_zhizhao) && $row['spacesta'] == '-1'){include('mystyles/a_zhizhao.htm');exit();}
	elseif($row['spacesta'] == '-1'){include('mystyles/lb_zhizhao.htm');exit();}
	else{include('mystyles/row_zhizhao.htm');exit();}
	
}
/*------------------------
function __Save()
------------------------*/
if($dopost=='save'){
	
	//---------------------------------------峰
	//处理上传的缩略图
	//$zhizhao = MemberUploads('zhizhao', '', $cfg_ml->M_ID, 'image', '', $cfg_ddimg_width, $cfg_ddimg_height, FALSE);
	$zhizhao = MemberUploads('zhizhao', '', $cfg_ml->M_ID, 'image', '', '', '', FALSE);	
	if($zhizhao!='') SaveUploadInfo($title,$zhizhao,1);
	//echo $zhizhao;exit;
	if(!empty($_POST)){
		
		$membermodel = new membermodel($cfg_ml->M_MbType);
		$modelform = $dsql->GetOne("SELECT * FROM #@__member_model WHERE id='$membermodel->modid' ");
		if(!is_array($modelform)){
			showmsg('模型表单不存在', '-1');
			exit();
		}
		
			//echo $zhizhao;echo $cfg_ml->M_ID;exit;
		$row_zhizhao = $dsql->GetOne("SELECT * FROM #@__diyzhizhao WHERE mid='$cfg_ml->M_ID' ");
		if($row_zhizhao){
			$query = "UPDATE `#@__diyzhizhao` set zhizhao='".$zhizhao."' where mid='$cfg_ml->M_ID'";
				if($dsql->ExecuteNoneQuery($query)){
					ShowMsg('修改成功！','zhizhao.php',0,5000);
					exit();
					}else{
						ShowMsg('修改失败！','zhizhao.php',0,5000);
						exit();
						}
			}else{
				//echo "34343";exit;
			$query = "INSERT INTO `#@__diyzhizhao` set mid='".$cfg_ml->M_ID."',zhizhao='".$zhizhao."' ";
			if($dsql->ExecuteNoneQuery($query)){
			
				ShowMsg('上传成功！','zhizhao.php',0,5000);
				exit();	
				}else{
					ShowMsg('上传失败！','zhizhao.php',0,5000);
				exit();	
					}
		
		
			
		}
	}
}

