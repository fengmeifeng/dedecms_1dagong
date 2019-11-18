<?php 
namespace Collect\Model;
use Library\Common\BaseModel;

class UrltagModel extends BaseModel {

	//自动完成
	protected $_auto = array ( 
		array('dateline','time',1,'function')
	);

	//自动验证
	protected $_validate=array(
		array('name','require','名称不能为空！',1,'',3),
	);


	public function getTopBusiness($pid = 0,$field = '*') {
		$condition['pid'] = intval($pid);
		return $this->field($field)->where($condition)->select();
	}
	
	// 获取所有用户信息
	public function getBisList($where = '' ,$limit='', $order = 'id  DESC') {
		//return $this->join(C('DB_PREFIX')."role AS r ON r.id = ".C('DB_PREFIX')."user.role")
		//->field(C('DB_PREFIX')."user.*,r.name")->where($where)->order($order)->limit($limit)->select();
		return $this->where($where)->order($order)->limit($limit)->select();
	}
	
	public function getBisCount($condition) {
		
		return $this->where($condition)->Count();
	}
	
	public function delBisTag($where) {
		if($where){
			return $this->where($where)->delete();
		}else{
			return false;
		}
	}
	
	public function getAllBusiness() {
		return $this->select();
	}
	
	public function getBusiness($condition) {
		return $this->where($condition)->find();
	}
	
	public function addBusiness($data = array()) {
		return $this->add($data);
	}
	
	public function upBusiness($condition,$data) {
		if(!is_array($condition)) return false;
		
		$data = $this->parseEmpty($data);
		
		if(empty($data)) return false;
		
		return $this->where($condition)->save($data);
	}
}