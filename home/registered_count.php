<?php
/**
 *2015-03-20   By   Z
 * 个人注册量/企业注册量统计页
 *
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");
$stamp=strtotime('2015-01-01 00:00:00');
//按地区显示个人注册量
$per_address=array('%安徽%','%上海%','%重庆%','%江苏%','%湖北%');
foreach($per_address as $v){
	$query="select a.mid from `#@__member` as a left join `#@__member_person` as b on a.mid=b.mid where b.address like '".$v."' and a.jointime > '".$stamp."';";
	$dsql->SetQuery($query);
	$dsql->Execute();
	$dsql->Query($query);
	$person_count[]= $dsql->GetTotalRow();
}

//按地区显示企业注册量
$com_address=array('10501,10502,10503,10504,10505,10506,10507,10508,10509,10510,10511,10512,10513,10514,10515,10516,10517',
	'1001,1002,1003,1004,1005,1006,1007,1008,1009,1010,1011,1012,1013,1014,1015,1016,1017,1018,1019',
	'2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030,2031,2032,2033,2034,2035,2036,2037,2038,2039,2040',
	'4001,4002,4003,4004,4005,4006,4007,4008,4009,4010,4011,4012,4013',
	'7001,7002,7003,7004,7005,7006,7007,7008,7009,7010,7011,7012,7013,7014,7015,7016,7017'
);
foreach($com_address as $v1){
	$query="select a.mid from `#@__member` as a left join `#@__member_company` as b on a.mid=b.mid where b.nativeplace in (".$v1.") and a.jointime > '".$stamp."';";
  // echo $query;exit;
	$dsql->SetQuery($query);
	$dsql->Execute();
	$dsql->Query($query);
	$company_count[]= $dsql->GetTotalRow();
}
echo '
<table border="6" width="800" align="center">
<caption>个人会员注册量（2015-01-01至今）</caption>
<tr align="center">
  <td>安徽</td>
  <td>上海</td>
  <td>重庆</td>
  <td>江苏</td>
  <td>湖北</td>
</tr>
<tr align="center" bgcolor="D3E1CE">
  <td>'.$person_count[0].'</td>
  <td>'.$person_count[1].'</td>
  <td>'.$person_count[2].'</td>
  <td>'.$person_count[3].'</td>
  <td>'.$person_count[4].'</td>
</tr>
</table><br/><br/><br/>
<table border="6" width="800" align="center">
<caption>企业会员注册量（2015-01-01至今）</caption>
<tr align="center">
  <td>安徽</td>
  <td>上海</td>
  <td>重庆</td>
  <td>江苏</td>
  <td>湖北</td>
</tr>
<tr align="center" bgcolor="D3E1CE">
  <td>'.$company_count[0].'</td>
  <td>'.$company_count[1].'</td>
  <td>'.$company_count[2].'</td>
  <td>'.$company_count[3].'</td>
  <td>'.$company_count[4].'</td>
</tr>
</table>
<br/>
<form action="/home/registered_count.php" method="post">
	<input type="submit" value="刷新" style="display:block;margin:0 auto;" />
</form>
';
?>