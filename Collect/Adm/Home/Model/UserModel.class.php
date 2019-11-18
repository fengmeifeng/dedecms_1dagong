<?php 
namespace Home\Model;
use Library\Common\BaseModel;

class UserModel extends BaseModel {

	//自动完成
	protected $_auto = array ( 
		array('password','md5',1,'function'),	
		array('last_login_time','time',1,'function'), 	
		array('last_login_ip','127.0.0.1'), 
		array('last_location','新建用户'), 
	);

	//自动验证
	protected $_validate=array(
		array('username','require','用户名称为空！',1,'',3),
		array('role','require','角色为空！',1,'',3),
		array('password','require','密码为空！',1,'',1),
		array('username','','用户名称已经存在！',1,'unique',3), // 新增修改时候验证username字段是否唯一
	);


	// 获取所有用户信息
	public function getAllUser($where = '' ,$limit='', $order = 'id  DESC') {
		return $this->join(C('DB_PREFIX')."role AS r ON r.id = ".C('DB_PREFIX')."user.role",'LEFT')
				->field(C('DB_PREFIX')."user.*,r.name")->where($where)->order($order)->limit($limit)->select();
	}

	// 获取单个用户信息
	public function getUser($where = '',$field = '*') {
		return $this->field($field)->where($where)->find();
	}

	// 删除用户
	public function delUser($where) {
		if($where){
			return $this->where($where)->delete();
		}else{
			return false;
		}
	}

	// 更新用户
	public function upUser($condition,$data) {
		if(!is_array($condition)) return false;
		
		$data = $this->parseEmpty($data);
		
		if(empty($data)) return false;
		
		return $this->where($condition)->save($data);
	}

	// 更新用户
	public function check_name($username,$user_id=0){
        if($user_id){   //编辑时查询
        	$map['id']  = array('neq',$user_id);
        	$map['username']  = array('eq',$username);
        }else{  // 新增是查询
        	$map['username']  = array('eq',$username);
        }
        return $this->where($map)->find();
	}
	
	public function getUserCount($map) {
		return $this->where($map)->Count();
	}
	
	public function addUser($data = array()) {
		return $this->add($data);
	}
}