<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Cookie;
class Memberlist extends Controller{

    public function index()
    { 
        //判断登录是否成功
        if(isLogin())
        {
            $account = Cookie::get("account");
            if($this->isadmin($account))
            {
                if(isset($_POST['operateType'])&&isset($_POST['Id']))
                {

                    //  echo $_POST['operateType'].'\n';
                    //  echo $_POST['articleId'];   
                    switch($_POST['operateType'])
                    {
                        //锁定
                        case "user_stop":
                            
                            return $this->userlock($_POST['Id']);
                            resultBackJson("200","user_stopped",$_POST['Id']);
                            break;
                        //开启
                        case "user_start":
                            //编辑
                            return $this->userunlock($_POST['Id']);
                            resultBackJson("200","user_starting",$_POST['Id']);
                            break;
                        case "user_delete":
                            $this->userdelete($_POST['Id']);
                            resultBackJson("200","user_deleted",$_POST['Id']);
                            break;    
                    }
                }
                else
                {
                    $db = Db::name("user");
                    $user =  $db->select();
                    $this->assign('user',$user);
                    $this->assign('account',$account);
                    return view('index/member-list');
                }
                
            }else
            {
                Header ("Location:/admin.php/Login");
            }
            
        }
        else
        {
         Header ("Location:/Errorpage");
        }
       
    }
    private function isadmin($account='')
    {
        $isadmin=false;
        if($account!='')
        {
            $db = Db::name("user");
            $res =  $db->where("account","=",$account)->page(1,1)->select();
            if($res[0]['authority']==0){
                $isadmin=true;
            }
        }
        return $isadmin;
    }
    private function userlock($id='')
    {
        if($id!='')
        {
            $db = Db::name(config('database_user'));
            $db->where('id','=',$id)->update(['account_state'=>0]);

        }
    }
    private function userunlock($id='')
    {
        if($id!='')
        {
            $db = Db::name(config('database_user'));
            $db->where('id','=',$id)->update(['account_state'=>1]);

        }
    }
    private function userdelete($id='')
    {
        if($id!='')
        {
            $db = Db::name(config('database_user'));
            $db->where('id','=',$id)->update(['account_state'=>-1]);

        }
    }
}