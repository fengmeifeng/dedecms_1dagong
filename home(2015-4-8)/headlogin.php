<?php
/**
 * @version        $Id: ajax_loginsta.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
AjaxHead();
if($myurl == '') exit('');

$uid  = $cfg_ml->M_LoginID;

//判断个人和企业				
$row = $dsql->GetOne("SELECT `mtype` FROM #@__member WHERE mid='$cfg_ml->M_ID'");

!$cfg_ml->fields['face'] && $face = ($cfg_ml->fields['sex'] == '女')? 'dfgirl' : 'dfboy';
$facepic = empty($face)? $cfg_ml->fields['face'] : $GLOBALS['cfg_memberurl'].'/templets/images/'.$face.'.png';
?>

        <div class="navbar-inner nffh">
          <ul class="nav">
            <li class="dropdown men_tu1 pull-right">
            	<a>您好，<?php echo $cfg_ml->M_UserName; ?></a>
            	<a class=" wida"><span class="caret"></span></a>
              <ul class="dropdown-menu men_tu2">
                <li><?php if($row['mtype'] == "个人"){ ?><a href="<?php echo $cfg_memberurl; ?>/index.php"><?php }else{?><a href="<?php echo $cfg_memberurl; ?>/index_company.php"><?php }?>会员中心</a></li>
                <li><a href="<?php echo $cfg_memberurl; ?>/index_do.php?fmdo=login&dopost=exit" style="color:#">退出登录</a></li>
              </ul>
            </li>
          </ul>
        </div>



<style>

.nffh{ margin-top:13px;}
.navbar .nav > li .men_tu2 {
	margin: 0;
	background:#f60;
	border-radius:0px;
	border:none;
	width:150px;
}
.navbar .nav > li .men_tu2 li a{
	display:block;
	line-height:24px;
	height:24px;
	width:150px;
}
.navbar .nav > li .men_tu2 li a:hover{
	background:#850185;
	line-height:24px;

}
.navbar .nav > li:hover .men_tu2 {
	display: block;
}


.navbar .nav > .men_tu1 a{
	width: 120px;
	height:30px;
	background:#f60;
	font-size: 14px;
	color: #fff;
	padding:0px 10px;
	line-height:30px;
	float:left;
	border-radius:2px 0 0 2px;
overflow: hidden;
	display: block;
	text-overflow: ellipsis;
	-o-text-overflow: ellipsis;
	white-space: nowrap;
}

.navbar .nav > .men_tu1 .wida{
	width:30px;
	height:30px;display: block;float:left;border-radius: 0 2px 2px 0;
}
</style>

<!--<div class="pull-right">您好，<strong><?php echo $cfg_ml->M_UserName; ?></strong>，欢迎登录。<?php if($row['mtype'] == "个人"){ ?><a href="<?php echo $cfg_memberurl; ?>/index.php"><?php }else{?><a href="<?php echo $cfg_memberurl; ?>/index_company.php"><?php }?><font color="#ff6600"><b>[会员中心]</b></font></a><a href="<?php echo $cfg_memberurl; ?>/index_do.php?fmdo=login&dopost=exit" style="color:#">[退出登录]</a> 

</div>--><!-- /userinfo -->