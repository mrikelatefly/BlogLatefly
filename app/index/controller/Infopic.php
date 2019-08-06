<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
use think\Cookie;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
//主要为跨域CORS配置的两大基本信息,Origin和headers
class Infopic extends Controller
{
    public function index(Request $request)
    {
        $isLogin = isLogin();
        $account = "";
        if($isLogin){//登录用户信息
            $account = Cookie::get("account");
        }
       $this->assign("account",$account);
       return view("index/infopic");
      
    }
    
}
