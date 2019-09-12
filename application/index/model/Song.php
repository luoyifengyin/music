<?php
namespace app\index\model;

use think\Model;

// require_once '\getID3'

class Song extends Model
{
	//protected $auto = ['duration'];

	protected $autoWriteTimestamp = 'datetime';
	protected $createTime = 'upload_time';

	protected function setSongPathAttr($value){
		// $mp3 = new \lib\getid3(ROOT_PATH.'public'.DS.'song'.DS.$value);
		// $this->setAttr('duration', $mp3->getDuration());
		// $getID3 = new getID3();
		// $fileinfo = $getID3->analyze(ROOT_PATH.'public'.DS.'song'.DS.$value);
		// $time = $fileinfo['playtime_seconds'];
		// $this->setAttr('duration', $time);
		return $value;
	}

	public function getDurationAttr($value){
		$h = floor($value / 3600);
		$m = floor($value / 60) % 60;
		$s = floor($value) % 60;
		$time_str = '';
		if ($h) $time_str .= $h . ':';
		if ($m < 10) $time_str .= '0';
		$time_str .= $m . ':';
		if ($s < 10) $time_str .= '0';
		$time_str .= $s;
		return $time_str;
	}

	public function getAreaAttr($value){
		switch($value){
			case 1: return '华语';
			case 2: return '粤语';
			case 3: return '欧美';
			case 4: return '日语';
			case 5: return '韩语';
			default: return '其他';
		}
	}
}
