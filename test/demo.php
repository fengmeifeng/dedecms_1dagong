<?php
$a=1;
//传值结果2和1
//传地址结果2和2
	function add($a){
		$a=$a+1;
		echo $a."<br>";
	
	}
	add($a);
	echo $a;
	echo "<br>";


//数组
$cites[]="北京";
$cites[]="上海";
$cites[]="天津";
$cites[]="南京";
$cites[]="深圳";
$cites[]="北京";
$cutes_index=count($cites);
for( $i=0; $i < $cutes_index; $i++)
{
	echo "第".$i."个城市是".$cites[$i]."<br>";

}

$arr=array("v","d","t","e","m");
sort($arr);

//3



//1.产生随机字符串函数

function random($length) {
$hash = "";
$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
$max = strlen($chars) - 1;
mt_srand((double)microtime() * 1000000);
for($i = 0; $i < $length; $i++) {
$hash .= $chars[mt_rand(0, $max)];
}
return $hash;
}
echo random(4)."<br>";

//2.截取一定长度的字符串

//注：该函数对GB2312使用有效

function wordscut($string, $length ,$sss=0) {
if(strlen($string) > $length) {
if($sss){
$length=$length - 3;
$addstr=' …';
}
for($i = 0; $i < $length; $i++) {
if(ord($string[$i]) > 127) {
$wordscut .= $string[$i].$string[$i + 1];
$i++;
} else {
$wordscut .= $string[$i];
}
}
return $wordscut.$addstr;

}
return $string;
}
echo wordscut('abcdefghijklmnopqrstuvwxyz',30)."<br>";
//3.取得客户端IP地址

function GetIP(){
if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
$ip = getenv("HTTP_CLIENT_IP");
else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
$ip = getenv("HTTP_X_FORWARDED_FOR");
else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
$ip = getenv("REMOTE_ADDR");
else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
$ip = $_SERVER['REMOTE_ADDR'];
else
$ip = "unknown";
return($ip);
}
echo GetIP();

//4.创建相应的文件夹

function createdir($dir="")
{
if (!is_dir($dir))
{
$temp = explode('/',$dir);
$cur_dir = "";
for($i=0;$i<count($temp);$i++)
{
$cur_dir .= $temp[$i].'/';
if (!is_dir($cur_dir))
{
@mkdir($cur_dir,0777);
}
}
}
}

createdir("d")."<br>";
//5.判断邮箱地址

function checkEmail($inAddress)
{
return (ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+",$inAddress));

}
echo checkEmail("1323232")."<br>";


//6.跳转
function gotourl($message="",$url="",$title="")
{

$html  ="<html><head>";
if(!empty($url))
$html .="<meta http-equiv='refresh' content=\"3;url='".$url."'\">";
$html .="<link href='../templates/style.css' type=text/css rel=stylesheet>";
$html .="</head><body><br><br><br><br>";
$html .="<table cellspacing='0′ cellpadding='0′ border='1′ width='450′ align='center'>";
$html .="<tr><td bgcolor='#ffffff'>";
$html .="<table border='1′ cellspacing='1′ cellpadding='4′ width='100%'>";
$html .="<tr class='m_title'>";
$html .="<td>".$title."</td></tr>";
$html .="<tr class='line_1′><td align='center' height='60′>";
$html .="<br>".$message."<br><br>";
if (!empty($url))
$html .="系统将在3秒后返回<br>如果您的浏览器不能自动返回,请点击[<a href=".$url." target=_self>这里</a>]进入";
else
$html .="[<a href='#' onclick='history.go(-1)'>返回</a>]";
$html .="</td></tr></table></td></tr></table>";
$html .="</body></html>";
echo $html;
exit;
}

//7.分页（两个函数配合使用）

function getpage($sql,$page_size=20)
{
global $page,$totalpage,$sums;  //out param
$page = $_GET["page"];
//$eachpage = $page_size;
$pagesql = strstr($sql," from ");
$pagesql = "select count(*) as ids ".$pagesql;
$result = mysql_query($pagesql);
if($rs = mysql_fetch_array($result)) $sums = $rs[0];
$totalpage = ceil($sums/$page_size);
if((!$page)||($page<1)) $page=1;
$startpos = ($page-1)*$page_size;
$sql .=" limit $startpos,$page_size ";
return $sql;
}

function showbar($string="")
{
global $page,$totalpage;
$out="共<font color='red'><b>".$totalpage."</b></font>页&nbsp;&nbsp;";
$linkNum =4;
$start = ($page-round($linkNum/2))>0 ? ($page-round($linkNum/2)) : "1";
$end   = ($page+round($linkNum/2))<$totalpage ? ($page+round($linkNum/2)) : $totalpage;
$prestart=$start-1;
$nextend=$end+1;
if($page<>1)
$out .= "<a href='?page=1&&".$string."'title=第一页>第一页</a>&nbsp;";
if($start>1)
$out.="<a href='?page=".$prestart."'title=>..<<</a>&nbsp;";
for($t=$start;$t<=$end;$t++)
{
$out .= ($page==$t) ? "<font color='red'><b>[".$t."]</b></font>&nbsp;" : "<a href='?page=$t&&".$string."'>$t</a>&nbsp;";
}
if($end<$totalpage)
$out.="<a href='?page=".$nextend."&&".$string."' title=>>>..</a>";
if($page<>$totalpage)
$out .= "&nbsp;<a href='?page=".$totalpage."&&".$string."' title=最后页>最后页</a>";
return $out;
}

 /*
php中单引号与双引号的区别
单引号内部的变量不会执行
双引号会执行
 */
 $name="Hello";
 echo "双引号输出："."the $name".'<br>';
 echo '单引号输出：'.'the  $name';



/*
这个用PHP写的函数,可以获取任意的字符串$string中的所有链接地址($string可以是从一个HTML页面文件直接读取出来的字符串),结果保存在一个数组中返回.该函数自动把电子邮件地址排除在外,而且返回的数组中不会有重复元素. 
*/
 function GetAllLink($string) 
{ 
$string = str_replace("\r","",$string); 
$string = str_replace("\n","",$string); 

$regex[url] = "((http|https|ftp|telnet|news):\/\/)?([a-z0-9_\-\/\.]+\.[][a-z0-9:;&#@=_~%\?\/\.\,\+\-]+)"; 
$regex[email] = "([a-z0-9_\-]+)@([a-z0-9_\-]+\.[a-z0-9\-\._\-]+)"; 

//去掉标签之间的文字 
$string = eregi_replace(">[^<>]+<","><", $string); 

//去掉JAVASCRIPT代码 
$string = eregi_replace("<!--.*//-->","", $string); 

//去掉非<a>的HTML标签 
$string = eregi_replace("<[^a][^<>]*>","", $string); 

//去掉EMAIL链接 
$string = eregi_replace("<a([ ]+)href=([\"']*)mailto:($regex[email])([\"']*)[^>]*>","", $string); 

//替换需要的网页链接 
$string = eregi_replace("<a([ ]+)href=([\"']*)($regex[url])([\"']*)[^>]*>","\\3\t", $string); 

$output[0] = strtok($string, "\t"); 
while(($temp = strtok("\t"))) 
{ 
if($temp && !in_array($temp, $output)) 
$output[++$i] = $temp; 
} 

return $output; 
} 

GetAllLink("http://www.chinaahhbja.com/");







