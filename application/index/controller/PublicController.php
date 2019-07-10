<?php
namespace app\index\controller;

use think\Controller;

class PublicController extends Controller
{
    // public function _initialize()
    // {
    //     parent::_initialize();
    //     $controller_name = request()->controller();
    //     $action_name = request()->action();
    //     if (!method_exists($this, $action_name)) return;
    //     if ($controller_name != 'User' || ($action_name != 'login' && $action_name != 'register')) {
    //         $this->chkLogin();
    //     }
    // }

    public function chkLogin()
    {
        if (!session('?user')) {
            $this->error('对不起，您还没有登录，请登录后再进行操作。', 'user/login');
            exit;
        }
    }
}
