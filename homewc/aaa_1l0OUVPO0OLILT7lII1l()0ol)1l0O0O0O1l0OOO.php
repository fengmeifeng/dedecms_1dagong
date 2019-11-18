<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");		//dede类


//注册
if($dopost=="regbase" && $step==1){
	//必填项--and--------------
	if(empty($_POST['souji']) || $_POST['souji']==''){
		ShowMsg("手机号未填写！", "-1");
		exit;
	}
	if(empty($_POST['fullname']) || $_POST['fullname']==''){
		ShowMsg("姓名未填写！", "-1");
		exit;
	}
	if(empty($_POST['sex']) || $_POST['sex']==''){
		ShowMsg("姓别未填写！", "-1");
		exit;
	}
	if(empty($_POST['syear']) || $_POST['syear']==''){
		ShowMsg("出生年未填写！", "-1");
		exit;
	}
	if(empty($_POST['diqushengtext']) || $_POST['diqushengtext']==''){
		ShowMsg("所在省未选择！", "-1");
		exit;
	}
	if(empty($_POST['diqushitext']) || $_POST['diqushitext']==''){
		ShowMsg("所在市未选择！", "-1");
		exit;
	}
	//必填项--end----------------
	
	
	//检测用户名是否存在
	$row = $dsql->GetOne("SELECT mid FROM `#@__member` WHERE userid LIKE '$souji' ");
	if(is_array($row))
	{
		ShowMsg("你输入的手机号 {$souji} 已存在！", "-1");
		exit();
	}
	
	//注册代码
		$userid = trim($souji);							//userid
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
			$qym="无";
		}
		//--------------------end------------
		
		$mtype = RemoveXSS(HtmlReplace($mtype,1));
		$safeanswer = HtmlReplace($safeanswer);
		$safequestion = HtmlReplace($safequestion);		
        
        $spaceSta = ($cfg_mb_spacesta < 0 ? $cfg_mb_spacesta : 0);
        
        $inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`uname` ,`sphone` ,`qym` ,`sex` ,`rank` ,`money` ,`email` ,`scores` ,
        `matt`, `spacesta` ,`face`,`safequestion`,`safeanswer` ,`jointime` ,`joinip` ,`logintime` ,`loginip`,`form`)
       VALUES ('$mtype','$userid','$pwd','$userid','$userid','$qym','$sex','10','$dfmoney','$email','$dfscores',
       '0','$spaceSta','','$safequestion','$safeanswer','$jointime','$joinip','$logintime','$loginip','1'); ";
	   
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
            $dsql->ExecuteNoneQuery("INSERT INTO `#@__member_flink` (mid,title,url) VALUES('$mid','织梦内容管理系统','http://www.dedecms.com'); ");   
            $dsql->ExecuteNoneQuery("INSERT INTO `#@__member_person` (`mid`) VALUES ('{$mid}');");
			//会员数据填写数据库
			
			$query = "UPDATE `#@__member` set uname='".$fullname."', sphone2='".$ophone2."', email='".$mail."',spacesta='2',verify='1' WHERE mid='{$mid}'";
			if($dsql->ExecuteNoneQuery($query)){
			$querys = "UPDATE `#@__member_person` set sex='".$sex."',uname='".$fullname."',mobile='".$userid."',syear='".$syear."',fullname='".$fullname."',qym='".$qym."',address='".$diqushengtext.$diqushitext."', qq='".$qq."', weixin='".$weixin."' WHERE mid='{$mid}'";
				if($dsql->ExecuteNoneQuery($querys)){
					// 清除缓存
					ShowMsg('报名完成！', 'http://ruzhi.1dagong.com');
					exit;
				}
			}
			
		}else{
            ShowMsg("操作失败！", "-1");
            exit();
        }
}


require_once(DEDEMEMBER."/mystyles/bb_yiruzhibaoming.htm");

?>