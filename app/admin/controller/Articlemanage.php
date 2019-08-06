<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Cookie;
class Articlemanage extends Controller{

    public function index()
    {
        if(isLogin()){
            $account = Cookie::get("account");
            if($this->isadmin($account))
            {
                $db = Db::name(config('database_article'));
                $article = $db->select();
                $this->assign('article',$article);
                $this->assign('account',$account);
                return view('index/article-manage');
            }
            
        }
        else{
            Header ("Location:/admin.php/Login");
            //header("admin.php/Articlemanage");
            die();
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
    // private function indexView($page,$account){
    //     //查看文章数量
    //     $db = Db::name(config('database_article'));
    //     $count = $db->where("is_publish","=","1")->count("id");
    //     $end = intval($count/$this->item);
    //     //转化为页数
    //     if(($end*$this->item)<$count){
    //         $end=$end+1;
    //     }
    //     if($page>$end){
    //         $page = $end;
    //     }
    //     $article = $db->where("is_publish","=","1")->order('id desc')->page($page,20)->select(); 
    //     return view("admmin.php/article-manage",[
    //          "article"  => $article,
    //          "account"  => $account,
    //          "page"     => $page,
    //          "end"      => $end,
    //          "property" =>"Index",
    //     ]);
    // }
}
