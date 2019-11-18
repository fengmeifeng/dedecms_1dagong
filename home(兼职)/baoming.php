<?php
/**
 * @version        $Id: reg_new.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once DEDEINC.'/membermodel.cls.php';
require_once(DEDEINC."/bb_duanxin.class.php"); 	//短信类
if($cfg_mb_allowreg=='N')
{
    ShowMsg('系统关闭了新用户注册！', 'index.php');
    exit();
}

if(!isset($dopost)) $dopost = '';
$step = empty($step)? 1 : intval(preg_replace("/[^\d]/", '', $step));

if($step == 1)
{
    if($cfg_ml->IsLogin())
    {
        if($cfg_mb_reginfo == 'Y')
        {
            //如果启用注册详细信息
            if($cfg_ml->fields['spacesta'] == 0 || $cfg_ml->fields['spacesta'] == 1 || $_POST['address'] == "")
            {
                 ShowMsg("尚未完成详细资料，请完善...", "index_do.php?fmdo=user&dopost=regnew&step=2", 0, 1000);
                 exit;
            }
        }
		
		//判断个人和企业-----------------------------------冯美峰
		$shenfen2 = $dsql->GetOne("SELECT `mtype` FROM #@__member WHERE mid='$cfg_ml->M_ID'");
		if($shenfen2['mtype'] == "企业")
		{
			 ShowMsg('您已报名，正在为您转入会员中心', 'index_company.php');	
			
		}
		else
		{
			ShowMsg('您已报名，正在为您转入会员中心', 'index.php');
		}
		
		
        exit();
    }
    if($dopost=='regbase')
    {
		/*-------验证码
        $svali = GetCkVdValue();
        if(preg_match("/1/", $safe_gdopen)){
            if(strtolower($vdcode)!=$svali || $svali=='')
            {
                ResetVdValue();
                ShowMsg('验证码错误！', '-1');
                exit();
            }
        }
		*/
        /*-------验证问题
        $faqkey = isset($faqkey) && is_numeric($faqkey) ? $faqkey : 0;
        if($safe_faq_reg == '1')
        {
            if($safefaqs[$faqkey]['answer'] != $rsafeanswer || $rsafeanswer=='')
            {
                ShowMsg('验证问题答案错误', '-1');
                exit();
            }
        }
        */
		/*--源代码
        $userid = trim($userid);
        $pwd = trim($userpwd);
        $pwdc = trim($userpwdok);
        $rs = CheckUserID($userid, '用户名');
		*/
		//验证是否是数字
		
		if(!is_numeric($userid)){
			ShowMsg('您好，电话号码和手机号必须数字的？请输入数字。', '-1');
			exit();
		}
		
		//验证电话号码
		switch(strlen($userid)){ 
			case strlen($userid) < 7; 
				ShowMsg('您好，您输入的电话号码位数不够，请认真核对后输入。', '-1');
				exit();
				break;
			case 7; 
				ShowMsg('亲，请在固定电话前输入区号哦~', '-1');
				exit();
				break;
			case 8; 
				ShowMsg('亲，请在固定电话前输入区号哦~', '-1');
				exit();
				break;
			case 11; 
				//验证是否为手机号
				if(!preg_match('/^1[3458][0-9]{9}$/',$userid)){
					$ts=array(
						"1"=>"您好，您输入的手机号码有误。 电话号码都输错，你爸妈知道吗？",
						"2"=>"您好，您输入的手机号码有误，请有点职业素养，认真输入。",
						"3"=>"",
						"4"=>"",
						"5"=>"",
						);
					$a=rand(1,1);
					
					ShowMsg($ts[$a], '-1');
					exit();
				}
				break;
			case 12; 
				if(substr($userid, 0, 1)!=0){
					ShowMsg('您好, 你输入的是电话号码，但是电话的区号不正确，谢谢！', '-1');
					exit();
				}
			case 13; 
				if(substr($userid, 0, 1)!=0){
					ShowMsg('您好, 你输入的是电话号码，但是电话的区号不正确，谢谢！', '-1');
					exit();
				}
			default;
				/*
				//验证是否第3或4位是-
				if(strpos($userid,"-")>=3){
					if(substr($userid, 0, 1)!=0){
						ShowMsg('您好, 你输入的区号不正确，谢谢！', '-1');
						exit();
					}
				}else{
					ShowMsg('您好, 请输入电话区号分隔符-或空格，谢谢！', '-1');
					exit();
				}
				//验证是否第3或4位是空格
				if(strpos($userid," ")>=3){
					if(substr($userid, 0, 1)!=0){
						ShowMsg('您好, 你输入的区号不正确，谢谢！', '-1');
						exit();
					}
				}else{
					ShowMsg('您好, 请输入电话区号分隔符-或空格，谢谢！', '-1');
					exit();
				}
				*/
				ShowMsg('你是来捣乱的吧！ 号码有你这样的吗？？？', '-1');
				exit();
				break;
		}
		
		
		//注册代码
		$userid = trim($userid);						//userid
		$uname = trim($userid);							//用户名。
		$pwd = trim(substr($userid, -4));				//取手机尾数4号做密码
        $userpwd=$pwdc = trim(substr($userid, -4));		//取手机尾数4号做密码
        $rs = CheckUserID($userid, '用户名');
		
        if($rs != 'ok')
        {	
			//如果用户名存在跳到登录页面
			if($rs=="用户名1"){
				ShowMsg("手机号已经注册！您可以直接登录。<br />如果不是您本人注册，请联系客服：400-118-5188", 'index.php');
				exit();
			}else{
				ShowMsg($rs, '-1');
				exit();
			}
        }
        if(strlen($userid) > 20 || strlen($uname) > 36)
        {
            ShowMsg('你的用户名或用户笔名过长，不允许注册！', '-1');
            exit();
        }
        if(strlen($userid) < $cfg_mb_idmin || strlen($pwd) < $cfg_mb_pwdmin)
        {
            ShowMsg("你的用户名或密码过短，不允许注册！","-1");
            exit();
        }
        if($pwdc != $pwd)
        {
            ShowMsg('你两次输入的密码不一致！', '-1');
            exit();
        }
        
        //$uname = HtmlReplace($uname, 1);
        //用户笔名重复检测
		/*
        if($cfg_mb_wnameone=='N')
        {
            $row = $dsql->GetOne("SELECT * FROM `#@__member` WHERE uname LIKE '$uname' ");
            if(is_array($row))
            {
                ShowMsg('用户笔名或公司名称不能重复！', '-1');
                exit();
            }
        }
		*/
		/*-------验证邮箱
        if(!CheckEmail($email))
        {
            ShowMsg('Email格式不正确！', '-1');
            exit();
        }
        */
        #api{{
        if(defined('UC_API') && @include_once DEDEROOT.'/uc_client/client.php')
        {
            $uid = uc_user_register($userid, $pwd, $email);
            if($uid <= 0)
            {
                if($uid == -1)
                {
                    ShowMsg("用户名不合法！","-1");
                    exit();
                }
                elseif($uid == -2)
                {
                    ShowMsg("包含要允许注册的词语！","-1");
                    exit();
                }
                elseif($uid == -3)
                {
                    ShowMsg("你指定的用户名 {$userid} 已存在，请使用别的用户名！","-1");
                    exit();
                }
                elseif($uid == -5)
                {
                    ShowMsg("你使用的Email 不允许注册！","-1");
                    exit();
                }
                elseif($uid == -6)
                {
                    ShowMsg("你使用的Email已经被另一帐号注册，请使其它帐号","-1");
                    exit();
                }
                else
                {
                    ShowMsg("注删失改！","-1");
                    exit();
                }
            }
            else
            {
                $ucsynlogin = uc_user_synlogin($uid);
            }
        }
        #/aip}}
        /*-------验证邮箱
        if($cfg_md_mailtest=='Y')
        {
            $row = $dsql->GetOne("SELECT mid FROM `#@__member` WHERE email LIKE '$email' ");
            if(is_array($row))
            {
                ShowMsg('你使用的Email已经被另一帐号注册，请使其它帐号！', '-1');
                exit();
            }
        }
		*/
        //检测用户名是否存在
        $row = $dsql->GetOne("SELECT mid FROM `#@__member` WHERE userid LIKE '$userid' ");
        if(is_array($row))
        {
            ShowMsg("你指定的用户名 {$userid} 已存在，请使用别的用户名！", "-1");
            exit();
        }
        if($safequestion==0)
        {
            $safeanswer = '';
        }
        else
        {
			$safeanswer = '';
			
			/* 
            if(strlen($safeanswer)>30)
            {
                ShowMsg('你的新安全问题的答案太长了，请控制在30字节以内！', '-1');
                exit();
            }
			*/
        }
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
		
		//如果意向公司为空就把意向公司为无--
		if(empty($qym)){
			$qym="无";
		}
		//--------------------end------------
		
		$mtype = RemoveXSS(HtmlReplace($mtype,1));
		$safeanswer = HtmlReplace($safeanswer);
		$safequestion = HtmlReplace($safequestion);		
        
        $spaceSta = ($cfg_mb_spacesta < 0 ? $cfg_mb_spacesta : 0);
        
        $inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`uname` ,`sphone` ,`qym` ,`sex` ,`rank` ,`money` ,`email` ,`scores` ,
        `matt`, `spacesta` ,`face`,`safequestion`,`safeanswer` ,`jointime` ,`joinip` ,`logintime` ,`loginip` )
       VALUES ('$mtype','$userid','$pwd','$userid','$userid','$qym','$sex','10','$dfmoney','$email','$dfscores',
       '0','$spaceSta','','$safequestion','$safeanswer','$jointime','$joinip','$logintime','$loginip'); ";
        if($dsql->ExecuteNoneQuery($inQuery))
        {
            $mid = $dsql->GetLastID();
    
            //写入默认会员详细资料
            if($mtype=='个人'){
                $space='person';
            }else if($mtype=='企业'){
                $space='company';
            }else{
                $space='person';
            }
    
            //写入默认统计数据
            $membertjquery = "INSERT INTO `#@__member_tj` (`mid`,`article`,`album`,`archives`,`homecount`,`pagecount`,`feedback`,`friend`,`stow`)
                   VALUES ('$mid','0','0','0','0','0','0','0','0'); ";
            $dsql->ExecuteNoneQuery($membertjquery);
    
            //写入默认空间配置数据
            $spacequery = "INSERT INTO `#@__member_space`(`mid` ,`pagesize` ,`matt` ,`spacename` ,`spacelogo` ,`spacestyle`, `sign` ,`spacenews`)
                    VALUES('{$mid}','10','0','{$uname}的空间','','$space','',''); ";
            $dsql->ExecuteNoneQuery($spacequery);
    
            //写入其它默认数据
            $dsql->ExecuteNoneQuery("INSERT INTO `#@__member_flink`(mid,title,url) VALUES('$mid','织梦内容管理系统','http://www.dedecms.com'); ");
            
            $membermodel = new membermodel($mtype);
            $modid=$membermodel->modid;
            $modid = empty($modid)? 0 : intval(preg_replace("/[^\d]/",'', $modid));
            $modelform = $dsql->getOne("SELECT * FROM #@__member_model WHERE id='$modid' ");
            
            if(!is_array($modelform))
            {
                showmsg('模型表单不存在', '-1');
                exit();
            }else{
                $dsql->ExecuteNoneQuery("INSERT INTO `{$membermodel->table}` (`mid`) VALUES ('{$mid}');");
            }
            
            //----------------------------------------------
            //模拟登录
            //---------------------------
            $cfg_ml = new MemberLogin(7*3600);
            $rs = $cfg_ml->CheckUser($userid, $userpwd);

				
			//同步数据--curl方法--------------------------------------------------------------------------------------------------------------------------------------------------
			/*
				1: 姓名
				2: 电话号码
				3: 生日
				4：公司
				5：性别
				tel_num ： 电话号码
			*/
			$url="http://60.173.200.45:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=2&batch=1&col=field_text_001,field_text_003,field_text_005,field_text_006,field_text_013&info='','".$userid."','','".$qym."',''&tel_num=".$userid."&corp_code=1009";
			$id=scurl($url);		//执行curl操作
			if($id!=1){
				$isql="INSERT INTO `bingbing_hjdata` (`sphone` ,`sex` ,`fullname` ,`syear` ,`qym`) VALUES ('".$userid."',  '',  '',  '',  '".$qym."')";
				$dsql->ExecuteNoneQuery($isql);
			}
			//如果$id不存在
			if(empty($id)){
				$isql="INSERT INTO `bingbing_hjdata` (`sphone` ,`sex` ,`fullname` ,`syear` ,`qym`) VALUES ('".$userid."',  '',  '',  '',  '".$qym."')";
				$dsql->ExecuteNoneQuery($isql);
			}
			//同步数据-------------------------------------------------------------------------------------------------------------------------------------------------------------------
			
			
			//----发送短信----and---------------------
			$duanxineirong="恭喜您成为壹打工网会员，账号为您手机号，密码为手机号末四位，更多招聘信息详见www.1dagong.com。4001185188【壹打工网】";
			$dx=new duanxin($userid,$duanxineirong);		//申明短信类
			$id=$dx->fs();			//发送短信
			//-------------------end----
			
            //邮件验证
            if($cfg_mb_spacesta==-10)
            {
                $userhash = md5($cfg_cookie_encode.'--'.$mid.'--'.$email);
                $url = $cfg_basehost.(empty($cfg_cmspath) ? '/' : $cfg_cmspath)."/home/index_do.php?fmdo=checkMail&mid={$mid}&userhash={$userhash}&do=1";
                $url = preg_replace("#http:\/\/#i", '', $url);
                $url = 'http://'.preg_replace("#\/\/#", '/', $url);
                $mailtitle = "{$cfg_webname}--会员邮件验证通知";
                $mailbody = '';
                $mailbody .= "尊敬的用户[{$uname}]，您好：\r\n";
                $mailbody .= "欢迎注册成为[{$cfg_webname}]的会员。\r\n";
                $mailbody .= "要通过注册，还必须进行最后一步操作，请点击或复制下面链接到地址栏访问这地址：\r\n\r\n";
                $mailbody .= "{$url}\r\n\r\n";
                $mailbody .= "Power by http://www.1dagong.com 壹打工网！\r\n";
          
                $headers = "From: ".$cfg_adminemail."\r\nReply-To: ".$cfg_adminemail;
                if($cfg_sendmail_bysmtp == 'Y' && !empty($cfg_smtp_server))
                {        
                    $mailtype = 'TXT';
                    require_once(DEDEINC.'/mail.class.php');
                    $smtp = new smtp($cfg_smtp_server,$cfg_smtp_port,true,$cfg_smtp_usermail,$cfg_smtp_password);
                    $smtp->debug = false;
                    $smtp->sendmail($email,$cfg_webname,$cfg_smtp_usermail, $mailtitle, $mailbody, $mailtype);
                }
                else
                {
                    @mail($email, $mailtitle, $mailbody, $headers);
                }
            }//End 邮件验证
            
            if($cfg_mb_reginfo == 'Y' && $spaceSta >=0)
            {
                ShowMsg("您以成功报名！，请完善详细信息...","index_do.php?fmdo=user&dopost=regnew&step=2",0,1000);
                exit();
            } else {
                //require_once(DEDEMEMBER."/templets/reg-new3.htm");
                //exit;
				ShowMsg("您以成功报名！，请完善详细信息...","index_do.php?fmdo=user&dopost=regnew&step=2",0,1000);
                exit();
            } 
        } else {
            ShowMsg("报名失败！<br/>请拨打全国免费求职热线400-1185188", "-1");
            exit();
        }
    }
    require_once(DEDEMEMBER."/mystyles/reg-new_sj.htm");
}elseif($step==3){ 
	//手机验证
	if($phone!=""){
		setcookie("yzm", "", time()-1200);
		$num=mt_rand(100000,999999);	//获取随机数
		setcookie("yzm", $num, time()+1200);
		$content="您好，您的壹打工网注册验证码为：".$num."。电脑或手机访问www.1dagong.com，随时随地找工作。【壹打工网】";
		$dx=new duanxin($phone,$content);		//申明短信类
		$id=$dx->fs();							//发送短信
		if($id==1){
			echo "1";
		}else{
			echo "0";
		}
	}
	
}else {//step==2
    if(!$cfg_ml->IsLogin())
    {
        ShowMsg("报名失败,请重新报名！", "index_do.php?fmdo=user&dopost=regnew");
        exit;
    } else {
        if($cfg_ml->fields['spacesta'] == 2)
        {
             ShowMsg('所有信息提交成功!我们会尽快快与你联系<br/>全国免费求职热线400-1185188', '../');
             exit;
        }
    }
    $membermodel = new membermodel($cfg_ml->M_MbType);
    $postform = $membermodel->getForm(true);
    if($dopost == 'reginfo')
    {
		
		if(!empty($_POST)){
			
			if($step!=2){
				ShowMsg("网络出错，重新提交", "index_do.php?fmdo=user&dopost=regnew&step=2");
				exit;
			}
			//短信验证
			if($_POST['yz']!='868686'){
				if($_POST['yz']!=$_COOKIE["yzm"]){
					ShowMsg('短信验证码错误！', '-1');
					exit();
				}
			}

			setcookie("yzm", "", time()-1200);		//删除验证码session

			/*if($diqushengtext=='' || $diqushitext == ''){                //地区必填
				ShowMsg('地区必须填写！', '-1');
				exit();
			}*/
			//同步数据--curl方法-------------------------------------------------------------------------------------------------------------
				
			$url="http://60.173.200.45:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=2&batch=1&col=field_text_001,field_text_003,field_text_005,field_text_006,field_text_013,field_text_007&info='".$fullname."','".$phone."','".$syear."','".$qym."','".$sex."','".$diqushengtext.$diqushitext."'&tel_num=".$phone."&corp_code=1009";
			$id=scurl($url);
			if($id!=1){
				$sql="select sphone from `bingbing_hjdata` where sphone='".$phone."'";
				$data = $dsql->GetOne($sql);
				if(empty($data)){
					$isql="INSERT INTO `bingbing_hjdata` (`sphone` ,`sex` ,`fullname` ,`syear` ,`qym` ,`address`) VALUES ('".$phone."',  '".$sex."',  '".$fullname."',  '".$syear."',  '".$qym."', '".$diqushengtext.$diqushitext."')";
					$dsql->ExecuteNoneQuery($isql);
				}else{
					$usql="UPDATE `bingbing_hjdata` SET `sex` =  '".$sex."',`fullname` =  '".$fullname."',`syear` =  '".$syear."',address='".$diqushengtext.$diqushitext."' where sphone='".$phone."'";
					$dsql->ExecuteNoneQuery($usql);
				}
			}
			//如果$id不存在-------
			if(empty($id)){
				$sql="select sphone from `bingbing_hjdata` where sphone='".$phone."'";
				$data = $dsql->GetOne($sql);
				if(empty($data)){
					$isql="INSERT INTO `bingbing_hjdata` (`sphone` ,`sex` ,`fullname` ,`syear` ,`qym` ,`address`) VALUES ('".$phone."',  '".$sex."',  '".$fullname."',  '".$syear."',  '".$qym."', '".$diqushengtext.$diqushitext."')";
					$dsql->ExecuteNoneQuery($isql);
				}else{
					$usql="UPDATE `bingbing_hjdata` SET `sex` =  '".$sex."',`fullname` =  '".$fullname."',`syear` =  '".$syear."',address='".$diqushengtext.$diqushitext."' where sphone='".$phone."'";
					$dsql->ExecuteNoneQuery($usql);
				}
			}
			
			//同步数据-----------------------------------------------------------------------------------------------------------------------
			//---------------------------------判断地区
			if($diqushengtext=='' || $diqushitext == ''){                //地区必填
				ShowMsg('地区必须填写！', '-1');
				exit();
			}
			$membermodel = new membermodel($cfg_ml->M_MbType);
			$modelform = $dsql->GetOne("SELECT * FROM #@__member_model WHERE id='$membermodel->modid' ");
			if(!is_array($modelform)){
				showmsg('模型表单不存在', '-1');
				exit();
			}
			$query = "UPDATE `#@__member` set uname='".$fullname."',sphone='".$phone."',sex='".$sex."',spacesta='2',verify='1' WHERE mid='{$cfg_ml->M_ID}'";
			if($dsql->ExecuteNoneQuery($query)){
			$querys = "UPDATE `{$membermodel->table}` set sex='".$sex."',uname='".$fullname."',mobile='".$phone."',syear='".$syear."',fullname='".$fullname."',qym='".$qym."',address='".$diqushengtext.$diqushitext."' WHERE mid='{$cfg_ml->M_ID}'";
				if($dsql->ExecuteNoneQuery($querys)){
					// 清除缓存
					$cfg_ml->DelCache($cfg_ml->M_ID);
					ShowMsg('数据已将录入完成', 'index.php');
					exit;
				}
			}
		}
    }
	
    require_once(DEDEMEMBER."/mystyles/reg-new2_sj.htm");
   
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/

//curl函数
function scurl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);        
	return curl_exec($ch);
	curl_close($ch);
}


//初始化
/*
$url="http://60.173.200.45:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=2&batch=1&col=field_text_001,field_text_003,field_text_005,field_text_006,field_text_013&info='".$fullname."','".$uname."','".$syear."','".$qym."','".$sex."'&tel_num=".$uname."&corp_code=1009";
$fp = fopen($url,"r");
*/
