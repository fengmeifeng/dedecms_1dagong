<?php
/**
 * 文档编辑器
 * 
 * @version        $Id: archives_edit.php 1 13:52 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
$channelid = isset($channelid) && is_numeric($channelid) ? $channelid : 1;
$aid = isset($aid) && is_numeric($aid) ? $aid : 0;
$mtypesid = isset($mtypesid) && is_numeric($mtypesid) ? $mtypesid : 0;
$menutype = 'content';

/*-------------
function _ShowForm(){  }
--------------*/
if(empty($dopost))
{
    //读取归档信息
    $arcQuery = "SELECT arc.*,ch.addtable,ch.fieldset,arc.mtype as mtypeid,ch.arcsta
       FROM `#@__archives` arc LEFT JOIN `#@__channeltype` ch ON ch.id=arc.channel
       WHERE arc.id='$aid' And arc.mid='".$cfg_ml->M_ID."'; ";
    $row = $dsql->GetOne($arcQuery);
    if(!is_array($row))
    {
        ShowMsg("读取文档信息出错!","-1");
        exit();
    }
    else if($row['arcrank']>=0)
    {
        $dtime = time();
        $maxtime = $cfg_mb_editday * 24 *3600;
        if($dtime - $row['senddate'] > $maxtime)
        {
            ShowMsg("这篇文档已经锁定，你不能再修改它！","-1");
            exit();
        }
    }
    $addRow = $dsql->GetOne("SELECT * FROM `{$row['addtable']}` WHERE aid='$aid'; ");
    $cInfos = $dsql->GetOne("SELECT * FROM `#@__channeltype`  WHERE id='{$row['channel']}'; ");

	//------------------------------------------------------------------冯-----检索出公司名称
	$row_company = $dsql->GetOne("SELECT `company`,`comface` FROM #@__member_company WHERE mid='$cfg_ml->M_ID'");
	//echo $row_company['comface'];exit;
	//echo $addRow['lasttime'];exit;
    include(DEDEMEMBER."/mystyles/gongzuo_edit.htm");
    exit();
}

