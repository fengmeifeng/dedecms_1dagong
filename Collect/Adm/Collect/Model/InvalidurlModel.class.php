<?php 
namespace Collect\Model;
use Library\Common\BaseModel;

class InvalidurlModel extends BaseModel {

	//自动完成
	protected $_auto = array ( 
		array('dateline','time',1,'function')
	);

	//自动验证
	protected $_validate=array(
		array('url','require','host不能为空！',1,'',3),
	);


	public function isExistUrl($key) {
		return $this->where(array("uuid" => $key))->Count();
	}
	
	public function getVaildUrl($condition) {
		return $this->field("url,uuid")->where($condition)->select();
	}
	
	public function removeVaildUrl($condition) {
		return $this->where($condition)->delete();
	}
}