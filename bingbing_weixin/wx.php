<?php
require_once('wx/weixin.class.php');
require_once(dirname(__FILE__)."/../include/common.inc.php");		//dede类
	
	
/*
	$weixin->reply("text",$text);				//回复文本
		
		
	$arr[]=array("图文消息标题","图文消息描述","图片链接","图文消息跳转链接");
	$weixin->reply("news",$arr,array(3,0));		//回复新闻
	
	
	$music=array('title'=>'音乐名','description'=>'音乐介绍','musicurl'=>'音乐链接');
	$this->reply("music",$music);					//回复音乐
	//接收消息
	$wx=$weixin->responseMsg();	//消息的获取
	$wx是一个数组
	$wx{
		//通用---------------
		touser
		fronuser
		totime
		type
		//text----------------
		key 		//接收的文本	
	}
*/
$weixin = new weixin("dagong");   //调用微信类参数为：Token
if( isset($_REQUEST['echostr'])){
	$weixin->valid();			//微信验证。
}elseif(isset($_REQUEST['signature'])){			  
	$wx=$weixin->responseMsg();	//消息的获取
	
	$weixin->session($wx['fronuser']."wx");
	//文本消息
	if($wx['type']=='text'){
	
		//如果存在参加活动这个状态，才录入电话号码
	/*	if(!empty($_SESSION['hdbm'])){
			//如果是电话号码就把这个号码保存到数据库
			if(preg_match('/^1[3458][0-9]{9}$/',$wx['key'])){
				$sel="select * from `zjobs_diyhuodong` where shouji='{$wx['key']}'";
				$sj=$db->getone($sel);
				if(empty($sj)){
					$inQuery = "INSERT INTO  `zjobs_diyhuodong` (`id` ,`ifcheck` ,`shouji`) VALUES (NULL ,  '0',  '{$wx['key']}')";
					if($db->ExecuteNoneQuery($inQuery)){
						$_SESSION['hdbm']='';
						
						/*-----------------------------------------------------------*/
						//报名注册代码
	/*					$userid = trim($wx['key']);							//userid
						$uname = trim($wx['key']);							//用户名。
						$pwd = trim(substr($wx['key'], -4));				//取手机尾数4号做密码
						$userpwd=$pwdc = trim(substr($wx['key'], -4));		//取手机尾数4号做密码
						$row = $dsql->GetOne("SELECT mid FROM `#@__member` WHERE sphone LIKE {$wx['key']} ");
						if(is_array($row)){
							$weixin->reply("text","参与成功！");
							exit();
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
						$mtype='个人';
						//如果意向公司为空就把意向公司为无--
						if(empty($qym)){
							$qym="微信注册";
						}
						//--------------------end------------
						$inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`uname` ,`sphone` ,`qym` ,`sex` ,`rank` ,`money` ,`email` ,`scores` ,
						`matt`, `spacesta` ,`face`,`safequestion`,`safeanswer` ,`jointime` ,`joinip` ,`logintime` ,`loginip` )
					   VALUES ('$mtype','$userid','$pwd','$userid','$userid','$qym','$sex','10','$dfmoney','$email','$dfscores',
					   '0','$spaceSta','','$safequestion','$safeanswer','$jointime','$joinip','$logintime','$loginip'); ";
						if($dsql->ExecuteNoneQuery($inQuery)){
							
							$mid = $dsql->GetLastID();
							//写入默认统计数据
							$membertjquery = "INSERT INTO `#@__member_tj` (`mid`,`article`,`album`,`archives`,`homecount`,`pagecount`,`feedback`,`friend`,`stow`)
								   VALUES ('$mid','0','0','0','0','0','0','0','0'); ";
							$dsql->ExecuteNoneQuery($membertjquery);
					
							//写入默认空间配置数据
							$spacequery = "INSERT INTO `#@__member_space`(`mid` ,`pagesize` ,`matt` ,`spacename` ,`spacelogo` ,`spacestyle`, `sign` ,`spacenews`)
									VALUES('{$mid}','10','0','{$uname}的空间','','person','',''); ";
							$dsql->ExecuteNoneQuery($spacequery);
					
							//写入其它默认数据
							$dsql->ExecuteNoneQuery("INSERT INTO `#@__member_flink`(mid,title,url) VALUES('$mid','织梦内容管理系统','http://www.dedecms.com'); ");
						}
						/*-----------------------------------------------------------------*/
						
						
	/*					$weixin->reply("text","参与成功！");
					}else{
						$weixin->reply("text","参与活动失败，请重新输入！");
					}
				}else{
					$_SESSION['hdbm']='';
					$weixin->reply("text","您已经参与活动，不需要重复参与。");
				}
			}else{
				if($wx['key']==='0'){
					$_SESSION['hdbm']='';
					$weixin->reply("text","返回成功！");
				}else{
					$weixin->reply("text","电话号码输入错误！ 返回请输入0");
				}
			}
		}
		*/
		//如果存在报名这个状态，才录入电话号码
		if($wx['key']=='入场券'||$wx['key']=='电子入场券'||$wx['key']=='人场券'||$wx['key']=='人场卷'||$wx['key']=='入场卷'||$wx['key']=='电子入场卷')
		{
			$sql="SELECT id,title,litpic,shorttitle,description FROM  `zjobs_archives` where id=1271 LIMIT 0 , 1";
			$db->SetQuery($sql);
			$db->Execute();
			$data=array();
			while($arr = $db->GetArray()){
				$data[]=$arr;
			}
			$wxdata=array();
			foreach ($data as $k => $v) {
				$wxdata[$k][]=$v['title'];
				$wxdata[$k][]=$v['shorttitle'];
				$wxdata[$k][]="http://www.1dagong.com".$v['litpic'];
				$wxdata[$k][]=$v['description'];
			}
			$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));		//回复图文消息
		}
		if(!empty($_SESSION['phone'])){
			if(preg_match('/^1[3458][0-9]{9}$/',$wx['key'])){
				/*-----------------------------------------------------------*/
				//报名注册代码
				$userid = trim($wx['key']);							//userid
				$uname = trim($wx['key']);							//用户名。
				$pwd = trim(substr($wx['key'], -4));				//取手机尾数4号做密码
		        $userpwd=$pwdc = trim(substr($wx['key'], -4));		//取手机尾数4号做密码
				$row = $dsql->GetOne("SELECT mid FROM `#@__member` WHERE userid LIKE {$wx['key']} ");
		        if(is_array($row)){
		        	$_SESSION['phone']='';
		            $weixin->reply("text","您填写的手机号已经报名，请登录或致电400-118-8188。");
		            exit();
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
				$mtype='个人';
				//如果意向公司为空就把意向公司为无--
				if(empty($qym)){
					$qym="微信注册";
				}
				//--------------------end------------
		        $inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`uname` ,`sphone` ,`qym` ,`sex` ,`rank` ,`money` ,`email` ,`scores` ,
		        `matt`, `spacesta` ,`face`,`safequestion`,`safeanswer` ,`jointime` ,`joinip` ,`logintime` ,`loginip`,`from`)
		       VALUES ('$mtype','$userid','$pwd','$userid','$userid','$qym','$sex','10','$dfmoney','$email','$dfscores',
		       '0','$spaceSta','','$safequestion','$safeanswer','$jointime','$joinip','$logintime','$loginip','3'); ";
		        if($dsql->ExecuteNoneQuery($inQuery)){
		        	
		        	$mid = $dsql->GetLastID();
					//写入默认统计数据
		            $membertjquery = "INSERT INTO `#@__member_tj` (`mid`,`article`,`album`,`archives`,`homecount`,`pagecount`,`feedback`,`friend`,`stow`)
		                   VALUES ('$mid','0','0','0','0','0','0','0','0'); ";
		            $dsql->ExecuteNoneQuery($membertjquery);
		    
		            //写入默认空间配置数据
		            $spacequery = "INSERT INTO `#@__member_space`(`mid` ,`pagesize` ,`matt` ,`spacename` ,`spacelogo` ,`spacestyle`, `sign` ,`spacenews`)
		                    VALUES('{$mid}','10','0','{$uname}的空间','','person','',''); ";
		            $dsql->ExecuteNoneQuery($spacequery);
		    
		            //写入其它默认数据
		            $dsql->ExecuteNoneQuery("INSERT INTO `#@__member_flink`(mid,title,url) VALUES('$mid','壹打工','http://www.1dagong.com'); ");

					//同步数据--curl方法--------------------------------------------------------------------------------------------------------------------------------------------------
					/*
						1: 姓名
						2: 电话号码
						3: 生日
						4：公司
						5：性别
						tel_num ： 电话号码
					*/
					//------原ip---60.173.200.45-------
					$url="http://60.173.200.172:61500/sdk/infoGetter.ashx?fun=set_cstm_info&templet=2&batch=1&col=field_text_001,field_text_003,field_text_005,field_text_006,field_text_013&info='','".$userid."','','".$qym."',''&tel_num=".$userid."&corp_code=1009";
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
					
					
		            $_SESSION['phone']='';
		            $weixin->reply("text","报名成功，<a href='http://www.1dagong.com/home/index.php'>点击登录</a>完善个人资料，网站客服人员将会与你联系！");
		        }
		        /*-----------------------------------------------------------------*/
				//
			}else{
				if($wx['key']==='0'){
					$_SESSION['phone']='';		
					$weixin->reply("text","返回成功！");
				}else{
					$weixin->reply("text","电话号码输入错误！ \n 返回请输入0");
				}
			}
		}
		//获取帮助信息
		if($wx['key']=='?' || $wx['key']=='？'){
			$weixin->reply("text"," 回复? 显示帮助\n 壹打工网2015全国巡回招聘会正在火热举行中 \n 回复 入场券或电子入场券 得到您的入场券 \n 回复1 查看正在招聘的企业\n 回复报名 报名填简历");
		}
		//查询企业，图文列表显示
		if($wx['key']==='1'){
			$data="回复11 合肥正在招聘的企业\n回复12 芜湖正在招聘的企业\n回复13 上海正在招聘的企业\n回复14 重庆正在招聘的企业\n回复15 湖北正在招聘的企业\n回复16 常熟正在招聘的企业";
			$weixin->reply("text",$data);
		}
		
		if($wx['key']=='11' || $wx['key']=='合肥'){
			$sql="SELECT id,title,litpic,shorttitle FROM  `zjobs_archives` where typeid=2 and arcrank>-1 LIMIT 0 , 10";
			$db->SetQuery($sql);
			$db->Execute();
			$data=array();
			while($arr = $db->GetArray()){
				$data[]=$arr;
			}
			$wxdata=array();
			foreach ($data as $k => $v) {
				$wxdata[$k][]=$v['title'];
				$wxdata[$k][]=$v['shorttitle'];
				$wxdata[$k][]="http://www.1dagong.com".$v['litpic'];
				$wxdata[$k][]="http://www.1dagong.com/plus/view.php?aid=".$v['id'];
			}
			$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));		//回复图文消息
		}
		if($wx['key']=='12' || $wx['key']=='芜湖'){
			$sql="SELECT id,title,litpic,shorttitle FROM  `zjobs_archives` where typeid=3 and arcrank>-1 LIMIT 0 , 10";
			$db->SetQuery($sql);
			$db->Execute();
			$data=array();
			while($arr = $db->GetArray()){
				$data[]=$arr;
			}
			$wxdata=array();
			foreach ($data as $k => $v) {
				$wxdata[$k][]=$v['title'];
				$wxdata[$k][]=$v['shorttitle'];
				$wxdata[$k][]="http://www.1dagong.com".$v['litpic'];
				$wxdata[$k][]="http://www.1dagong.com/plus/view.php?aid=".$v['id'];
			}
			$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));		//回复图文消息
		}
		if($wx['key']=='13' || $wx['key']=='上海'){
			$sql="SELECT id,title,litpic,shorttitle FROM  `zjobs_archives` where typeid=5 and arcrank>-1 LIMIT 0 , 10";
			$db->SetQuery($sql);
			$db->Execute();
			$data=array();
			while($arr = $db->GetArray()){
				$data[]=$arr;
			}
			$wxdata=array();
			foreach ($data as $k => $v) {
				$wxdata[$k][]=$v['title'];
				$wxdata[$k][]=$v['shorttitle'];
				$wxdata[$k][]="http://www.1dagong.com".$v['litpic'];
				$wxdata[$k][]="http://www.1dagong.com/plus/view.php?aid=".$v['id'];
			}
			$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));		//回复图文消息
		}
		if($wx['key']=='14' || $wx['key']=='重庆'){
			$sql="SELECT id,title,litpic,shorttitle FROM  `zjobs_archives` where typeid=7 and arcrank>-1 LIMIT 0 , 10";
			$db->SetQuery($sql);
			$db->Execute();
			$data=array();
			while($arr = $db->GetArray()){
				$data[]=$arr;
			}
			$wxdata=array();
			foreach ($data as $k => $v) {
				$wxdata[$k][]=$v['title'];
				$wxdata[$k][]=$v['shorttitle'];
				$wxdata[$k][]="http://www.1dagong.com".$v['litpic'];
				$wxdata[$k][]="http://www.1dagong.com/plus/view.php?aid=".$v['id'];
			}
			$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));		//回复图文消息
		}
		if($wx['key']=='15' || $wx['key']=='湖北'){
			$sql="SELECT id,title,litpic,shorttitle FROM  `zjobs_archives` where typeid=8 and arcrank>-1 LIMIT 0 , 10";
			$db->SetQuery($sql);
			$db->Execute();
			$data=array();
			while($arr = $db->GetArray()){
				$data[]=$arr;
			}
			$wxdata=array();
			foreach ($data as $k => $v) {
				$wxdata[$k][]=$v['title'];
				$wxdata[$k][]=$v['shorttitle'];
				$wxdata[$k][]="http://www.1dagong.com".$v['litpic'];
				$wxdata[$k][]="http://www.1dagong.com/plus/view.php?aid=".$v['id'];
			}
			$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));		//回复图文消息
		}
		if($wx['key']=='16' || $wx['key']=='常熟'){
			$sql="SELECT id,title,litpic,shorttitle FROM  `zjobs_archives` where typeid=6 and arcrank>-1 LIMIT 0 , 10";
			$db->SetQuery($sql);
			$db->Execute();
			$data=array();
			while($arr = $db->GetArray()){
				$data[]=$arr;
			}
			$wxdata=array();
			foreach ($data as $k => $v) {
				$wxdata[$k][]=$v['title'];
				$wxdata[$k][]=$v['shorttitle'];
				$wxdata[$k][]="http://www.1dagong.com".$v['litpic'];
				$wxdata[$k][]="http://www.1dagong.com/plus/view.php?aid=".$v['id'];
			}
			$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));		//回复图文消息
		}
		
		//报名参加活动
		/*if($wx['key']==='2'){
			$_SESSION['hdbm'] = 'hd';		//写入参加活动这个状态
			$weixin->reply("text","参与精彩星期六 壹起赢大奖，请输入手机号参与活动：");
		}*/
		
		//报名
		if($wx['key']=='报名'){
			$_SESSION['phone'] = 'bm';		//写入参加活动这个状态
			$weixin->reply("text","报名填简历，轻松找工作。请输入您的手机号：");
		}
	}
	
	//事件消息
	if($wx['type']=='event'){
		//订阅微信号
		if($wx['event']=="subscribe"){
			$weixin->reply("text","欢迎订阅“壹打工网”微信。\n 壹打工网2015全国巡回招聘会火热进行中 \n 回复 入场券或电子入场券 即可免费获得电子门票！ \n回复? 显示帮助\n 回复1 查看正在招聘的企业\n 回复报名 报名填简历");
		}
		//退订微信号
		if($wx['event']=="unsubscribe"){
			
		}
		
		//自定义菜单
		if($wx['event']=="CLICK"){
			//接收键值
			switch($wx['eventKey']){
				//推荐工作
				case tuigongzuo:
					$sql="SELECT id,title,litpic,shorttitle FROM  `zjobs_archives` where arcrank>-1 AND channel=66  and  `flag` is not null LIMIT 0 , 10";
					$db->SetQuery($sql);
					$db->Execute();
					$data=array();
					while($arr = $db->GetArray()){
						$data[]=$arr;
					}
					$wxdata=array();
					foreach ($data as $k => $v) {
						$wxdata[$k][]=$v['title'];
						$wxdata[$k][]=$v['shorttitle'];
						$wxdata[$k][]="http://www.1dagong.com".$v['litpic'];
						$wxdata[$k][]="http://www.1dagong.com/plus/view.php?aid=".$v['id'];
					}
					$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));		//回复图文消息
					break;
				//工作一览
				case gongzuoyilan:	
					$data=$db->getone("SELECT id,title,litpic,shorttitle FROM  `zjobs_archives` where id=95");
					$wxdata[$k][]=$data['title'];
					$wxdata[$k][]=$data['shorttitle'];
					$wxdata[$k][]="http://www.1dagong.com".$data['litpic'];
					$wxdata[$k][]="http://www.1dagong.com/gongzuo/";
					$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));		//回复图文消息
					break;
				//免费求职热线
				case qiuzhirexian:	
					$weixin->reply("text","全国免费求职热线(点击即可拨打)：\n 400-118-5188");
					break;
				//微信报名
				case hefeilianbao:	
					$_SESSION['phone'] = 'bm';		//写入参加活动这个状态
					$weixin->reply("text","报名填简历，轻松找工作。请输入您的手机号：");
					break;
				//往期消息
				case baoming:	
					$weixin->reply("text",'<a href="http://www.1dagong.com/yidagong-weixin/">点击阅读往期消息</a> ');
					break;
				//我要投稿
				case woyaotougao:	
					$weixin->reply("text",'<a href="http://www.1dagong.com/zhengwen/">征文比赛</a> ');
					break;
				//每日一笑
				case ruchangquan:	
				$sql="SELECT id,title,litpic,shorttitle,description FROM  `zjobs_archives` where id=1271 LIMIT 0 , 1";
			$db->SetQuery($sql);
			$db->Execute();
			$data=array();
			while($arr = $db->GetArray()){
				$data[]=$arr;
			}
			$wxdata=array();
			foreach ($data as $k => $v) {
				$wxdata[$k][]=$v['title'];
				$wxdata[$k][]=$v['shorttitle'];
				$wxdata[$k][]="http://www.1dagong.com".$v['litpic'];
				$wxdata[$k][]=$v['description'];
			}
			$weixin->reply("news",$wxdata,array(sizeof($wxdata),0));	
				
					break;
				//默认无
				default:
					break;
			}
		}
	}	

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