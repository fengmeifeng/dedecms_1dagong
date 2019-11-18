			<?php
			if(strpos($_SERVER['PHP_SELF'],'index')){ $index='class="homeleftbg active"';}
			if(strpos($_SERVER['PHP_SELF'],'info')){ $info='class="homeleftbg active"';}
			if(strpos($_SERVER['PHP_SELF'],'password')){ $password='class="homeleftbg active"';}
			if(strpos($_SERVER['PHP_SELF'],'zhengwen')){ $lb_zhengwen='class="homeleftbg active"';}
			if(strpos($_SERVER['PHP_SELF'],'tj_zhengwen')){ $tj_zhengwen="homeleftbg active";}
			if(strpos($_SERVER['PHP_SELF'],'snw')){ $snw='class="homeleftbg active"';}
			
			$data='


			   
							<div class="panel panel-info" style="margin-top:-20px;">
							  <div class="panel-heading"><h3>会员中心</h3></div>
							  <div class="panel-body">
								<ul class="nav nav-pills nav-stacked husd">
									<!-- <li '.$s.'><a href="#">收藏夹<span class="badge pull-right">查看</span></a></li>-->
																		
									<li class="m_neijian">
										<a href="neijian.php" class="pull-left">加入“1+2事业平台”</a>
										<a href="/neijian/" class="badge pull-right pmny">详情</a>
									</li>

									<li>
										<a href="12.php" class="pull-left">登录“1+2事业平台"</a>
									</li>
									
						<style>
							.caidan{
								margin-left:20px;
							}
							.zcaidan{
								margin-left:40px;
							}
						</style>
						<div id="collapseOne" class="panel-collapse collapse in">
						<ul class="nav nav-pills nav-stacked caidan">
							<li class="">
								<a data-toggle="collapse" href="#collapsegeren" class="pull-left collapsed">个人信息</a>
							</li>
								<div id="collapsegeren" class="panel-collapse collapse in">
									<ul class="nav nav-pills nav-stacked zcaidan">
										<li class="">
											<a href="1.php" class="pull-left">添加我推荐会员</a>
										</li>
										<li class="">
											<a href="2.php" class="pull-left">个人推荐信息</a>
										</li>
									</ul>
								</div>
							<li class="">
								<a data-toggle="collapse" href="#collapsezhanghu" class="pull-left collapsed">账户信息</a>
							</li>
								<div id="collapsezhanghu" class="panel-collapse collapse in">
									<ul class="nav nav-pills nav-stacked zcaidan">
										<li class="">
											<a href="3.php" class="pull-left">我的帐户图</a>
										</li>
										<li class="">
											<a href="4.php" class="pull-left">我的帐户表</a>
										</li>
										<li class="">
											<a href="5.php" class="pull-left">推荐的账户</a>
										</li>
										<li class="">
											<a href="6.php" class="pull-left">奖金记录</a>
										</li>
									</ul>
								</div>
							<li class="">
								<a data-toggle="collapse" href="#collapsecaiwu" class="pull-left collapsed">财务信息</a>
							</li>
								<div id="collapsecaiwu" class="panel-collapse collapse in">
									<ul class="nav nav-pills nav-stacked zcaidan">
										<li class="">
											<a href="7.php" class="pull-left">申请提现</a>
										</li>
										<li class="">
											<a href="8.php" class="pull-left">提现记录</a>
										</li>
									</ul>
								</div>
						</ul>
						</div>

									<li '.$info.'>
										<a href="info.php" class="pull-left">个人资料</a>
										<a class="badge pull-right pmny">修改</a>
									</li>
									<li '.$password.'>
										<a href="password.php" class="pull-left">密码管理</a>
										<a class="badge pull-right pmny">更改</a>
									</li>
									<li '.$lb_zhengwen.'>
										<a href="lb_zhengwen.php?channelid=-68" class="pull-left">征文比赛</a>
										<a href="tj_zhengwen.php?channelid=-68" class="badge pull-right pmny">投稿</a>
									</li>

									
									<li '.$s.'>
										<a href="index_do.php?fmdo=login&dopost=exit#" class="pull-left">退出</a>
									</li>
								</ul>
							  </div>
							</div>
			
			
			';
			
			echo $data;
			?>