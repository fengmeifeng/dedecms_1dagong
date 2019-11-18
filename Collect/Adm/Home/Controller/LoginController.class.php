<?php
namespace Home\Controller;

use Library\Common\BaseController;
use Library\Auth\Auth;
use Library\Query\TQuery;

class LoginController extends BaseController {
	
	public function index(){
		//print_r($_SESSION['_ACCESS_LIST']);
		$this->display();
	}
	
	public function checkLogin() {
		$username = I("username");
		$password = I("password");
		$map['username'] = $username;
		
		$authinfo = Auth::authenticate($map);
		if(empty($authinfo)) {
			$this->response(array("status" => -1,"msg" => "用户不存在！","success" => true));
		}else {
			if($authinfo['password'] != md5($password)) {
				//$this->response(array("status" => -1,"msg" => "".md5($password)."","success" => true));
				$this->response(array("status" => -1,"msg" => "密码不正确！","success" => true));
			}
			
			$this->_setUserSession($authinfo);
			
			$ip = get_client_ip();
			$data['last_login_time'] = UNIXTIME;
			$data['last_login_ip'] = $ip;
			
			$where['id'] = $authinfo['id'];
			
			$User =	M(C('USER_AUTH_MODEL'));
			$User->where($where)->save($data);
			
			Auth::saveAccessList($authinfo['role']);
			
			$this->response(array("status" => 1,"msg" => "登录成功","success" => true,"url" => PHP_FILE));
			$this->display();
			//redirect(PHP_FILE);
		}
	}
	
	private function _setUserSession($user) {
		session(C('USER_AUTH_KEY'), $user['id']);
		session('userid',$user['id']); 
		session('username',$user['username']);   
		session('roleid',$user['role']);    
		
		$founder = getFounder();
		if(in_array($user['username'],$founder)) {
			session(C('ADMIN_AUTH_KEY'), true);
		}
	}
	
	public function logout() {
		if(session(C('USER_AUTH_KEY'))) {
			session(C('USER_AUTH_KEY'),null);
			session(null);
			redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
		}else {
			redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
		}
	}
	
}