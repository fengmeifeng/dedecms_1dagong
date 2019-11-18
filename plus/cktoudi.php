<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");

$aid = ( isset($aid) && is_numeric($aid) ) ? $aid : 0;
$type=empty($type)? "" : HtmlReplace($type,1);
if($aid==0)
{
	ShowMsg('记录id不能为空!','javascript:window.close();');
	exit();
}

require_once(DEDEINC."/memberlogin.class.php");
$ml = new MemberLogin();

if($ml->M_ID==0)
{
	/*ShowMsg('只有会员才允许投递简历！','javascript:window.close();');*/
	ShowMsg('只有会员才允许投递简历！','/home/');
	exit();
}

//判断个人和企业-----------------------------------------------------------------------------------------------------冯
	$row1 = $dsql->GetOne("SELECT `mtype`,`rank` FROM #@__member WHERE mid='$ml->M_ID'");//----------------feng
	
	if($row1['mtype'] == "企业"){ShowMsg('只有个人会员才允许投递简历！','javascript:window.history.back()');exit();}
//echo $row1['mtype'];exit;
//判断个人和企业-----------------------------------------------------------------------------------------------------冯

//读取文档信息
$arcRow = GetOneArchive($aid);
if($arcRow['aid']=='')
{
	ShowMsg("无法投递未知工作!","javascript:window.close();");
	exit();
}
extract($arcRow, EXTR_SKIP);
$title = HtmlReplace($title,1);
$aid = intval($aid);
$addtime = time();

if($type==''){
	
	
	$row = $dsql->GetOne("Select * From `#@__member_stow` where aid='$aid' And mid='{$ml->M_ID}' AND type='' ");
	//echo "<pre>";print_r($row);exit;
	if(!is_array($row))
	{
		$dsql->ExecuteNoneQuery("INSERT INTO `#@__member_stow`(mid,aid,title,addtime) VALUES ('".$ml->M_ID."','$aid','".addslashes($arctitle)."','$addtime'); ");
  }

}else{
	$row = $dsql->GetOne("Select * From `#@__member_stow` where type='$type' and (aid='$aid' And mid='{$ml->M_ID}')");
  if(!is_array($row)){
  	$dsql->ExecuteNoneQuery(" INSERT INTO `#@__member_stow`(mid,aid,title,addtime,type) VALUES ('".$ml->M_ID."','$aid','$title','$addtime','$type'); ");
  }
}

//更新用户统计
$row = $dsql->GetOne("SELECT COUNT(*) AS nums FROM `#@__member_stow` WHERE `mid`='{$ml->M_ID}' ");
$dsql->ExecuteNoneQuery("UPDATE #@__member_tj SET `stow`='$row[nums]' WHERE `mid`='".$ml->M_ID."'");

ShowMsg('投递成功！','/home/');
?>