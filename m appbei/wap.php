<?php
require_once (dirname(__FILE__) . "/include/common.inc.php");
header("Content-Type: text/html; charset=utf-8");
//header("Content-type:text/vnd.wap.wml");
require_once(dirname(__FILE__)."/include/wap.inc.php");
if(empty($action)) $action = 'index';
$cfg_templets_dir = $cfg_basedir.$cfg_templets_dir;
$channellist = '';
$newartlist = '';
$channellistnext = '';

//顶级导航列表
$dsql->SetQuery("Select id,typename From `#@__arctype` where reid=0 And channeltype=1 And ishidden=0 And ispart<>2 order by sortrank");
$dsql->Execute();
while($row=$dsql->GetObject())
{
	$channellist .= "<li><a href='wap.php?action=list&amp;typeid={$row->id}' data-icon='grid'>{$row->typename}</a></li> ";
}

//当前时间
$curtime = strftime("%Y-%m-%d %H:%M:%S",time());
$cfg_webname = ConvertStr($cfg_webname);

//主页
/*------------
function __index();
------------*/
if($action=='index')
{
	//最新文章
	$dsql->SetQuery("Select id,typeid,title,pubdate,click From `#@__archives` where channel=66 And arcrank = 0 order by id desc limit 0,10");
	$dsql->Execute();
	while($row=$dsql->GetObject())
	{
		$newartlist .= "<li><a href='wap.php?action=article&amp;typeid={$row->typeid}&amp;id={$row->id}'><h3>".ConvertStr($row->title)."</h3> <p class='ui-li-aside'>[".date("m-d",$row->pubdate)."]</p><span class='ui-li-count'>{$row->click}</span></a></li>";
	}
	//显示WML
	include($cfg_templets_dir."/wap/index.wml");
	$dsql->Close();
	echo $pageBody;
	exit();
}
/*------------
function __list();
------------*/
//列表
else if($action=='list')
{
	$needCode = 'utf-8';
	$typeid = preg_replace("[^0-9]", '', $typeid);
	if(empty($typeid)) exit('Error!');

	//当前栏目下级分类
	//$typeid = preg_replace("[^0-9]", '', intval($_GET[typeid]));
	$dsql->SetQuery("Select id,typename From `#@__arctype` where reid='{$typeid}' And channeltype=1 And ishidden=0 And ispart<>2 order by sortrank");
	$dsql->Execute();
	while($row=$dsql->GetObject())
	{
		$channellistnext .= "<li><a href='wap.php?action=list&amp;typeid={$row->id}'>".ConvertStr($row->typename)."</a></li> ";
	}

	require_once(dirname(__FILE__)."/include/datalistcp.class.php");
	$row = $dsql->GetOne("Select typename,ishidden From `#@__arctype` where id='$typeid' ");
	if($row['ishidden']==1) exit();
	$typename = ConvertStr($row['typename']);
	//栏目内容(分页输出)
	$sids = GetSonIds($typeid,1,true);
	$varlist = "cfg_webname,typename,channellist,channellistnext,cfg_templeturl";
	ConvertCharset($varlist);
	$dlist = new DataListCP();
	$dlist->SetTemplet($cfg_templets_dir."/wap/list.wml");
	$dlist->pageSize = 10;
	$dlist->SetParameter("action","list");
	$dlist->SetParameter("typeid",$typeid);
	$dlist->SetSource("Select id,title,pubdate,click From `#@__archives` where typeid in($sids) And arcrank=0 order by id desc");
	$dlist->Display();
	exit();
}
//文档
/*------------
function __article();
------------*/
else if($action=='article')
{
	//文档信息
	$query = "
	  Select tp.typename,tp.reid,tp.ishidden,arc.typeid,arc.title,arc.arcrank,arc.pubdate,arc.writer,arc.click,addon.body From `#@__archives` arc 
	  left join `#@__arctype` tp on tp.id=arc.typeid
	  left join `#@__addonarticle` addon on addon.aid=arc.id
	  where arc.id='$id'
	";
	$row = $dsql->GetOne($query,MYSQL_ASSOC);
	foreach($row as $k=>$v) $$k = $v;
	unset($row);
	$pubdate = strftime("%y-%m-%d %H:%M:%S",$pubdate);
	if($arcrank!=0) exit();
	$title = ConvertStr($title);
	$body = html2wml($body);
	if($ishidden==1) exit();

	//当前栏目同级分类
	//$reid = $reid;
	//if($typeid){
		//获取当前栏目上级分类id
		//$dsql->SetQuery("Select reid From `#@__arctype` where id='{$typeid}' And channeltype=1 And ishidden=0 And ispart<>2 limit 1");
		//$dsql->Execute();
		//如果获取到了数据
		//if($row=$dsql->GetObject()){
			//$reid = $row->reid;
			$dsql->SetQuery("Select id,typename From `#@__arctype` where reid='{$reid}' And channeltype=1 And ishidden=0 And ispart<>2 order by sortrank");
			$dsql->Execute();
			while($row=$dsql->GetObject())
			{
				$channellistnext .= "<li><a href='wap.php?action=list&amp;typeid={$row->id}'>".ConvertStr($row->typename)."</a></li> ";
			}
		//}
	//}

	//栏目内容(分页输出)
	include($cfg_templets_dir."/wap/article.wml");
	$dsql->Close();
	echo $pageBody;
	exit();
}
//错误
/*------------
function __error();
------------*/
else
{
	ConvertCharset($varlist);
	include($cfg_templets_dir."/wap/error.wml");
	$dsql->Close();
	ConvertCharset($varlist);
	echo $pageBody;
	exit();
}
?>
