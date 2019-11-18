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

!$cfg_ml->fields['face'] && $face = ($cfg_ml->fields['sex'] == '女')? 'dfgirl' : 'dfboy';
$facepic = empty($face)? $cfg_ml->fields['face'] : $GLOBALS['cfg_memberurl'].'/templets/images/'.$face.'.png';
?>

您好，<strong><?php echo $cfg_ml->M_UserName; ?></strong>，欢迎登录。<a href="<?php echo $cfg_memberurl; ?>/index.php"><font color="#ff6600"><b>[会员中心]</b></font></a><a href="<?php echo $cfg_memberurl; ?>/index_do.php?fmdo=login&dopost=exit">[退出登录]</a> 

</div><!-- /userinfo -->