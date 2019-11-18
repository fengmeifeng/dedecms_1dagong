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
	$user=$db->getone("select * from tuijian where sphone='".$cfg_ml->fields['sphone']."' ");			//查询数据库
	
if(!isset($dopost)) $dopost = '';

if($dopost=='')
{
	
	if(!empty($user)){
		
		if($user['jihuo']!='1'){
			showmsg('未激活不可以提现！ ', '/home/12tuijian/gerenxinxi.php');
			exit();
		}
		
		if($cfg_ml->fields['shengfenid']!='' && $cfg_ml->fields['uname']!=""){
			if($user['pasword2']!='' && $user['bank']!='' && $user['subbranch']!='' && $user['bank_account']!=''){
				
				require_once(dirname(__FILE__)."/style/tixian.htm");		//模版
				
			}else{
				showmsg('你的提现密码未设置! <br/><br/>或提现银行帐号信息未填写！ ', '/home/12tuijian/gerenxinxi.php');
				exit();
			}
		}else{
			showmsg('请完善个人信息！ ', '/home/info.php');
			exit();
		}
		
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}
	
//提现
}elseif($dopost=='save'){
	
	
	if(!empty($user)){
	
		//查询这个人是否存在
		$user=$db->getone("select * from tuijian where id='".$uids."' ");
		//确定是否为本人
		if(strval($user['sphone'])==strval($cfg_ml->fields['sphone'])){
			
			if($_POST['txmoney']==''){
				showmsg('提现金额不能为空！ ', '-1');
				exit();
			}
			if($user['pasword2']!=MD5('1+2huidong'.$_POST['tixianpass'])){
				showmsg('提现密码错误！ ', '-1');
				exit();
			}else{
			
				if($user['jiangjin'] < 0){
					showmsg('提现申请失败！ ', '-1');
					exit();
				}
				
				if($user['jiangjin'] < $_POST['txmoney']){
					showmsg('超出提现奖金！ ', '-1');
					exit();
				}
			
				if(intval($_POST['txmoney']) >= 100){
					$tx=array(
						"userbianhao"=>$user['bianhao'],
						"username"=>$user['name'],
						"tjmoney"=>$user['jiangjin'],
						"txmoney"=>intval($_POST['txmoney']),
						"cyjiangjin"=>intval($user['jiangjin'])-intval($_POST['txmoney']),
						"add_time"=>time()
					);
					//申请提现保存到数据库
					$tid=$db->insert("tixian",$tx);
					//申请提现成功，执行保存日志，否则申请提现失败！
					if($tid>0){
						/*------奖金提现的日志--and------*/
						$data=$db->getone("select * from tixian where id='".$tid."' ");		//查找申请的提现
						$recordmoney=array(
							"hyhumber"=>$data['userbianhao'],
							"hyname"=>$data['username'],
							"money"=>intval($_POST['txmoney']),
							"leftmoney"=>intval(intval($user['jiangjin'])-intval($_POST['txmoney'])),
							"caozuo"=>"减少",
							"newbianhao"=>'',
							"beizhuxinming"=>"提现".intval($_POST['txmoney'])."元奖金",
							"beizhu"=>"提现".intval($_POST['txmoney'])."元奖金",
							"pid"=>$user['pid'],
							"path"=>$user['path'],
							"addtime"=>date("Y-m-d H:i:s",time())
						);
						$rid=$db->insert("recordmoney",$recordmoney);		//保存日志到 数据库
						/*------奖金提现的日志--end------*/
						//奖金日志插入成功，执行扣除奖金代码，否则删除申请的提现,于日志。
						if($rid>0){
							//执行扣除奖金代码
							/*-----提现扣除奖金代码------------*/
							$kid=$db->update("tuijian","jiangjin=jiangjin-".intval($_POST['txmoney'])," `id`='".$uids."' ");
							/*-----提现扣除奖金代码------------*/
							if($kid>0){
								showmsg('提现申请成功！', '/home/12tuijian/tixianjilu.php');
								exit();
							}else{
								//执行删除申请的提现
								$del=$db->del("tixian"," `id`='".$tid."' ");
								//执行删除提现日志
								$del=$db->del("recordmoney"," `id`='".$rid."' ");
								showmsg('提现申请失败！ ', '-1');
								exit();
							}
							
						}else{
							//执行删除申请的提现
							$del=$db->del("tixian"," `id`='".$tid."' ");
							showmsg('提现申请失败！ ', '-1');
							exit();
						}
						
					}else{
						showmsg('提现申请失败！ ', '-1');
						exit();
					}
					
				}else{
					showmsg('提现金额标准最低为100元！ ', '-1');
					exit();
				}

			}
		}else{
			showmsg('出错了！ ', '-1');
			exit();
		}
		
	}else{
		showmsg('出错了！ ', '-1');
		exit();
	}
}