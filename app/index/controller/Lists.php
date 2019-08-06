<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
use think\Cookie;
use think\Db;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
//主要为跨域CORS配置的两大基本信息,Origin和headers
class Lists extends Controller
{
    public function index(Request $request)
    {
        $isLogin = isLogin();
        $account = "";
        if($isLogin){//登录用户信息
            $account = Cookie::get("account");
        }
        //分配侧边栏推荐
        $db = Db::name(config('database_article'));
        $article_new = $db->where("is_publish","=","1")->order('release_time desc')->page(1,10)->select();
        $article_top = $db->where("is_publish","=","1")->order('views desc')->page(1,10)->select();
        $this->assign('article_new',$article_new);
        $this->assign('article_top',$article_top);


        //分配分类随笔心情，笔记分享
        $notes = $db->where("is_publish","=","1")->where("type","=","3")->select();
        //标签信息
        $db = Db::name(config('database_label'));
        $selectType=$db->where('type1','=',1)->select();


        return view("index/list",[
            "account"  => $account,
            "page"     => 1,
            "end"      => 2,
            "property" =>"Index",
            "notes"         =>$notes,
            "selectType"    =>$selectType
       ]);
      
    }
    
}
