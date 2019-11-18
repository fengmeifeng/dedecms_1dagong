<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(DEDEINC."/bb_duanxin.class.php"); 	//短信类
$aid = ( isset($aid) && is_numeric($aid) ) ? $aid : 0;
$job = ( isset($job) && is_numeric($job) ) ? $job : 0;
$c = ( isset($c) && $c )? urldecode($c) : 0;
//echo $aid;exit;
$type=empty($type)? "" : HtmlReplace($type,1);
if($aid==0)
{
	ShowMsg('工作id不能为空!','javascript:window.close();');
	exit();
}

require_once(DEDEINC."/memberlogin.class.php");
$ml = new MemberLogin();

if($ml->M_ID==0)
{
	/*ShowMsg('只有会员才允许投递简历！','javascript:window.close();');*/
	ShowMsg('您不是会员，请登陆或注册个人会员！','/home/');
	exit();
}

//判断个人和企业-----------------------------------------------------------------------------------------------------冯
	$row1 = $dsql->GetOne("SELECT `mtype`,`rank`,`sphone` FROM #@__member WHERE mid='$ml->M_ID'");//----------------feng
	
	if($row1['mtype'] == "企业"){
		
		//ShowMsg('只有个人会员才允许投递简历！','javascript:window.history.back()');exit();
		ShowMsg('您不是个人会员，不允许报名','javascript:window.history.back()');exit();
	
	}else{//----------个人会员
	
	//判断是否发布简历-----------------------------------------------------------------------------------------------------冯
	//echo $ml->M_ID."<br>";
	$row2 = $dsql->GetOne("Select a.id From `#@__archives` as a left join `#@__addjianli82` as b on a.id=b.aid where  a.mid='{$ml->M_ID}'");
	if(!$row2){ShowMsg('请填写完简历在报名！','/home/pt_jianli.php?channelid=82');exit();}
	//print_r($row2);exit;
	//判断是否发布简历-----------------------------------------------------------------------------------------------------冯
	}


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
$person = $dsql->GetOne("SELECT `fullname`,`mid` FROM #@__member_person WHERE mid='".$ml->M_ID."'");//----------------feng
//echo "<pre>";print_r($row2);exit;
if($type==''){
	
	//$row = $dsql->GetOne("Select * From `#@__member_stow` where aid='$aid' And mid='{$ml->M_ID}' AND type='' ");//---峰
	$row = $dsql->GetOne("Select * From `#@__member_stow` where mid='{$ml->M_ID}' and aid='$aid' ");
	//echo "<pre>";print_r($row);exit;
	if(!is_array($row))
	{
		$dsql->ExecuteNoneQuery("INSERT INTO `#@__member_stow`(mid,aid,title,addtime,company_id,company,person,p_aid) VALUES ('".$ml->M_ID."','$aid','".addslashes($arctitle)."','$addtime','$job','$c','".$person['fullname']."','".$row2['id']."'); ");
	}

}else{
	//--------------------------------------------------------------------------------------------------------企业报名
	$row = $dsql->GetOne("Select * From `#@__member_stow` where type='$type' and aid='$aid' and mid='{$ml->M_ID}'");
	//echo !is_array($row);print_r($row);exit;
	if(!is_array($row)){
  	$dsql->ExecuteNoneQuery(" INSERT INTO `#@__member_stow`(mid,aid,title,addtime,type,company_id,company,person,p_aid) VALUES ('".$ml->M_ID."','$aid','$title','$addtime','$type','$job','$title','".$person['fullname']."','".$row2['id']."'); ");
  }
}

//更新用户统计
//$row = $dsql->GetOne("SELECT COUNT(*) AS nums FROM `#@__member_stow` WHERE `mid`='{$ml->M_ID}' ");/-------------------
//print_r($row);exit;
$dsql->ExecuteNoneQuery("UPDATE #@__member_tj SET `stow`='$row[nums]' WHERE `mid`='".$ml->M_ID."'");

if(!is_array($row)){
	ShowMsg('报名成功！','/');
}else{
ShowMsg('您已报名','javascript:window.history.back()');
}

?>