<!--
var stch=true;

function sjend(){
	var phone=$.trim($("#phone").val());
	if(stch){
	
		stch=false;		//接收验证码成功 再次发送给禁用
		
		$.post("info_qy.php", { dopost: "phone", phone: phone },
		function(data){
			if(data==1){
				stch=false;		//接收验证码成功 再次发送给禁用
				buton();		//控制获取验证码按钮
			}
			if(data==0){
				stch=true;		//接收验证码失败 再次发送给启用
				$("#buton").html("获取失败,重新获取验证码");
				$("#yz").css({width:"52px"});
			}
			if(data==2){
				alert("已经不可以发送了");
			}
		});
	}else{
		alert("等待验证码来！");
	}
}

//按钮120内只能点一次
var wait=120;
function buton(){
	var btn=document.getElementById("buton");
	if(wait==0){ 
		stch=true;		//时间=0 再次发送给启用
		btn.removeAttribute("disabled");
		$("#buton").html("获取验证码");
		$("#yzs").css({width:"165px"});
		wait=120;
	}else{ 
		stch=false;		//时间不等于0 再次发送给禁用
		btn.setAttribute("disabled", true); 
		$("#buton").html("重新发送(" + wait + ")");
		$("#yz").css({width:"140px"});
		wait--; 
		setTimeout(function(){
			buton(btn);
		},1000)
	}
}	 
//-->