<?php 
namespace app\index\model;

use think\Model;

class Comment extends Model{
	protected $autoWriteTimestamp = 'datetime';
	protected $createTime = 'publish_time';

	protected $auto = ['user_id'];

	protected function setUserIdAttr(){
		return session('user.id');
	}
}
