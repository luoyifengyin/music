<?php 
namespace app\index\controller;
use think\Controller;

class Debug extends Controller {
	public function test(){
		// echo "APP_PATH: ".APP_PATH."<br>";
  //   	echo "ROOT_PATH: ".ROOT_PATH."<br>";
  //   	echo "__DIR__: ".__DIR__."<br>";
  //   	echo "THINK_PATH: ".THINK_PATH."<br>";
  //   	echo "LIB_PATH: ".LIB_PATH."<br>";
  //   	echo "CORE_PATH: ".CORE_PATH."<br>";
        
        return view();
        //return $this->fetch();
        exit;
	}

    public function pjax_content(){
        return view();
    }

  	public function header(){
  		return $this->fetch('common@public/header1');
  	}

    private static function debug(){
        return 'hello, debug';
    }

    public function search(){
        return view('fragment/search_test');
    }

    public function upload(){
        return view('user/upload');
    }
}
