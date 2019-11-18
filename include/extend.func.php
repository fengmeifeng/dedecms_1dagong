<?php
function litimgurls($imgid=0)
{
    global $lit_imglist,$dsql;
    //获取附加表
    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c 
                                                            ON a.channel=c.id where a.id='$imgid'");
    $addtable = trim($row['addtable']);
    
    //获取图片附加表imgurls字段内容进行处理
    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$imgid'");
    
    //调用inc_channel_unit.php中ChannelUnit类
    $ChannelUnit = new ChannelUnit(2,$imgid);
    
    //调用ChannelUnit类中GetlitImgLinks方法处理缩略图
    $lit_imglist = $ChannelUnit->GetlitImgLinks($row['imgurls']);
    
    //返回结果
    return $lit_imglist;

	
}
//---------------------------------------------------前台调用联动
function Getsysenum($fields){
global $dsql;
$row = $dsql->GetOne("select * from dede_sys_enum where evalue = '".$fields."'");
//echo "<pre>";print_r($row);exit;
if(!is_array($row)){
return "联动类别不存在";
}
else{
return $row['ename'];
}
}
//------------------------------------------------------前台调用联动2
function GetInfoType($tid,$bigt) { 
	global $dsql; $typename = ''; 
	$query = "Select ename From `dede_sys_enum` where evalue=$tid and egroup='$bigt'"; 
	$dsql->Execute('ename',$query); 
	while($row = $dsql->GetArray('ename')) { 
		$typename .= ($typename=='' ? $row['ename'] : ','.$row['ename']);
		} 
		return $typename;
	}

//-----------------------------------------------------清除html样式
	function clearhtml($a){
	return strip_tags($a);
	}

//===========================================2015-03-12 17-12-39========搜索页面调用自定义字段====start====这是第一处，第二处在include/arc.searchview.class.php==========

 function Search_addfields($id,$result){
    global $dsql;
    $mnkj = $dsql->GetOne("SELECT * FROM `zjobs_addgongzuo81` where aid='$id'");
    $name=$mnkj[$result];
    return $name;
 }