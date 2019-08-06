<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;
class Charts1 extends Controller{

    public function index()
    {
       if(isLogin())
       {
            $account = Cookie::get("account");
            $db = Db::name(config('database_user'));
            $user = $db->where("account","=",$account)->select(); 
            $this->assign("user",$user[0]);
            $this->assign("account",$account);
            return view('index/charts-1');
       }
       else
       {
        Header ("Location:/Errorpage");
       }
    }
}
