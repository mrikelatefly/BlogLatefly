<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
//主要为跨域CORS配置的两大基本信息,Origin和headers
class Userhome extends Controller{

    public function index()
    {
        $isLogin = isLogin();
        $account = "";
        if($isLogin){//登录用户信息
            $account = Cookie::get("account");
            
            $db = Db::name(config('database_user'));
            $user = $db->where("account","=",$account)->select();

            $this->assign("user",$user[0]);
            $this->assign("account",$account);
            return view('index/userhome');
        }
        else{

            echo "404";
            die();
        }
       
    }
}
