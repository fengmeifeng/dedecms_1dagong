<?php
/**
 *
 * 文档统计
 *
 * 如果想显示点击次数,请增加view参数,即把下面ＪＳ调用放到文档模板适当位置
 * <script src="{dede:field name='phpurl'/}/count.php?view=yes&aid={dede:field name='id'/}&mid={dede:field name='mid'/}" language="javascript"></script>
 * 普通计数器为
 * <script src="{dede:field name='phpurl'/}/count.php?aid={dede:field name='id'/}&mid={dede:field name='mid'/}" language="javascript"></script>
 *
 * @version        $Id: count.php 1 20:43 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");

if(isset($aid)) $arcID = $aid;

$cid = empty($cid)? 1 : intval(preg_replace("/[^-\d]+[^\d]/",'', $cid));
$arcID = $aid = empty($arcID)? 0 : intval(preg_replace("/[^\d]/",'', $arcID));

$maintable = '#@__archives'; $idtype='id'; 

$work='#@__addwork6';       //添加表

/*---更据时间段随机取出数据---------------------------------------------*/
if($h>=19 and $h<=23){
	$num=rand(2,10);			//随机数
}elseif($h>=9 and $h<=18){
	$num=rand(0,10);			//随机数
}elseif($H>=7 and $h<=8){
	$num=rand(1,2);				//随机数
}elseif($h>=00 and $h<=6){
	$num=1;						//随机数
}
//------------------------------------------------------------
if($aid==0) exit();

//获得频道模型ID
if($cid < 0)
{
    $row = $dsql->GetOne("SELECT addtable FROM `#@__channeltype` WHERE id='$cid' AND issystem='-1';");
    $maintable = empty($row['addtable'])? '' : $row['addtable'];
    $idtype='aid';
}

//UpdateStat();
if(!empty($maintable))
{
    $dsql->ExecuteNoneQuery(" UPDATE `{$work}` SET baomingshu=baomingshu+{$num} WHERE aid='$aid' ");
}
if(!empty($view))
{
    $row = $dsql->GetOne(" SELECT baomingshu FROM `{$maintable}` join `{$work}` on `{$work}`.aid=`{$maintable}`.id WHERE {$idtype}='$aid' ");
    if(is_array($row))
    {
        echo "document.write('".$row['baomingshu']."');\r\n";
    }
}
exit();