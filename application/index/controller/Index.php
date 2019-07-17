<?php
namespace app\index\controller;
use app\index\controller\PublicController;
use think\Controller;
use think\Request;
use app\index\model\User;
use app\index\model\Song;
use app\index\mode\Comment;

class Index extends PublicController
{
    public function index(){
        return $this->fetch();
    }

    // public static $rankTitles = Array(1=>'热歌榜', 2=>'新歌榜', 11=>'华语榜', 12=>'粤语榜', 13=>'欧美榜', 14=>'日语榜', 15=>'韩语榜', 100=>'其他榜');
    public function rank(){
    	$request = Request::instance();
    	$rank = input('get.rank');
		if (empty($rank)) $rank = 1;
    	if ($rank > 10){
    		if ($rank <= 20) $query = Song::where('area', $rank-10);
	    	else $query = Song::where('area', '100');
    	}
    	else $query = Song::where('1=1');
    	if ($rank == 2) $order = 'upload_time';
    	else $order = 'popularity';
    	$list = $query->order($order, 'desc')->limit(20)->select();
    	if ($request->isAjax()){
	    	//$res->rank_title = Index::$rankTitles[$rank];
	    	$res->rank_list = $list;
	    	return json_encode($res);
	    }
	    else {
	    	//$this->assign('rank_title', '热歌榜');
	    	$this->assign('rank_list', $list);
	    	return $this->fetch();
	    }
    }

    public function song(){
    	echo "--------1";
    	$request = Request::instance();
    	$song_id = $request->get('id');
    	if (!empty($song_id)){
	    	echo "--------2";
	    	$list = Comment::where('song_id', $song_id)->order('publish_time', 'desc')->select();
	    	echo "--------3";
	    	$this->assign('comment_list', $list);
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
