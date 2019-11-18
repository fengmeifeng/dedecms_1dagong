<?php
	require_once(dirname(__FILE__)."/../config.php");
	require_once(DEDEINC."/bb_mysql.class.php"); 	//数据库类
	CheckRank(0,0);		//查看是否登录
	yzmima();			//查看当前密码是否为默认的，否则跳到修改密码页面
	//----------------------------------------------------
	require_once(DEDEDATA.'/common.inc.php');		//数据库链接信息
	$dbhost=$sqltag['tuijian']['dbhost'];			//主机
	$dbuser=$sqltag['tuijian']['dbuser'];			//帐号
	$dbpass=$sqltag['tuijian']['dbpwd'];			//密码
	$dbname=$sqltag['tuijian']['dbname'];			//库名
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);		//new 数据库类
	

if(!isset($dopost)) $dopost = '';

if($dopost=='')
{
	//查询当前用户的信息。
	$user=$db->getone("select * from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");			//查询数据库
	//-----------------------------------------------------
	if(!empty($user)){
		//推荐的url链接
		$userurl="http://".$_SERVER['HTTP_HOST']."/tj.php?bh=".base64_encode($user['bianhao']);
		//判断是设置提现密码还是修改提现密码
		if($user['pasword2']!=''){
			$bd='<li><label>原提现密码：<span class="red">*</span></label><input class="form-control" type="password" name="yztxmima" size="30" style="width:225px; display:inline-block;" ></li>';
		}else{
			$bd='<li><label><b>登录密码</b>：<span class="red">*</span></label><input class="form-control" type="password" name="yzdlmima" size="30" style="width:225px; display:inline-block;" ></li>';
		}
		//模版---
		require_once(dirname(__FILE__)."/style/gerenxinxi.htm");
		exit();
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}
//保存数据	
}elseif($dopost=='save'){

	//防止用户不填-------------------------
	if($bank==''){
		showmsg('银行名称未填写！', '-1');
		exit();
	}
	if($subbranch==''){
		showmsg('银行所在的支行未填写！', '-1');
		 exit();
	}
	if($bank_account==''){
		showmsg('银行卡号未填写！', '-1');
		exit();
	}
	//查询这个人是否存在
	$user=$db->getone("select * from tuijian where id='".$useruid."' ");
	//确定修改的是否为本人
	if(strval($user['sphone'])==strval($cfg_ml->fields['sphone'])){
		
		if(!empty($useruid)){
			$updata="UPDATE `tuijian` SET  bank='".$bank."', subbranch='".$subbranch."', bank_account='".$bank_account."' WHERE `id` = '".$useruid."' ";
			$id=$db->query($updata);
			if($id){
				showmsg('操作成功！', '-1');
				exit();
			}else{
				showmsg('操作失败！ ', '-1');
				exit();
			}
		}
		
	}else{
		showmsg('出错了，请重试！', '-1');
		exit();
	}

//修改密码	
}elseif($dopost=='pass'){
	//提现密码是否为空！
	if($txmima1=='' && $txmima2==''){
		showmsg('提现密码不能为空！', '-1');
		exit();
	}
	//查询这个人是否存在
	$user=$db->getone("select * from tuijian where id='".$useruid."' ");
	//确定修改的是否为本人
	if(strval($user['sphone'])==strval($cfg_ml->fields['sphone'])){
		if(!empty($useruid)){
			//设置提现密码
			if($_POST['yzdlmima']!=''){
				//验证登录密码
				if(strval($cfg_ml->fields['pwd'])==strval(MD5($_POST["yzdlmima"]))){
					//判断2次密码输入是否一致
					if($_POST["txmima1"]==$_POST["txmima1"]){
						$txpasword=MD5('1+2huidong'.$_POST["txmima1"]);
						$updata="UPDATE `tuijian` SET pasword2='".$txpasword."'  WHERE `id` = '".$useruid."' ";
						$id=$db->query($updata);
						if($id){
							showmsg('设置提现密码成功！', '-1');
							exit();
						}else{						
							showmsg('设置提现密码失败！', '-1');
							exit();
						}
						
					}else{
						showmsg('两次输入的密码不一致！', '-1');
						exit();
					}
				}else{
					showmsg('登录密码错误！请重新输入！', '-1');
					exit();
				}
			
			//修改提现密码
			}elseif($_POST['yztxmima']!=''){
				//验证原提现密码是否正确
				if($user['pasword2']==MD5('1+2huidong'.$_POST["yztxmima"])){
					//判断2次密码输入是否一致
					if($_POST["txmima1"]==$_POST["txmima1"]){
						$txpasword=MD5('1+2huidong'.$_POST["txmima1"]);
						$updata="UPDATE `tuijian` SET pasword2='".$txpasword."'  WHERE `id` = '".$useruid."' ";
						$id=$db->query($updata);
						if($id){
							showmsg('修改提现密码成功！', '-1');
							exit();
						}else{						
							showmsg('修改提现密码失败！', '-1');
							exit();
						}
					}else{
						showmsg('两次输入的密码不一致！', '-1');
						exit();
					}
				}else{
					showmsg('原提现密码不正确！请重新输入', '-1');
					exit();
				}
				
			}else{
				showmsg('密码不能为空！', '-1');
				exit();
			}
			
		}else{
			showmsg('出错了，请重试！', '-1');
			exit();		
		}
		
	}else{
		showmsg('出错了，请重试！', '-1');
		exit();
	}
	
}