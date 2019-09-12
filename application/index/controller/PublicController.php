<?php
namespace app\index\controller;

use think\Controller;

class PublicController extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->view->config('tpl_cache', false);
        if (request()->isAjax() || request()->isPjax()){
            //echo "----------";
            $this->view->engine->layout(false);
        }
        //echo request()->method();
        // $controller_name = request()->controller();
        // $action_name = request()->action();
        // if ($action_name == 'search'){
        //     if (request()->isPjax()){
        //         echo "ajax";
        //     }
        //     else echo "not ajax";
        // }
        //if (!method_exists($this, $action_name)) exit;
    }

    public function chkLogin($uid = null)
    {
        if (!session('?user')) {
            $this->error('对不起，您还没有登录，请登录后再进行操作。', 'user/login');
            exit;
        }
        elseif (!empty($uid) && session('user.id') != $uid){
            $this->error('网络传输错误');
            exit;
        }
    }
}
