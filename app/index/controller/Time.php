<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
use think\Db;
use think\Cookie;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
//主要为跨域CORS配置的两大基本信息,Origin和headers
class Time extends Controller
{
    private $item = 30;
    public function index(Request $request)
    {

       $isLogin = isLogin();
       $account = "";
       if($isLogin){//登录用户信息
            $account = Cookie::get("account");
       }
       return $this->timeView(1,$account);
       //return view("index/time");
      
    }
    private function timeView($page,$account){
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

        return view("index/time",[
             "article"  => $article,
             "account"  => $account,
             "page"     => $page,
             "end"      => $end,
             "property" =>"Time",
        ]);
    }
    public function page($id=1){
        $isLogin = isLogin();
        $account = "";
        if($isLogin){//登录用户信息
            $account = Cookie::get("account");
        }
        if($id<1){
            $id = 1;
        }
        return $this->timeView($id,$account);
    }
    
}
