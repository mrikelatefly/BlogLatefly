<?php
namespace app\admin\controller;
use think\Request;
use think\Controller;
use think\Cookie;
use think\Session;
use think\Db;
/*
登录的判定
在Cookie中设置
acccount_level:
    admin
    author
    user
    stranger
account_type:
    email
    account
当account——level为stranger时account为空

*/
class Login extends Controller
{
    private $item = 20;
    public function index($login=0)//默认为即将登陆状态
    {
        //是否已经登录
        if(isLogin()){
            header("location:/admin.php");
            die();
        }
        if(isset($_POST["type"])){ //访问是否有效
            $type  = $_POST["type"];
            if($type=="login"){//是否是登录
                $this->login();
            }
            else{
                if($type=="out"){//注销登录
                    $this->setUserOut();
                }else{//非法访问
                    header("location:/Errorpage");
                }
        }
        }else{
            //默认登录界面
            $this->assign('login',$login);
            return view("index/login");
        }
    }
    private function setcookies($account_level)
    {
        if($account_level=='stranger')
        {
            Cookie::set('acccount_level','stranger');
            Cookie::set('account_type','null');
        }
        else
        {
            Cookie::set('acccount_level',$account_level,time()+60*60*24*2);//失效时间为两天
            Cookie::set('account_type','account',time()+60*60*24*2);
        }
    }
    private function login(){  
        $account = isset($_POST["account"])?$_POST["account"]:"";
        $password = isset($_POST["md5password"])?$_POST["md5password"]:"";
        $callback = isset($_GET["callback"])?$_GET["callback"]:"";

        if($account!=""&&$password!=""){
            $db = Db::name("user");
            $res =  $db->where("account","=",$account)->where("password","=",$password)->page(1,1)->select();
            //判断登录是否成功
            if(empty($res)){
                resultBackJson("403","login_failed","account or password error!!",$callback);
            }else{
                //再次确认
                if($res[0]["account"]==$account&&$res[0]["password"]==$password&&$res[0]["account_state"]=='1'){
                    //返回信息 登录成功
                    if($res[0]["authority"]==0)
                    {
                        //同时设置cookie 和session 的值
                        Cookie::set('account',$account);
                        resultBackJson("200","login_ok","sucss",$callback);
                        $this->setUserLogin($account);
                    }
                    else
                    {
                        resultBackJson("403","login_failed","you are not a admin!!",$callback);
                    }
                    
                }else{
                    resultBackJson("403","login_failed","account or password error!!",$callback);
                }
            } 
        }
    }
    // private function register()
    // {  
    //     $account = isset($_POST["account"])?$_POST["account"]:"";
    //     $password = isset($_POST["password"])?$_POST["password"]:"";
    //     $confirm = isset($_POST["confirm"])?$_POST["confirm"]:"";
    //     if($account!=""&&$password!=""&&($confirm==$password)){
    //         try{
    //             $db = Db::name("user");
    //             //插入
    //             $count = $db->insert([
    //                'account'         => $account,
    //                'password'        => $password,
    //                'authority'       =>2,
    //                'account_state'   =>1,
    //                'nick_name'       =>'user_'.$account
    //             ]);
    //             resultBackJson("200","registe_sucss","sucss");
    //         }catch(Exception $e){
    //             resultBackJson("500","registe_failed","error");
    //         }
    //     }else{
    //         resultBackJson("403","registe_failed","error");
    //     }
    // }
    private function setUserLogin($account)
    {  
        $randPassword = md5(rand(0,9999));
        Cookie::set('account',$account,time()+60*60*24*2);//失效时间为两天
        Cookie::set('randPassword',$randPassword,time()+60*60*24*2);
        Session::set('tempPassword',md5($account.$randPassword));
    }
    public function setUserOut()
    {  
        Cookie::set('account',"",time()+60*60*24*2);//失效时间为两天
        Cookie::set('randPassword',"",time()+60*60*24*2);
        Session::set('tempPassword',"");
        header("location:/admin.php/Login");
    }
    
}


/*
$db1 = Db::name("article0");
        $db2 = Db::name("article");
        $article =  $db1->select();
        foreach($article as $v){
            $count = $db2->insert([
                        'title'    => $v['title'],
                        'summary'  => $v['summary'],
                        'from_user' => $v['fromuser'],
                        'type'     => $v['type'],
                        'content'  => $v['content'],
                        'release_time'  => $v['daytime'],
                        'authority'=> $v['authority'],
                        'views'    => $v['views'],
                        'is_publish'  => $v['isok'],
                        'img_url'   => $v['img'],
                        'ulove'    => $v['ulove'],
                        'uhate'    => 0
            ]);
            echo "<br/>".$count;
        }
private function register()
    {  
        $account = isset($_POST["account"])?$_POST["account"]:"";
        $password = isset($_POST["password"])?$_POST["password"]:"";
        $confirm = isset($_POST["confirm"])?$_POST["confirm"]:"";
        $callback = isset($_GET["callback"])?$_GET["callback"]:"";
        if($account!=""&&$password!=""&&($confirm==$password)){
            try{
                $db = Db::name("user");
                //插入
                $count = $db->insert([
                   'account'         => $account,
                   'password'        => $password,
                   'authority'       =>2,
                   'account_state'   =>1,
                   'nick_name'       =>'user_'.$account
                ]);
                resultBackJson("200","registe_sucss","sucss",$callback);
            }catch(Exception $e){
                resultBackJson("500","registe_failed","error",$callback);
            }
        }else{
            resultBackJson("403","registe_failed","error",$callback);
        }
    }
*/