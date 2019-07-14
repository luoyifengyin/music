<?php
namespace app\index\controller;
use app\index\controller\PublicController;
use app\index\model\User as UserModel;
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
            }
            else {
                if ($user->allowField(true)->save()){
                    //echo $user->password."<br/>";
                    //echo $user->ip."<br/>";
                    //session('user', $user);
                    $this->success('注册成功', 'User/login');
                }
                else $this->error('注册失败');
            }
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
                $this->redirect('index/index');
            }
            else $this->error('用户名不存在或密码不正确');
        }
        else return $this->fetch();
    }

    public function logout(){
        session("user", null);
        return $this->redirect('index/index');
    }

    public function modify(){
        $this->chkLogin();
        $request = Request::instance();
        $data = $request->post();
        if (!empty($data)){
            $user = UserModel::get(session('user.id'));
            $user->data($data);
            if ($user->allowField(true)->save()){
                session('user', $user);
                $this->success('个人信息修改成功');
            }
            else $this->error('个人信息修改失败');
        }
        return $this->fetch();
    }
}
