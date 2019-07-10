<?php 
namespace app\index\controller;
use think\Controller;

class PublicController extends Controller{
	public function _initialize(){
		parent::_initialize();
		if (CONTROLLER_NAME != 'user' || ACTION_NAME != 'login' || ACTION_NAME != 'register'){
			$this->chkLogin();
		}
	}

	public function chkLogin(){
		if (!section('?user')){
			$this->error('对不起，您还没有登录，请登录后再进行操作。', 'user/login');
		}
	}
}

 ?>