<?php
namespace app\index\controller;
//use app\common\controller\Index as commonIndex;
use think\Request;
use think\Controller;
use think\Db;
use think\Cookie;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
//主要为跨域CORS配置的两大基本信息,Origin和headers
class Index extends Controller
{
    private $item = 20;
    public function index(Request $request)
    {
        $isLogin = isLogin();
        $account = "";
        if($isLogin){//登录用户信息
            $account = Cookie::get("account");
        }
       return $this->indexView(1,$account);
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
        
        //侧边栏推荐
        $article_new = $db->where("is_publish","=","1")->order('release_time desc')->page($page,10)->select();
        $article_top = $db->where("is_publish","=","1")->order('views desc')->page($page,10)->select();
        //文章分类
        $db = Db::name(config('database_label'));
        $selectType=$db->where('type1','=',1)->select();
       
       // $this->assign("selectType",$selectType);

        return view("index/index",[
             "article"  => $article,
             "account"  => $account,
             "page"     => $page,
             "end"      => $end,
             "property" =>"Index",
             "article_new" =>$article_new,
             "article_top" =>$article_top,
             "selectType"  =>$selectType
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
        return $this->indexView($id,$account);
    }
   
}
