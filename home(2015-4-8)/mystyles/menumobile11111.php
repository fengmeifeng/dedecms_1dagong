			<?php
			if(strpos($_SERVER['PHP_SELF'],'index')){ $index='class="active"';}
			if(strpos($_SERVER['PHP_SELF'],'info')){ $info='class="active"';}
			if(strpos($_SERVER['PHP_SELF'],'password')){ $password='class="active"';}
			if(strpos($_SERVER['PHP_SELF'],'snw')){ $snw='class="active"';}
			
			$data='<ul class="nav nav-pills pull-right">
					<li '.$index.'><a href="index.php">会员中心</a></li>
					<!-- <li '.$s.'><a href="#">收藏夹<span class="badge pull-right">查看</span></a></li>-->					
					<li '.$info.'><a href="info.php">个人资料<span class="badge pull-right">修改</span></a></li>
					<li '.$password.'><a href="password.php">密码管理<span class="badge pull-right">更改</span></a></li>
					<li '.$snw.'><a href="snw.php">省内200元，省外300元<span class="badge pull-right">参与</span></a></li>
					<li '.$s.'><a href="index_do.php?fmdo=login&dopost=exit#">退出</a></li>
					</ul>
					';
			
			echo $data;
			?>