<?php
namespace app\index\controller;
use app\index\controller\PublicController;
use app\index\model\User as UserModel;
use app\index\model\Song as SongModel;
use think\Request;

class User extends PublicController
{
    public function register(){
        $request = Request::instance();
        $data = $request->post();
        if (!empty($data)){
            $user = new UserModel();
            $user->data($data, true);
            //echo $user->password."<br/>";
            if ($user->where('username', $user->username)->find()){
                $this->error('用户名已存在');
                exit;
            }
            if ($user->validate(true)->allowField(true)->save()){
                //echo $user->password."<br/>";
                //echo $user->ip."<br/>";
                //session('user', $user);
                $this->success('注册成功', 'User/login');
            }
            else dump($user->getError());
        }
        else return $this->fetch();
    }

    public function login(){
        $request = Request::instance();
        $data = $request->post();
        if (!empty($data)){
            $user = new UserModel();
            $user->data($data, true);
            $user = UserModel::where('username', $user->username)->where('password', $user->password)->find();
            if ($user){
                session('user', $user);
                cookie('user', $user);
                $this->success('登录成功', '/');
            }
            else $this->error('用户名不存在或密码不正确');
        }
        else return $this->fetch();
    }

    public function logout(){
        $this->chkLogin();
        session("user", null);
        return $this->redirect('index/index');
    }

    public function personal(){
        $this->chkLogin();
        $uid = session('user.id');
        $list = SongModel::where('user_id', $uid)->order('upload_time', 'desc')->select();
        $this->assign('upload_list', $list);
        return $this->fetch();
    }

    public function modify(){
        $this->chkLogin();
        $request = Request::instance();
        //echo session('user');
        if ($request->isPost()){
            $data = $request->post();
            $user_id = session('user.id');
            //$data['id'] = $user_id;
            //echo 'session user id: '.$user_id."<br>";
            if (!empty($data)){
                //dump($data);
                if (!empty($data['username'])) $data['username'] = trim($data['username']);
                //echo "-------user id".$user->id;
                // foreach ($data as $key => $value) {
                //     $user[$key] = $value;
                // }
            }
            $file = $request->file('profilePicture');
            if (!empty($file)){
                //echo ROOT_PATH.'public'.DS.'user'.DS.'profile_picture';
                $info = $file->validate(['ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH.'public'.DS.'user'.DS.'profile_picture');
                if ($info) {
                    //echo "avatar success";
                    //if (empty($user)) $user = UserModel::get($user_id);
                    //$user->profile_picture = $info->getSaveName();
                    $data['profile_picture'] = $info->getSaveName();
                }
            }
            $user = UserModel::get($user_id);
            if (empty($user)){
                $this->error('个人信息修改失败');
                exit;
            }
            if ($user->allowField(true)->save($data)){
                session('user', $user);
                $this->success('个人信息修改成功');
            }
            else $this->error('个人信息修改失败');
            exit;
        }
        // else if ($request->isPjax()){
        //     $this->view->engine->layout(false);
        //     echo "---modify pjax";
        //     return $this->fetch();
        // }
        else {
            //echo "----modify normal";
            return $this->fetch();
        } 
    }

    public function upload(){
        $this->chkLogin();
        $request = Request::instance();
        if ($request->isPost()){
            $data = $request->post();
            $music = $request->file('music');
            $cover = $request->file('cover');
            if (empty($data)) $this->error('歌曲信息不能为空');
            if (empty($music)) $this->error('音乐文件不能为空');
            //if (empty($cover)) $this->error('cover empty');
            // if (empty($data) || empty($music)){
            //     $this->error('上传文件失败!');
            //     exit;
            // }
            if ($musicinfo = $music->validate(['ext'=>'mp3'])->move(ROOT_PATH.'public'.DS.'song')){
                $song = new SongModel();
                $song->data($data, true);
                $song->song_path = $musicinfo->getSaveName();
                if (!empty($cover) && $coverinfo = $cover->validate(['ext'=>'jpg,jpg,jpeg,png,gif'])->move(ROOT_PATH.'public'.DS.'song'.DS.'cover')){
                    $song->cover = $coverinfo->getSaveName();
                }
                $song->user_id = session('user.id');
                if ($song->allowField(true)->save()){
                    $this->success('文件上传成功');
                    exit;
                }
            }
            $this->error('文件上传失败');
        }
        else return $this->fetch();
    }
}
