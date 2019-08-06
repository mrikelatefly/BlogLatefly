<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Cookie;
class Charts2 extends Controller{

    public function index()
    {
        if(isLogin())
        {
             $account = Cookie::get("account");
             $this->assign('account',$account);
             return view('index/charts-2');
        }
        else
        {
         Header ("Location:/Errorpage");
        }
    }
}
