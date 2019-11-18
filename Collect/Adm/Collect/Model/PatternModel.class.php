<?php 
namespace Collect\Model;
use Library\Common\BaseModel;

class PatternModel extends BaseModel {

	//自动完成
	protected $_auto = array ( 
		array('dateline','time',1,'function'),
		array('uid','getUserId',1,'function'),
	);

	//自动验证
	protected $_validate = array(
		array('url','require','host不能为空！',1,'',3),
		array('pattern','require','pattern不能为空！',1,'',3),
	);


	public function isExistPattern($condition) {
		return $this->where($condition)->Count();
	}
	
	public function getPatternType($pattern) {
		//echo $pattern;
		$condition['puuid'] = getParamUUid($pattern);
		//print_r($condition);
		return $this->where($condition)->getField("type");
	}
}