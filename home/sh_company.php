<?php
/**
 * 内容列表
 * 
 * @version        $Id: content_list.php 1 13:52 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
//CheckRank(0,0);
require_once(DEDEINC."/typelink.class.php");
require_once(DEDEINC."/datalistcp.class.php");
require_once(DEDEMEMBER."/inc/inc_list_functions.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
if(!isset($spacesta)) $spacesta = '';

//----------------------------------------查询所有企业会员
	/*$sql="select * from #@__member where mtype='企业'";
	$dsql->SetQuery($sql);
	$dsql->Execute();
	$i=0;
	while($row = $dsql->GetArray()){
		$res[$i]=$row;
		$i++;
	}*/
	//var_dump($res);exit;
	//echo "<pre>";print_r($res);exit;
//-----------------------------------------------------查询所有企业会员

//接收参数，组装查询条件 By Z
if(isset($company_name) && $company_name!=''){
	$GLOBALS['company_name']=$company_name;
	$ksqls[] = " c.company like '%".$company_name."%' ";
}
if(isset($start) && isset($end) && $start!='' && $end!=''){
	$start=strtotime($start);
	$end=strtotime($end);
	$ksqls[] = " m.jointime>'".$start."' and m.jointime<'".$end."'";
}
if(isset($shenhe_sta) && $shenhe_sta!=0){
	$ksqls[] = " m.spacesta = '".$shenhe_sta."' ";
}
if(isset($zhizhao_sta) && $zhizhao_sta!=-1){
	if($zhizhao_sta==0){
		$ksqls[] = " d.zhizhao is null ";
	}else{
		$ksqls[] = " d.zhizhao != '' ";
	}
}
//增加一个销售姓名搜索
if(isset($xiaoshou) && $xiaoshou!=''){
	$ksqls[] = "c.xiaoshou like '%".$xiaoshou."%' ";
}
//搜索是企业会员
$ksqls[] = " m.mtype='企业' ";
$WhereSql = join(' AND ',$ksqls);
//搜索屏道模版80的所有内容
//$whereSql = " where arc.channel = '$channelid' and arcrank in(-1,0)";
// echo $whereSql;exit;

//$query = "select m.mid,m.uname,c.company,m.jointime,m.spacesta,m.mtype,d.zhizhao from `#@__member` as  m left join `#@__member_company` as c left join  `#@__diyzhizhao` as d on m.mid=c.mid  $whereSql order by m.mid desc ";
$query="select m.mid,m.userid,m.uname,c.company,c.xiaoshou,m.jointime,m.spacesta,m.mtype,d.zhizhao,m.sphone from (`#@__member` as m left join `#@__member_company` as c on m.mid=c.mid) left join `#@__diyzhizhao` as d on m.mid=d.mid where $WhereSql order by m.mid desc ";
//echo $fields['spacesta'];exit;
// echo $query;exit;
//print_r($fields);exit;
//---------------------------------------------------------营业执照

$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetTemplate(DEDEMEMBER."/mystyles/sh_company.htm");
$dlist->SetSource($query);
$dlist->Display();