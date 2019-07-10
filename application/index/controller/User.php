<?php
namespace app\index\controller;
use app\index\controller\PublicController;
use app\index\model\User as UserModel;
use think\Request;

class User extends PublicController
{
    public function register(){
    	$request = Request::instance();
    	if (!empty($request->post())){
    		$user = new UserModel;
    		$user->username = trim($request->post('username'));
    		$user->password = md5($request->post('password'));
    		if ($user->where('username', $user->username)->find()){
    			$this->error('用户名已存在');
    		}
    		else {
    			if ($user->save()){
    				//session('user', $user);
    				$this->success('注册成功', 'login');
    				//return $this->fetch('index/index');
    			}
    			else $this->error('注册失败');
    		}
    	}
    	else return $this->fetch();
    }

    public function login(){
    	$request = Request::instance();
    	if (!empty($request->post())){
    		$username = trim($request->post('username'));
    		$password = md5($request->post('password'));
    		$user = User::where('username', $username)->where('password', $password)->find();
    		if ($user){
    			session('user', $user);
    			return $this->fetch('index/index');
    		}
    		else $this->error('用户名不存在或密码不正确');
    	}
        else return $this->fetch();
    }

    public function logout(){
    	session("user", null);
    	return $this->fetch('index/index');
    }

    public function modify(){
    	$request = Request::instance();
    	if (!empty($request->post())){
    		$user = User::get(session('user.id'));
    		$user->username = trim($request->post('username'));
    		$user->password = md5($request->post('password'));
    		if ($user->save()){
	    		session('user', $user);
	    		$this->success('个人信息修改成功');
	    	}
	    	else $this->error('个人信息修改失败');
    	}
    	return $this->fetch();
    }
}
