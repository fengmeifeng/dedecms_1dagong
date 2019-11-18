<?php
/**
 * 文档发布器
 * 
 * @version        $Id: archives_add.php 1 13:52 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(dirname(__FILE__)."/config.php"); 
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/userlogin.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
$channelid = isset($channelid) && is_numeric($channelid) ? $channelid : 1;
$typeid = isset($typeid) && is_numeric($typeid) ? $typeid : 0;
$mtypesid = isset($mtypesid) && is_numeric($mtypesid) ? $mtypesid : 0;
$menutype = 'content';

/*-------------
function _ShowForm(){  }
--------------*/
if(empty($dopost))
{
    $cInfos = $dsql->GetOne("Select * From `#@__channeltype`  where id='$channelid'; ");
	
    if(!is_array($cInfos))
    {
        ShowMsg('模型不存在', '-1');
        exit();
    }

    //如果限制了会员级别或类型，则允许游客投稿选项无效
    if($cInfos['sendrank']>0 || $cInfos['usertype']!='')
    {
        CheckRank(0,0);
    }

    //检查会员等级和类型限制
    if($cInfos['sendrank'] > $cfg_ml->M_Rank)
		{
        $row = $dsql->GetOne("Select membername From `#@__arcrank` where rank='".$cInfos['sendrank']."' ");
        ShowMsg("对不起，需要[".$row['membername']."]才能在这个频道发布文档！","-1","0",5000);
        exit();
    }
    if($cInfos['usertype']!='' && $cInfos['usertype'] != $cfg_ml->M_MbType)
    {
        ShowMsg("对不起，需要[".$cInfos['usertype']."帐号]才能在这个频道发布文档！","-1","0",5000);
        exit();
    }
	//判断个人和企业
	$row1 = $dsql->GetOne("SELECT `mtype`,`rank` FROM #@__member WHERE mid='$cfg_ml->M_ID'");
	if($row1['mtype'] == "企业"){
	//------------------------------------------------------------------冯-----检索出公司名称
	$row_company = $dsql->GetOne("SELECT `company`,`nativeplace`,`comface`,`comface` FROM #@__member_company WHERE mid='$cfg_ml->M_ID'");
	//echo $row_company['company'];exit;
	//echo $cInfos['needpic'];exit;
    include(DEDEMEMBER."/mystyles/pt_gongzuo.htm");//===========================
	}
	else{
	ShowMsg("对不起，您不是企业用户不能发布职位！","-1","0",5000);
	}
    exit();
}
/*------------------------------
function _SaveArticle(){  }
------------------------------*/
else if($dopost=='save')
{
    //如果招聘人数为空，不允许提交 By Z
    if(empty($zprenshu)){
        ShowMsg('请输入招聘人数！','-1');
        exit();
    }
    include(dirname(__FILE__).'/inc/archives_check_gongzuo.php');
	//echo $litpic;exit;
    //分析处理附加表数据
    $inadd_f = $inadd_v = '';
    if(!empty($dede_addonfields))
    {
        $addonfields = explode(';',$dede_addonfields);
        $inadd_f = '';
        $inadd_v = '';
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
                    ${$vs[0]} = AnalyseHtmlBody(${$vs[0]},$description,$vs[1]);
                }

                ${$vs[0]} = GetFieldValueA(${$vs[0]},$vs[1],0);

                $inadd_f .= ','.$vs[0];
                $inadd_v .= " ,'".${$vs[0]}."' ";
            }
        }
        
        if (empty($dede_fieldshash) || $dede_fieldshash != md5($dede_addonfields.$cfg_cookie_encode))
        {
            showMsg('数据校验不对，程序返回', '-1');
            exit();
        }
        
        // 这里对前台提交的附加数据进行一次校验
        $fontiterm = PrintAutoFieldsAdd($cInfos['fieldset'],'autofield', FALSE);
        if ($fontiterm != $inadd_f)
        {
            ShowMsg("提交表单同系统配置不相符,请重新提交！", "-1");
            exit();
        }
    }

    //处理图片文档的自定义属性
    if($litpic!='') $flag = 'p';

    //生成文档ID
    $arcID = GetIndexKey($arcrank,$typeid,$sortrank,$channelid,$senddate,$mid);
    if(empty($arcID))
    {
        ShowMsg("无法获得主键，因此无法进行后续操作！","-1");
        exit();
    }
	//-------------------------------------------------------处理tags
	 $tags= implode(',',$_POST['tags']); //exit;
	 //------------------------------------------------------转化成时间戳
	 // echo $lasttime;exit;
	  $lasttime = strtotime($_POST['lasttime']);
	 
	 //echo $gzname;exit;

	//--------------------------------------------------------------------如果会员通过审核职位也就已审核---------冯
	$row_s = $dsql->GetOne("Select `spacesta` From `#@__member` where mid='$cfg_ml->M_ID'");
	if($row_s['spacesta'] == '-1'){
	$arcrank=-1;
	}elseif($row_s['spacesta'] == '2'){
	$arcrank=0;
	}
	//------------------------------------------------------------------------------------------------公司名称------
	$writer=$gzname;//echo $writer;exit;
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

	//--------------------------------------------------------------------------------------------------------------
	//echo $arcrank;exit;

	
    //保存到主表
    $inQuery = "INSERT INTO `#@__archives`(id,typeid,sortrank,flag,ismake,channel,arcrank,click,money,title,shorttitle,
