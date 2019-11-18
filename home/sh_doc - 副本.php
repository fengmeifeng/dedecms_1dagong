<?php
/**
 * 发布信息管理
 * 
 * @version        $Id: archives_do.php 1 13:52 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
if(empty($dopost)) $dopost = '';
$mid = isset($mid) && is_numeric($mid) ? $mid : 0;
$mtype = isset($mtype) && trim($mtype) ? $mtype : '企业';
if(!isset($spacesta)) $spacesta = '';
//if($spacesta == -1){$spacesta=2;}else if($spacesta == 2){$spacesta=-1;}
//echo $aid."<br>" ;echo $channelid;exit;
/*-----------------
function delStow()
删除收藏
------------------*/
if($dopost=="delStow")
{
    CheckRank(0,0);
    $type=empty($type)? 'sys' : trim($type);
    $ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL']) ? "mystow.php" : $_COOKIE['ENV_GOBACK_URL'];
    $dsql->ExecuteNoneQuery("DELETE FROM #@__member_stow WHERE aid='$aid' AND mid='".$cfg_ml->M_ID."' AND type='$type';");
    //更新用户统计
    $row = $dsql->GetOne("SELECT COUNT(*) AS nums FROM `#@__member_stow` WHERE `mid`='".$cfg_ml->M_ID."' ");
    $dsql->ExecuteNoneQuery("UPDATE #@__member_tj SET `stow`='$row[nums]' WHERE `mid`='".$cfg_ml->M_ID."'");
        
    ShowMsg("成功删除一条收藏记录！",$ENV_GOBACK_URL);
    exit();
}

/*-----------------
function addArchives()
添加投稿
------------------*/
else if($dopost=="addArc")
{
    if($channelid==1)
    {
        $addcon = 'pt_job.php?channelid='.$channelid;
    }
    else if($channelid==2)
    {
        $addcon = 'album_add.php?channelid='.$channelid;
    }
    else if($channelid==3)
    {
        $addcon = 'soft_add.php?channelid='.$channelid;
    }
    else
    {
        $row = $dsql->GetOne("SELECT useraddcon FROM `#@__channeltype` WHERE id='$channelid' ");
        if(!is_array($row))
        {
            ShowMsg("模型参数错误!","-1");
            exit();
        }
        $addcon = $row['useraddcon'];
        if(trim($addcon)=='')
        {
            $addcon = 'pt_job.php';
        }
        $addcon = $addcon."?channelid=$channelid";
    }
    header("Location:$addcon");
    exit();
}

/*-----------------
function editArchives()
修改投稿
------------------*/
else if($dopost=="edit")
{
	
	
    CheckRank(0,0);
    if($mtype == '企业')
    {
        $edit = 'sh_edit_c.php?mid='.$mid;
    }
   
    else
    {
		//echo $channelid;exit;
        $row = $dsql->GetOne("SELECT usereditcon FROM `#@__channeltype` WHERE id='$channelid' ");
		
        if(!is_array($row))
        {
            ShowMsg("参数错误!","-1");
            exit();
        }
		
		$edit = $row['usereditcon'];
		
        if(trim($edit)=='')
        {
            $edit = 'sh_edit.php';
        }
        $edit = $edit."?channelid=$channelid";
		//echo  $edit ;exit;
    }
	
	header("Location:$edit");
    //header("Location:$edit"."&aid=$aid");
    exit();
}


/*--------------------
function shenheArchives()
审核文章
--------------------*/
else if($dopost=="shenheArc")
{
    //CheckRank(0,0);
    include_once(DEDEMEMBER."/inc/inc_batchup.php");
    $ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL']) ? 'shenhe.php?channelid=' : $_COOKIE['ENV_GOBACK_URL'];


    $equery = "SELECT m.mid,m.jointime,m.uname,c.company,m.spacesta FROM `#@__member` as  m
               LEFT JOIN `#@__member_company` as c  ON m.mid=c.mid ";
	
    $row = $dsql->GetOne($equery);
	//echo "<pre>";print_r($row);exit;
    if(!is_array($row))
    {
        ShowMsg("你没有权限审核这篇发布信息！","-1");
        exit();
    }
	

    $mtype = $row['mtype'];
	//-----------------------------------------------------已审核和未审核互换
	if($spacesta == 2){
		$spacesta=-1;
		$arcrank=-1;
		}elseif($spacesta == -1){
			$spacesta=2;
			$arcrank=0;
			}
	
	//修改审核
	 if(trim($row['spacesta'])!='')
    {
		
		//echo $row['spacesta']."<br>";echo $spacesta;exit;
		$res=$dsql->ExecuteNoneQuery("UPDATE `#@__member`  SET  spacesta='$spacesta'  WHERE  mid=$mid");
		//--------------------------------更新发布的职位-----------------------------------------------------
		$dsql->ExecuteNoneQuery("UPDATE `#@__archives`  SET  arcrank='$arcrank'  WHERE  mid=$mid");
		//---------------------------------------------------------------------------------------------------
     	
    }

    if($res)
    {
       ShowMsg("审核成功！",$ENV_GOBACK_URL);
        exit();
    }
    else
    {
      ShowMsg("审核失败！",$ENV_GOBACK_URL);
      exit();
    }
    exit();
}


