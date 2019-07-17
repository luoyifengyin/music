<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use app\index\model\Song;
use think\Controller;

class Ajax extends Controller{
	public function rank(){
		if (request()->isAjax()){
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
	    	$view = view('index/rank_list', ['rank_list'=>$list]);
	    	//echo $view;
	    	return $view;
	    }
	}

    public function play(){
    	$request = Request::instance();
    	$song_id = $request->get('song');
    	if ($song = Song::get($song_id)){
	    	$song->popularity++;
	    	$song->allowField(true)->save();
	    	echo $song->song;
	    }
    }

    public function collect(){
    	$request = Request::instance();
    	$song_id = $request->get('song');
    	$playlist_id = $request->get('playlist');
    	if (Db::execute("insert into song_playlist (song_id, playlist_id, collection_time) value($song_id, $playlist_id, CURDATE())")){
    		echo 1;
    	}
    	else echo 0;
    	exit;
    }

    public function upload(){
    	$request = Request::instance();
    	$file = $request->file('music');
    	if ($file){
    		$info = $file->validate(['ext'=>'mp3'])->move(ROOT_PATH.'public'.DS.'song');
    		if ($info){

    			echo "success";
    		}
    		else {
    			echo $file->getError();
    		}
    	}
    }

    public function download(){

    }
}
