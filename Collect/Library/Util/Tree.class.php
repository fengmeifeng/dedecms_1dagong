<?php
namespace Library\Util;

class Tree {
	
	public $tree = array();
	public $treeGrid = array("text" => ".");
	public static $_instance = null;
	public $showText = "name";
	
	public static function getInstance($list,$showText="") {
		if(self::$_instance == null) {
			self::$_instance = new self($list,$showText);
		}
		
		return self::$_instance;
	}
	
	public function __construct($list,$showText) {

		if(!empty($list)) $this->tree = $list;
		if(!empty($showText)) $this->showText = $showText;
	}
	
	
	public function getTrees($pid = 0) {
		$child = $this->getChildTree($pid);
		
		if($child !== false) {
			$this->treeGrid["children"] = $child;
			foreach($this->treeGrid["children"] as $k => $v) {
				$sub = $this->getChildTree($v['id']);
				if($sub !== false) $this->treeGrid["children"][$k]["children"] = $sub;
				else $this->treeGrid["children"][$k]['leaf'] = true;
			}
		}
		
		return $this->treeGrid;
	}
	
	private function getChildTree($pid) {
		$arr = array();
		if(is_array($this->tree) && !empty($this->tree)) {
			foreach($this->tree as $k => $v) {
				$v['expanded'] = true;
				if(!empty($this->showText))  $v['text'] = $v[$this->showText];
				
				$v['dateline'] = date("Y-m-d H:i",$v['dateline']);
				$v['iconCls'] = 'Applicationtilehorizontal';
				if($pid != 0) {
					$v['leaf'] = true;
					$v['iconCls'] = 'Applicationviewtile';
				}
				
				if($v['pid'] == $pid) $arr[] = $v;
			}
		}
		//print_R($arr);
		return $arr ? $arr : false;
	}
}