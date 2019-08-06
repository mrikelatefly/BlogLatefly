<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Cookie;
class Membershow extends Controller{

    public function index()
    {
        if(isLogin())
        {
             $account = Cookie::get("account");
             $this->assign('account',$account);
             return view('index/member-show');
        }
        else
        {
         Header ("Location:/Errorpage");
        }
    }
}
