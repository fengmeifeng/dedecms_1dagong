<?php
	require_once(dirname(__FILE__)."/../config.php");
	require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类
	require_once(DEDEINC."/bb_duanxin.class.php"); 	//短信类
	CheckRank(0,0);		//查看是否登录
	yzmima();			//查看当前密码是否为默认的，否则跳到修改密码页面
	//----------------------------------------------------
	require_once(DEDEDATA.'/common.inc.php');		//数据库链接信息
	$dbhost=$sqltag['tuijian']['dbhost'];			//主机
	$dbuser=$sqltag['tuijian']['dbuser'];			//帐号
	$dbpass=$sqltag['tuijian']['dbpwd'];			//密码
	$dbname=$sqltag['tuijian']['dbname'];			//库名
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);		//new 数据库类
	$user=$db->getone("select * from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");			//查询数据库
	
if(!isset($dopost)) $dopost = '';

if($dopost=='')
{

	if(!empty($user)){
	
		if($user['status']!='1' && $user['status']!='3'){
			showmsg("您还未入职，不可以推荐", '/home/12tuijian/gerenxinxi.php');
			exit();
		}
		require_once(dirname(__FILE__)."/style/addtuijian.htm");
		exit();
		
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}
	
//保存数据	
}elseif($dopost=='save'){

	if(!empty($user)){
		
		//确定修改的是否为本人
		if(strval($user['sphone'])==strval($cfg_ml->fields['sphone'])){
		
			//防止用户不填-------------------------
			if($guanxi==''){
				showmsg('推荐的关系未选择', '-1');
				 exit();
			}
			if($name==''){
				showmsg('姓名未填写！', '-1');
				 exit();
			}
			if($sphone==''){
				showmsg('联系电话未填写！', '-1');
				 exit();
			}
			if($id_number==''){
				showmsg('身份证号码未填写！', '-1');
				exit();
			}
			
			//----------------------------------------------
			switch(strlen($sphone)){ 
				case strlen($sphone) < 7: 
					ShowMsg('您好，您输入的电话号码位数不够，请认真核对后输入。', '-1');
					exit();
					break;
				case 7: 
					ShowMsg('亲，请在固定电话前输入区号哦~', '-1');
					exit();
					break;
				case 8: 
					ShowMsg('亲，请在固定电话前输入区号哦~', '-1');
					exit();
					break;
				case 11: 
					//验证是否为手机号
					if(!preg_match('/^1[3458][0-9]{9}$/',$sphone)){
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
				case 12: 
					if(substr($sphone, 0, 1)!=0){
						ShowMsg('您好, 你输入的是电话号码，但是电话的区号不正确，谢谢！', '-1');
						exit();
					}
				case 13: 
					if(substr($sphone, 0, 1)!=0){
						ShowMsg('您好, 你输入的是电话号码，但是电话的区号不正确，谢谢！', '-1');
						exit();
					}
				default:
					ShowMsg('你是来捣乱的吧！ 号码有你这样的吗？？？', '-1');
					exit();
					break;
			}
			
			//------------------------------------------
			//一定必须的值不能为空
			if($_POST['name']!='' && $_POST['sphone']!='' && $_POST['id_number']!=''){
				//查询是否有重复数据
				$userdata=$db->getone("select * from tuijian where sphone='".$sphone."' or id_number='".$id_number."' ");
			}else{
				showmsg('姓名，手机号和身份证号必须填写！', '-1');
				exit();
			}
			
			//有重复数据就过滤
			if(empty($userdata)){
				
				if(!empty($user['bianhao'])){
					//存在后随机生成新的编号-------------------------
					$bianhao="s".rand(100000,999999);
					//使用死循环防止纯在重复的随机数
					$i=1;
					while($i){
						$data=$db->getone("select * from tuijian where bianhao='".$bianhao."' ");	//查询这个新生成的编号是否存在
						if(!empty($data)){		//存在就重新生成新的编号
							$bianhao="s".rand(100000,999999);
							$i=1;
						}else{
							break;				//不存在就跳出循环使用这个编号
						}
					}
					//组成数组插入数据库--------------------------------
					$data=array(
						'bianhao'=>$bianhao,
						'name'=>$name,
						'sex'=>$sex,
						'sphone'=>$sphone,
						'qq'=>$qq,
						'guanxi'=>$guanxi,
						'id_number'=>$id_number,
						'f_bianghao'=>$user['bianhao'],
						'f_name'=>$user['name'],
						'pid'=>$user['id'],
						'jibie'=>'3',
						'path'=>$user['path'].$user['id'].',',
						'hujiaozhongxin'=>'1',
						'add_gs'=>'',
						'add_time'=>time()
					);
				
					$id=$db->insert("tuijian",$data);
				
					if($id > 0){
						$data = $dsql->GetOne("SELECT * FROM #@__member WHERE sphone='$sphone' ");
						if(empty($data)){
						
							/*--壹打工网注册----and----------------------------------------------*/
							$userid = trim($sphone);							//userid
							$uname = trim($sphone);							//用户名。
							$pwd = trim(substr($sphone, -4));				//取手机尾数4号做密码
							$userpwd=$pwdc = trim(substr($sphone, -4));		//取手机尾数4号做密码
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
								$qym="推荐注册";
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
								$dsql->ExecuteNoneQuery("INSERT INTO `#@__member_flink`(mid,title,url) VALUES('$mid','壹打工','http://www.1dagong.com'); ");
							}
							/*--壹打工网注册----end----------------------------------------------*/
							
						}
						//--发短信提醒被推荐人的1打工网的帐号-------------------------------------------------
						$content="您好".$name."，".$user['name']."已经将您推荐到1+2事业平台，请登陆www.1dagong.com查看。账号为您的手机号，密码为手机号后四位。【壹打工网】";
						$dx=new duanxin($sphone,$content);
						$dx->fs();
						//---------------------------------------------------
						
						showmsg('推荐成功！!', '/home/12tuijian/tuijianbiao.php');
						exit();
					}else{
						showmsg('推荐失败！! ', '-1');
						exit();
					}
					
				}else{
					showmsg('出错了，请重试！', '-1');
					exit();
				}
				
			}else{
				showmsg('这个人已经被推荐过了！', '-1');
				exit();
			}
		
		}else{
			showmsg('出错了，请重试！', '-1');
			exit();
		}
		
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}

}