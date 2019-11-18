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
//--------------------------------------------------------------------峰
//判断个人和企业				
//$row = $dsql->GetOne("SELECT mtype FROM #@__member WHERE m.mid='$cfg_ml->M_ID'");
//print_r($row);exit;
	echo "<a class='btn btn-primary' style='width:200px;margin:10px auto;' href='/plus/baoming_hymq.php?aid=$aid&job=$mid&type=$type'>报名</a>\r\n";
!$cfg_ml->fields['face'] && $face = ($cfg_ml->fields['sex'] == '女')? 'dfgirl' : 'dfboy';
$facepic = empty($face)? $cfg_ml->fields['face'] : $GLOBALS['cfg_memberurl'].'/templets/images/'.$face.'.png';
?>

        




