			<?php
			//-----------------------------------
			//判断是否是审核员
			if($cfg_ml->IsLogin()){
					//echo $cfg_ml->M_ID;exit;
					//判断个人和企业
					 $row1 = $dsql->GetOne("SELECT `mtype`,`rank` FROM #@__member WHERE mid='$cfg_ml->M_ID'");
					 if($row1['mtype'] == "企业")
					 {
						 //判断会员级别
						if($row1['rank'] == '20000')
						{
							$style='display:none;';
							$style_1='display:block;';
							$style_2='display:none;';
							$title="审核员中心";
							
							
						}elseif($row1['rank'] == '30000')
							{
								$style='display:none;';
								$style_1='display:none;';
								$style_2='display:block;';
								$title="职位跟踪员中心";
							}else{
								$style='display:block;';
								$style_1='display:none;';//---不显示审核员信息
								$style_2='display:none;';//---不显示职位跟踪员信息
								$title="企业会员中心";
							}	

							if(strpos($_SERVER['PHP_SELF'],'index')){ $index='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'info')){ $info='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'password')){ $password='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'snw')){ $snw='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'gongzuo')){ $gongzuo='class="homeleftbg active"';}

							if(strpos($_SERVER['PHP_SELF'],'zhizhao')){$zhizhao='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'jianli')){$jianli='class="homeleftbg active"';}
							
							if(strpos($_SERVER['PHP_SELF'],'shenhe')){ $shenhe='class="homeleftbg active"';}
							
							if(strpos($_SERVER['PHP_SELF'],'sh_company')){ $sh_company='class="homeleftbg active"';}							
							if(strpos($_SERVER['PHP_SELF'],'hymq')){ $hymq='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'jilu')){ $jilu='class="homeleftbg active"';}

							if(strpos($_SERVER['PHP_SELF'],'zwgenzong')){ $zwgenzong='class="homeleftbg active"';}
							if(strpos($_SERVER['PHP_SELF'],'bmgenzong')){ $bmgenzong='class="homeleftbg active"';}
							
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
									<div class="panel-heading"><h3>'.$title.'</h3></div>
									
									<div class="panel-body">							
				
									<ul class="nav nav-pills nav-stacked husd">
										
										<li '.$zwgenzong.' style="'.$style_2.'">
											<a href="zwgenzong.php?channelid=81" class="pull-left">职位跟踪</a>
											<a href="zwgenzong.php?channelid=81" class="badge pull-right pmny">跟踪</a>
										</li>
										<li '.$bmgenzong.' style="'.$style_2.'">
											<a href="bmgenzong.php?channelid=81" class="pull-left">行业名企报名跟踪</a>
											<a href="bmgenzong.php?channelid=81" class="badge pull-right pmny">跟踪</a>
										</li>
										<p style="border-bottom:3px dotted #ebebeb; margin:10px 15px;'.$style_2.'"></p>
										
										<li '.$gongzuo.' style="'.$style.'">
											<a href="gongzuo.php?channelid=81" class="pull-left">职位管理</a>
											<a href="pt_gongzuo.php?channelid=81" class="badge pull-right pmny">发布</a>
										</li>
										
										<li '.$jianli.' style="'.$style.'">
										<a href="ck_jianli.php?channelid=82" class="pull-left">简历箱</a>
										<a href="ck_jianli.php?channelid=82" class="badge pull-right pmny">简历</a>
										</li>
										
										<li '.$zhizhao.' style="'.$style.'">
										<a href="/home/zhizhao.php" class="pull-left">上传营业执照</a>
										<a href="/home/zhizhao.php" class="badge pull-right pmny" target="_black">上传</a>
										</li>

										

										<li '.$shenhe.' style="'.$style_1.'">
											<a href="shenhe.php?channelid=81" class="pull-left">职位审核</a>
											<a href="shenhe.php?channelid=81" class="badge pull-right pmny">审核</a>
										</li>
										<li '.$sh_company.' style="'.$style_1.'">
											<a href="sh_company.php?channelid=81" class="pull-left">企业会员审核</a>
											<a href="sh_company.php?channelid=81" class="badge pull-right pmny">审核</a>
										</li>

										<p style="border-bottom:3px dotted #ebebeb; margin:10px 15px;'.$style_1.'"></p>
										
										
										<li '.$hymq.' style="'.$style_1.'">
											<a href="/home/hymq.php?channelid=66" class="pull-left">行业名企信息管理</a>
											<a href="/home/pt_hymq.php?channelid=66" class="badge pull-right pmny">发布</a>
										</li>
										<li '.$jilu.' style="'.$style_1.'">
											<a href="/home/jilu.php" class="pull-left">报名行业名企记录</a>
											<a href="/gongzuo/" class="badge pull-right pmny">报名</a>
										</li>
										
										<p style="border-bottom:3px dotted #ebebeb;; margin:10px 15px;'.$style_1.'"></p>
										<p style="border-bottom:3px dotted #ebebeb;; margin:10px 15px;'.$style.'"></p>
										
										
										<li '.$info.'>
											<a href="/home/info_qy.php" class="pull-left">详细资料</a>
											<a href="/home/info_qy.php" class="badge pull-right pmny">修改</a>
										</li>
										<li '.$password.'>
											<a href="/home/password.php" class="pull-left">密码管理</a>
											<a href="/home/password.php" class="badge pull-right pmny">更改</a>
										</li>
										
										<li '.$s.'>
											<a href="/home/index_do.php?fmdo=login&dopost=exit#" class="pull-left">退出</a>
										</li>
										
										
										
									</ul>
								  </div>
								</div>
							';
							
							echo $data;
							//--------------------------------------------------------------------------------------------------审核员
						
					 }else{
						 //-------------------------------------------------------------------------------------------------------个人用户
						 //ShowMsg("您不是企业会员,请登录...","./login.php",0,2000);
						 //exit;
						if(strpos($_SERVER['PHP_SELF'],'index')){ $index='class="homeleftbg active"';}
						if(strpos($_SERVER['PHP_SELF'],'info')){ $info='class="homeleftbg active"';}
						if(strpos($_SERVER['PHP_SELF'],'password')){ $password='class="homeleftbg active"';}
						if(strpos($_SERVER['PHP_SELF'],'zhengwen')){ $lb_zhengwen='class="homeleftbg active"';}
						if(strpos($_SERVER['PHP_SELF'],'tj_zhengwen')){ $tj_zhengwen="homeleftbg active";}
						if(strpos($_SERVER['PHP_SELF'],'toudi')){ $toudi='class="homeleftbg active"';}
						if(strpos($_SERVER['PHP_SELF'],'snw')){ $snw='class="homeleftbg active"';}
						
						
						if(strpos($_SERVER['PHP_SELF'],'jianli')){ $jianli='class="homeleftbg active"';}

						//=-------------------------------------------冯
						//echo "Select `a.id` From `#@__archives` as a left join `#@__addjianli82` as b on a.id=b.aid where  a.mid='$cfg_ml->M_ID'";exit;
						$row_jianli = $dsql->GetOne("Select a.id From `#@__archives` as a left join `#@__addjianli82` as b on a.id=b.aid WHERE  a.mid='$cfg_ml->M_ID'");
						//print_r($row_jianli);exit;
						//搜索简历表
						//$jianli
						if($row_jianli){
							$url="/home/jianli_edit.php?channelid=82&aid=".$row_jianli['id'];
							//$url="jianli.php?channelid=82";
						}else{
							$url="/home/pt_jianli.php?channelid=82";
						}

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
								<div class="panel-heading"><h3>个人会员中心</h3></div>
			
								'.$tuijian.'
								
								<div class="panel-body">							
			
								<ul class="nav nav-pills nav-stacked husd">
									'.$jiaru.'
									
									<li '.$jianli.'>
										<a href="'.$url.'" class="pull-left">发布简历</a>
										<a href="'.$url.'" class="badge pull-right pmny">发布</a>
									</li>
									<li '.$toudi.'>
										<a href="/home/toudi.php" class="pull-left">投递记录</a>
										<a href="/plus/search.php?typeid=41" class="badge pull-right pmny" target="_black">投递</a>
									</li>
									<p style="border-bottom:3px dotted #ebebeb;; margin:10px 15px;"></p>



									<li '.$info.'>
										<a href="/home/info.php" class="pull-left">个人资料</a>
										<a href="/home/info.php" class="badge pull-right pmny">修改</a>
									</li>
									<li '.$password.'>
										<a href="/home/password.php" class="pull-left">密码管理</a>
										<a href="/home/password.php" class="badge pull-right pmny">更改</a>
									</li>
									<p style="border-bottom:3px dotted #ebebeb;; margin:10px 15px;"></p>
									
									<li '.$lb_zhengwen.'>
										<a href="/home/lb_zhengwen.php?channelid=-68" class="pull-left">征文比赛</a>
										<a href="/home/tj_zhengwen.php?channelid=-68" class="badge pull-right pmny">投稿</a>
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