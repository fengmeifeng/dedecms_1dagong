<?php
namespace Home\Controller;
use Library\Common\BaseController;
use Library\Query\TQuery;
use Library\Util\Node;

class GroupController extends BaseController {
	
	/**
	 +----------------------------------------------------------
	 * <title:用户组>
	 * <nav:用户管理>
	 * <display:nav>
	 * <sort:1>
	 +----------------------------------------------------------
	 * @return 
	 +----------------------------------------------------------
	 */
    public function groupList() {
    	if(IS_AJAX && I("isData","","intval") == 1) {
    		$map = array();
    		$uMod = TQuery::TModel("Role");
    		$count = $uMod->getRoleCount($map);
    		
    		list($pageIndex,$perpage,$offset) = $this->getPageParam();
    		 
    		$list = $uMod->getAllRole($map,$offset.",".$perpage);
    		
    		$result = array();
    		foreach($list as $k => $v) {
    			$temp['id'] = $v['id'];
    			$temp['name'] = $v['name'];
    			$temp['remark'] = $v['remark'];
    			$temp['status'] = $v['status'];
    			$temp['dateline'] = date("Y-m-d H:i",$v['dateline']);
    			$result[] = $temp;
    		}
    		 
    		unset($list);
    		 
    		$response['total'] = $count;
    		$response['data'] = $result;
    		 
    		$this->response($response);
    	}else {
    		$this->display();
    	}
    }
    
    /**
     +----------------------------------------------------------
     * <title:增加用户组>
     * <nav:用户管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function add() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("Role");
    		
    		if($uMod->create()) {
    			if($uMod->addGroup()) {
    				$response = array("status" => 1,"msg" => "组增加成功","success" => true,"target" => "grouplist");
    			}else {
    				$response = array("status" => -1,"msg" => "组增加失败","success" => true);
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
     * <title:删除用户组>
     * <nav:用户管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function del() {
    	
    	$id = I("ids");
    	if(!is_array($id)) {
    		$this->response(array("status" => -1,"msg" => "参数错误","success" => true));
    	}
    	
    	$uMod = TQuery::TModel("Role");
    	$condition['id'] = array('in',$id);
    	//存在用户不给删除
    	
    	$res = $uMod->delGroup($condition);
    	
    	if($res !== false) {
    		$response = array("status" => 1,"msg" => "组删除成功","success" => true,"target" => "grouplist");
    	}else {
    		$response = array("status" => -1,"msg" => "组删除失败","success" => true);
    	}
    	
    	$this->response($response);
    }
    
    /**
     +----------------------------------------------------------
     * <title:编辑用户组>
     * <nav:用户管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function edit() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("Role");
    		$data = $this->getPostData();
    		
    		if(!isset($data['id'])) $this->response(array("status" => -1,"msg" => "参数不正确","success" => true));
    		
    		$condition['id'] = intval($data['id']);
    		unset($data['id']);
    		
    		if($uMod->upRole($condition,$data) !== false) {
    			$response = array("status" => 1,"msg" => "组修改成功","success" => true,"target" => "grouplist");
    		}else {
    			$response = array("status" => -1,"msg" => "组修改失败","success" => true);
    		}
    	
    		$this->response($response);
    	}else {
    		$id = I("id","","intval");
    		
    		$uMod = TQuery::TModel("Role");

    		$info = $uMod->getRole(array("id" => $id));
    		$this->assign("info",$info);
    		$this->display();
    	}
    }
    
    public function access() {
    	
    	
    	if(IS_AJAX && I("isData","","intval") == 1) {
    		$id = I("roleid","","intval");
    		$node = new Node();
    		$nMod = TQuery::TModel("Node");
    		
    		$role = $nMod->getRoleNode(array("roleid" => $id));
    		
    		$tree = $node->getNodeList();
    		
    		$tree = $node->roleTree($tree,$role);
    		
    		$this->response($tree);
    	}else {
    		$id = I("id","","intval");
    		
    		$this->assign("roleid",$id);
    		$this->display();
    	}
    }
    
    public function saveAccess() {
    	$json = $_POST['access'];
    	
    	$access = json_decode($json,1);
    	$roleid = I("roleid","","intval");
    	
    	$dataList = array();
    	foreach($access as $k => $v) {
    		if(isset($v['iconCls'])) continue;
    		
    		unset($access[$k]['text'],$access[$k]['leaf'],$access[$k]['checked']);
    		$access[$k]['roleid'] = $roleid;
    		
    		$dataList[] = $access[$k];
    	}
    	
    	$nMod = TQuery::TModel("Node");
    	$condition['roleid'] = $roleid;
    	$nMod->delAllNode($condition);
    	
    	$res = $nMod->addAll($dataList);
    	
    	if($res) {
    		$response = array("status" => 1,"msg" => "配置成功","success" => true,"target" => "","close" => true);
    	}else {
    		$response = array("status" => -1,"msg" => "配置失败","success" => true);
    	}
    	
    	$this->response($response);
    	//print_r($access);
    }
    
}