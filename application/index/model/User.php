<?php
namespace app\index\model;

use think\Model;

class User extends Model
{
	protected $auto = ['username', 'password'];

	protected function setUsernameAttr($value){
		return trim($value);
	}

	protected function setPasswordAttr($value){
		return md5($value);
	}

	protected $autoWriteTimestamp = 'datetime';
	protected $createTime = 'register_time';
}
