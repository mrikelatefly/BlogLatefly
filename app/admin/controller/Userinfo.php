<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Cookie;
class Userinfo extends Controller{

    public function index()
    {

        if(isLogin()){
            $account = Cookie::get("account");
            $this->assign('account',$account);
            return view('index/user-info');
        }else if(isset($_POST['editorValue'])){
            echo $_POST['editorValue'];
        }
        else{
            Header ("Location:/admin.php/Login");
            //header("admin.php/Articlemanage");
            die();
        }
       
    }
}