<?php 
namespace Collect\Model;
use Library\Common\BaseModel;

class TagfieldModel extends BaseModel {

	public function getTagField($condition) {
		return $this->where($condition)->select();
	}
	
	public function delByCondition($condition) {
		return $this->where($condition)->delete();
	}
}