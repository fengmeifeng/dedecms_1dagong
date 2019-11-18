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