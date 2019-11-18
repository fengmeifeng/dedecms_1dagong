<?php
namespace Collect\Controller;
use Library\Common\BaseController;
use Library\Query\TQuery;
use Library\Util\Tree;
use Library\Util\CThrift;
use Library\Util\Http;

class PatternController extends BaseController {
	
	/**
	 +----------------------------------------------------------
	 * <title:host列表>
	 * <nav:pattern管理>
	 * <display:nav>
	 * <sort:1>
	 +----------------------------------------------------------
	 * @return 
	 +----------------------------------------------------------
	 */
    public function hostList() {
    	if(IS_AJAX && I("isData","","intval") == 1) {
    		list($pageIndex,$perpage,$offset) = $this->getPageParam();
    		
    		$path = I("path","","trim");
    		$avro = I("avro","part-r-00000.avro","trim");
    		
    		$res = CThrift::getDomainList($path."/".$avro, $offset, $perpage);
    		$hlist = $res['data'];
    		
    		$list = $uuid = array();
    		$hostDesc = C("HOSTDESC");
    		$iMod = TQuery::TModel("Invalidurl");
    		
    		foreach($hlist as $k => $v) {
    			
    			$tmp['host'] = $tmp['link'] = $v;
    			$fix = strrchr($v,"_");
    			
    			if($fix) {
    				
    				$tmp['link'] = str_replace($fix, "", $v);//trim($v,$fix);
    			}
    			
    			//$tmp['hum_result'] = $iMod->isExistUrl(getHostUUid($tmp['link']));
    			
				$tmp['code_result'] = $hostDesc[$fix] ? $hostDesc[$fix] : "-";
    			
    			$list[] = $tmp;
    		}
    		
    		
    		$response['total'] = $res['total'];
    		$response['data'] = $list;
    		$this->response($response);
    	}else {
    		$pth = C("HADOOPPATH");
    		
    		$avroPath = $path = "";
    		$result = $avroList = array();
    		foreach($pth as $k => $v) {
    			if($k == 0) $path = $v;//$this->assign("path",$v);
    			 
    			$tmp['id'] = $v;
    			$tmp['value'] = $v;
    			 
    			$result[] = $tmp;
    		}
    		
    		$avro = CThrift::getPathList($path);
    		foreach($avro as $k => $v) {
    			if($k == 0) $avroPath = $v;//$this->assign("path",$v);
    		
    			$tmp['id'] = $v;
    			$tmp['value'] = $v;
    		
    			$avroList[] = $tmp;
    		}
    		
    		$this->assign("combopath",$this->formartComboboxData($result));
    		$this->assign("path",$path);
    		$this->assign("comboavro",$this->formartComboboxData($avroList));
    		$this->assign("avro",$avroPath);
    		
    		//获取type
    		$uMod = TQuery::TModel("Urlcategory");
    		$type = $uMod->getAllUrlcategory(array("status" => 1));
    		$types = array();
    		foreach($type as $k => $v) {
    			$tmp = "[".$v['id'].",\"".$v['name']."\"]";
    			$types[] = $tmp;
    		}
    		
    		$this->assign("types",implode(",", $types));
    		
    		$this->display();
    	}
    }
    
    public function viewSite() {
    	$host = I("host","","parseHost");
    	echo $host;
    	$content = @file_get_contents($host);
    	var_dump($content);
    	$this->assign("content",$content);
    	$this->display();
    }
    
