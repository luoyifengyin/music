<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
use app\index\model\Song;

class Index extends Controller
{
    public function index(){
    	echo "APP_PATH: ".APP_PATH."<br>";
    	echo "ROOT_PATH: ".ROOT_PATH."<br>";
    	echo "__DIR__: ".__DIR__."<br>";
    	echo "THINK_PATH: ".THINK_PATH."<br>";
    	echo "LIB_PATH: ".LIB_PATH."<br>";
    	echo "CORE_PATH: ".CORE_PATH."<br>";
        return $this->fetch();
    }

    public function rank(){
    	$rank = input('get.rank');
    	if (empty($rank)) $rank = 1;
    	if ($rank > 10){
    		$query = Song::where('area', $rank-10);
    	}
    	else $query = Song::where('1=1');
    	if ($rank == 2) $order = 'upload_time';
    	else $order = 'popularity';
    	$list = $query->order($order, 'desc')->limit(20)->select();
    	$this->assign('rank_list', $list);
    	return $this->fetch();
    }

    public function search(){
    	$keyword = input('get.keyword');
    	$list = Song::where('name', 'like', '%$keyword%')
    			->whereOr('singer', 'like', '%$keyword%')
    			->order('popularity', 'desc')
    			->select();
    	$this->assign("list", $list);
    	return $this->fetch();
    }
}
