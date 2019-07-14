<?php
namespace app\index\model;

use think\Model;

class Song extends Model
{
	protected $autoWriteTimestamp = 'datetime';
	protected $createTime = 'upload_time';
}
