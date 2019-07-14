<?php
namespace app\index\model;

use think\Model;

class User extends Model
{
	protected $auto = ['ip'];

	public function setUsernameAttr($value){
		return trim($value);
	}

	public function setPasswordAttr($value){
		return md5($value);
	}

	protected function setIpAttr(){
		return request()->ip();
	}

	protected $autoWriteTimestamp = 'datetime';
	protected $createTime = 'register_time';
}