    /*public function saveVaild() {
    	$host = I("host","","trim");
    	$type = I("type","","trim");
    	
    	$iMod = TQuery::TModel("Invalidurl");
    	$urlKey = getHostUUid($host);
    	
    	if($type == "submit") {
    		//先判断是否标记过
    		$c = $iMod->isExistUrl($urlKey);
    		 
    		if($c > 0) $this->response(array("status" => -1,"msg" => "已经标记","success" => true));
    		
    		$data['url'] = $host;
    		$data['uuid'] = $urlKey;
    		$data['dateline'] = UNIXTIME;
    		
    		if($iMod->create($data)) {
    			if($iMod->add($data)) {
    				$response = array("status" => 1,"msg" => "标记成功","success" => true,"target" => "hostlist","close" => true);
    			}else {
    				$response = array("status" => -1,"msg" => "标记失败","success" => true);
    			}
    		}else {
    			$response = array("status" => -1,"msg" => $iMod->getError(),"success" => true);
    		}
    		
    	}else if($type == "cancel") {
    		$res = $iMod->removeVaildUrl(array("uuid" => $urlKey));	
    		
    		if($res != false) {
    			$response = array("status" => 1,"msg" => "取消成功","success" => true,"target" => "hostlist");
    		}else {
    			$response = array("status" => -1,"msg" => "取消失败","success" => true);
    		}
    	}
    	
    	$this->response($response);
    }*/
    
    public function savePattern() {
    	$host = I("host","","trim");
    	$pattern = I("pattern","","trim");
    	$ptype = I("ptype","","intval");
    	$type = I("type","","trim");
    	 
    	$iMod = TQuery::TModel("Pattern");
    	$patternKey = getParamUUid($pattern);
    	 
    	if($type == "submit") {
    		//先判断是否标记过
    		$map['puuid'] = $patternKey;
    		//$map['type'] = $ptype;
    		$c = $iMod->isExistPattern($map);
    		
    		unset($map);
    		//if($c > 0) $this->response(array("status" => -1,"msg" => "已经标记","success" => true));
    
    		$data['url'] = $host;
    		$data['uuid'] = getParamUUid($host);
    		$data['pattern'] = $pattern;
    		$data['type'] = $ptype;
    		$data['puuid'] = getParamUUid($pattern);
    		$data['dateline'] = UNIXTIME;
    		$data['uid'] = getUserId();
    		//print_r($data);exit;
    		if($c > 0) {
    			$res = $iMod->where(array("puuid" => $data['puuid']))->save($data);
    			if($res === false) {
    				$response = array("status" => -1,"msg" => "没有修改标记","success" => true);
    			}else {
    				$response = array("status" => 1,"msg" => "标记成功","success" => true,"target" => "patternlist","close" => true);
    			}
    		}else {
    
	    		if($iMod->create($data)) {
	    			if($iMod->add($data)) {
	    				$response = array("status" => 1,"msg" => "标记成功","success" => true,"target" => "patternlist","close" => true);
	    			}else {
	    				$response = array("status" => -1,"msg" => "标记失败","success" => true);
	    			}
	    		}else {
	    			$response = array("status" => -1,"msg" => $iMod->getError(),"success" => true);
	    		}
    		
    		}
    
    	}else if($type == "cancel") {
    		
    	}
    	 
    	$this->response($response);
    }
    
    public function getAvroList() {
    	$path = I("path","","trim");
    	
    	if(empty($path)) $path = array_shift(C("HADOOPPATH"));
    	
    	$avroList = array();
    	$avro = CThrift::getPathList($path);
    	
    	foreach($avro as $k => $v) {
    	
    		$tmp['id'] = $v;
    		$tmp['value'] = $v;
    	
    		$avroList[] = $tmp;
    	}
    	
    	$response['data'] = $avroList;
    	$_SESSION['lastAvro'] = array_shift($avroList);
    	
    	$this->response($response);
    }
    
    public function getAvroRecord() {
    	//查询记录
    	
    	$this->response($_SESSION['lastAvro']['id']);
    }
    
