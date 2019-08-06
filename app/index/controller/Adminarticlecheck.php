<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
//主要为跨域CORS配置的两大基本信息,Origin和headers
class Adminarticlecheck extends Controller{

    public function index()
    {
    
        $isLogin = isLogin();
        $account = "";
        if($isLogin){//登录用户信息
            if(isset($_POST['operateType'])&&isset($_POST['articleId'])){
                switch($_POST['operateType'])
                {
                    case "delete":
                         //删除
                         $this->delete($_POST['articleId']);
                         resultBackJson("200","delete_successfuly",$_POST['articleId']);
                        break;
                    case "publish":
                         //发布
                         $this->publish($_POST['articleId']);
                         resultBackJson("200","publish_successfuly",$_POST['articleId']);
                      
                        break;
                    case "unPublish":
                        //发布
                        $this->unPublish($_POST['articleId']);
                        resultBackJson("200","unPublish_successfuly",$_POST['articleId']);
                     
                       break;
                    case "check":  
                        $this->check($_POST['articleId']);
                        resultBackJson("200","Check_successfuly",$_POST['articleId']);
                        break;
                    case "uncheck":  
                        $this->uncheck($_POST['articleId']);
                        resultBackJson("200","unCheck_successfuly",$_POST['articleId']);
                        break;
                    default:
                        resultBackJson("403","failed","");
                        break;
                    
                }
            }else{
                $account = Cookie::get("account");
                
                $db = Db::name("article_test");
                //此处需要分页处理但是现在测试阶段不用
                $article = $db->where("is_publish","=","0")->whereOr(["is_publish"=>3])->select();
                $db = Db::name(config('database_user'));
                $user = $db->where("account","=",$account)->select(); 
                
                $this->assign("user",$user[0]);
                $this->assign("account",$account);
                $this->assign("article",$article);
                return view('index/admin-article-check');
            }
        }
        else
        {
            header("location:/Errorpage");
        }
    }
    private function edit($id){

    }
    private function unPublish($id){
        $db = Db::name(config('database_article'));
        $db->where('id','=',$id)->update(['is_publish'=>2]);
    }
    private function delete($id){
        $db = Db::name(config('database_article'));
        $db->where('id','=',$id)->update(['is_publish'=>-2]);
    }
    private function submitCheck($id){
        $db = Db::name(config('database_article'));
        $db->where('id','=',$id)->update(['is_publish'=>0]);
    }
    private function publish($id){
        $db = Db::name(config('database_article'));
        $db->where('id','=',$id)->update(['is_publish'=>1]);
    }

    //管理员审核
    private function check($id){
        $db = Db::name(config('database_article'));
        $db->where('id','=',$id)->update(['is_publish'=>1]);
    }
    private function uncheck($id){
        $db = Db::name(config('database_article'));
        $db->where('id','=',$id)->update(['is_publish'=>3]);
    }
}