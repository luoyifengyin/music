<?php
namespace app\index\model;

use think\Model;

class User extends Model
{
	protected $autoWriteTimestamp = 'datetime';
	protected $createTime = 'register_time';
}
