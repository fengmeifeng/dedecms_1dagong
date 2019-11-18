<?php
 /*
 * 查看报名
*/
header("Content-type: text/html;charset=utf-8");
define('IN_QISHI', true);
/*
require_once(dirname(__FILE__).'/../include/common.inc.php');
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'app';
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
*/
require_once('mysql.class.php');
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$dbname="test1";
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
?>
<div align="center">
<table width="80%" border="1" cellspacing="1" style="border-collapse: collapse" bordercolorlight="#000000" bordercolordark="#000000">
  <tr>
    <td colspan="6" align="center" valign="middle">有才你就来报名明细</td>
    </tr>
  <tr>
 <td align="center" valign="middle">编号</td>
    <td align="center" valign="middle">姓名</td>
    <td align="center" valign="middle">性别</td>
    <td align="center" valign="middle">民族</td>
    <td align="center" valign="middle">婚否</td>
    <td align="center" valign="middle">身高</td>
    <td align="center" valign="middle">出生年月</td>
    <td align="center" valign="middle">政治面貌</td>
    <td align="center" valign="middle">文化程度</td> 
    <td align="center" valign="middle">联系电话</td>
    <td align="center" valign="middle">身份证号</td>
    <td align="center" valign="middle">现居住地</td>
    <td align="center" valign="middle">现工作单位和职务</td>  
    <td align="center" valign="middle">工作经历</td>  
    <td align="center" valign="middle">个人特长</td>
    <td align="center" valign="middle">人生故事</td>
    <td align="center" valign="middle">理想工作和职位</td>
    <td align="center" valign="middle">下载用户简历图片</td>
    <td align="center" valign="middle">报名时间</td>
  </tr><?php
$exec="select * from ycnjl order by id";
$result=mysql_query($exec);
while($rs=mysql_fetch_object($result))
{
echo"<tr>";
 echo" <td align=\"center\" valign=\"middle\">".$rs->id."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->xingming."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->xingbie."</td>";
    echo" <td align=\"center\" valign=\"middle\">".$rs->mingzu."</td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->hunfou."</td>";
  echo" <td align=\"center\" valign=\"middle\">".$rs->shengao."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->chusheng."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->zhengzhi."</td>";
    echo" <td align=\"center\" valign=\"middle\">".$rs->wenhua."</td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->dianhua."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->haoma."</td>";
     echo" <td align=\"center\" valign=\"middle\">".$rs->juzhudi."</td>";
   echo" <td align=\"center\" valign=\"middle\">".$rs->zhiwu."</td>";
    echo" <td align=\"center\" valign=\"middle\">".$rs->gongzuo."</td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->techang."</td>";
   echo"  <td align=\"center\" valign=\"middle\">".$rs->jinli."</td>";
    echo"  <td align=\"center\" valign=\"middle\">".$rs->lixiang."</td>";
 echo"  <td align=\"center\" valign=\"middle\"><a href=\"http://www.1jobs.cn/ycnjl/".$rs->wdurl."\">下载简历</a>&nbsp; &nbsp; 
 <a href=\"http://www.1jobs.cn/ycnjl/".$rs->url."\">下载图片</a>
 </td>";
  echo"  <td align=\"center\" valign=\"middle\">".$rs->time."</td>";
 echo" </tr>";
 }
 ?>
</table></div>