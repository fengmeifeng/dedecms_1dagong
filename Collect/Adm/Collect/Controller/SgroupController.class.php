<?php
namespace Collect\Controller;
use Library\Common\BaseController;
use Library\Query\TQuery;
use Library\Util\Tree;

class SgroupController extends BaseController {
	
	
    public function groupList() {
    	if(IS_AJAX && I("isData","","intval") == 1) {
    		$uMod = TQuery::TModel("Sgroup");
    		$list = $uMod->getAllSgroup();
    		
    		$tree = Tree::getInstance($list)->getTrees();
    		
    		$this->response($tree);
    	}else {
    		
    		$this->display();
    	}
    }
    
    public function add() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("Sgroup");
    
    		if($uMod->create()) {
    			if($uMod->addSgroup()) {
    				$response = array("status" => 1,"msg" => "组增加成功","success" => true,"target" => "sgrouplist");
    			}else {
    				$response = array("status" => -1,"msg" => "组增加失败","success" => true);
    			}
    		}else {
    			$response = array("status" => -1,"msg" => $uMod->getError(),"success" => true);
    		}
    
    		$this->response($response);
    	}else {
    		$this->_getSgroups();
    		$this->display();
    	}
    }
    
    private function _getSgroups() {
    	//读取一级的分类
    	$uMod = TQuery::TModel("Sgroup");
    	$topGroup = $uMod->getTopSgroup();
    	$combo = $this->formartComboboxData($topGroup);
    	
    	$this->assign("combo",$combo);
    }
    
    public function edit() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("Sgroup");
    		$data = $this->getPostData();
    
    		if(!isset($data['id'])) $this->response(array("status" => -1,"msg" => "参数不正确","success" => true));
    
    		$condition['id'] = intval($data['id']);
    		unset($data['id']);
    
    		if($uMod->upSgroup($condition,$data) !== false) {
    			$response = array("status" => 1,"msg" => "修改成功","success" => true,"target" => "sgrouplist");
    		}else {
    			$response = array("status" => -1,"msg" => "修改失败","success" => true);
    		}
    		 
    		$this->response($response);
    	}else {
    		$id = I("id","","intval");
    
    		$uMod = TQuery::TModel("Sgroup");
    
    		$info = $uMod->getSgroup(array("id" => $id));
    		if($info['pid'] == 0) $info['pid'] = '';
    		$this->assign("info",$info);
    		
    		$this->_getSgroups();
    		$this->display();
    	}
    }
    
    public function del() {
    	 
    	$id = I("ids","","intval");
    	//if(!is_array($id)) $ids = (array) $id;
    	 
    	$uMod = TQuery::TModel("Sgroup");
    	$childCount = $uMod->getTopSgroupCount($id);
    	if($childCount > 0) $this->response(array("status" => -1,"msg" => "存在下级！","success" => true));
    	
    	//不存在下级需要判断是否存在信源
    	
    	$condition['id'] = $id;
    	$res = $uMod->delSgroup($condition);
    	 
    	if($res !== false) {
    		$response = array("status" => 1,"msg" => "删除成功","success" => true,"target" => "sgrouplist");
    	}else {
    		$response = array("status" => -1,"msg" => "删除失败","success" => true);
    	}
    	 
    	$this->response($response);
    }
    
}