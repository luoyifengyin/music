<?php
namespace app\index\controller;
use app\index\controller\PublicController;
use think\Request;
use think\Db;
use app\index\model\Song;
use app\index\model\Comment;

class Ajax extends PublicController{
    public function _initialize(){
        if (!request()->isAjax()) exit;
        parent::_initialize();
    }

	public function rank(){
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
    	$view = view('fragment/rank_list', ['rank_list'=>$list]);
    	//echo $view;
    	return $view;
	}

    public function search(){
        $keyword = input('get.keyword');
        if (!empty($keyword)){
            $list = Song::where('name', 'like', '%'.$keyword.'%')
                    ->whereOr('singer', 'like', '%'.$keyword.'%')
                    ->order('popularity', 'desc')
                    ->select();
            $this->assign("search_list", $list);
        }
        return view('fragment/search_list');
    }

    public function play(){
    	$song_id = input('get.id');
    	if (!empty($song_id) && $song = Song::get($song_id)){
	    	$song->popularity++;
	    	$song->allowField(true)->save();
            $uri = request()->root(true);
            $song->url = $uri.'/song/'.$song->song_path;
            echo json_encode($song);
	    	//return json_encode($song);
	    }
    }

    public function collect(){
    	//$uid = input('get.uid');
        //return "***********0";
    	$this->chkLogin();
    	$song_id = input('post.id');
    	//$playlist_id = input('get.playlist');
        $uid = session('user.id');
    	// if (Db::execute("insert into song_playlist (song_id, playlist_id, collection_time) value($song_id, $playlist_id, CURDATE())")){
    	// 	echo 1;
    	// }
    	// else echo 0;
        //return "*********1"; 
        if (!Db::query("select * from song_user where song_id='$song_id' and user_id='$uid'")){
            //return "insert into song_user (song_id,user_id) values($song_id,$uid)";
            if (Db::execute("insert into song_user (song_id,user_id) values($song_id,$uid)")){
                return 1;
            }
            else return 0;
        }
        else return 2;
    }

    public function delete(){
        $this->chkLogin();
        $song_id = input('post.id');
        $uid = session('user.id');
        if (Db::execute("delete from song_user where song_id='$song_id' and user_id='$uid'")){
            return 1;
        }
        else return 0;
    }

    public function upload(){
        $this->chkLogin();
    	$data = input('post');
    	if (empty($data)){
            $this->error('上传文件失败!');
            exit;
        }
    	//$uid = $data['uid'];
    	$music = request()->file('music');
        $cover = request()->file('cover');
    	if ($music){
    		//$response->code = 0;
    		$musicinfo = $music->validate(['ext'=>'mp3'])->move(ROOT_PATH.'public'.DS.'song');
            $coverindo = $cover->validate(['ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH.'public'.DS.'song');
    		if ($musicinfo){
    			$song = new Song;
    			$song->data($data, true);
    			if ($song->allowField(true)->save()){
    				// $response->code = 1;
    				// $response->msg = "上传成功！";
                    $this->success('上传成功！');
    			}
    			else{
                    //$response->msg = "文件上传失败";
                    $this->error('上传文件失败!');
                } 
    		}
    		else {
    			//$response->msg = $file->getError();
                $this->error($music->getError());
    		}
    		//return json_encode($response);
    	}
    }

    public function download(){
        $this->chkLogin();
    	$data = request()->get();
    	if (empty($data)) exit;
    	//$uid = $data['uid'];
    	$song_id = $data['id'];

    	$song = Song::get($song_id);
        $path = $song->song_path;
    	$uri = request()->root(true);
        //return $uri;
        $url = "$uri/song/$path";
        //return $url;
        $res = new class{};
        $res->url = $url;
        $res->downloadName = $song->name.".mp3";
        //return 3;
        return json_encode($res);
		//header("Location: $uri/song/$path");
		exit;
    }

    public function comment(){
        //return '-------0';
        $this->chkLogin();
        $data = request()->post();
        //echo "--------1";
        if (!empty($data)){
            //echo "--------2";
            $comment = new Comment();
            $comment->data($data, true);
            if ($comment->allowField(true)->save()){
                //Db::execute('go');
                //return $comment->song_id;
                //$comment = new Comment;
                // $list = $comment->where('song_id', $comment->song_id)->order('publish_time', 'desc')->paginate(3, false, [
                //     'fragment' => 'comment'
                // ]);
                // //return "-----3";
                // foreach ($list as $key => $value) {
                //     //return "*******0";
                //     $user = (new User)->get($value->user_id);
                //     //return "*******1";
                //     $value->username = $user->username;
                //     $value->profile_picture = $user->profile_picture;
                // }
                // //return "-----4";
                // $this->assign('comment_list', $list);
                // return $this->fetch('fragment/comment_list');
                
                // $this->view->engine->layout(true);
                // $this->success("评论发送成功");
                
                $this->redirect('index/song');
            }
        }
    }
}
