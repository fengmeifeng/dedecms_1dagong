<?php 
namespace Collect\Model;
use Library\Common\BaseModel;

class SgroupModel extends BaseModel {

	//自动完成
	protected $_auto = array ( 
		array('dateline','time',1,'function')
	);

	//自动验证
	protected $_validate=array(
		array('name','require','信源分组名称不能为空！',1,'',3),
	);


	public function getTopSgroup($pid = 0) {
		$condition['pid'] = intval($pid);
		return $this->field("id,name")->where($condition)->select();
	}
	
	public function getTopSgroupCount($pid = 0) {
		$condition['pid'] = intval($pid);
		
		return $this->where($condition)->Count();
	}
	
	public function delSgroup($where) {
		if($where){
			return $this->where($where)->delete();
		}else{
			return false;
		}
	}
	
	public function getAllSgroup() {
		return $this->select();
	}
	
	public function getSgroup($condition) {
		return $this->where($condition)->find();
	}
	
	public function addSgroup($data = array()) {
		return $this->add($data);
	}
	
	public function upSgroup($condition,$data) {
		if(!is_array($condition)) return false;
		
		$data = $this->parseEmpty($data);
		
		if(empty($data)) return false;
		
		return $this->where($condition)->save($data);
	}
}