/*--------------------
function delArchives()
删除文章
--------------------*/
else if($dopost=="delArc")
{
    CheckRank(0,0);
    include_once(DEDEMEMBER."/inc/inc_batchup.php");
    $ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL']) ? 'shenhe_company.php?channelid=' : $_COOKIE['ENV_GOBACK_URL'];


    $equery = "SELECT m.userid,m.mid,m.uname,m.jointime,c.company,m.spacesta,m.mtype FROM `#@__member` as m
               LEFT JOIN `#@__member_company` as c  ON m.mid=c.mid WHERE m.mid='$mid' ";
	
   
	$row = $dsql->GetOne($equery);
	
    if(!is_array($row))
    { 
		
        ShowMsg("你没有权限删除这篇发布信息！","-1");
        exit();
    }
	 

  

    $mtype = $row['mtype'];
    $row['litpic'] = (isset($arr['litpic']) ? $arr['litpic'] : '');

    //删除会员信息
	$sql="delete  FROM `#@__member`  WHERE mid='$mid'";$rs = $db->ExecuteNoneQuery($sql); 
	$sql_company="delete  FROM `#@__member_company`  WHERE mid='$mid'";$rs_company = $db->ExecuteNoneQuery($sql_company);
	//echo "232323";exit;
    if($rs && $rs_company)
    {
        //更新用户记录
       // countArchives($channelid);
        //扣除积分
       // $dsql->ExecuteNoneQuery("Update `#@__member` set scores=scores-{$cfg_sendarc_scores} where mid='".$cfg_ml->M_ID."' And (scores-{$cfg_sendarc_scores}) > 0; ");
	   //echo $channelid;exit;
	    ShowMsg("成功删除企业会员信息！",$ENV_GOBACK_URL);
        exit();
    }
    else
    {
      ShowMsg("删除发布信息失败！",$ENV_GOBACK_URL);
      exit();
    }
    exit();
}

/*-----------------
function viewArchives()
查看文章
------------------*/
else if($dopost=="viewArchives")
{
    CheckRank(0,0);
    if($type==""){
        header("location:".$cfg_phpurl."/view.php?aid=".$aid);
    }else{
        header("location:/book/book.php?bid=".$aid);
    }
}

/*--------------
function DelUploads()
删除上传的附件
----------------*/
else if($dopost=="delUploads")
{
    CheckRank(0,0);
    if(empty($ids))
    {
        $ids = '';
    }

    $tj = 0;
    if($ids=='')
    {
        $arow = $dsql->GetOne("SELECT url,mid FROM `#@__uploads` WHERE aid='$aid'; ");
        if(is_array($arow) && $arow['mid']==$cfg_ml->M_ID)
        {
            $dsql->ExecuteNoneQuery("DELETE FROM `#@__uploads` WHERE aid='$aid'; ");
            if(file_exists($cfg_basedir.$arow['url']))
            {
                @unlink($cfg_basedir.$arow['url']);
            }
        }
        $tj++;
    }
    else
    {
        $ids = explode(',',$ids);
        foreach($ids as $aid)
        {
            $aid = preg_replace("#[^0-9]#", "", $aid);
            $arow = $dsql->GetOne("SELECT url,mid From #@__uploads WHERE aid='$aid'; ");
            if(is_array($arow) && $arow['mid']==$cfg_ml->M_ID)
            {
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__uploads` WHERE aid='$aid'; ");
                $tj++;
                if(file_exists($cfg_basedir.$arow['url']))
                {
                    @unlink($cfg_basedir.$arow['url']);
                }
            }
        }
    }
    ShowMsg("成功删除 $tj 个附件！",$ENV_GOBACK_URL);
    exit();
}