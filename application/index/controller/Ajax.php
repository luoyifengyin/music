<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use think\Song;

class Ajax {
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
}
