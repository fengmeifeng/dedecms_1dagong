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
	
	require_once(DEDEMEMBER."/mystyles/bb_tuijianbaoming.htm");
    exit();
}
//注册
if($dopost=="regbase" && $step==1){
	
	//必填项--and-----------------------------------------
	if(empty($_POST['tuicunid']) || $_POST['tuicunid']==''){
		ShowMsg("自己的id未填写！", "-1");
		exit;
	}
	if(empty($_POST['tuicunname']) || $_POST['tuicunname']==''){
		ShowMsg("自己的姓名未填写！", "-1");
		exit;
	}
	if(empty($_POST['tuicunshouji']) || $_POST['tuicunshouji']==''){
		ShowMsg("自己的手机号未填写！", "-1");
		exit;
	}
	if(empty($_POST['guanxi']) || $_POST['guanxi']=='-1'){
		ShowMsg("与推荐人的关系未选择！", "-1");
		exit;
	}
	if(empty($_POST['souji']) || $_POST['souji']==''){
		ShowMsg("推荐人手机未填写！", "-1");
		exit;
	}
	if(empty($_POST['fullname']) || $_POST['fullname']==''){
		ShowMsg("推荐人姓名未填写！", "-1");
		exit;
	}
	if(empty($_POST['shengfenid']) || $_POST['shengfenid']==''){
		ShowMsg("推存人省份证未填写！", "-1");
		exit;
	}
	//必填项--end-----------------------------------------
	
		//发送数据到呼叫中心--curl方法----and---------------------------------------------------------------------------------------------------------
	/*
		ALTER TABLE  `zjobs_member` ADD  `tuicunid` VARCHAR( 32 ) NOT NULL COMMENT  '推荐人id';
		ALTER TABLE  `zjobs_member` ADD  `tuicunname` VARCHAR( 32 ) NOT NULL COMMENT  '推荐人姓名';
		ALTER TABLE  `zjobs_member` ADD  `tuicunshouji` VARCHAR( 20 ) NOT NULL COMMENT  '推荐人手机号';
		ALTER TABLE  `zjobs_member` ADD  `guanxi` VARCHAR( 8 ) NOT NULL COMMENT  '与推荐人的关系';
		ALTER TABLE  `zjobs_member` ADD  `nianling` VARCHAR( 2 ) NOT NULL COMMENT  '年龄' AFTER  `sphone2`;
		ALTER TABLE  `zjobs_member` ADD  `shengfenid` VARCHAR( 20 ) NOT NULL COMMENT  '身份证号码' AFTER  `nianling`;
		
		   姓名：   001		$fullname
			 qq：	002		$qq
		   年龄：   010		$nianling
		   性别：	013		$sex
		   手机：	003		$souji
		  手机2：	004		$souji2
	 省份证号码：	033		$shengfenid
		   地区：	007		$diqushengtext.$diqushitext
		   备注：	008		
	   就职意向：	009		
	   推存人id：	015		$tuicunid
	  推存人姓名：	016		$tuicunname
	推存人手机号：	017		$tuicunshouji
	  推存人关系：	018		$guanxi
		  所在地：	019
	*/

	$urldata="field_text_001,field_text_002,field_text_003,field_text_004,field_text_007,field_text_010,field_text_013,field_text_015,field_text_016,field_text_017,field_text_018,field_text_033&info='".$fullname."','".$qq."','".$souji."','".$souji2."','".$diqushengtext.$diqushitext."','".$nianling."','".$sex."','".$tuicunid."','".$tuicunname."','".$tuicunshouji."','".$guanxi."','".$shengfenid."'";
	$url="http://60.173.200.45:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=8&batch=21&col=".$urldata."&tel_num=".$souji."&corp_code=1009";
	//echo "<br><br><br><br><br>".$url;
	$id=scurl($url);
	//echo "<br/>返回值：".$id;
	//发送数据到呼叫中心--curl方法---end----------------------------------------------------------------------------------------------------------
	
	
	//保存到1打工数据库-----and-------------------------------------------------
	//检测用户名是否存在
		$row = $dsql->GetOne("SELECT mid FROM `#@__member` WHERE sphone LIKE '$souji' ");
		if(is_array($row)){
			ShowMsg("你推荐的用户已在1打工注册过了！, 你还可以推荐别人.", "-1");
			exit();
		}
		//注册代码
		$userid = trim($souji);						//userid
		$uname = trim($souji);							//用户名。
		$pwd = trim(substr($souji, -4));				//取手机尾数4号做密码
		$userpwd=$pwdc = trim(substr($souji, -4));		//取手机尾数4号做密码
		
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
			$qym="推荐报名";
		}
		
		$mtype = RemoveXSS(HtmlReplace($mtype,1));
		$safeanswer = HtmlReplace($safeanswer);
		$safequestion = HtmlReplace($safequestion);		
		
		$spaceSta = ($cfg_mb_spacesta < 0 ? $cfg_mb_spacesta : 0);
		
		$inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`uname` ,`sphone` ,`qym` ,`sex` ,`rank` ,`money` ,`email` ,`scores` ,
        `matt`, `spacesta` ,`face`,`safequestion`,`safeanswer` ,`jointime` ,`joinip` ,`logintime` ,`loginip`)
       VALUES ('$mtype','$userid','$pwd','$userid','$userid','$qym','$sex','10','$dfmoney','$email','$dfscores',
       '0','$spaceSta','','$safequestion','$safeanswer','$jointime','$joinip','$logintime','$loginip'); ";
		
		if($dsql->ExecuteNoneQuery($inQuery)){
            $mid = $dsql->GetLastID();
            //写入默认会员详细资料
            if($mtype=='个人'){    $space='person';  }else if($mtype=='企业'){    $space='company';    }else{    $space='person';    }
            //写入默认统计数据
            $membertjquery = "INSERT INTO `#@__member_tj` (`mid`,`article`,`album`,`archives`,`homecount`,`pagecount`,`feedback`,`friend`,`stow`) VALUES ('$mid','0','0','0','0','0','0','0','0'); ";
            $dsql->ExecuteNoneQuery($membertjquery);
            //写入默认空间配置数据
            $spacequery = "INSERT INTO `#@__member_space`(`mid` ,`pagesize` ,`matt` ,`spacename` ,`spacelogo` ,`spacestyle`, `sign` ,`spacenews`) VALUES('{$mid}','10','0','{$uname}的空间','','$space','',''); ";
            $dsql->ExecuteNoneQuery($spacequery);
            //写入其它默认数据
            $dsql->ExecuteNoneQuery("INSERT INTO `#@__member_flink` (mid,title,url) VALUES('$mid','织梦内容管理系统','http://www.dedecms.com'); ");   
            $dsql->ExecuteNoneQuery("INSERT INTO `#@__member_person` (`mid`) VALUES ('{$mid}');");
			//会员数据填写数据库
			
			$query = "UPDATE `#@__member` set uname='".$fullname."', sphone2='".$souji2."',spacesta='2',verify='1',tuicunid='".$tuicunid."',tuicunname='".$tuicunname."',tuicunshouji='".$tuicunshouji."',guanxi='".$guanxi."',nianling='".$nianling."',shengfenid='".$shengfenid."' WHERE mid='{$mid}'";
			if($dsql->ExecuteNoneQuery($query)){
			$querys = "UPDATE `#@__member_person` set sex='".$sex."',uname='".$fullname."',mobile='".$userid."',fullname='".$fullname."',qym='".$qym."',address='".$diqushengtext.$diqushitext."', qq='".$qq."' WHERE mid='{$mid}'";
				if($dsql->ExecuteNoneQuery($querys)){
					// 清除缓存
					ShowMsg('报名完成！', 'index.php');
					exit;
				}
			}
			
		}else{
            ShowMsg("操作失败！", "-1");
            exit();
        }
	//保存到1打工数据库-----end-------------------------------------------------
}

//curl函数
function scurl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);        
	return curl_exec($ch);
	curl_close($ch);
}
?>