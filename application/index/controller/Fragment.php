<?php 
// namespace app\index\controller;
// use app\index\controller\PublicController;
// use think\Controller;
// use think\Request;
// use app\index\model\Song;
// use app\index\model\Album;
// use app\index\model\Comment;

// class Fragment extends PublicController{
// 	// public static $rankTitles = Array(1=>'热歌榜', 2=>'新歌榜', 11=>'华语榜', 12=>'粤语榜', 13=>'欧美榜', 14=>'日语榜', 15=>'韩语榜', 100=>'其他榜');
// 	public function rank(){
// 		$request = Request::instance();
//     	$rank = input('get.rank');
// 		if (empty($rank)) $rank = 1;
//     	if ($rank > 10){
//     		if ($rank <= 20) $query = Song::where('area', $rank-10);
// 	    	else $query = Song::where('area', '100');
//     	}
//     	else $query = Song::where('1=1');
//     	if ($rank == 2) $order = 'upload_time';
//     	else $order = 'popularity';
//     	$list = $query->order($order, 'desc')->limit(20)->select();
//     	if ($request->isAjax()){
// 	    	//$res->rank_title = Index::$rankTitles[$rank];
// 	    	$res->rank_list = $list;
// 	    	return json_encode($res);
// 	    }
// 	    else {
// 	    	//$this->assign('rank_title', '热歌榜');
// 	    	$this->assign('rank_list', $list);
// 	    	return $this->fetch();
// 	    }
// 	}

// 	public function song(){
// 		$request = Request::instance();
//     	$song_id = $request->get('id');
//     	if (!empty($song_id)){
//     		$song = Song::get($song_id);
//     		if (!empty($song->album_id)){
// 	    		$album = Album::get($song->album_id);
// 	    		$this->assign('album', $album->name);
// 	    	}
// 	    	$list = Comment::where('song_id', $song_id)->order('publish_time', 'desc')->paginate(3);

// 	    	$this->assign([
// 	    		'song'			=> $song,
// 	    		'comment_list'	=> $list
// 	    	]);
// 	    	return $this->fetch('fragment/song');
// 	    }
// 	}
// }