color,writer,source,litpic,pubdate,senddate,mid,description,keywords,mtype)
VALUES ('$arcID','$typeid','$sortrank','$flag','$ismake','$channelid','$arcrank','0','$money','$title','$shorttitle',
'$color','$writer','$source','$litpic','$pubdate','$senddate','$mid','$description','$keywords','$mtypesid'); ";
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        $gerr = $dsql->GetError();
        $dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID' ");
        ShowMsg("把数据保存到数据库主表 `#@__archives` 时出错，请联系管理员。","javascript:;");
        exit();
    }

    //保存到附加表
    $addtable = trim($cInfos['addtable']);
    if(empty($addtable))
    {
        $dsql->ExecuteNoneQuery("Delete From `#@__archives` where id='$arcID'");
        $dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID'");
        ShowMsg("没找到当前模型[{$channelid}]的主表信息，无法完成操作。","javascript:;");
        exit();
    }
    else
    {
        $inquery = "INSERT INTO `{$addtable}`(aid,typeid,userip,redirecturl,templet{$inadd_f}) Values('$arcID','$typeid','$userip','',''{$inadd_v})";
        if(!$dsql->ExecuteNoneQuery($inquery))
        {
            $gerr = $dsql->GetError();
            $dsql->ExecuteNoneQuery("Delete From `#@__archives` where id='$arcID'");
            $dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID'");
            ShowMsg("把数据保存到数据库附加表 `{$addtable}` 时出错<br>error:{$gerr}，请联系管理员！","javascript:;");
            exit();
        }
    }

    //增加积分
    $dsql->ExecuteNoneQuery("Update `#@__member` set scores=scores+{$cfg_sendarc_scores} where mid='".$cfg_ml->M_ID."' ; ");
    //更新统计
    countArchives($channelid);

    //生成HTML
    InsertTags($tags,$arcID);
    $artUrl = MakeArt($arcID,true);
    if($artUrl=='')
    {
        $artUrl = $cfg_phpurl."/view.php?aid=$arcID";
    }
    
    #api{{
    if(defined('UC_API') && @include_once DEDEROOT.'/api/uc.func.php')
    {
        //推送事件
        $feed['icon'] = 'thread';
        $feed['title_template'] = '<b>{username} 在网站发布了一篇内容</b>';
        $feed['title_data'] = array('username' => $cfg_ml->M_UserName);
        $feed['body_template'] = '<b>{subject}</b><br>{message}';
        $url = !strstr($artUrl,'http://') ? ($cfg_basehost.$artUrl) : $artUrl;        
        $feed['body_data'] = array('subject' => "<a href=\"".$url."\">$title</a>", 'message' => cn_substr(strip_tags(preg_replace("/\[.+?\]/is", '', $description)), 150));
        $feed['images'][] = array('url' => $cfg_basehost.'/images/scores.gif', 'link'=> $cfg_basehost);
        uc_feed_note($cfg_ml->M_LoginID,$feed);
        //同步积分
        $row = $dsql->GetOne("SELECT `scores`,`userid` FROM `#@__member` WHERE `mid`='".$cfg_ml->M_ID."'");
        uc_credit_note($row['userid'],$cfg_sendarc_scores);
    }
    #/aip}}
    
    //会员动态记录
    $cfg_ml->RecordFeeds('add', $title, $description, $arcID);
    
    ClearMyAddon($arcID, $title);
    
     //返回成功信息
   ShowMsg('职位发布成功','gongzuo.php?channelid=81',0,3000);
    /*$msg = "
    　　请选择你的后续操作：
        <a href='archives_add.php?cid=$typeid&channelid=$channelid'><u>继续发布内容</u></a>
        &nbsp;&nbsp;
        <a href='$artUrl' target='_blank'><u>查看内容</u></a>
        &nbsp;&nbsp;
        <a href='archives_edit.php?channelid=$channelid&aid=$arcID'><u>更改内容</u></a>
        &nbsp;&nbsp;
        <a href='content_list.php?channelid={$channelid}'><u>已发布内容管理</u></a>
        ";
    $wintitle = "成功发布内容！";
    $wecome_info = "内容管理::发布内容";
    $win = new OxWindow();
    $win->AddTitle("成功发布内容：");
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow("hand","&nbsp;",false);
    $win->Display();*/
}