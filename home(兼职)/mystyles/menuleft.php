			<?php
			//-----------------------------------
			//判断是否是审核员
			if($cfg_ml->IsLogin()){
					
					//判断个人和企业
					 $row1 = $dsql->GetOne("SELECT `mtype`,`rank` FROM #@__member WHERE mid='$cfg_ml->M_ID'");
					
					// echo $row['mtype'];exit;
					 if($row1['mtype'] == "企业")
					 {
						 //判断会员级别
						 // $row2 = $dsql->GetOne("SELECT `rank` FROM #@__arcrank WHERE rank=20000");
						 
						if($row1['rank'] == '20000')
						{
							
							 $shenhe_style='display:block';
							 if(strpos($_SERVER['PHP_SELF'],'shenhe')){ $shenhe='class="homeleftbg active"';}
						}
						else
						{
							$shenhe_style='display:none';
							 //---------------------------------------------------------------------------普通企业
							if(strpos($_SERVER['PHP_SELF'],'index')){ $index='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'info')){ $info='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'password')){ $password='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'snw')){ $snw='class="homeleftbg active"';}
							
							if(strpos($_SERVER['PHP_SELF'],'jianzhi')){ $jianzhi='class="homeleftbg active"';}
							
							
							//-----------------------------------
							require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类
							require_once(DEDEDATA.'/common.inc.php');		//数据库链接信息
							
							$dbhost=$sqltag['tuijian']['dbhost'];			//主机
							$dbuser=$sqltag['tuijian']['dbuser'];			//帐号
							$dbpass=$sqltag['tuijian']['dbpwd'];			//密码
							$dbname=$sqltag['tuijian']['dbname'];			//库名
							$db=new mysql($dbhost,$dbuser,$dbpass,$dbname);		//new 数据库类
							$user=$db->getone("select * from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");			//查询数据库
							if(empty($user)){
							
								$jiaru='';
									
							}else{
							
								$tuijian='';
							
							}
							
							
							//-----------------------------------
							
							
							
							$data='
							
								<div class="panel panel-info" style="margin-top:0px;">
									<div class="panel-heading"><h3>会员中心</h3></div>
									
									<div class="panel-body">							
				
									<ul class="nav nav-pills nav-stacked husd">
										
										<li '.$info.'>
											<a href="/home/info_qy.php" class="pull-left">详细资料</a>
											<a href="/home/info_qy.php" class="badge pull-right pmny">修改</a>
										</li>
										<li '.$password.'>
											<a href="/home/password.php" class="pull-left">密码管理</a>
											<a href="/home/password.php" class="badge pull-right pmny">更改</a>
										</li>
										
										<li '.$jianzhi.'>
											<a href="jianzhi.php?channelid=80" class="pull-left">发布工作</a>
											<a href="pt_job.php?channelid=80" class="badge pull-right pmny">发布</a>
										</li>
										
										<li '.$jianli.'>
										<a href="jianli.php?channelid=82" class="pull-left">简历管理</a>
										<a href="pt_jianli.php?channelid=82" class="badge pull-right pmny">发布</a>
										</li>
										
										<li '.$shenhe.' style="'.$shenhe_style.'">
											<a href="shenhe.php?channelid=80" class="pull-left">审核专区</a>
											<a href="shenhe.php?channelid=80" class="badge pull-right pmny">审核</a>
										</li>
										
										<li '.$s.'>
											<a href="/home/index_do.php?fmdo=login&dopost=exit#" class="pull-left">退出</a>
										</li>
									</ul>
								  </div>
								</div>
							';
							
							echo $data;
							//--------------------------------------------------------------------------------------------------普通企业
						}
					 }
					 else
					 {
						 //ShowMsg("您不是企业会员,请登录...","./login.php",0,2000);
						 //exit;
						if(strpos($_SERVER['PHP_SELF'],'index')){ $index='class="homeleftbg active"';}
						if(strpos($_SERVER['PHP_SELF'],'info')){ $info='class="homeleftbg active"';}
						if(strpos($_SERVER['PHP_SELF'],'password')){ $password='class="homeleftbg active"';}
						if(strpos($_SERVER['PHP_SELF'],'zhengwen')){ $lb_zhengwen='class="homeleftbg active"';}
						if(strpos($_SERVER['PHP_SELF'],'tj_zhengwen')){ $tj_zhengwen="homeleftbg active";}
						if(strpos($_SERVER['PHP_SELF'],'tj_jianli')){ $tj_jianli="homeleftbg active";}
						if(strpos($_SERVER['PHP_SELF'],'snw')){ $snw='class="homeleftbg active"';}
						
						//-----------------------------------
						require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类
						require_once(DEDEDATA.'/common.inc.php');		//数据库链接信息
						
						$dbhost=$sqltag['tuijian']['dbhost'];			//主机
						$dbuser=$sqltag['tuijian']['dbuser'];			//帐号
						$dbpass=$sqltag['tuijian']['dbpwd'];			//密码
						$dbname=$sqltag['tuijian']['dbname'];			//库名
						$db=new mysql($dbhost,$dbuser,$dbpass,$dbname);		//new 数据库类
						$user=$db->getone("select * from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");			//查询数据库
						if(empty($user)){
						
							$jiaru='
								<li class="m_neijian">
									<a href="neijian.php" class="pull-left">加入“1+2事业平台”</a>
									<a href="/neijian/" class="badge pull-right pmny">详情</a>
								</li>
							';
								
						}else{
						
							$tuijian='
							
							<div class="m-lefttitle">
								<a href="javascript:;">1+2事业平台</a> 
								<a href="/neijian/" class="rlink pull-right">详情</a>
							</div>
							
							<div class="m-left-title-2 b-bottom">
								<a href="javascript:;">个人信息</a>
							</div>
			
							<div class="m-left-title-2">
								<div class="btn-group">
								  <a href="/home/12tuijian/addtuijian.php" class="btn btn-default">我要推荐会员</a>
								  <a href="/home/12tuijian/gerenxinxi.php" class="btn btn-default">我的推荐信息</a>
								</div> 
							</div>
			
							<div class="m-left-title-2 b-bottom">
								<a href="javascript:;">账户信息</a>
							</div>
			
							<div class="panel-body">							
								<ul class="nav nav-pills nav-stacked husd">
									<li style="padding-left:10px;">
										<a href="/home/12tuijian/wodetichi.php" class="pull-left">全部梯次图表</a>
										<a href="/home/12tuijian/xianshifangshi.php" class="badge pull-right pmny" >切换显示方式</a>
									</li>
									<li style="padding-left:10px;">
										<a href="/home/12tuijian/tuijianbiao.php" class="pull-left">我推荐的会员</a>
										<a href="/home/12tuijian/jiangjinjilu.php" class="pull-right" href="">奖金纪录</a>
									</li>
								</ul>
							</div>
			
							<div class="m-left-title-2 b-bottom">
								<a href="javascript:;">财务信息</a>
							</div>
			
							<div class="panel-body">							
								<ul class="nav nav-pills nav-stacked husd">
									<li style="padding-left:10px;">
										<a href="/home/12tuijian/tixian.php" class="pull-left">申请提现</a>
										<a href="/home/12tuijian/tixianjilu.php" class="pull-right">提现纪录</a>
									</li>
								</ul>
							</div>
							
							<div class="m-lefttitle"><a href="">会员中心功能</a></div>
							
							';
						
						}
						
						//-----------------------------------
						
						
						
						$data='
						
							<div class="panel panel-info" style="margin-top:0px;">
								<div class="panel-heading"><h3>会员中心</h3></div>
			
								'.$tuijian.'
								
								<div class="panel-body">							
			
								<ul class="nav nav-pills nav-stacked husd">
									'.$jiaru.'
									
									<li '.$info.'>
										<a href="/home/info.php" class="pull-left">个人资料</a>
										<a href="/home/info.php" class="badge pull-right pmny">修改</a>
									</li>
									<li '.$password.'>
										<a href="/home/password.php" class="pull-left">密码管理</a>
										<a href="/home/password.php" class="badge pull-right pmny">更改</a>
									</li>
									<li '.$lb_zhengwen.'>
										<a href="/home/lb_zhengwen.php?channelid=-68" class="pull-left">征文比赛</a>
										<a href="/home/tj_zhengwen.php?channelid=-68" class="badge pull-right pmny">投稿</a>
									</li>
									<li '.$lb_jianli.'>
										<a href="/home/jianli.php?channelid=82" class="pull-left">发布简历</a>
										<a href="/home/pt_jianli.php?channelid=82" class="badge pull-right pmny">发布</a>
									</li>
									<li '.$lb_toudi.'>
										<a href="/home/toudi.php?channelid=81" class="pull-left">投递记录</a>
										<a href="/home/toudi.php?channelid=81" class="badge pull-right pmny">投递</a>
									</li>
									<li '.$s.'>
										<a href="/home/index_do.php?fmdo=login&dopost=exit#" class="pull-left">退出</a>
									</li>
								</ul>
							  </div>
							</div>
						';
						
						echo $data;
			//------------------------------------------------------------------------------------
					 }  
				}
				else
				{
					ShowMsg("您不是会员,请登录...","./login.php",0,2000);
					exit;
				}
			?>
			
<style>
.m-lefttitle{
	padding:10px 0 5px 15px;
	background:#ffebe1;
	border-bottom:3px solid #d8d8d8;
	color:#000000;
}
.m-lefttitle a{
	font-size:16px;
	color:#660099;
}

.m-lefttitle .pmny{
	padding:4px 12px;
	margin-top:10px;
	margin-right:10px;
}
.m-lefttitle .rlink {
	background:#ff6600;
	padding:2px 5px;
	margin-right:10px;
	border-radius:5px;
	font-size:14px;
	color:#ffffff;
}

.m-left-title-2{
	padding:10px 0 5px 25px;
}
.b-bottom{
	border-bottom:1px solid #e6e6e6;
	background: #eeddff;
}

.rlink a{
	font-size:14px;
}

</style>