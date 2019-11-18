<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(DEDEINC."/bb_duanxin.class.php"); 	//短信类
$aid = ( isset($aid) && is_numeric($aid) ) ? $aid : 0;
$job = ( isset($job) && is_numeric($job) ) ? $job : 0;
$c = ( isset($c) && $c )? $c : 0;
//echo $c;exit;
$type=empty($type)? "0" : HtmlReplace($type,1);
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
		ShowMsg('对不起，您不是个人用户，不允许投递简历','javascript:window.history.back()');exit();
	
	}else{//----------个人会员
	
	//判断是否发布简历-----------------------------------------------------------------------------------------------------冯
	//echo $ml->M_ID."<br>";
	$row2 = $dsql->GetOne("Select a.id From `#@__archives` as a left join `#@__addjianli82` as b on a.id=b.aid where  a.mid='{$ml->M_ID}'");
	if(!$row2){ShowMsg('请填写完简历在投递简历！','/home/pt_jianli.php?channelid=82');exit();}
	//print_r($row2);exit;
	//判断是否发布简历-----------------------------------------------------------------------------------------------------冯
	}

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
$person = $dsql->GetOne("SELECT `uname`,`mid` FROM #@__member_person WHERE mid='".$ml->M_ID."'");//----------------feng
//echo "<pre>";print_r($person);exit;
if($type==''){
	
	//$row = $dsql->GetOne("Select * From `#@__member_stow` where aid='$aid' And mid='{$ml->M_ID}' AND type='' ");//---峰
	$row = $dsql->GetOne("Select * From `#@__member_stow` where mid='{$ml->M_ID}' and aid='$aid' ");
	//echo "<pre>";print_r($row);exit;
	if(!is_array($row))
	{
		$dsql->ExecuteNoneQuery("INSERT INTO `#@__member_stow`(mid,aid,title,addtime,company_id,company,person,p_aid) VALUES ('".$ml->M_ID."','$aid','".addslashes($arctitle)."','$addtime','$job','$c','".$person['uname']."','".$row2['id']."'); ");
	}

}else{
	$row = $dsql->GetOne("Select * From `#@__member_stow` where type='$type' and (aid='$aid' And mid='{$ml->M_ID}')");
  if(!is_array($row)){
  	$dsql->ExecuteNoneQuery(" INSERT INTO `#@__member_stow`(mid,aid,title,addtime,type,company_id,company,person,p_aid) VALUES ('".$ml->M_ID."','$aid','$title','$addtime','$type','$job','$c','".$person['uname']."','".$row2['id']."'); ");
  }
}

//更新用户统计
//$row = $dsql->GetOne("SELECT COUNT(*) AS nums FROM `#@__member_stow` WHERE `mid`='{$ml->M_ID}' ");/-------------------
//print_r($row);exit;
$dsql->ExecuteNoneQuery("UPDATE #@__member_tj SET `stow`='$row[nums]' WHERE `mid`='".$ml->M_ID."'");

if(!is_array($row)){
	//当求职者投递简历时用短信通知企业 By Z
	//echo $job;exit;
	$homes = $dsql->GetOne("SELECT `mtype`,`rank`,`sphone`,`sphone2`, FROM #@__member WHERE mid='$job'");
	//echo $homes['sphone'];exit;
	if($homes['mtype'] == '企业'){
			$sphone=$homes['sphone'];
			$mobile=$homes['sphone2'];
		    $sphone_len=strlen($sphone);
            $mobile_len=strlen($mobile);
			//----发送短信----只有当企业用户填写的是手机号码而不是座机的时候发 By Z
            if($sphone_len==11 && $sphone==$mobile){
                if(substr($sphone,0,1)=='1'){
                    // echo '111==='.$sphone;exit;
                    $content="欢迎您加入壹打工网，请立即登录www.1dagong.com发布职位。企业合作请拨打：4001185188【壹打工网】";
                    // $content=mb_convert_encoding($content,"GBK","UTF-8");
                    $dx=new duanxin($sphone,$content);      //申明短信类
                    $id=$dx->fs();          //发送短信
                }
            }elseif($sphone_len==11 && substr($sphone,0,1)=='1'){
                // echo '111==='.$sphone;exit;
    			$content="欢迎您加入壹打工网，请立即登录www.1dagong.com发布职位。企业合作请拨打：4001185188【壹打工网】";
    			// $content=mb_convert_encoding($content,"GBK","UTF-8");
                $dx=new duanxin($sphone,$content);		//申明短信类
    			$id=$dx->fs();			//发送短信
            }elseif($mobile_len==11 && substr($mobile,0,1)=='1'){
                // echo '111==='.$sphone;exit;
                $content="欢迎您加入壹打工网，请立即登录www.1dagong.com发布职位。企业合作请拨打：4001185188【壹打工网】";
                // $content=mb_convert_encoding($content,"GBK","UTF-8");
                $dx=new duanxin($mobile,$content);      //申明短信类
                $id=$dx->fs();          //发送短信
            }
	}

	
	//-------------------end----
	ShowMsg('投递职位成功！','/home/toudi.php?channelid=81');
}else{
ShowMsg('您已投递过该职位','/home/toudi.php?channelid=81');
}

?>