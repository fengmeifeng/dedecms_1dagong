<?php
function sp_input( $text ) 
{ $text = trim( $text ); $text = htmlspecialchars( $text ); 
if (!get_magic_quotes_gpc()) return addslashes( $text ); else return $text; } $autotime = 3600;//�Զ�����ʱ��,��λΪ��,��������ΪһСʱ,��ҿ������и���. 
$fpath = "../data/last_time.inc";//��¼����ʱ���ļ�,������ܴﵽĿ��,�����Ƿ��ж�ȡȨ��. 
include( $fpath ); if( empty($last_time)) $last_time = 0; if( sp_input($_GET['renew'])=="now") $last_time = 0; if((time()-$last_time)>=$autotime ) { define('DEDEADMIN', ereg_replace("[/\\]{1,}",'/',dirname(__FILE__) ) ); require_once(DEDEADMIN."/../include/common.inc.php"); 
require_once(DEDEINC."/arc.partview.class.php"); 
/* $row = $dsql->GetOne("Select * From dede_homepageset"); $dsql->Close(); $templet=$row['templet']; $position=$row['position']; */ $templet = "templets/dgstyle/index_3.htm";//��������ҳģ��λ��,��ǰ��dedeĬ������λ��. 
$position = "../index.html"; $homeFile = dirname(__FILE__)."/".$position; $homeFile = str_replace("\\", "/", $homeFile ); $homeFile = str_replace( "//", "/", $homeFile ); $pv = new PartView(); $pv ->SetTemplet( $cfg_basedir.$cfg_templets_dir."/".$templet ); $pv -> SaveToHtml( $homeFile ); $pv -> Close(); $file = fopen( $fpath, "w"); fwrite( $file, "<?php\n"); fwrite( $file,"\$last_time=".time().";\n"); fwrite( $file, '?>' ); fclose( $file ); } ?>