<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Cookie;
class Index extends Controller{

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
                return view('index/index');
            }else{
                Header ("Location:/admin.php/Login");
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
}

/*
 $list=[
            'user1'=>[
                'id'    =>'123',
                'name'  =>'aaa'
            ],
            'name2'=>[
                'id'    =>'456',
                'name'  =>'bbb'
            ],
            'name3'=>[
                'id'    =>'678',
                'name'  =>'ccc'
            ]
        ];
       // $this->assign('list',$list);
        // return view("index",[
        //     "list"      =>$list
        // ]);
        dump(config('database'));


*/