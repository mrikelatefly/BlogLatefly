<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Cookie;
class Memberdetails extends Controller{

    public function index()
    { 

        if(isLogin())
        {
            $account = Cookie::get("account");
            $db = Db::name(config('database_user'));
            $user =  $db->select();
            //判断登录是否成功



            $form=isset($_POST['submit'])?isset($_POST['submit']):'';
            if($form!='')
            {
                resultBackJson("200","submitted",$form);die();
            }
            $this->assign('user',$user);
            $this->assign('account',$account);
            return view('index/member-details');
        }
        else
        {
         Header ("Location:/Errorpage");
        }
       
    }
}