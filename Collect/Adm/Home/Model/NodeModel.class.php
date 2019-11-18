<?php 
namespace Home\Model;
use Library\Common\BaseModel;

class NodeModel extends BaseModel {

	public function delAllNode($condition) {
		return $this->where($condition)->delete();
	}
	
	public function getRoleNode($condition) {
		$list = $this->where($condition)->select();
		
		$result = array();
		foreach($list as $k => $v) {
			$result[strtolower($v['group'].$v['controller'].$v['method'])] = $v;
		}
		
		return $result;
	}
}