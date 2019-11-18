<?php
namespace Home\Controller;

use Library\Common\BaseController;
use Library\Util\Node;

/**
 +------------------------------------------------------------------------------
 * Home\Controller类
 * IndexController.class.php
 * 后台首页框架 权限
 +------------------------------------------------------------------------------
 * @author    yimiao <yimiao@iflytek.com>
 * @version   2014-10-5
 +------------------------------------------------------------------------------
 */
class IndexController extends BaseController {
	
	/**
	 +----------------------------------------------------------
	 * <title:后台主页框架>
	 * <nav:用户管理>
	 * <display:action>
	 * <sort:1>
	 +----------------------------------------------------------
	 * @return 
	 +----------------------------------------------------------
	 */
    public function index() {
    	//print_r($_SESSION['_ACCESS_LIST']);
        $this->display();
    }
    
    /**
     +----------------------------------------------------------
     * <title:后台左侧导航>
     * <nav:用户管理>
     * <display:action>
     * <sort:1>
     +----------------------------------------------------------
     * @return 
     +----------------------------------------------------------
     */
    public function getNavs() {
    	//print_r($_SESSION['_ACCESS_LIST']);
    	/*$nav[] = array(
    		'text' => '用户管理',
    		'expanded' => true,
    		'iconCls' => 'Application',
    		'children' => array(
    			array(
    				'id' => 'app-nav-tab-1',
    				'text' => '用户列表',
    				'leaf' => true,
    				'iconCls' => 'Applicationviewcolumns',
    				'url' => U('Home/User/userList')
    			),
    			array(
    				'id' => 'app-nav-tab-2',
    				'text' => '用户组',
    				'leaf' => true,
    				'iconCls' => 'Applicationviewcolumns',
    				'url' => U('Home/Group/groupList')
    			),
    		),
    	);
    	
    	$nav[] = array(
    		'text' => 'url标签管理',
    		'expanded' => true,
    		'iconCls' => 'Application',
    		'children' => array(
    			array(
    				'id' => 'app-nav-tab-3',
    				'text' => 'url类别管理',
    				'leaf' => true,
    				'iconCls' => 'Applicationviewcolumns',
    				'url' => U('Collect/Url/cateList')
    			),
    			array(
    				'id' => 'app-nav-tab-4',
    				'text' => '业务分类管理',
    				'leaf' => true,
    				'iconCls' => 'Applicationviewcolumns',
    				'url' => U('Collect/Bis/businessList')
    			),
    			array(
    				'id' => 'app-nav-tab-5',
    				'text' => '业务管理',
    				'leaf' => true,
    				'iconCls' => 'Applicationviewcolumns',
    				'url' => U('Collect/Bis/tagList')
    			),
    				
    		),
    	);
    	
    	$nav[] = array(
    			'text' => '系统管理',
    			'expanded' => true,
    			'iconCls' => 'Application',
    			'children' => array(
    					array(
    							'id' => 'app-nav-tab-6',
    							'text' => '通用字段配置管理',
    							'leaf' => true,
    							'iconCls' => 'Applicationviewcolumns',
    							'url' => U('Collect/Url/cateList')
    					),
    	
    			),
    	);*/
    	if($_SESSION[C('ADMIN_AUTH_KEY')]) {
    		$node = new Node();
    		$accessList = $node->getNodeList(false);
    	}else {
    		$accessList = $_SESSION['_ACCESS_LIST'];
    	}
    	
    	$nav = $tree = array();
    	foreach($accessList as $k => $v) {
    		$nav[$v['nav']] = $v['nav'];
    	}
    	
    	$key = $index = 0;
    	foreach($nav as $k => $v) {
    		$tree[$key]['text'] = $v;
    		$tree[$key]["iconCls"] = "Application";
    		$tree[$key]["expanded"] = "true";
    		foreach($accessList as $row) {
    			$index++;
    			if($row['nav'] == $v && $row['display'] == "nav") {
    				$temp = array();
    				$temp['text'] = $row['title'];
    				$temp['leaf'] = "true";
    				$temp['id'] = "app-nav-tab-".$index;
    				$temp["iconCls"] = "Applicationviewcolumns";
    				$temp["url"] = U($row['group']."/".$row['controller']."/".$row['method']);
    				$tree[$key]['children'][] = $temp;
    			}
    		}
    		
    		if(!isset($tree[$key]['children'])) {
    			unset($tree[$key]);
    		}else {
    	
    			$key++;
    		}
    	}
    	
    	//print_r($tree);
    	
    	$this->response($tree);
    }
    
    public function main() {
    	$this->display();
    }
}