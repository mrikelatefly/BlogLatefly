<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Addarticle extends Controller{

    public function index()
    {
        $isLogin = isLogin();
        $account = "";
        if($isLogin){//登录用户信息
            $account = Cookie::get("account");
            $this->assign('account',$account);
            return $this->article_view();
        }
        else{
            //return view("index/errorpage");
            header("location:/Errorpage");
            echo "403 error";
        }
    }
    private function article_view()
    {
        /*
        数据更新到数据库
        创建文本文件
        */
        if(isset($_POST['editorValue'])){
            $account = Cookie::get("account");
            $date = date("Y-m-d h:i");
            $content = $_POST['editorValue'];
            $article=[
                'title'    => $_POST['title'],
                'summary'  => $_POST['summary'],
                'from_user' => $account,
                'type'     => $_POST['article_type'],
                'release_time'  => $date,
                'authority'=>2,
                'views'    => 0,
                'is_publish'  => 0,
                'img_url'   =>$_POST['article_cover'],
                'comment_permission' => $_POST['comment_permission'],
                'ulove'    => 0,
                'uhate'    => 0
            ];


            //插入数据库
            $id =  $this->insertArticle($article);
            //创建文件
            //dump(mb_detect_encoding($content, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5')));
            $this->savearticle("user/".$article['from_user']."/article/".explode(" ",$date)[0],$content,$id);
            $callback =  $callback = isset($_GET["callback"])?$_GET["callback"]:"";
            resultBackJson("200","add_ok","sucss",$callback);
       }else{
            $account = Cookie::get("account");
            
            //输出分类信息
            $db = Db::name(config('database_label'));
            $selectType=$db->where('type1','=',1)->select();
            
            
            $db = Db::name(config('database_user'));
            $user = $db->where("account","=",$account)->select(); 
            $this->assign("user",$user[0]);
            $this->assign("selectType",$selectType);
            return view('index/article-add');
       }

    }

    private function insertArticle($article){
        $db = Db::name(config('database_article'));
        $id = $db->insertGetId($article);
    
        return $id;
    }
    private function savearticle($direct='',$arts='',$title='')
    {
        $dir = iconv("UTF-8", "GBK", $direct);
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
            //echo '创建文件夹成功';
        } else {
            //echo '需创建的文件夹已经存在';
        }
        $myfile = fopen($direct.'/'.$title.'.html', "w") or die("Unable to open file!");
        fwrite($myfile,$arts);
        fclose($myfile);
    }
   
    
}