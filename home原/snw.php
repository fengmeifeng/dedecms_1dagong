<?php
/**
 * @version        $Id: edit_fullinfo.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__).'/config.php');
require_once DEDEINC.'/membermodel.cls.php';
require_once(DEDEINC."/userlogin.class.php");
require_once(DEDEINC."/bb_duanxin.class.php"); 	//短信类
CheckRank(0,0);
require_once(DEDEINC.'/enums.func.php');
$menutype = 'config';
if(!isset($dopost)) $dopost = '';

if($dopost==''){
    //判断手机时候验证
	if($cfg_ml->fields['verify']!=1){
		ShowMsg('请手机验证后才能申请路费','info.php',0,3000);
		exit();
	}

    $dede_fields = empty($dede_fields) ? '' : trim($dede_fields);
    if(!empty($dede_fields)){
        if($dede_fieldshash != md5($dede_fields.$cfg_cookie_encode))
        {
            showMsg('数据校验不对，程序返回', '-1');
            exit();
        }
    }
    $dede_fieldshash = empty($dede_fieldshash) ? '' : trim($dede_fieldshash);
    $membermodel = new membermodel($cfg_ml->M_MbType);
    $modelform = $dsql->GetOne("SELECT * FROM #@__member_model WHERE id='$membermodel->modid' ");
    if(!is_array($modelform)){
        showmsg('模型表单不存在', '-1');
        exit();
    }
    $row = $dsql->GetOne("SELECT * FROM ".$modelform['table']." WHERE mid=$cfg_ml->M_ID");
    if(!is_array($row)){
        showmsg("你访问的记录不存在或未经审核", '-1');
        exit();
    }
    $postform = $membermodel->getForm('edit', $row, 'membermodel');
    $datas=$dsql->GetOne("select * from `bb_lufei` where mid=$cfg_ml->M_ID");
	
    include(DEDEMEMBER."/mystyles/a_snw.htm");
    exit();
}

/*------------------------
提交路费信息

------------------------*/
if($dopost=='snw'){
	
//--------------------------------------------------

	//判断是否超过时间，超过时间就不可以申请路费报销了
	if($cfg_ml->M_JoinTime > "2014-03-20"){
		showmsg("报名时间超过2014年3月20号，您已经的无法申请！", '-1');
		exit();
	}

//--------------------------------------------------
	if(empty($kaihuhang)){
		showmsg("开户银行不能为空！", '-1');
		exit();
	}
	if(empty($kahao)){
		showmsg("开户卡号不能为空！", '-1');
		exit();
	}
	if(empty($fullname)){
		showmsg("开户银行的姓名不能为空！", '-1');
		exit();
	}
	if(empty($nameid)){
		showmsg("身份证号码不能为空！", '-1');
		exit();
	}
	if(empty($company)){
		showmsg("入职企业不能为空！", '-1');
		exit();
	}
	if(empty($addtime)){
		showmsg("入职时间不能为空！", '-1');
		exit();
	}
	if(empty($sphone)){
		showmsg("手机号码不能为空！", '-1');
		exit();
	}
//-------------------------------------------------------	
    $sql="select * from `bb_lufei` where mid='".$modid."'";
    $data=$db->getone($sql);
    if(!empty($data)){
        $addtime=strtotime($addtime);
        $query = "UPDATE `bb_lufei` SET `xingming`='{$fullname}',`dianhua`='{$sphone}',`nameid`='{$nameid}',`gongshiming`='{$company}',`yinhangming`='{$kaihuhang}',`yinghaohao`='{$kahao}',`rztime`='{$addtime}',`baoming_time`='{$baoming_time}',`text`='' WHERE `mid`='{$modid}' ";
		if($dsql->ExecuteNoneQuery($query)){
            $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET  `uname`='{$fullname}' WHERE `mid`='{$modid}' LIMIT 1");
            $dsql->ExecuteNoneQuery("UPDATE `#@__member_person` SET  `uname`='{$fullname}',`fullname`='{$fullname}' WHERE `mid`='{$modid}' LIMIT 1");
            ShowMsg('成功修改你的路费报销信息，等待我们审核！','snw.php',0,10000);
            exit();
        }
		
    }else{
        $time=time();
        $addtime=strtotime($addtime);
        $query = "INSERT INTO `bb_lufei` (`mid`, `xingming`, `dianhua`, `nameid`, `gongshiming`, `yinhangming`, `yinghaohao`, `rztime`, `addtime`, `baoming_time`) VALUES ('{$modid}', '{$fullname}', '{$sphone}', '{$nameid}', '{$company}', '{$kaihuhang}', '{$kahao}', '{$addtime}', '{$time}', '{$baoming_time}')";    
		if($dsql->ExecuteNoneQuery($query)){
            $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET  `uname`={$fullname} WHERE `mid`='{$modid}' LIMIT 1");
            $dsql->ExecuteNoneQuery("UPDATE `#@__member_person` SET  `uname`='{$fullname}',`fullname`='{$fullname}' WHERE `mid`='{$modid}' LIMIT 1");
            ShowMsg('成功提交你的路费报销信息，等待我们审核！','snw.php',0,10000);
            exit();
        }

    }


}