<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Editarticle extends Controller{

    public function index()
    {
        $isLogin = isLogin();
        $account = "";
        if($isLogin){//登录用户信息
            if(isset($_POST["getContent"])&&isset($_GET['id'])){
                $id = $_GET['id'];
                Db::name(config('database_article'));
                $db = Db::name(config('database_article'));
                $article = $db->where("id","=",$id)->select(); 
                $article= $article[0];
                $this->assign('article',$article);
                
                $path = "user/".$article['from_user']."/article/".explode(" ",$article['release_time'])[0]."/".$article['id'].".html";
                
                $file = fopen($path, "r") or die("Unable to open file!");
                $article["content"] = fread($file,filesize($path));
                echo $article["content"];
            }else if(isset($_POST["submitEdit"])&&isset($_GET['id'])){
                $id = $_GET['id'];
                $article=[
                    'title'    => $_POST['title'],
                    'summary'  => $_POST['summary'],
                    'comment_permission' =>$_POST['comment_permission'],
                ];
                if($_POST['article_cover']!=''){
                    $article['img_url']=$_POST['article_cover'];
                }
                if($_POST['article_type']!='0'){
                    $article['type'] =$_POST['article_type'];
                }

                $db = Db::name(config('database_article'));
                $db->where('id','=',$id)->update($article);

                $article=$db->where('id','=',$id)->select();
                $this->savearticle("user/".Cookie::get('account')."/article/".explode(" ",$article[0]['release_time'])[0],$_POST['editorValue'],$id);

            }
            else
            {

                $account = Cookie::get("account");
                //返回用户信息
                $db = Db::name(config('database_user'));
                $user = $db->where("account","=",$account)->select(); 
                $this->assign("user",$user[0]);
                $this->assign('account',$account);
                return $this->article_view();
            }
            
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
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            Db::name(config('database_article'));
            $db = Db::name(config('database_article'));
            $article = $db->where("id","=",$id)->select(); 
            $article= $article[0];

            //输出分类信息
            $db = Db::name(config('database_label'));
            $selectType=$db->where('type1','=',1)->select();

            $path = "user/".$article['from_user']."/article/".explode(" ",$article['release_time'])[0]."/".$article['id'].".html";
            
            $file = fopen($path, "r") or die("Unable to open file!");
            $article["content"] = fread($file,filesize($path));

            return view("index/article-edit",[
                "article"       =>  $article,
                "selectType"   =>  $selectType
            ]);     
       }else{
            echo "404";
       }

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