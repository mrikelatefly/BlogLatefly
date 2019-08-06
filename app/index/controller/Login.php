<?php
namespace app\index\controller;
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
    public function index()//默认为即将登陆状态
    {
        //是否已经登录
        if(isLogin()){
            header("location:/Index");
            die();
        }
        if(isset($_POST["type"])){ //访问是否有效
           
            //判断类型
            switch($_POST["type"]){
                case "login"://是否是登录
                    $this->login();
                    break;
                case "out"://注销登录
                    $this->setUserOut();
                    break;
               default:
                    header("location:/Errorpage");
                    break;
            }
            
        }else{
            //默认登录界面
            return view("login/index");
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

        if($account!=""&&$password!=""){
            $db = Db::name(config('database_user'));
            $res =  $db->where("account","=",$account)->where("password","=",$password)->page(1,1)->select();
            //判断登录是否成功
            if(empty($res)){
                resultBackJson("404","login_failed","none");
            }else{
                //再次确认
                if($res[0]["account"]==$account&&$res[0]["password"]==$password&&$res[0]["account_state"]=='1'){
                    //返回信息 登录成功

                    //同时设置cookie 和session 的值
                    Cookie::set('account',$account);

                    resultBackJson("200","login_ok","sucss");
                    $this->setUserLogin($account);
                }else{
                    resultBackJson("400","login_failed","error");
                }
            } 
        }else{
            resultBackJson("403","login_failed","account password is none");
        }
    }
    
    //用户是否存在
    private function userExisted($account,$db)
    {  
        $exist = false;
        $res =  $db->where("account","=",$account)->page(1,1)->select();
        if(!empty($res)){
            $exist = true;
        }
        return $exist;
    }
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
        $db = Db::name(config('database_label'));
        $selectType=$db->where('type1','=',1)->select();
        $this->assign("selectType",$selectType);
        return $this->indexView(1,"");
    }
    private function indexView($page,$account){
        //查看文章数量
        $db = Db::name(config('database_article'));
        $count = $db->where("is_publish","=","1")->count("id");
        $end = intval($count/$this->item);
        //转化为页数
        if(($end*$this->item)<$count){
            $end=$end+1;
        }
        if($page>$end){
            $page = $end;
        }
        $article = $db->where("is_publish","=","1")->order('id desc')->page($page,$this->item)->select(); 
        //分配侧边栏推荐
        $db = Db::name(config('database_article'));
        $article_new = $db->where("is_publish","=","1")->order('release_time desc')->page(1,10)->select();
        $article_top = $db->where("is_publish","=","1")->order('views desc')->page(1,10)->select();
        $this->assign('article_new',$article_new);
        $this->assign('article_top',$article_top);
        



        return view("index/index",[
             "article"  => $article,
             "account"  => $account,
             "page"     => $page,
             "end"      => $end,
             "property" =>"Index",
        ]);
    }
}
