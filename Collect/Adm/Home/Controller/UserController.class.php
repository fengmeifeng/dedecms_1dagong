<?php
namespace Home\Controller;
use Library\Common\BaseController;
use Library\Query\TQuery;

class UserController extends BaseController {
	
	/**
	 +----------------------------------------------------------
	 * <title:用户列表>
	 * <nav:用户管理>
	 * <display:nav>
	 * <sort:1>
	 +----------------------------------------------------------
	 * @return 
	 +----------------------------------------------------------
	 */
    public function userList() {
    	if(IS_AJAX && I("isData","","intval") == 1) {
    		$roleId = I("role","","intval");
    		$keyword = I("keyword","","trim");
    		
    		//$role = M('Role')->getField('id,name');
    		if(!empty($roleId)) $map['role'] = $roleId;
    		if(!empty($keyword)) $map['username'] = array('like','%'.$keyword.'%');
    		
    		$uMod = TQuery::TModel("User");
    		$count = $uMod->getUserCount($map);
    		
    		list($pageIndex,$perpage,$offset) = $this->getPageParam();
    		 
    		$list = $uMod->getAllUser($map,$offset.",".$perpage);
    		
    		$result = array();
    		foreach($list as $k => $v) {
    			$temp['id'] = $v['id'];
    			$temp['username'] = $v['username'];
    			$temp['role'] = $v['id'] == 12 ? "神级管理员" : $v['name'];
    			$temp['remark'] = $v['remark'];
    			$temp['status'] = $v['status'];
    			$temp['lastlogintime'] = date("Y-m-d H:i",$v['last_login_time']);
    			$temp['lastloginip'] = $v['last_login_ip'];
    			//$temp['lastLocation'] = $v['last_location'];
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
     * <title:添加用户>
     * <nav:用户管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function add() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("User");
    		
    		if($uMod->create()) {
    			if($uMod->addUser()) {
    				$response = array("status" => 1,"msg" => "用户增加成功","success" => true,"target" => "userlist");
    			}else {
    				$response = array("status" => -1,"msg" => "用户增加失败","success" => true);
    			}
    		}else {
    			$response = array("status" => -1,"msg" => $uMod->getError(),"success" => true);
    		}
    		
    		$this->response($response);
    	}else {
    		//获取用户组
    		$rMod = TQuery::TModel("Role");
    		$condition['status'] = 1;
    		$allRole = $rMod->getAllRole($condition);
    		
    		$this->assign("role",$this->formartComboboxData($allRole));
    		$this->display();
    	}
    }
    
    /**
     +----------------------------------------------------------
     * <title:删除用户>
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
    	
    	$uMod = TQuery::TModel("User");
    	$condition['id'] = array('in',$id);
    	$res = $uMod->delUser($condition);
    	
    	if($res !== false) {
    		$response = array("status" => 1,"msg" => "用户删除成功","success" => true,"target" => "userlist");
    	}else {
    		$response = array("status" => -1,"msg" => "用户删除失败","success" => true);
    	}
    	
    	$this->response($response);
    }
    
    /**
     +----------------------------------------------------------
     * <title:编辑用户>
     * <nav:用户管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function edit() {
    	if(IS_POST) {
    		$uMod = TQuery::TModel("User");
    		$data = $this->getPostData();
    		
    		if(!isset($data['id'])) $this->response(array("status" => -1,"msg" => "参数不正确","success" => true));
    		if(!empty($data['password'])) $data['password'] = md5($data['password']);
    		$condition['id'] = intval($data['id']);
    		unset($data['id']);
    		
    		if($uMod->upUser($condition,$data) !== false) {
    			$response = array("status" => 1,"msg" => "用户修改成功","success" => true,"target" => "userlist");
    		}else {
    			$response = array("status" => -1,"msg" => "用户修改失败","success" => true);
    		}
    	
    		$this->response($response);
    	}else {
    		$id = I("id","","intval");
    		
    		$uMod = TQuery::TModel("User");

    		$info = $uMod->getUser(array("id" => $id));
    		$this->assign("info",$info);
    		
    		//获取用户组
    		$rMod = TQuery::TModel("Role");
    		$condition['status'] = 1;
    		$allRole = $rMod->getAllRole($condition);
    		
    		$this->assign("role",$this->formartComboboxData($allRole));
    		
    		$this->display();
    	}
    }
    
}