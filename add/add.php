<?php
/*define('IN_QISHI', true);
require_once(dirname(__FILE__).'/../include/common.inc.php');
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'app';
require_once(QISHI_ROOT_PATH.'include/mysql.class.php');*/
header("Content-type: text/html;charset=utf-8");
define('IN_QISHI', true);

require_once('mysql.class.php');
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$dbname="test1";
$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
$as=$db->getone("SELECT * FROM ycnjl WHERE dianhua ='{$_POST['dianhua']}' LIMIT 1");
 if($as['dianhua']!='')
				{ echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"你已经报过名了\");\r\n";   echo " history.back();\r\n";   echo "</script>";
					exit;  
				}

if ($_POST['xingming']=='' || $_POST['xingbie']=='' ||$_POST['mingzu']==''||$_POST['hunfou']==''||$_POST['shengao']==''||$_POST['chusheng']==''||$_POST['zhengzhi']==''|| $_POST['wenhua']=='' || $_POST['dianhua']=='' || $_POST['juzhudi']=='' || $_POST['haoma']=='' || $_POST['zhiwu']==''|| $_POST['gongzuo']==''|| $_POST['techang']==''|| $_POST['jinli']==''|| $_POST['lixiang']=='')
{
echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"请填写完整信息再提交\");\r\n";   echo " location.replace(\"http://www.1jobs.cn/ycnjl/index.html\");\r\n";   echo "</script>";   exit; 
		}

$uptypes1=array(
'application/msword',
'application/vnd.ms-powerpoint',
'application/vnd.ms-excel'
);  
$uptypes2=array(
'image/jpg', 
'image/jpeg',
'image/png',
'image/jpeg',
'image/gif',
'image/bmp',
'image/pjpeg',
'image/x-png'
);  
$max_file_size=20000000;   //上传文件大小限制, 单位BYTE
$path_parts=pathinfo($_SERVER['PHP_SELF']); //取得当前路径
$time=time();
$destination_folder=date("Y",$time).'/'; //上传文件路径
$destination_folder .=date("m",$time).'/'; //上传文件路径

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
if (!is_uploaded_file($_FILES["upfile"][tmp_name][0]))
//是否存在文件
{
echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"视频文件没有上传\");\r\n";   echo " history.back();\r\n";   echo "</script>";
					exit;  
}
if (!is_uploaded_file($_FILES["upfile"][tmp_name][1]))
//是否存在文件
{

echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"图片文件没有上传\");\r\n";   echo " history.back();\r\n";   echo "</script>";
					exit;  
}

 $file = $_FILES["upfile"];
 if($max_file_size < $file["size"][0])
 //检查文件大小
 {
 echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"视频文件太大！\");\r\n";   echo " history.back();\r\n";   echo "</script>";
					exit;  
  }
if($max_file_size < $file["size"][1])
 //检查文件大小
 {
 echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"图片文件太大！\");\r\n";   echo " history.back();\r\n";   echo "</script>";
					exit;  
  }

 if(!in_array($file["type"][0], $uptypes1))  
    //检查文件类型  
    {  
        echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"视频文件类型不符！\");\r\n";   echo " history.back();\r\n";   echo "</script>";
					exit;  
    }  
   if(!in_array($file["type"][1], $uptypes2))  
    //检查文件类型  
    {  
           echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"图片文件类型不符！\");\r\n";   echo " history.back();\r\n";   echo "</script>";
					exit;   
    }  
  

if(!file_exists($destination_folder))
if(!mkdir($destination_folder,0777,true)){
	echo "<font color='red'>您创建目录失败,请手动创建！</a>";
}
$filename1=$file["tmp_name"][0];
$filename2=$file["tmp_name"][1];
$image_size = getimagesize($filename2);  
$pinfo1=pathinfo($file["name"][0]);
$pinfo2=pathinfo($file["name"][1]);
$ftype1=$pinfo1[extension];
$ftype2=$pinfo2[extension];
$firstname=$_POST['dianhua'];
$destination1 = $destination_folder.$firstname."doc".time().".".$ftype1;
$destination2 = $destination_folder.$firstname."pic".time().".".$ftype2;
if (file_exists($destination1) && $overwrite != true)
{
     echo "<font color='red'>相同文件已经存在了！</a>";
     exit;
  }
  if (file_exists($destination2) && $overwrite != true)
{
     echo "<font color='red'>相同图片文件已经存在了！</a>";
     exit;
  }

 if(!move_uploaded_file ($filename1, $destination1))
 {
   echo "<font color='red'>移动文件出错！</a>";
     exit;
  }

 if(!move_uploaded_file ($filename2, $destination2))
 {
   echo "<font color='red'>移动图片文件出错！</a>";
     exit;
  }


}

$xingming=$_POST['xingming'];
$xingbie=$_POST['xingbie'];
$mingzu=$_POST['mingzu'];
$hunfou=$_POST['hunfou'];
$shengao=$_POST['shengao'];
$chusheng=$_POST['chusheng'];
$zhengzhi=$_POST['zhengzhi'];
$wenhua=$_POST['wenhua'];
$dianhua=$_POST['dianhua'];
$juzhudi=$_POST['juzhudi'];
$haoma=$_POST['haoma'];
$zhiwu=$_POST['zhiwu'];
$gongzuo=$_POST['gongzuo'];
$techang=$_POST['techang'];
$jinli=$_POST['jinli'];
$lixiang=$_POST['lixiang'];
$time=Date('Y-m-d H:i:s',time());
//echo $xingming;
//echo $xingbie;
//echo $time;
echo "INSERT INTO ycnjl(xingming,xingbie,mingzu,hunfou,wdurl,url,shengao,chusheng,zhengzhi,wenhua,dianhua,juzhudi,haoma,zhiwu,gongzuo,techang,jinli,lixiang,time)VALUES('{$xingming}','{$xingbie}','{$mingzu}','{$hunfou}','{$destination1}','{$destination2}','{$shengao}','{$chusheng}','{$zhengzhi}','{$wenhua}','{$dianhua}','{$juzhudi}','{$haoma}','{$zhiwu}','{$gongzuo}','{$techang}','{$jinli}','{$lixiang}','{$time}')";
exit;
$db->query("INSERT INTO ycnjl (xingming,xingbie,mingzu,hunfou,wdurl,url,shengao,chusheng,zhengzhi,wenhua,dianhua,juzhudi,haoma,zhiwu,gongzuo,techang,jinli,lixiang,time) VALUES ('{$xingming}','{$xingbie}','{$mingzu}','{$hunfou}','{$destination1}','{$destination2}','{$shengao}','{$chusheng}','{$zhengzhi}','{$wenhua}','{$dianhua}','{$juzhudi}','{$haoma}','{$zhiwu}','{$gongzuo}','{$techang}','{$jinli}','{$lixiang}','{$time}')");

//print_r($res);


echo "<script language=\"JavaScript\">\r\n";   echo " alert(\"报名成功,请保持手机畅通，等待工作人员联系您！\");\r\n";  echo " location.replace(\"http://www.1jobs.cn/ycnjl/\");\r\n";   echo "</script>";   exit; 		
?>
