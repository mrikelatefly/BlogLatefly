<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
use think\Db;
use think\Cookie;

class Info extends Controller
{
    //http://localhost/Info/index/id/80.html
    public function index($id="")
    {
        $isLogin = isLogin();
        $account = "";
        $user="";
        if($isLogin){//登录用户信息
            $db = Db::name("user");
            $account = Cookie::get("account");
            $user=$db->where('account','=',$account)->select();
        }
        if($id=="")
        {
            echo "404";
            die();
        }else{
            $db = Db::name(config('database_article'));
            $article = $db->where('id','=',$id)->select();
            //已经登录  并且文章存在
            if($account!=""&&!empty($article)){
                //作者自己浏览自己文章 或者管理员 不管任何状态都可浏览
                if($account==$article[0]['from_user']||($user!=""&&($user[0]["authority"]==0||$user[0]["authority"]==1))){
                        if($account==$article[0]['from_user']){
                            return $this->infoView($article,$account);
                        }else{
                            return $this->infoView($article,$account,$db);
                        }
                       
                }else{
                    //登录者不是文章作者本人没有发表不能查看
                    if(!empty($article)&&$article[0]["is_publish"]==1){
                        return $this->infoView($article,$account,$db);
                    }else{
                        echo "404";
                    }
                }
            }else{
                //没有登录文章存在并且发布可以浏览
                if(!empty($article)&&$article[0]["is_publish"]==1){

                    return $this->infoView($article,$account,$db);
                }else{
                    echo "404";
                }
            }
        }
    }
    private function infoView($article,$account,$db=""){
        $last_article='';
        $next_article='';
        //文章浏览量加一
        if($db!=""){
            $views = $article[0]['views']+1;
            $db->where('id','=',$article[0]['id'])->update(['views'=> $views]);
            //分配上下篇列表
            $last_article=$db->where('id','<',$article[0]['id'])->order('id desc')->where('is_publish','=',1)->select();
            $next_article=$db->where('id','>',$article[0]['id'])->order('id asc')->where('is_publish','=',1)->select();
        }
        //返回文章
        $path = "user/".$article[0]['from_user']."/article/".explode(" ",$article[0]['release_time'])[0]."/".$article[0]['id'].".html";
        $file = fopen($path, "r") or die("Unable to open file!");
        $article[0]["content"] = fread($file,filesize($path));
        $article[0]["views"] = $article[0]['views']+1;

        
        //返回文章分类
        $db = Db::name(config('database_label'));
        $selectType=$db->where('type1','=',1)->select();

        //分配侧边栏推荐
        $db = Db::name(config('database_article'));
        $article_new = $db->where("is_publish","=","1")->order('release_time desc')->page(1,10)->select();
        $article_top = $db->where("is_publish","=","1")->order('views desc')->page(1,10)->select();
        $this->assign('article_new',$article_new);
        $this->assign('article_top',$article_top);

        $this->assign('selectType',$selectType);
        $this->assign('article',$article[0]);
        $this->assign('account',$account);
        $this->assign('last_article',$last_article);
        $this->assign('next_article',$next_article);
        return view("index/info");
    }
    
}
