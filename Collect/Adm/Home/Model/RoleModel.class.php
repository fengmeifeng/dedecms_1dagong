<?php 
namespace Home\Model;
use Library\Common\BaseModel;

class RoleModel extends BaseModel {

	//自动完成
	protected $_auto = array ( 
		array('dateline','time',1,'function')
	);

	//自动验证
	protected $_validate=array(
		array('name','require','组名次不能为空！',1,'',3),
	);


	// 获取所有用户信息
	public function getAllRole($where = '' ,$limit='', $order = 'id  DESC') {
		
		return $this->where($where)->order($order)->limit($limit)->select();
	}

	// 获取单个用户信息
	public function getRole($where = '',$field = '*') {
		return $this->field($field)->where($where)->find();
	}

	// 删除用户
	public function delGroup($where) {
		if($where){
			return $this->where($where)->delete();
		}else{
			return false;
		}
	}

	// 更新用户
	public function upRole($condition,$data) {
		if(!is_array($condition)) return false;
		
		$data = $this->parseEmpty($data);
		
		if(empty($data)) return false;
		
		return $this->where($condition)->save($data);
	}
	
	public function getRoleCount($map) {
		return $this->where($map)->Count();
	}
	
	public function addGroup($data = array()) {
		return $this->add($data);
	}
}