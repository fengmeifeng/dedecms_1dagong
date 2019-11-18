<?php

	/**
	 * 根据条件从数据库筛选职位
	 * by Z
	 */	

	require_once(dirname(__FILE__)."/../include/common.inc.php");		//加载核心处理文件
	require_once(dirname(__FILE__)."/config.php");
	require_once(DEDEINC."/typelink.class.php");
	require_once(DEDEINC."/datalistcp.class.php");

	//接收页面传过来的搜索条件
	$position=trim($_POST['position']);	//职位
	$workarea=$_POST['workarea'];	//地区	
	// $hotposition=$_POST['hotposition'];	//热门职位	
	$work_domain=$_POST['work_domain'];	//行业领域
	$updatetime=$_POST['updatetime'];	//更新时间

	//组装查询条件
	if(isset($position) && !empty($position)){
		$position = cn_substr(trim(preg_replace("#[><\|\"\r\n\t%\*\.\?\(\)\$ ;,'%-]#", "", stripslashes($position))),30);
    	$position = addslashes($position);
    	$whereSql .= " zwmiaoshu like '%$position%' ";
	}
	if(isset($workarea) && !empty($workarea)){
		$whereSql .= "And (workarea == $workarea)";
	}
	if(isset($work_domain) && !empty($work_domain)){
		$whereSql .= "And (work_domain == $work_domain)";
	}
	if(isset($updatetime) && !empty($updatetime)){
		switch ($updatetime){
			case 1:
				$timestamp=time();
				$whereSql .= "And ($timestamp-shuaxintime < 3600*24*3)";
				break;
			case 2:
				$timestamp=time();
				$whereSql .= "And ($timestamp-shuaxintime < 3600*24*5)";
				break;
		}
	}
	//处理同时有职位条件和热门职位条件的情况
	/*if(isset($hotposition) && !empty($hotposition)){
		if($hotposition!=$position){
			$whereSql .= "And (hotposition == $hotposition)";
		}
	}*/

	//数据库查询
	$sql="select * from #@__addgongzuo81 where ".$whereSql;
	// echo $sql;exit;
	$dsql->SetQuery($sql);
	$dsql->Execute();
	$i=0;
	while($row = $dsql->GetArray()){
		$res[$i]=$row;
		$i++;
	}
	$dlist = new DataListCP();
	$dlist->pageSize = 20;
	$dlist->SetTemplate(DEDETEMPLATE."/dgstyle/list.htm");
	$dlist->SetSource($res);
	$dlist->Display();
		