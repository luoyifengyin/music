<?php 
namespace app\index\controller;
use think\Controller;

class Debug extends Controller {
	public function test(){
		$view = $this->fetch('test',['val'=>'hello,world']);
        return $view;
        //return $this->fetch();
        exit;
	}
}

 ?>