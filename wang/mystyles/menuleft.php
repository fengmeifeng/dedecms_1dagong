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

							  <div class="m-lefttitle"><a href="neijian.php">1+2事业平台</a> <a href="/neijian/" class="rlink pull-right">详情</a></div>

							  <div class="m-left-title-2 b-bottom">
								<a href="neijian.php">个人信息</a>
							  </div>

							  <div class="m-left-title-2">
								<div class="btn-group">
								  <a href="1.php" class="btn btn-default">我要推荐会员</a>
								  <a href="2.php" class="btn btn-default">我的推荐信息</a>
								</div> 
							  </div>

							  <div class="m-left-title-2 b-bottom">
								<a href="neijian.php">账户信息</a>
							  </div>


							  <div class="panel-body">							

								<ul class="nav nav-pills nav-stacked husd">

									<li style="padding-left:10px;">
										<a href="3.php" class="pull-left">全部梯次图表</a>
										<a class="badge pull-right pmny" href="">切换显示方式</a>
									</li>

									<li style="padding-left:10px;">
										<a href="5.php" class="pull-left">我推荐的账户</a>
										<a href="6.php" class="pull-right" href="">奖金纪录</a>
									</li>
								</ul>

							  </div>

							  <div class="m-left-title-2 b-bottom">
								<a href="neijian.php">财务信息</a>
							  </div>


							  <div class="panel-body">							

								<ul class="nav nav-pills nav-stacked husd">

									<li style="padding-left:10px;">
										<a href="7.php" class="pull-left">申请提现</a>
										<a href="8.php" class="pull-right">提现纪录</a>
									</li>
								</ul>

							  </div>


							  <div class="m-lefttitle"><a href="">会员中心功能</a></div>

							   <div class="panel-body">							

								<ul class="nav nav-pills nav-stacked husd">
									
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