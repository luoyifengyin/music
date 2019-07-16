<?php
namespace app\index\controller;
use app\index\controller\PublicController;
use think\Request;
use app\index\model\User;
use app\index\model\Song;

class Index extends PublicController
{
    public function index(){
    	echo "APP_PATH: ".APP_PATH."<br>";
    	echo "ROOT_PATH: ".ROOT_PATH."<br>";
    	echo "__DIR__: ".__DIR__."<br>";
    	echo "THINK_PATH: ".THINK_PATH."<br>";
    	echo "LIB_PATH: ".LIB_PATH."<br>";
    	echo "CORE_PATH: ".CORE_PATH."<br>";
    	// echo __ROOT__."<br>";
    	// echo __STATIC__."<br>";
    	// echo __JS__."<br>";
    	// echo __CSS__."<br>";
        return $this->fetch();
    }

    public static $rankTitles = Array(1=>'热歌榜', 2=>'新歌榜', 11=>'内地榜', 12=>'港澳台榜', 13=>'欧美榜', 14=>'日本榜', 15=>'韩国榜');
    public function rank(){
    	$request = Request::instance();
    	$rank = $request->get('rank');
    	if (empty($rank)) $rank = 1;
    	if ($rank > 10){
    		$query = Song::where('area', $rank-10);
    	}
    	else $query = Song::where('1=1');
    	if ($rank == 2) $order = 'upload_time';
    	else $order = 'popularity';
    	$list = $query->order($order, 'desc')->limit(20)->select();
    	if ($request->isAjax()){
	    	$res->rank_title = Index::$rankTitles[$rank];
	    	$res->rank_list = $list;
	    	return json_encode($res);
	    }
	    else {
	    	$this->assign('rank_title', Index::$rankTitles[$rank]);
	    	$this->assign('rank_list', $list);
	    	return $this->fetch();
	    }
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