    public function detailPattern() {
    	$host = I("host","","trim");
    	$path = I("path","","trim");
    	//echo "http://192.168.86.39:10001/urlpattern?path=".$path."/&host=".$host."&patternNum=1000";exit;
    	$content = @file_get_contents("http://192.168.86.39:10001/urlpattern?path=".$path."/&host=".$host."&patternNum=1000");
    	
    	$hostInfo = json_decode($content,1);
    	$pMod = TQuery::TModel("Pattern");
   		
    	$list['text'] = '.';
    	$len = count($hostInfo);
    	for($i=1;$i<$len;$i++) {
    		$tmp['pattern'] = trim($hostInfo[$i]['pattern']);
    		$tmp['type'] = $pMod->getPatternType($tmp['pattern']);
    		
    		$tmp['iconCls'] = 'task-folder';
    		$tmp['expanded'] = false;
    		
    		if($hostInfo[$i]['url']) {
    			$l = count($hostInfo[$i]['url']);
    			
    			$tmp['children'] = $explame = array();
    			
    			for($j=0;$j<$l-1;$j++) {
    				$explame[] = $hostInfo[$i]['url'][$j];
    				$sub['pattern'] = '<a href="'.$hostInfo[$i]['url'][$j].'" title="'.$hostInfo[$i]['url'][$j].'" target="_blank">'.$hostInfo[$i]['url'][$j].'</a>';
    				$sub['leaf'] = true;
    				$sub['iconCls'] = 'task';
    				
    				$tmp['children'][] = $sub;
    				
    				if(count($tmp['children']) >= 5) break;
    			}
    			
    			$tmp['explame'] = implode("|", $explame);
    		}
    		
    		$list['children'][] = $tmp;
    		
    	}
    	
   		//echo json_encode($list,JSON_UNESCAPED_SLASHES);
    	$this->response($list);
    	//print_r($list);exit;
    }
    
    /**
     +----------------------------------------------------------
     * <title:url类别添加>
     * <nav:url标签管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function addCategory() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("Urlcategory");
    
    		if($uMod->create()) {
    			if($uMod->addUrlcategory()) {
    				$response = array("status" => 1,"msg" => "增加成功","success" => true,"target" => "urlcategorylist");
    			}else {
    				$response = array("status" => -1,"msg" => "增加失败","success" => true);
    			}
    		}else {
    			$response = array("status" => -1,"msg" => $uMod->getError(),"success" => true);
    		}
    
    		$this->response($response);
    	}else {
    		$this->display();
    	}
    }
    
    /**
     +----------------------------------------------------------
     * <title:url类别编辑>
     * <nav:url标签管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function editCategory() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("Urlcategory");
    		$data = $this->getPostData();
    
    		if(!isset($data['id'])) $this->response(array("status" => -1,"msg" => "参数不正确","success" => true));
    
    		$condition['id'] = intval($data['id']);
    		unset($data['id']);
    
    		if($uMod->upUrlcategory($condition,$data) !== false) {
    			$response = array("status" => 1,"msg" => "修改成功","success" => true,"target" => "urlcategorylist");
    		}else {
    			$response = array("status" => -1,"msg" => "修改失败","success" => true);
    		}
    		 
    		$this->response($response);
    	}else {
    		$id = I("id","","intval");
    
    		$uMod = TQuery::TModel("Urlcategory");
    
    		$info = $uMod->getUrlcategory(array("id" => $id));
    		
    		
    		$this->assign("info",$info);
    		$this->display();
    	}
    }
    
    /**
     +----------------------------------------------------------
     * <title:url类别删除>
     * <nav:url标签管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function delCategory() {
    	 
    	$id = I("ids","","intval");
    	//if(!is_array($id)) $ids = (array) $id;
    	 
    	$uMod = TQuery::TModel("Urlcategory");
    	
    	//判断是否存在已经标记过此分类的，不给删除
    	
    	$condition['id'] = $id;
    	$res = $uMod->delUrlcategory($condition);
    	 
    	if($res !== false) {
    		$response = array("status" => 1,"msg" => "删除成功","success" => true,"target" => "urlcategorylist");
    	}else {
    		$response = array("status" => -1,"msg" => "删除失败","success" => true);
    	}
    	 
    	$this->response($response);
    }
    
}