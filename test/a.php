<?php
$nowtime=time();
$pastsec=$nowtime-$_GET["t"];
if ($pastsec<3600)
{
exit; //5分钟更新一次，时间可以自己调整
}
ob_start(); //打开缓冲区
include("index.php");
$content=ob_get_contents(); //得到缓冲区的内容
$content.="\n<script language=javascript src=\"m.php?t=".$nowtime."\"></script>"; //加上调用更新程序的代码

file_put_contents("index.html",$content);

if (!function_exists("file_put_contents"))
{
function file_put_contents($fn,$fs)
{
$fp=fopen($fn,"w");
fputs($fp,$fs);
fclose($fp);   
}
}
