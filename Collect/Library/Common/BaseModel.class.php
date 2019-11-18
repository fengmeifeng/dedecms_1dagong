<?php 
namespace Library\Common;
use Think\Model;

class BaseModel extends Model {
	
	public function parseEmpty($data) {
		foreach($data as $k => $v) {
			if(empty($v)) unset($data[$k]);
		}
		
		return $data;
	}
}