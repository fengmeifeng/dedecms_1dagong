
<html>
<head>
<title>短信测试</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">

<script language='JavaScript'>
// 显示服务器的当前时间
function timeview(){
  timestr=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());
  time_area.innerHTML = timestr;
  window.setTimeout( 'timeview()', 1000);
}
</script>


<body onload="timeview();" >

	现在时间：<span id="time_area" class="timer"> </span>
	<br/><br/><br/><br/>


<form method='post' action="">
	你的手机号码：<input type='text' name='sj'>
	<Input type='submit' value="发送">
</form>

</body>
</html>


<?php

require_once('./bb_duanxin.class.php');

if(!empty($_GET['mima'])){
	if($_GET['mima']=='112500'){
	
		if(!empty($_POST['sj'])){

			$num=mt_rand(100000,999999);	//获取随机数
			
			$content="您好，您的壹打工网注册验证码为：".$num."。电脑或手机访问www.1dagong.com，随时随地找工作。【壹打工网】";

			$dx=new duanxin($_POST['sj'],$content);		//申明短信类
			
			$id=$dx->fs();	
			
			echo '发送短信的手机号是：'.$_POST['sj'].'<br/><br/><br/>';
			
			if($id){
				
				echo '短信发送成功！ 发送时间：'.date("Y-m-d H:i:s", time()).'<br/><br/><br/>';
				
			}else{
				echo "短信发送失败！";
			}
		}
		
	}else{
		header("Location: http://www.1dagong.com");
	}
}else{
	header("Location: http://www.1dagong.com");
}
?>