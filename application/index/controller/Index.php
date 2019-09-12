<?php
namespace app\index\controller;
use app\index\controller\PublicController;
use think\Request;
use app\index\model\User;
use app\index\model\Song;
use app\index\model\Album;
use app\index\model\Comment;
use think\Db;

class Index extends PublicController
{
    public function index(){
    	//$this->redirect('rank');
        return $this->fetch();
        //return $this->rank();
    }

    // public static $rankTitles = Array(1=>'热歌榜', 2=>'新歌榜', 11=>'华语榜', 12=>'粤语榜', 13=>'欧美榜', 14=>'日语榜', 15=>'韩语榜', 100=>'其他榜');
    public function rank(){
    	//$this->assign('page', 'rank');
    	$request = Request::instance();
    	$rank = $request->get('rank');
		if (empty($rank)) $rank = 1;
    	if ($rank > 10){
    		if ($rank <= 20) $query = Song::where('area', $rank-10);
	    	else $query = Song::where('area', '100');
    	}
    	else $query = Song::where('1=1');
    	if ($rank == 2) $order = 'upload_time';
    	else $order = 'popularity';
    	$list = $query->order($order, 'desc')->limit(20)->select();
    	$this->assign('rank_list', $list);
    	// if ($request->isAjax() || $request->isPjax() || $request->isPost()){
    	// 	echo "------rank pjax";
	    // 	//$res->rank_title = Index::$rankTitles[$rank];
	    // 	//$res->rank_list = $list;
	    // 	$this->view->engine->layout(false);
	    // }
	    // else {
	    // 	echo "-------rank normal";
	    // 	//$this->assign('rank_title', '热歌榜');
	    // }
    	return $this->fetch();
    	//return $this->fetch('index');
    }

    public function song($id){
    	$request = Request::instance();
    	$song_id = $id;
    	//$song_id = $request->get('id');
    	if (!empty($song_id)){
    		$song = Song::get($song_id);
    		if (!empty($song->album_id)){
	    		$album = Album::get($song->album_id);
	    		$this->assign('album', $album->name);
	    	}

	    	$list = Comment::where('song_id', $song_id)->order('publish_time', 'desc')->paginate(10, false, [
	    		'fragment' => 'comment'
	    	]);
	    	foreach ($list as $key => $value) {
	    		$user = User::get($value->user_id);
	    		$value->username = $user->username;
	    		$value->profile_picture = $user->profile_picture;
	    	}

	    	$this->assign([
	    		'song'			=> $song,
	    		'comment_list'	=> $list
	    	]);
	    	// if ($request->isAjax() || $request->isPjax() || $request->isPost()){
	    	// 	echo "--------song ajax";
	    	// 	$this->view->engine->layout(false);
	    	// }
	    	// else echo "-----song normal";
	    	return $this->fetch();
	    }
		// return '../fragment/song?id='.$song_id;
		// //return url('fragment/song').'?id=$song_id';
		// //return $this->fetch('fragment/song?id=1');
  //   	return $this->fetch('index', ['page'=>'song?id='.$song_id]);
    }

    public function search(){
    	$request = Request::instance();
    	$keyword = $request->get('keyword');
    	if (!empty($keyword)){
	    	$list = Song::where('name', 'like', '%'.$keyword.'%')
	    			->whereOr('singer', 'like', '%'.$keyword.'%')
	    			->order('popularity', 'desc')
	    			->select();
	    	$this->assign("keyword", $keyword);
	    	$this->assign("search_list", $list);
	    }
	    //$this->view->engine->layout(false);
    	return $this->fetch();
    }

    public function my_music(){
        $this->chkLogin();
        $uid = session('user.id');
        $list = Db::query("select * from song_user where user_id='$uid'");
        //dump($list);
        $songlist = Array();
        foreach ($list as $key => $value) {
            $song = Song::get($value['song_id']);
            $song->id = $value['song_id'];
            $songlist[$key] = $song;
        }
        //dump($songlist);
        $this->assign('music_list', $songlist);
    	return $this->fetch();
    }

    public function comment(){
    	$this->chkLogin();
        $data = request()->post();
        if (!empty($data)){
            $comment = new Comment();
            $comment->data($data, true);
            if ($comment->allowField(true)->save()){
            	$this->redirect('song/'.$comment->song_id);
            }
        }
    }
}
