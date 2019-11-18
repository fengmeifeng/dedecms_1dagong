<?php
namespace Collect\Controller;
use Library\Common\BaseController;
use Library\Query\TQuery;
use Library\Util\Tree;

class UrlController extends BaseController {
	
	/**
	 +----------------------------------------------------------
	 * <title:url类别管理>
	 * <nav:url标签管理>
	 * <display:nav>
	 * <sort:1>
	 +----------------------------------------------------------
	 * @return 
	 +----------------------------------------------------------
	 */
    public function cateList() {
    	if(IS_AJAX && I("isData","","intval") == 1) {
    		$uMod = TQuery::TModel("Urlcategory");
    		$list = $uMod->getAllUrlcategory();
    		
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