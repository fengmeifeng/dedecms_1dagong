<?php
require "excel_class.php";
//$str = file_get_contents('server-spl.xls');
Read_Excel_File("e.xls",$return);
echo "<pre>";
//ob_end_clean();
//$str = explode("\n", $str);
foreach($return as $k=>$v){
	foreach($v as $key=>$val){
		if($key==0) continue;
	print_r($val);
	}
}


/*foreach($str as $key => $val)
{
	if(empty($val) || $key == 0) continue;
	$val = explode("\t", $val);

	print_r($val);
}*/
?>