/*------------------------------
function _SaveArticle(){  }
------------------------------*/
else if($dopost=='save')
{
	
    include(DEDEMEMBER.'/inc/archives_check_edit_gongzuo.php');
	//echo $litpic;exit;
    //分析处理附加表数据
    $inadd_f = $inadd_m = '';
    if(!empty($dede_addonfields))
    {
        $addonfields = explode(';', $dede_addonfields);
        if(is_array($addonfields))
        {
            foreach($addonfields as $v)
            {
                if($v=='')
                {
                    continue;
                }
                $vs = explode(',',$v);
                if(!isset(${$vs[0]}))
                {
                    ${$vs[0]} = '';
                }

                //自动摘要和远程图片本地化
                if($vs[1]=='htmltext'||$vs[1]=='textdata')
                {
                    ${$vs[0]} = AnalyseHtmlBody(${$vs[0]}, $description, $vs[1]);
                }

                ${$vs[0]} = GetFieldValueA(${$vs[0]}, $vs[1], $aid);
                $inadd_m .= ','.$vs[0];
                $inadd_f .= ','.$vs[0]." ='".${$vs[0]}."' ";
            }
        }

        if (empty($idhash) || $idhash != md5($aid.$cfg_cookie_encode))
        {
            showMsg('数据校验不对，程序返回', '-1');
            exit();
        }
        
        // 这里对前台提交的附加数据进行一次校验

        $fontiterm = PrintAutoFieldsAdd($cInfos['fieldset'],'autofield', FALSE);
		//echo $fontiterm."<br>";echo $inadd_f;exit;
        if ($fontiterm != $inadd_m)
        {
            ShowMsg("提交表单同系统配置不相符,请重新提交！", "-1");
            exit();
        }//echo 323232;exit;

    }
    //处理图片文档的自定义属性
    if($litpic!='') $flag = 'p';
	
	//-------------------------------------------------------处理tags
	 $tags= implode(',',$_POST['tags']); //exit;
	 $lasttime = strtotime($_POST['lasttime']);
	 $pubdate = time();
	 //------------------------------------------------------转化成时间戳  
	 //echo $lasttime;exit;
	//--------------------------------------------------------------------如果会员通过审核职位也就已审核---------冯
	$row_s = $dsql->GetOne("Select `spacesta` From `#@__member` where mid='$cfg_ml->M_ID'");
	if($row_s['spacesta'] == '-1'){
	$arcrank=-1;
	}elseif($row_s['spacesta'] == '2'){
	$arcrank=0;
	}
	//--------------------------------------------------------------------------------------------------------------

    //更新数据库的SQL语句
    $upQuery = "UPDATE `#@__archives` SET
              ismake='$ismake',
              arcrank='$arcrank',
              typeid='$typeid',
              title='$title',
              litpic='$litpic',
              description='$description',
              keywords='$keywords',  
              mtype = '$mtypesid',
			  writer='$gzname',
			  pubdate = '$pubdate',        
              flag='$flag'
     WHERE id='$aid' And mid='$cfg_ml->M_ID'; ";
    
    if(!$dsql->ExecuteNoneQuery($upQuery))
    {
        ShowMsg("把数据保存到数据库主表时出错，请联系管理员！".$dsql->GetError(),"-1");
        exit();
    }
	//--------------------------------------------------------------------------------------------同时更新企业会员表
	$upQuery_company = "UPDATE `#@__member_company` SET      
              company='$gzname'
     WHERE  mid='$cfg_ml->M_ID'; ";
	if(!$dsql->ExecuteNoneQuery($upQuery_company))
    {
        ShowMsg("把数据保存到数据库企业会员表时出错，请联系管理员！".$dsql->GetError(),"-1");
        exit();
    }
	//echo $gzname;exit;
	//---------------------------------------------------------------------------------------------------------------

    if($addtable!='')
    {
        $upQuery = "UPDATE `$addtable` SET typeid='$typeid'{$inadd_f}, userip='$userip' WHERE aid='$aid' ";
        if(!$dsql->ExecuteNoneQuery($upQuery))
        {
            ShowMsg("更新附加表 `$addtable`  时出错，请联系管理员！","javascript:;");
            exit();
        }
    }
    $arcrank = empty($arcrank)? 0 : $arcrank;
    $sortrank = empty($sortrank)? 0 : $sortrank;
    UpIndexKey($aid, $arcrank, $typeid, $sortrank, $tags);
    $artUrl = MakeArt($aid, TRUE);
    if($artUrl=='') $artUrl = $cfg_phpurl."/view.php?aid=$aid";

    //返回成功信息
	 ShowMsg('修改成功','gongzuo.php?channelid=81',0,3000);

//----------------------------------------------------------------------------冯
	 /*------------------------------
function _SaveArticle(){  }
------------------------------*/
}else if($dopost=='pubArc')
{

	//---------------------------------------------------------------------------冯
	$row_arc = $dsql->GetOne("Select `typeid`,`litpic`,`title` From `#@__archives` where id='$aid'");
	$title = $row_arc['title'];
	$typeid = $row_arc['typeid'];
	$litpic = $row_arc['litpic'];
	//print_r($row_arc);exit;

    include(DEDEMEMBER.'/inc/archives_check_edit_gongzuo.php');
	//echo $litpic;exit;
    //分析处理附加表数据
    $inadd_f = $inadd_m = '';
    if(!empty($dede_addonfields))
    {
        $addonfields = explode(';', $dede_addonfields);
        if(is_array($addonfields))
        {
            foreach($addonfields as $v)
            {
                if($v=='')
                {
                    continue;
                }
                $vs = explode(',',$v);
                if(!isset(${$vs[0]}))
                {
                    ${$vs[0]} = '';
                }

                //自动摘要和远程图片本地化
                if($vs[1]=='htmltext'||$vs[1]=='textdata')
                {
                    ${$vs[0]} = AnalyseHtmlBody(${$vs[0]}, $description, $vs[1]);
                }

                ${$vs[0]} = GetFieldValueA(${$vs[0]}, $vs[1], $aid);
                $inadd_m .= ','.$vs[0];
                $inadd_f .= ','.$vs[0]." ='".${$vs[0]}."' ";
            }
        }

        if (empty($idhash) || $idhash != md5($aid.$cfg_cookie_encode))
        {
            showMsg('数据校验不对，程序返回', '-1');
            exit();
        }
        
        // 这里对前台提交的附加数据进行一次校验

        $fontiterm = PrintAutoFieldsAdd($cInfos['fieldset'],'autofield', FALSE);
		//echo $fontiterm."<br>";echo $inadd_f;exit;
        if ($fontiterm != $inadd_m)
        {
            ShowMsg("提交表单同系统配置不相符,请重新提交！", "-1");
            exit();
        }//echo 323232;exit;

    }
    //处理图片文档的自定义属性
    if($litpic!='') $flag = 'p';
	
	//-------------------------------------------------------处理tags
	 $tags= implode(',',$_POST['tags']); //exit;
	 $lasttime = strtotime($_POST['lasttime']);
	 $pubdate = time();
	 //------------------------------------------------------转化成时间戳  
	 //echo $lasttime;exit;
	//--------------------------------------------------------------------如果会员通过审核职位也就已审核---------冯
	$row_s = $dsql->GetOne("Select `spacesta` From `#@__member` where mid='$cfg_ml->M_ID'");
	if($row_s['spacesta'] == '-1'){
	$arcrank=-1;
	}elseif($row_s['spacesta'] == '2'){
	$arcrank=0;
	}
	//---------------------------keywords='$keywords',--------------------------------------------------------------------

    //更新数据库的SQL语句
    $upQuery = "UPDATE `#@__archives` SET
              ismake='$ismake',
              arcrank='$arcrank',
              typeid='$typeid',
              title='$title',
              litpic='$litpic',
              description='$description',
              mtype = '$mtypesid',
			  pubdate = '$pubdate',        
              flag='$flag'
     WHERE id='$aid' And mid='$mid'; ";
    
    if(!$dsql->ExecuteNoneQuery($upQuery))
    {
        ShowMsg("把数据保存到数据库主表时出错，请联系管理员！".$dsql->GetError(),"-1");
        exit();
    }

    if($addtable!='')
    {
        $upQuery = "UPDATE `$addtable` SET typeid='$typeid'{$inadd_f}, userip='$userip' WHERE aid='$aid' ";
        if(!$dsql->ExecuteNoneQuery($upQuery))
        {
            ShowMsg("更新附加表 `$addtable`  时出错，请联系管理员！","javascript:;");
            exit();
        }
    }
    $arcrank = empty($arcrank)? 0 : $arcrank;
    $sortrank = empty($sortrank)? 0 : $sortrank;
    UpIndexKey($aid, $arcrank, $typeid, $sortrank, $tags);
    $artUrl = MakeArt($aid, TRUE);
    if($artUrl=='') $artUrl = $cfg_phpurl."/view.php?aid=$aid";

    //返回成功信息
	 ShowMsg('刷新职位成功','gongzuo.php?channelid=81',0,3000);
   /* $msg = "　　请选择你的后续操作：
        <a href='archives_add.php?cid=$typeid&channelid=$channelid'><u>发布新内容</u></a>
        &nbsp;&nbsp;
        <a href='archives_edit.php?channelid=$channelid&aid=".$aid."'><u>查看更改</u></a>
        &nbsp;&nbsp;
        <a href='$artUrl' target='_blank'><u>查看内容</u></a>
        &nbsp;&nbsp;
        <a href='content_list.php?channelid=$channelid'><u>管理内容</u></a>
        ";
    $wintitle = "成功更改内容！";
    $wecome_info = "内容管理::更改内容";
    $win = new OxWindow();
    $win->AddTitle("成功更改内容：");
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow("hand","&nbsp;",false);
    $win->Display();*/
}