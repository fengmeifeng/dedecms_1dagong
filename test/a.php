<?php
$nowtime=time();
$pastsec=$nowtime-$_GET["t"];
if ($pastsec<3600)
{
exit; //5���Ӹ���һ�Σ�ʱ������Լ�����
}
ob_start(); //�򿪻�����
include("index.php");
$content=ob_get_contents(); //�õ�������������
$content.="\n<script language=javascript src=\"m.php?t=".$nowtime."\"></script>"; //���ϵ��ø��³���Ĵ���

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
