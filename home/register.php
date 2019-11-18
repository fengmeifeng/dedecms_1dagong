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
$step = empty($step)? 2 : intval(preg_replace("/[^\d]/", '', $step));

if($step == 2)
{
    if($cfg_ml->IsLogin())
    {
        if($cfg_mb_reginfo == 'Y')
        {
            //如果启用注册详细信息
            if($cfg_ml->fields['spacesta'] == 0 || $cfg_ml->fields['spacesta'] == 1)
            {
                 ShowMsg("尚未完成详细资料，请完善...", "index_do.php?fmdo=user&dopost=regnew1&step=2", 0, 1000);
                 exit;
            }
        }
        ShowMsg('你已经登陆系统，无需重新注册！', 'index_company.php');
        exit();
    }
    if($dopost=='regbase')
    {
		//echo '1';exit;
       /* $svali = GetCkVdValue();
        if(preg_match("/1/", $safe_gdopen)){
            if(strtolower($vdcode)!=$svali || $svali=='')
            {
                ResetVdValue();
                ShowMsg('验证码错误！', '-1');
                exit();
            }
        }
        
        $faqkey = isset($faqkey) && is_numeric($faqkey) ? $faqkey : 0;
        if($safe_faq_reg == '1')
        {
            if($safefaqs[$faqkey]['answer'] != $rsafeanswer || $rsafeanswer=='')
            {
                ShowMsg('验证问题答案错误', '-1');
                exit();
            }
        }
        
        $userid = trim($userid);
        $pwd = trim($userpwd);
        $pwdc = trim($userpwdok);
        $rs = CheckUserID($userid, '用户名');
        if($rs != 'ok')
        {
            ShowMsg($rs, '-1');
            exit();
        }*/

         //‘用户名’或者‘联系人姓名’超过15则不允许注册 By Z
        if(strlen($userid) > 25)
        {
            ShowMsg('您输入的用户名过长，请使用25个字符以内的数字、字母、下划线组成的用户名！', '-1');
            exit();
        }
        //用户名不允许包含脚本中的字符
        if(preg_match('/[^\w]/', $userid)){
            ShowMsg('您输入的用户名包含非法字符，请使用15个字符以内的数字、字母、下划线组成的用户名！', '-1');
            exit();
        }
        if(preg_match('/[\<\?\>\;\$\{\}]/', $qym)){
            ShowMsg('您输入的公司名包含非法字符，请正确输入公司名！', '-1');
            exit();
        }
        if(strlen($uname) > 15)
        {
            ShowMsg('您输入的联系人姓名过长！', '-1');
            exit();
        }
        if(preg_match('/[\<\?\>\;\$\{\}]/', $uname)){
            ShowMsg('您输入的联系人姓名包含非法字符，请正确输入联系人姓名！', '-1');
            exit();
        }
        if(strlen($userid) < 4 || strlen($pwd) < 6)
        {
            ShowMsg("你的用户名或密码过短，不允许注册！","-1");
            exit();
        }
        if(strlen($pwd)>32){
            ShowMsg("请使用32位以内的密码","-1");
            exit();
        }
        if($pwdc != $pwd)
        {
            ShowMsg('你两次输入的密码不一致！', '-1');
            exit();
        }
        if(preg_match('/[\<\?\>\;\$\{\}]/', $xiaoshou)){
            ShowMsg('您输入的客户经理名包含非法字符，请正确输入客户经理名！', '-1');
            exit();
        }
        $uname = HtmlReplace($uname, 1);
        //用户笔名重复检测（不合理）
        /*if($cfg_mb_wnameone=='N')
        {
            $row = $dsql->GetOne("SELECT * FROM `#@__member` WHERE uname LIKE '$uname' ");
            if(is_array($row))
            {
                ShowMsg('用户笔名或公司名称不能重复！', '-1');
                exit();
            }
        }*/
        if(isset($qym)){
            $row=$dsql->GetOne("select qym from `#@__member` where qym ='$qym'");
			$row_c=$dsql->GetOne("select company from `#@__member_company` where company ='$qym'");
            if(is_array($row) || is_array($row_c)){
                ShowMsg('这个公司名称已经被注册！','-1');
                exit();
        }
        }else{
            ShowMsg('请填写公司名称！','-1');
            exit();
        }        
		//echo '3';exit;
        //邮箱非必填，此处不验证
        /*if(!CheckEmail($email))
        {
            ShowMsg('Email格式不正确！', '-1');
            exit();
        }*/
        //echo '4';exit;
		//验证电话号码(不合理的验证逻辑，有待完善)
		/*switch(strlen($sphone)){ 
			case strlen($sphone) < 7; 
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
				if(!preg_match('/^1[34578][0-9]{9}$/',$sphone)){
					$ts=array(
						"1"=>"您好，您输入的手机号码有误。 ",
						"2"=>"您好，您输入的手机号码有误。",
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
				if(substr($sphone, 0, 1)!=0){
					ShowMsg('您好, 你输入的是电话号码，但是电话的区号不正确，谢谢！', '-1');
					exit();
				}
			case 13; 
				if(substr($sphone, 0, 1)!=0){
					ShowMsg('您好, 你输入的是电话号码，但是电话的区号不正确，谢谢！', '-1');
					exit();
				}
			default;
				//验证是否第3或4位是-
				if(strpos($sphone,"-")>=3){
					if(substr($sphone, 0, 1)!=0){
						ShowMsg('您好, 你输入的区号不正确，谢谢！', '-1');
						exit();
					}
				}else{
					//ShowMsg('您好, 请输入电话区号分隔符-或空格，谢谢！', '-1');
					//exit();
				}*/
				//验证是否第3或4位是空格
				/*if(strpos($sphone," ")>=3){
					if(substr($sphone, 0, 1)!=0){
						ShowMsg('您好, 你输入的区号不正确，谢谢！', '-1');
						exit();
					}
				}else{
					ShowMsg('您好, 请输入电话区号分隔符-或空格，谢谢！', '-1');
					exit();
				}
				ShowMsg('你是来捣乱的吧！ 号码有你这样的吗？？？', '-1');
				exit();
				break;
		}
		*/
		//echo '2';exit;
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
                /*elseif($uid == -5)
                {
                    ShowMsg("你使用的Email 不允许注册！","-1");
                    exit();
                }
                elseif($uid == -6)
                {
                    ShowMsg("你使用的Email已经被另一帐号注册，请使其它帐号","-1");
                    exit();
                }*/
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
        
        if($cfg_md_mailtest=='Y')
        {
            $row = $dsql->GetOne("SELECT mid FROM `#@__member` WHERE email LIKE '$email' ");
            if(is_array($row))
            {
                ShowMsg('你使用的Email已经被另一帐号注册，请使其它帐号！', '-1');
                exit();
            }
        }
    
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
            if(strlen($safeanswer)>30)
            {
                ShowMsg('你的新安全问题的答案太长了，请控制在30字节以内！', '-1');
                exit();
            }
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
        $pwd = md5($pwd);
		//echo $pwd;exit;
		//diqu 
		/*$diqushengtext=$_POST['diqushengtext'];
		$diqushitext=$_POST['diqushitext'];
		$address=$diqushengtext.$diqushitext;*/
		//echo $address;exit;
		
		$mtype = RemoveXSS(HtmlReplace($mtype,2));
		$safeanswer = HtmlReplace($safeanswer);
		$safequestion = HtmlReplace($safequestion);
     
		//审核会员发布信息时是否需要验证
        //$spaceSta = ($cfg_mb_spacesta < 0 ? $cfg_mb_spacesta : 0);
		//--------------------------------------------------------------------冯
		//$spaceSta = 2;
		$spaceSta = -1;
		//-----------------------------------------------------fff判断地区是否为空
		if(empty($nativeplace)){echo "<script language='javascript' type='text/javascript'>alert('请选择企业所在地!');window.history.back(-1);</script>";exit;}
        
        $inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`uname` ,`sex` ,`sphone`,`sphone2`,`qym`,`nativeplace`,`xiaoshou`,`rank` ,`money` ,`email` ,`scores` ,
        `matt`, `spacesta` ,`face`,`safequestion`,`safeanswer` ,`jointime` ,`joinip` ,`logintime` ,`loginip` )
       VALUES ('$mtype','$userid','$pwd','$uname','$sex','$sphone','$mobile','$qym','$nativeplace','$xiaoshou','10','$dfmoney','$email','$dfscores',
       '0','$spaceSta','','$safequestion','$safeanswer','$jointime','$joinip','$logintime','$loginip'); ";
	    // echo $mtype;echo $email;echo $inQuery;exit;
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
    
			 //写入默认企业注册表
			 if($mtype=='企业'){
            $membertjquery = "INSERT INTO `#@__member_company` (`mid`,`company`,`linkman`,`mobile`,`nativeplace`,`email`,`zhiwei`,`sex`,`xiaoshou`)
                   VALUES ('$mid','$qym','$uname','$mobile','$nativeplace','$email','$zhiwei','$sex','$xiaoshou')";
            $dsql->ExecuteNoneQuery($membertjquery);
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
            $rs = $cfg_ml->CheckUser($userid, $pwd);


			//同步数据--curl方法--------------------------------------------------------------------------------------------------------------------------------------------------
			/*
				1: 姓名
				2: 电话号码
				3: 生日
				4：公司
				5：性别
				tel_num ： 电话号码
			*/
			
			/*$url="http://60.173.200.45:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=2&batch=1&col=field_text_001,field_text_003,field_text_005,field_text_006,field_text_013&info='','".$userid."','','".$qym."',''&tel_num=".$userid."&corp_code=1009";
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
			*/
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
            }elseif(substr($sphone,0,1)=='1'){
                // echo '111==='.$sphone;exit;
    			$content="欢迎您加入壹打工网，请立即登录www.1dagong.com发布职位。企业合作请拨打：4001185188【壹打工网】";
    			// $content=mb_convert_encoding($content,"GBK","UTF-8");
                $dx=new duanxin($sphone,$content);		//申明短信类
    			$id=$dx->fs();			//发送短信
            }elseif(substr($mobile,0,1)=='1'){
                // echo '111==='.$sphone;exit;
                $content="欢迎您加入壹打工网，请立即登录www.1dagong.com发布职位。企业合作请拨打：4001185188【壹打工网】";
                // $content=mb_convert_encoding($content,"GBK","UTF-8");
                $dx=new duanxin($mobile,$content);      //申明短信类
                $id=$dx->fs();          //发送短信
            }
			//-------------------end----
            //邮件验证
            if($cfg_mb_spacesta==-10)
            {
                $userhash = md5($cfg_cookie_encode.'--'.$mid.'--'.$email);
                $url = $cfg_basehost.(empty($cfg_cmspath) ? '/' : $cfg_cmspath)."/member/index_do.php?fmdo=checkMail&mid={$mid}&userhash={$userhash}&do=1";
                $url = preg_replace("#http:\/\/#i", '', $url);
                $url = 'http://'.preg_replace("#\/\/#", '/', $url);
                $mailtitle = "{$cfg_webname}--会员邮件验证通知";
                $mailbody = '';
                $mailbody .= "尊敬的用户[{$uname}]，您好：\r\n";
                $mailbody .= "欢迎注册成为[{$cfg_webname}]的会员。\r\n";
                $mailbody .= "要通过注册，还必须进行最后一步操作，请点击或复制下面链接到地址栏访问这地址：\r\n\r\n";
                $mailbody .= "{$url}\r\n\r\n";
                $mailbody .= "Power by http://www.dedecms.com 织梦内容管理系统！\r\n";
          
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
            //echo $cfg_mb_reginfo;echo $spaceSta;exit;
			
            if($cfg_mb_reginfo == 'Y' && $spaceSta >=0)//判断会员时候完善信息
            {
                //ShowMsg("您以成功注册！，请完善详细信息...","index_do.php?fmdo=user&dopost=regnew1&step=2",0,1000);
				ShowMsg("您已成功注册！，请登录.....","index_company.php",0,1000);
                exit();
            } else {
				if($cfg_ml->IsLogin())
				{
   					 
					//ShowMsg("您以成功注册!请完善发布工作详细信息");
					require_once(DEDEMEMBER."/mystyles/pt_job.htm");
   					exit();
				}
				 ShowMsg("您已成功注册！，请登录.....","index_company.php",0,1000);
				/*require_once(dirname(__FILE__)."/mystyles/login_sj.htm");	*/
                exit;
            } 
        } else {
            ShowMsg("注册失败，请拨打全国免费求职热线400-1185188", "-1");
            exit();
        }
    }
    require_once(DEDEMEMBER."/mystyles/register.htm");
} else {
    if(!$cfg_ml->IsLogin())
    {
        ShowMsg("尚未完成基本信息的注册,请返回重新填写！","index_do.php?fmdo=user&dopost=regnew1&step=2",0,1000);
        exit;
    } else {
        if($cfg_ml->fields['spacesta'] == 2)
        {
             ShowMsg('所有信息提交成功我们会尽快快与你联系<br/>全国免费求职热线400-1185188', 'index_company.php');
             exit;
        }
    }
    $membermodel = new membermodel($cfg_ml->M_MbType);
    $postform = $membermodel->getForm(true);
    if($dopost == 'reginfo')
    {
        //这里完成详细内容填写
        $dede_fields = empty($dede_fields) ? '' : trim($dede_fields);
        $dede_fieldshash = empty($dede_fieldshash) ? '' : trim($dede_fieldshash);
        $modid = empty($modid)? 0 : intval(preg_replace("/[^\d]/",'', $modid));
        
        if(!empty($dede_fields))
        {
            if($dede_fieldshash != md5($dede_fields.$cfg_cookie_encode))
            {
                showMsg('数据校验不对，程序返回', '-1');
                exit();
            }
        }
        $modelform = $dsql->GetOne("SELECT * FROM #@__member_model WHERE id='$modid' ");
        if(!is_array($modelform))
        {
            showmsg('模型表单不存在', '-1');
            exit();
        }
        $inadd_f = '';
        if(!empty($dede_fields))
        {
            $fieldarr = explode(';', $dede_fields);
            if(is_array($fieldarr))
            {
                foreach($fieldarr as $field)
                {
                    if($field == '') continue;
                    $fieldinfo = explode(',', $field);
                    if($fieldinfo[1] == 'textdata')
                    {
                        ${$fieldinfo[0]} = FilterSearch(stripslashes(${$fieldinfo[0]}));
                        ${$fieldinfo[0]} = addslashes(${$fieldinfo[0]});
                    }
                    else
                    {
                        if(empty(${$fieldinfo[0]})) ${$fieldinfo[0]} = '';
                        ${$fieldinfo[0]} = GetFieldValue(${$fieldinfo[0]}, $fieldinfo[1],0,'add','','diy', $fieldinfo[0]);
                    }
                    if($fieldinfo[0]=="birthday") ${$fieldinfo[0]}=GetDateMk(${$fieldinfo[0]});
                    $inadd_f .= ','.$fieldinfo[0]." ='".${$fieldinfo[0]}."' ";
                }
            }

        }
		
  
        $query = "UPDATE `{$membermodel->table}` SET `mid`='{$cfg_ml->M_ID}' $inadd_f WHERE `mid`='{$cfg_ml->M_ID}'; ";
        if($dsql->executenonequery($query))
        {
            $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET `spacesta`='2' WHERE `mid`='{$cfg_ml->M_ID}'");
            // 清除缓存
            $cfg_ml->DelCache($cfg_ml->M_ID);
            require_once(DEDEMEMBER."/templets/reg-new3.htm");
            exit;
        }
    }
    require_once(DEDEMEMBER."/mystyles/register.htm");
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