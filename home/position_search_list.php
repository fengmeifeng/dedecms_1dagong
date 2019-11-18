<?php
//职位搜索页
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(DEDEINC."/arc.searchview.class.php");
require_once(DEDEINC."/datalistcp.class.php");

if(!isset($keyword)){
    if(!isset($q)) $q = '';
    $keyword=$q;
}
//$oldkeyword = $keyword = FilterSearch(stripslashes($keyword));

$keyword = addslashes(cn_substr($keyword,30));

if($cfg_notallowstr !='' && preg_match("#".$cfg_notallowstr."#i", $keyword))
{
    ShowMsg("你的搜索关键字中存在非法内容，被系统禁止！","-1");
    exit();
}

/*if(($keyword=='' || strlen($keyword)<2) && empty($typeid))
{
    ShowMsg('关键字不能小于2个字节！','-1');
    exit();
}*/

//检查搜索间隔时间
$lockfile = DEDEDATA.'/time.lock.inc';
$lasttime = file_get_contents($lockfile);
if(!empty($lasttime) && ($lasttime + $cfg_search_time) > time())
{
    ShowMsg('管理员设定搜索时间间隔为'.$cfg_search_time.'秒，请稍后再试！','-1');
    exit();
}

/**********************组装查询条件**********************/
//时间查询条件
$timecon=intval($_GET['timecon']);
//$timecon=1;
$whereSql="where a.title like '%$keyword%'";
$timestamp=time();
if(isset($timecon) && !empty($timecon)){
        switch ($timecon){
            case 1:              
                $whereSql .= " And ($timestamp-a.pubdate < 3600*24*3)";
                break;
            case 2:
                $whereSql .= " And ($timestamp-a.pubdate < 3600*24*5)";
                break;
            case 3:
                $whereSql .= " And ($timestamp-a.pubdate < 3600*24*7)";
                break;
            case 4:
                $whereSql .= " And ($timestamp-a.pubdate < 3600*24*15)";
                break;
        }
}
//工资范围条件
if(isset($salarycon) && !empty($salarycon)){
        switch ($salarycon){
            case '面议':
                $whereSql .= " And (g.gongzi = '面议')";
                break;
            case '1000-2000':
                $whereSql .= " And (g.gongzi = '1000-2000')";
                break;
            case '2000-3000':
                $whereSql .= " And (g.gongzi = '2000-3000')";
                break;
            case '3000-5000':
                $whereSql .= " And (g.gongzi = '3000-5000')";
                break;
            case '5000-8000':
                $whereSql .= " And (g.gongzi = '5000-8000')";
                break;
            case '8000以上':
                $whereSql .= " And (g.gongzi = '8000以上')";
                break;    
        }
}
//行业类型条件
$professioncon=trim($_GET['professioncon']);
if(isset($professioncon) && !empty($professioncon)){
	$whereSql .= " And (g.typeid = $professioncon)";
}
if($keyword=='index'){
    // echo '111';exit;
	$query="select a.id,a.senddate,a.title,a.writer,g.gongzi,g.nativeplace,g.bmrenshu from `#@__archives` as a  left join `#@__addgongzuo81` as g on a.id=g.aid where a.arcrank > '-1' and ($timestamp-a.pubdate < 3600*24*15) order by g.aid desc";
}else{
    // echo '222';exit;
	$query="select a.id,a.senddate,a.title,a.writer,g.gongzi,g.nativeplace,g.bmrenshu from `#@__archives` as a  left join `#@__addgongzuo81` as g on a.id=g.aid $whereSql  and a.arcrank > '-1' and ($timestamp-a.pubdate < 3600*24*15) order by g.aid desc ";
}	
//echo $query;exit;
// $GLOBALS['keyword'] =$keyword;
$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetTemplate(DEDETEMPLATE."/dgstyle/list.htm");
$dlist->SetSource($query);
$dsql->SetQuery($query);
// var_dump($result);exit;
// echo $dsql->queryString;exit;
$dsql->Execute();
$dsql->Query($query);
// var_dump($dsql->GetArray());exit;

$GLOBALS['count']= $dsql->GetTotalRow();
// echo $GLOBALS['count'];exit;
if($GLOBALS['count']==-1){$GLOBALS['count']=0;}
//echo $dlist->getValues['totalresult'];exit;
$dlist->Display();

