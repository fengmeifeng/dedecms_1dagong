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
helper('filter');
if($cfg_mb_allowreg=='N')
{
    ShowMsg('系统关闭了新用户注册！', 'index.php');
    exit();
}
if(!isset($dopost)) $dopost = '';
$step = empty($step)? 2 : intval(preg_replace("/[^\d]/", '', $step));
if($step==1){
    $userid=$_POST['shouye'];
    // echo $userid;exit;
    $userid = trim($userid);                        //userid
        $uname = trim($uname);                          //用户名。
        $pwd = trim(substr($userid, -4));               //取手机尾数4号做密码
        $userpwd=$pwdc = trim(substr($userid, -4));     //取手机尾数4号做密码
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
}
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
		//注册代码
		$userid = trim($userid);						//userid
		$uname = trim($uname);							//用户名。
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
		
        if(strlen($userid) > 11 || strlen($uname) > 40)
        {
            ShowMsg('请输入正确的手机号码！', '-1');
            exit();
        }
        //过滤手机号码中，非数字外的非法字符 By Z
        MobileNumValidate($userid);
        if(strlen($userid) < $cfg_mb_idmin || strlen($pwd) < $cfg_mb_pwdmin)
        {
            ShowMsg("你的用户名或密码过短，不允许注册！","-1");
            exit();
        }
        //过滤姓名中的非法字符 By Z
        TextValidate($uname);
        if($pwdc != $pwd)
        {
            ShowMsg('你两次输入的密码不一致！', '-1');
            exit();
        }
        //过滤备用手机号码中，非数字外的非法字符 By Z
        MobileNumValidate($sphone2);
        $uname = HtmlReplace($uname, 1);
        //用户姓名重复检测(此处不合理，去掉)
        /*if($cfg_mb_wnameone=='N')
        {
            $row = $dsql->GetOne("SELECT * FROM `#@__member` WHERE uname LIKE '$uname' ");
            if(is_array($row))
            {
                ShowMsg('用户笔名或公司名称不能重复！', '-1');
                exit();
            }
        }*/
       /* if(!CheckEmail($email))
        {
            ShowMsg('Email格式不正确！', '-1');
            exit();
        }*/
        
		//验证电话号码
		/*switch(strlen($userid)){ 
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
				if(!preg_match('/^1[34587][0-9]{9}$/',$userid)){
					$ts=array(
						"1"=>"您好，您输入的手机号码有误。 电话号码都输错,请重新输入。",
						"2"=>"您好，您输入的手机号码有误，电话号码输入错误，认真输入。",
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
				
				ShowMsg('你是来捣乱的吧！ 号码有你这样的吗？？？', '-1');
				exit();
				break;
		}*/
		
		
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
		//echo $userpwd;exit;
        $pwd = md5($userpwd);
		//echo $pwd;exit;
		//diqu 
		$diqushengtext=$_POST['diqushengtext'];
		$diqushitext=$_POST['diqushitext'];
		$address=$diqushengtext.$diqushitext;
		//echo $address;exit;
		
		$mtype = RemoveXSS(HtmlReplace($mtype,2));
		$safeanswer = HtmlReplace($safeanswer);
		$safequestion = HtmlReplace($safequestion);
        
		//-----------------------------------------------------------------冯
		//短信验证
			/*if($_POST['yz']!='868686'){
				if($_POST['yz']!=$_COOKIE["yzm"]){
					ShowMsg('短信验证码错误！', '-1');
					exit();
				}
			}

			setcookie("yzm", "", time()-1200);		//删除验证码session*/


		//审核会员发布信息时是否需要验证
        //$spaceSta = ($cfg_mb_spacesta < 0 ? $cfg_mb_spacesta : 0);
		
		$spaceSta = 2;
		
        //echo $pwd;exit;
        $inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`uname` ,`sex` ,`sphone`,`qym`,`form`,`nativeplace`,`sphone2`,`rank` ,`money` ,`email` ,`scores` ,
        `matt`, `spacesta` ,`face`,`safequestion`,`safeanswer` ,`jointime` ,`joinip` ,`logintime` ,`loginip` )
       VALUES ('$mtype','$userid','$pwd','$uname','$sex','$userid','$qym','0','0','$sphone2','10','$dfmoney','$email','$dfscores',
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
    
			 //写入默认企业注册表
			 if($mtype=='企业'){
            $membertjquery = "INSERT INTO `#@__member_company` (`mid`,`company`,`linkman`,`mobile`,`address`,`email`,`zhiwei`,`sex`,`nativeplace`)
                   VALUES ('$mid','$qym','$uname','$sphone','$address','$email','$zhiwei','$sex','0')";
            $dsql->ExecuteNoneQuery($membertjquery);
			 }
			 else
			 {
				  $membertjquery = "INSERT INTO `#@__member_person` (`mid`,`mobile`,`address`,`sex`,`syear`,`fullname`,`uname`,`nativeplace`)
                   VALUES ('$mid','$userid','$address','$sex','$syear','$uname','$uname','0')";
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

			//echo $uname."<br>";
			//echo $userid."<br>";
			//echo $address."<br>";
			//echo $sex."<br>";exit;
			//同步数据--curl方法--------------------------------------------------------------------------------------------------------------------------------------------------
			/*
				1: 姓名
				2: 电话号码
				3: 生日
				4：公司
				5：性别
				tel_num ： 电话号码
			*/
			//echo $uname."<br>";echo $userid."<br>";echo $address."<br>";echo $syear."<br>";echo $sex."<br>";exit;
			//$url="http://60.173.200.45:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=2&batch=1&col=field_text_001,field_text_003,field_text_005,field_text_007,field_text_013&info='','".$userid."','','".$qym."',''&tel_num=".$userid."&corp_code=1009";
			$url="http://60.173.200.45:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=2&batch=1&col=field_text_001,field_text_003,field_text_005,field_text_007,field_text_013&info='".$uname."','".$userid."','".$syear."','".$address."','".$sex."'&tel_num=".$userid."&corp_code=1009";			
			$id=scurl($url);		//执行curl操作
			//echo $id;exit;
			if($id != 1){
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
			$duanxineirong="恭喜您成为壹打工网会员，账号为您手机号，初始密码是手机后四位,更多招聘信息详见www.1dagong.com。4001185188【壹打工网】";
			//转码
            // $content=mb_convert_encoding($duanxineirong,"GBK","UTF-8");
            $dx=new duanxin($userid,$duanxineirong);		//申明短信类
			$id=$dx->fs();			//发送短信
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
				ShowMsg("您已成功注册！，请登录.....","index.php",0,1000);
                exit();
            } else {
				if($cfg_ml->IsLogin())
				{
   					 
					//ShowMsg("您以成功注册!请完善发布工作详细信息");
					require_once(DEDEMEMBER."/mystyles/pt_jianli.htm");
   					exit();
				}
				 ShowMsg("您已成功注册！，请登录.....","index.php",0,1000);
				/*require_once(dirname(__FILE__)."/mystyles/login_sj.htm");	*/
                exit;
            } 
        } else {
            ShowMsg("注册失败，请拨打全国免费求职热线400-1185188", "-1");
            exit();
        }
    }
    require_once(DEDEMEMBER."/mystyles/p_register.htm");
}
//--------------------------------------------------------------------
elseif($step==3){ 
	//手机验证
	if($phone!=""){
		setcookie("yzm", "", time()-1200);
		$num=mt_rand(100000,999999);	//获取随机数
		setcookie("yzm", $num, time()+1200);
		$content="您好，您的壹打工网注册验证码为：".$num."。电脑或手机访问www.1dagong.com，随时随地找工作。【壹打工网】";
        // $content=mb_convert_encoding($content,"GBK","UTF-8");
		$dx=new duanxin($phone,$content);		//申明短信类
		$id=$dx->fs();							//发送短信
		if($id==1){
			echo "1";
		}else{
			echo "0";
		}
	}
	
}
else {
    if(!$cfg_ml->IsLogin())
    {
        //ShowMsg("尚未完成基本信息的注册,请返回重新填写！","index_do.php?fmdo=user&dopost=regnew&step=2",0,1000);
		 require_once(DEDEMEMBER."/mystyles/p_register.htm");
        exit;
    } else {
        if($cfg_ml->fields['spacesta'] == 2)
        {
             ShowMsg('所有信息提交成功我们会尽快快与你联系<br/>全国免费求职热线400-1185188', 'index.php');
             exit;
        }
    }
    $membermodel = new membermodel($cfg_ml->M_MbType);
    $postform = $membermodel->getForm(true);
    if($dopost == 'reginfo')
    {
		//-----------------------------------------------------------------冯
		//短信验证
			/*if($_POST['yz']!='868686'){
				if($_POST['yz']!=$_COOKIE["yzm"]){
					ShowMsg('短信验证码错误！', '-1');
					exit();
				}
			}

			setcookie("yzm", "", time()-1200);		//删除验证码session*/

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
    require_once(DEDEMEMBER."/mystyles/p_register.htm");
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


/*--------------------------
手机验证
--------------------------*/
if($dopost=='phone'){
	if($phone!=""){
		$_SESSION['yzm']="";			//清空session
		$num=mt_rand(100000,999999);	//获取随机数
		$_SESSION['yzm']=$num;			//设置session
		$content="您好，您的壹打工网注册验证码为：".$num."。电脑或手机访问www.1dagong.com，随时随地找工作。【壹打工网】";
        // $content=mb_convert_encoding($content, "GBK", "UTF-8" );
		$dx=new duanxin($phone,$content);		//申明短信类
		$id=$dx->fs();							//发送短信
		if($id==1){
			echo "1";
		}else{
			echo "0";
		}
	}
}