<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");		//dede类


require_once(DEDEMEMBER."/mystyles/bb_tjbaoming.htm");


//注册
if($dopost=="regbase" && $step==1){
	/*---- ALTER TABLE  `zjobs_member_person` ADD  `ophone2` VARCHAR( 20 ) NOT NULL COMMENT  '备用号码' AFTER  `uname` ----*/
	print_r($_POST);
	

}


?>