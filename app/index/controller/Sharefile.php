<?php
namespace app\index\controller;
use think\Controller;
use think\Cookie;
class Sharefile extends Controller
{
   private $files = array();
   public function index(){
        $isLogin = isLogin();
        $account = "";
        if($isLogin){//登录用户信息
            $account = Cookie::get("account");
            $this->assign('account',$account);
            $dir = "user".DIRECTORY_SEPARATOR.$account ;
            if(isset($_GET["dir"])){
                if($_GET["dir"]=="/"||$_GET["dir"]=="\\"){
                    $dir = "user".DIRECTORY_SEPARATOR.$account;
                }else{
                    $dir= "user".DIRECTORY_SEPARATOR.$account.$_GET["dir"];
                }
               
                //$dir = "user".DIRECTORY_SEPARATOR."geticsen";
                $this->ListDictionary($dir,false);
                resultBackJson(200,"List_sucss",$this->files);
            }else{
                return view("index/fileserver");
            }
        }
        else{
            echo "403 error";
        }
        
       

   }
   private function ListDictionary($dir,$all=false){
       
         $dirArr = scandir($dir);
         foreach($dirArr as $v){
                if($v!="." && $v!=".."){
                   
                    $dirname = $dir.DIRECTORY_SEPARATOR.$v;  //子文件夹的目录地址 
                    $this->files[$v] =  [];
                    //文件路径
                    $this->files[$v]['url'] =  $dirname;
                    //文件名字
                    $this->files[$v]['name'] =  $v;
                    //是否是文件夹
                    if(is_dir($dirname)){
                        $this->files[$v]['type'] =  "dir";
                        $this->files[$v]['isDir'] = true;
                       
                        if($all){
                            $this->ListDictionary($dirname,$all);
                        }
                        
                    }else{
                        $this->files[$v]['isDir'] = false;
                        //获取文件详细类型
                        switch(pathinfo($v)["extension"]){
                            case "html":
                                $this->files[$v]['type'] =  "htm";
                                break;
                            default: $this->files[$v]['type'] =  "file";
                        }
                        
                        
                    }
                }
         }
        
    }

}
