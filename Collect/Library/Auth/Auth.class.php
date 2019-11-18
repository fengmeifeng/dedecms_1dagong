<?php
namespace Library\Auth;

use Library\Query\TQuery;

class Auth {
	
	
	public static function checkNode() {
		
		if(empty($_SESSION[C('ADMIN_AUTH_KEY')])) {
			$accessKey = strtolower(MODULE_NAME.CONTROLLER_NAME.ACTION_NAME);
			$accessUuid = md5($accessKey);
			
			if($_SESSION[$accessUuid]) return true;
			
			if(!isset($_SESSION['_ACCESS_LIST'][$accessKey])) {
				$_SESSION[$accessUuid] = false;
				return false;
			}else {
				$_SESSION[$accessUuid] = true;
			}
			
		}else {
			return true;
		}
		
		return true;
	}
	
	public static function getAccess() {
		
	}
	
	public static function authenticate($map) {
		$model =  C('USER_AUTH_MODEL');
        //使用给定的Map进行认证
        return M($model)->where($map)->find();
	}
	
	public static function saveAccessList($roleid) {
		$_SESSION['_ACCESS_LIST'] =	Auth::getAccessList($roleid);
	}
	
	public static function getAccessList($role) {
		$mod = TQuery::TModel("Node");
		
		$condition['roleid'] = $role;
		$list = $mod->where($condition)->select();
		
		$result = array();
		foreach($list as $k => $v) {
			$result[strtolower($v['group'].$v['controller'].$v['method'])] = $v;
		}
		
		return $result;
	}
	
}