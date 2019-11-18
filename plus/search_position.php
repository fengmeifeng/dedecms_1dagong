<?php
/**
 *
 * 搜索页
 *
 * @version        $Id: search.php 1 15:38 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
// echo '===';exit;
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(DEDEINC."/arc.searchview.class.php");
require_once(DEDEINC."/datalistcp.class.php");

$pagesize = (isset($pagesize) && is_numeric($pagesize)) ? $pagesize : 10;
$typeid = (isset($typeid) && is_numeric($typeid)) ? $typeid : 0;
$channeltype = (isset($channeltype) && is_numeric($channeltype)) ? $channeltype : 0;
$kwtype = (isset($kwtype) && is_numeric($kwtype)) ? $kwtype : 0;
$mid = (isset($mid) && is_numeric($mid)) ? $mid : 0;

if(!isset($orderby)) $orderby='';
else $orderby = preg_replace("#[^a-z]#i", '', $orderby);

if(!isset($searchtype)) $searchtype = 'titlekeyword';
else $searchtype = preg_replace("#[^a-z]#i", '', $searchtype);

if(!isset($keyword)){
    if(!isset($q)) $q = '';
    $keyword=$q;
}

$oldkeyword = $keyword = FilterSearch(stripslashes($keyword));
//接收其他参数
$timecon=intval($_GET['timecon']);
$con=intval($_GET['con']);
// echo $con;exit;
if(isset($con) && !empty($con)){
        //echo 'abc';exit;
        if($con==1){
            $sql="select * from #@__addgongzuo81 order by aid desc limit 8";
            // echo $sql;exit;
            $dsql->SetQuery($sql);
            // echo $dsql->queryString;exit;
            $dsql->Execute();
            $i=0;
            while($row = $dsql->GetArray()){
                $res[$i]=$row;
                $i++;
            }
            // var_dump($res);exit;
            $dlist = new DataListCP();
            $dlist->pageSize = 20;
            $dlist->SetTemplate(DEDETEMPLATE."/dgstyle/front_list.htm");
            $dlist->SetSource($res);
            $dlist->Display();
            exit;
        }
    }
// echo $timecon;exit;
if(isset($timecon) && !empty($timecon)){
        switch ($timecon){
            case 1:
                $timestamp=time();
                $whereSql .= "And ($timestamp-shuaxintime < 3600*24*3)";
                break;
            case 2:
                $timestamp=time();
                $whereSql .= "And ($timestamp-shuaxintime < 3600*24*5)";
                break;
            case 3:
                $timestamp=time();
                $whereSql .= "And ($timestamp-shuaxintime < 3600*24*7)";
                break;
            case 4:
                $timestamp=time();
                $whereSql .= "And ($timestamp-shuaxintime < 3600*24*15)";
                break;
        }
}
// echo $whereSql;exit;

//查找栏目信息
if(empty($typeid))
{
    $typenameCacheFile = DEDEDATA.'/cache/typename.inc';
    if(!file_exists($typenameCacheFile) || filemtime($typenameCacheFile) < time()-(3600*24) )
    {
        $fp = fopen(DEDEDATA.'/cache/typename.inc', 'w');
        fwrite($fp, "<"."?php\r\n");
        $dsql->SetQuery("Select id,typename,channeltype From `#@__arctype`");
        $dsql->Execute();
        while($row = $dsql->GetArray())
        {
            fwrite($fp, "\$typeArr[{$row['id']}] = '{$row['typename']}';\r\n");
        }
        fwrite($fp, '?'.'>');
        fclose($fp);
    }
    //引入栏目缓存并看关键字是否有相关栏目内容
    require_once($typenameCacheFile);
    if(isset($typeArr) && is_array($typeArr))
    {
        foreach($typeArr as $id=>$typename)
        {
            //$keywordn = str_replace($typename, ' ', $keyword);
            $keywordn = $keyword;
            if($keyword != $keywordn)
            {
                $keyword = HtmlReplace($keywordn);
                $typeid = intval($id);
                break;
            }
        }
    }
}

$keyword = addslashes(cn_substr($keyword,30));
$typeid = intval($typeid);

if($cfg_notallowstr !='' && preg_match("#".$cfg_notallowstr."#i", $keyword))
{
    ShowMsg("你的搜索关键字中存在非法内容，被系统禁止！","-1");
    exit();
}

if(($keyword=='' || strlen($keyword)<2) && empty($typeid))
{
    ShowMsg('关键字不能小于2个字节！','-1');
    exit();
}

//检查搜索间隔时间
$lockfile = DEDEDATA.'/time.lock.inc';
$lasttime = file_get_contents($lockfile);
if(!empty($lasttime) && ($lasttime + $cfg_search_time) > time())
{
    ShowMsg('管理员设定搜索时间间隔为'.$cfg_search_time.'秒，请稍后再试！','-1');
    exit();
}

//开始时间
if(empty($starttime)) $starttime = -1;
else
{
    $starttime = (is_numeric($starttime) ? $starttime : -1);
    if($starttime>0)
    {
       $dayst = GetMkTime("2008-1-2 0:0:0") - GetMkTime("2008-1-1 0:0:0");
       $starttime = time() - ($starttime * $dayst);
  }
}

$t1 = ExecTime();
//限定在工作库里进行搜索
$typeid=41;
$sp = new SearchView($typeid,$keyword,$orderby,$channeltype,$searchtype,$starttime,$pagesize,$kwtype,$mid,$whereSql);
$keyword = $oldkeyword;
$count=$sp->TotalResult;
//将计数放入globals数组，可以在模版中用标签调用
$GLOBALS['position_count'] =$count; 
$GLOBALS['thiskeyword'] =$keyword;
$sp->Display();
PutFile($lockfile, time());

//echo ExecTime() - $t1;