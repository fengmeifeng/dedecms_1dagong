<?php
$a=1;
//��ֵ���2��1
//����ַ���2��2
	function add($a){
		$a=$a+1;
		echo $a."<br>";
	
	}
	add($a);
	echo $a;
	echo "<br>";


//����
$cites[]="����";
$cites[]="�Ϻ�";
$cites[]="���";
$cites[]="�Ͼ�";
$cites[]="����";
$cites[]="����";
$cutes_index=count($cites);
for( $i=0; $i < $cutes_index; $i++)
{
	echo "��".$i."��������".$cites[$i]."<br>";

}

$arr=array("v","d","t","e","m");
sort($arr);

//3



//1.��������ַ�������

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

//2.��ȡһ�����ȵ��ַ���

//ע���ú�����GB2312ʹ����Ч

function wordscut($string, $length ,$sss=0) {
if(strlen($string) > $length) {
if($sss){
$length=$length - 3;
$addstr=' ��';
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
//3.ȡ�ÿͻ���IP��ַ

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

//4.������Ӧ���ļ���

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
//5.�ж������ַ

function checkEmail($inAddress)
{
return (ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+",$inAddress));

}
echo checkEmail("1323232")."<br>";


//6.��ת
function gotourl($message="",$url="",$title="")
{

$html  ="<html><head>";
if(!empty($url))
$html .="<meta http-equiv='refresh' content=\"3;url='".$url."'\">";
$html .="<link href='../templates/style.css' type=text/css rel=stylesheet>";
$html .="</head><body><br><br><br><br>";
$html .="<table cellspacing='0�� cellpadding='0�� border='1�� width='450�� align='center'>";
$html .="<tr><td bgcolor='#ffffff'>";
$html .="<table border='1�� cellspacing='1�� cellpadding='4�� width='100%'>";
$html .="<tr class='m_title'>";
$html .="<td>".$title."</td></tr>";
$html .="<tr class='line_1��><td align='center' height='60��>";
$html .="<br>".$message."<br><br>";
if (!empty($url))
$html .="ϵͳ����3��󷵻�<br>�����������������Զ�����,����[<a href=".$url." target=_self>����</a>]����";
else
$html .="[<a href='#' onclick='history.go(-1)'>����</a>]";
$html .="</td></tr></table></td></tr></table>";
$html .="</body></html>";
echo $html;
exit;
}

//7.��ҳ�������������ʹ�ã�

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
$out="��<font color='red'><b>".$totalpage."</b></font>ҳ&nbsp;&nbsp;";
$linkNum =4;
$start = ($page-round($linkNum/2))>0 ? ($page-round($linkNum/2)) : "1";
$end   = ($page+round($linkNum/2))<$totalpage ? ($page+round($linkNum/2)) : $totalpage;
$prestart=$start-1;
$nextend=$end+1;
if($page<>1)
$out .= "<a href='?page=1&&".$string."'title=��һҳ>��һҳ</a>&nbsp;";
if($start>1)
$out.="<a href='?page=".$prestart."'title=>..<<</a>&nbsp;";
for($t=$start;$t<=$end;$t++)
{
$out .= ($page==$t) ? "<font color='red'><b>[".$t."]</b></font>&nbsp;" : "<a href='?page=$t&&".$string."'>$t</a>&nbsp;";
}
if($end<$totalpage)
$out.="<a href='?page=".$nextend."&&".$string."' title=>>>..</a>";
if($page<>$totalpage)
$out .= "&nbsp;<a href='?page=".$totalpage."&&".$string."' title=���ҳ>���ҳ</a>";
return $out;
}

 /*
php�е�������˫���ŵ�����
�������ڲ��ı�������ִ��
˫���Ż�ִ��
 */
 $name="Hello";
 echo "˫���������"."the $name".'<br>';
 echo '�����������'.'the  $name';



/*
�����PHPд�ĺ���,���Ի�ȡ������ַ���$string�е��������ӵ�ַ($string�����Ǵ�һ��HTMLҳ���ļ�ֱ�Ӷ�ȡ�������ַ���),���������һ�������з���.�ú����Զ��ѵ����ʼ���ַ�ų�����,���ҷ��ص������в������ظ�Ԫ��. 
*/
 function GetAllLink($string) 
{ 
$string = str_replace("\r","",$string); 
$string = str_replace("\n","",$string); 

$regex[url] = "((http|https|ftp|telnet|news):\/\/)?([a-z0-9_\-\/\.]+\.[][a-z0-9:;&#@=_~%\?\/\.\,\+\-]+)"; 
$regex[email] = "([a-z0-9_\-]+)@([a-z0-9_\-]+\.[a-z0-9\-\._\-]+)"; 

//ȥ����ǩ֮������� 
$string = eregi_replace(">[^<>]+<","><", $string); 

//ȥ��JAVASCRIPT���� 
$string = eregi_replace("<!--.*//-->","", $string); 

//ȥ����<a>��HTML��ǩ 
$string = eregi_replace("<[^a][^<>]*>","", $string); 

//ȥ��EMAIL���� 
$string = eregi_replace("<a([ ]+)href=([\"']*)mailto:($regex[email])([\"']*)[^>]*>","", $string); 

//�滻��Ҫ����ҳ���� 
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







