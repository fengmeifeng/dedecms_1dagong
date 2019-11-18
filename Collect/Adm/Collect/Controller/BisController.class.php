<?php
namespace Collect\Controller;
use Library\Common\BaseController;
use Library\Query\TQuery;
use Library\Util\Tree;

class BisController extends BaseController {
    
	/**
	 +----------------------------------------------------------
	 * <title:业务分类管理>
	 * <nav:url标签管理>
	 * <display:nav>
	 * <sort:1>
	 +----------------------------------------------------------
	 * @return 
	 +----------------------------------------------------------
	 */
    public function businessList() {
    	if(IS_AJAX && I("isData","","intval") == 1) {
    		$uMod = TQuery::TModel("Urltag");
    		$list = $uMod->getTopBusiness();
    	
    		foreach($list as $k => $v) {
    			$list[$k]['dateline'] = date("Y-m-d H:i",$v['dateline']);
    		}
    	
    		$response['total'] = count($list);
    		$response['data'] = $list;
    	
    		unset($list);
    		$this->response($response);
    	}else {
    		
    		
    		$this->display();
    	}
    }
    
    /**
     +----------------------------------------------------------
     * <title:增加业务分组>
     * <nav:url标签管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function addBusiness() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("Urltag");
    
    		if($uMod->create()) {
    			if($uMod->addBusiness()) {
    				//判断是否勾选通用字段
    				$tagid = $uMod->getLastInsID();
    				if(I("isdefault","","intval") == 1) {
    					$field = C("SOURCEFIELD");	
    					
    					$dataList = array();
    					foreach($field as $k => $v) {
    						$v['tagid'] = $tagid;
    						$v['dateline'] = UNIXTIME;
    						$dataList[] = $v;
    					}
    					
    					$tMod = TQuery::TModel("Tagfield");
    					$tMod->addAll($dataList);
    				}
    				
    				$response = array("status" => 1,"msg" => "增加成功","success" => true,"target" => "businesslist","tagid" => $tagid);
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
     * <title:编辑业务分组>
     * <nav:url标签管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function editBusiness() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("Urltag");
    		$data = $this->getPostData();
    
    		if(!isset($data['id'])) $this->response(array("status" => -1,"msg" => "参数不正确","success" => true));
    
    		$condition['id'] = intval($data['id']);
    		unset($data['id']);
    
    		if($uMod->upBusiness($condition,$data) !== false) {
    			$response = array("status" => 1,"msg" => "修改成功","success" => true,"target" => "businesslist");
    		}else {
    			$response = array("status" => -1,"msg" => "修改失败","success" => true);
    		}
    		 
    		$this->response($response);
    	}else {
    		$id = I("id","","intval");
    
    		$uMod = TQuery::TModel("Urltag");
    
    		$info = $uMod->getBusiness(array("id" => $id));
    
    
    		$this->assign("info",$info);
    		$this->display();
    	}
    }
    
    /**
     +----------------------------------------------------------
     * <title:删除业务分组>
     * <nav:url标签管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function delBusiness() {
    
    	$id = I("ids","","intval");
    	//if(!is_array($id)) $ids = (array) $id;
    
    	$uMod = TQuery::TModel("Urltag");
    	 
    	
    	 
    	$condition['id'] = $id;
    	$single = $uMod->getBusiness($condition);
    	
    	if($single['pid'] == 0) {
    		//是否存在子类
    		$where['pid'] = $single['id'];
    		$count = $uMod->getBisCount($where);
    		if($count > 0) $this->response($response = array("status" => -1,"msg" => "存在子类，无法删除","success" => true));
    	}else {
    		
    	}
    	
    	$res = $uMod->delBisTag($condition);
    
    	if($res !== false) {
    		$response = array("status" => 1,"msg" => "删除成功","success" => true,"target" => "businesslist");
    	}else {
    		$response = array("status" => -1,"msg" => "删除失败","success" => true);
    	}
    
    	$this->response($response);
    }
    
    /**
     +----------------------------------------------------------
     * <title:获取业务分组tree>
     * <nav:url标签管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function getBusinessTree() {
    	$uMod = TQuery::TModel("Urltag");
    	$list = $uMod->getTopBusiness();
    	
    	$tree = Tree::getInstance($list)->getTrees();
    	
    	$this->response($tree);
    }
    
    /**
     +----------------------------------------------------------
     * <title:增加业务>
     * <nav:url标签管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function addBis() {
    	$this->getTopBis();
    	
    	$this->display();
    }
    
    /**
     +----------------------------------------------------------
     * <title:编辑业务>
     * <nav:url标签管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function editBis() {
    	$this->getTopBis();
    	$uMod = TQuery::TModel("Urltag");
    	$id = I("id","","intval");
    	
    	$condition['id'] = $id;
    	$single = $uMod->getBusiness($condition);
    	
    	$this->assign("info",$single);
    	$this->display();
    }
    
    private function getTopBis() {
    	$uMod = TQuery::TModel("Urltag");
    	$list = $uMod->getTopBusiness();
    
    	$this->assign("combo",$this->formartComboboxData($list));
    }
    
    /**
     +----------------------------------------------------------
     * <title:业务管理>
     * <nav:url标签管理>
     * <display:nav>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function tagList() {
    	if(IS_AJAX && I("isData","","intval") == 1) {
    		$uMod = TQuery::TModel("Urltag");
    		
    		$map['pid'] = array("neq",0);
    		$pid = I("pid","","intval");
    		if(!empty($pid)) $map['pid'] = $pid;
    		
    		$count = $uMod->getBisCount($map);
    		
    		list($pageIndex,$perpage,$offset) = $this->getPageParam();
    		 
    		$list = $uMod->getBisList($map,$offset.",".$perpage);
    		
    		$result = array();
    		foreach($list as $k => $v) {
    			//$temp['dateline'] = date("Y-m-d H:i",$v['dateline']);
    			//$temp['lastLocation'] = $v['last_location'];
    			$list[$k]['dateline'] = date("Y-m-d H:i",$v['dateline']);
    		}
    		 
    		$response['total'] = $count;
    		$response['data'] = $list;
    		unset($list);
    		$this->response($response);
    	}else {
    		 
    		$this->display();
    	}
    }
    
    public function showField() {
    	$data = C("SOURCEFIELD");
    	
    	$result = array("success" => true,"data" => $data);
    	$this->response($result);
    }
    
    public function saveBisField() {
    	$data = $this->getPostData();
    	
    	$dataList = array();
    	foreach($data['field'] as $k => $v) {
    		if(empty($data['field'][$k]) || empty($data['name'][$k])) continue;
    		
    		$tmp['name'] = $data['name'][$k];
    		$tmp['field'] = $data['field'][$k];
    		$tmp['tagid'] = $data['tagid'];
    		
    		$dataList[] = $tmp;
    	}
    	
    	if(count($dataList) > 0) {
    		$tMod = TQuery::TModel("Tagfield");
    		$res = $tMod->delByCondition(array("tagid" => $data['tagid']));
    		if($res) {
    			$tMod->addAll($dataList);
    			$response = array("status" => 1,"msg" => "配置成功","success" => true,"target" => "","close" => true);
    		}else {
    			$response = array("status" => 1,"msg" => "配置失败","success" => true,"target" => "");
    		}
    	}else {
    		$response = array("status" => 1,"msg" => "没数据提交","success" => true,"target" => "");
    	}
    	
    	$this->response($response);
    }
    
    public function addBisField() {
    	$id = I("id","","intval");
    	$where['tagid'] = $id;
    	
    	$tMod = TQuery::TModel("Tagfield");
    	$fields = $tMod->getTagField($where);
    	
    	$this->assign("field",json_encode($fields));
    	$this->assign("tagid",$id);
    	$this->display();
    }
}