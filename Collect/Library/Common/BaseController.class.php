<?php
namespace Library\Common;
use Think\Controller;
use Library\Auth\Auth;


class BaseController extends Controller {
	
    public function _initialize() {
    	
    	if (C('USER_AUTH_ON') && !in_array(MODULE_NAME."/".CONTROLLER_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
    		if(!Auth::checkNode()) {
    			redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
    		}
    	}
    	
    	return true;
    }
    
    protected function response($data,$type = 'JSON') {
    	//echo json_encode($data);exit;
    	$this->ajaxReturn($data,$type);
    }
    
    protected function getPageParam() {
    	$pageIndex = max(1,I("page","","intval"));
    	$perpage = I("limit") ? I("limit","","intval") : C('WEBPAGE');
    	$offset = ($pageIndex - 1) * $perpage;
    	 
    	return array($pageIndex,$perpage,$offset);
    }
    
    protected function getPostData() {
    	return I("post.");
    }
    
    protected function formartComboboxData($data = array(),$key,$value) {
    	/*if(empty($key) || empty($value)) return array();
    	
    	$result = array();
    	foreach($data as $k => $v) {
    		$result[$key]
    	}*/
    	
    	if($data === null) $data = array();
    	
    	return json_encode($data);
    }
}