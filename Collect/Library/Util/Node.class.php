<?php
namespace Library\Util;

class Node {
	public $isTree = false;
	
	public function getNodeList($isTree = true) {
		$this->isTree = $isTree;
		
		$conPath = APP_PATH;
			
		$node = array();
		$methodNotUse = getPageNodeNotUseMethod();
			
		if(is_dir($conPath)) {
			$handel = opendir($conPath);
			while (($file = readdir($handel)) !== false) {
				if($file == "." || $file == "..") continue;
		
				if(is_dir($conPath.$file)) {
					$controller = $conPath.$file."/Controller";
		
					$od = opendir($controller);
					while (($controller = readdir($od)) !== false) {
						if($controller == "." || $controller == ".." || strpos($controller,".class.php") === false) continue;
							
						$moduleName = basename($controller,'.class.php');
						$a = "\\$file\\Controller\\".$moduleName;
							
						$o = new $a();
						$namespaceKey = strtolower($file);
						$controllerKey = strtolower(basename($moduleName,"Controller"));
						$node[$namespaceKey][$controllerKey] = array();
							
						$class = new \ReflectionClass($o);
						foreach($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $key => $method) {
							if(in_array($method->name,$methodNotUse)) continue;
							$func = new \ReflectionMethod($o,$method->name);
							preg_match_all("/<(.*)>/isU", $func->getDocComment(),$matches);
							//print_r($matches);
							if(empty($matches[1])) {
								//unset($node[$namespaceKey][$controllerKey]);
								continue;
							}
								
							$doc = array();
							foreach($matches[1] as $k => $v) {
								list($key,$value) = explode(":", $v);
								$doc[$key] = $value;
							}
								
							$node[$namespaceKey][$controllerKey][] = array("func" => $method->name,"doc" => $doc);
						}
					}
					closedir($od);
		
				}
			}
		
			closedir($handel);
				
			return $this->_saveNode($node);
		}
		
		return array();
	}
	
	private function _saveNode($nodes) {
		$dataList = $tree = $nav = array();
		foreach($nodes as $group => $controllers) {
			$temp['group'] = strtolower($group);
			
			foreach($controllers as $controller => $methods) {
				$temp['controller'] = strtolower($controller);
				
				foreach($methods as $method => $doc) {
					$nav[$doc['doc']['nav']] = $doc['doc']['nav'];
					$temp['method'] = $doc['func'];
					$temp['title'] = $doc['doc']['title'];
					$temp['nav'] = $doc['doc']['nav'];
					$temp['display'] = $doc['doc']['display'];
					$temp['sort'] = $doc['doc']['sort'];
					$dataList[] = $temp;
				}
				
			}
			
			
		}	
		
		if($this->isTree) {
			$key = 0;
			foreach($nav as $k => $v) {
				$tree[$key]['text'] = $v;
				$tree[$key]["iconCls"] = "Pagekey";
				$tree[$key]["expanded"] = true;
				$tree[$key]['checked'] = false;
				foreach($dataList as $row) {
					
					if($row['nav'] == $v) {
						$row['text'] = $row['title'];
						$row['leaf'] = true;
						$row['checked'] = false;
						$tree[$key]['children'][] = $row;
					}
				}
				
				$key++;
			}
		
		}else {
			$tree = $dataList;
		}
		
		return $tree;
	}
	
	public function roleTree($tree,$role) {
		foreach($tree as $k => $v) {
			if($v['children']) {
				foreach($v['children'] as $key => $row) {
					if(array_key_exists(strtolower($row['group'].$row['controller'].$row['method']), $role)) {
						$tree[$k]['children'][$key]['checked'] = true;
					}
				}
			}
		}

		return $tree;
	}
	
	
}