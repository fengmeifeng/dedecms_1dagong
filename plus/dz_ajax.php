<?php
/**
 *
 * 文档digg处理ajax文件
 *
 * @version        $Id: digg_ajax.php 2 13:00 2011/11/25 tianya $
 * @package        DedeCMS.Plus
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");
$action = isset($action) ? trim($action) : '';
$id = empty($id)? 0 : intval(preg_replace("/[^\d]/",'', $id));

helper('cache');

if($id < 1)
{
    exit();
}

$maintable = '#@__addzhengwen';

$prefix = 'diggCache';
$key = 'aid-'.$id;
$row = GetCache($prefix, $key);
$rand_num = rand(1,2);//=====================2个数之间的随机点击数,如10-20之间=============

if(!is_array($row) || $cfg_digg_update==0)
{
  $row = $dsql->GetOne("SELECT goodpost,badpost,scores FROM `$maintable` WHERE aid='$id' ");
	
    if($cfg_digg_update == 0)
    {
		if($action == 'good')
		{
			$row['goodpost'] = $row['goodpost'] + $rand_num;		//显示当前数量
			$dsql->ExecuteNoneQuery("UPDATE `$maintable` SET scores = scores + {$cfg_caicai_add},goodpost=goodpost+".$rand_num.",lastpost=".time()." WHERE aid='$id'");
		}
		else if($action=='bad')
		{
			$row['badpost'] = $row['badpost'] + 1;
			$dsql->ExecuteNoneQuery("UPDATE `$maintable` SET scores = scores - {$cfg_caicai_sub},badpost=badpost+1,lastpost=".time()." WHERE aid='$id'");
		}
		DelCache($prefix, $key);
    }
  SetCache($prefix, $key, $row, 0);
} else {
	if($action == 'good')
	{
	    $row['goodpost'] = $row['goodpost'] + 1;
	    $row['scores'] = $row['scores'] + $cfg_caicai_sub;
	    if($row['goodpost'] % $cfg_digg_update == 0)
	    {
			$add_caicai_sub = $cfg_digg_update * $cfg_caicai_sub;

		    $dsql->ExecuteNoneQuery("UPDATE `$maintable` SET scores = scores + {$add_caicai_sub},goodpost=goodpost+{$cfg_digg_update} WHERE aid='$id'");
		    DelCache($prefix, $key);
	    }
	} else if($action == 'bad')
	{
	    $row['badpost'] = $row['badpost'] + 1;
		$row['scores'] = $row['scores'] - $cfg_caicai_sub;
	    if($row['badpost'] % $cfg_digg_update == 0)
	    {
			$add_caicai_sub = $cfg_digg_update * $cfg_caicai_sub;
		    $dsql->ExecuteNoneQuery("UPDATE `$maintable` SET scores = scores - {$add_caicai_sub},badpost=badpost+{$cfg_digg_update} WHERE aid='$id'");
		    DelCache($prefix, $key);
	    }
	}
	SetCache($prefix, $key, $row, 0);
}

$digg = '';
if(!is_array($row)) exit();

if($row['goodpost'] + $row['badpost'] == 0)
{
    $row['goodper'] = $row['badper'] = 0;
}
else
{
    $row['goodper'] = number_format($row['goodpost'] / ($row['goodpost'] + $row['badpost']), 3) * 100;
    $row['badper'] = 100 - $row['goodper'];
}

if(empty($formurl)) $formurl = '';
if($formurl=='caicai')
{
    if($action == 'good') $digg = $row['goodpost'];
    if($action == 'bad') $digg  = $row['badpost'];
}
else
{
    $row['goodper'] = trim(sprintf("%4.2f", $row['goodper']));
    $row['badper'] = trim(sprintf("%4.2f", $row['badper']));
    $digg =
		'<div class="btn-group btn-group-xs">
		  <a type="button" class="btn btn-purple" onclick="javascript:postDigg(\'good\','.$id.')">我要点赞</a>
		  <a type="button" class="btn btn-default">'.$row['goodpost'].'</a>
		</div>';
}
AjaxHead();
echo $digg;
exit();
