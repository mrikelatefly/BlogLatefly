<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
use think\Db;
use think\Cookie;
use Uploader;
class Tools extends Controller
{
    //http://localhost/Info/index/id/80.html
    private $CONFIG;
    public function index()
    {
        //return $_POST;
        $type=isset($_POST["type"])?$_POST["type"]:"";
        $article_id=isset($_POST["article_id"])?$_POST["article_id"]:"";
        $keyboard=isset($_POST["keyboard"])?$_POST["keyboard"]:"";
        if($article_id!=''&&$type!='')
        {
            $db=Db::name(config('database_article'));
            $article = $db->where('id','=',$article_id)->select()[0];

            switch($type)
            {
                case 'uhate': 
                    $uhate=$article['uhate']+1;
                    $db->where('id','=',$article_id)->update(['uhate'=> $uhate]);
                    break;
                case 'ulove':
                    $ulove=$article['ulove']+1;
                    $db->where('id','=',$article_id)->update(['ulove'=> $ulove]);
                    break;
                default:resultBackJson("500","pasererror",$_POST);die();
            }
        }
        else if($keyboard!='')
        {
            resultBackJson("200","I am here",$keyboard);die();
        }
        resultBackJson("200","I am here",$type.' '.$article_id);
        
    }
    public function uploadimg()
    {
        $account = Cookie::get("account");

        $file = $this->request->file('file');
        if(!empty($file)){

            //创建文件夹
            $date = date("Y-m-d h:i");
            $dir="user/". $account."/article/".explode(" ",$date)[0];
            $dir = iconv("UTF-8", "GBK", $dir);
            if (!file_exists($dir)){
                 mkdir ($dir,0777,true);
                 //echo '创建文件夹成功';
            } 
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>10485760,'ext'=>'jpg,png,gif'])->rule('uniqid')->move($dir);
            $error = $file->getError();
            //验证文件后缀后大小
             if(!empty($error)){
                dump($error);exit;
             }
            if($info){
                    // 成功上传后 获取上传信息
                    // 输出 jpg
                    $info->getExtension();
                    // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                    $info->getSaveName();
                    // 输出 42a79759f284b767dfcb2a0197904287.jpg
                    $photo = $dir.'/'.$info->getFilename();

                }else{
                    // 上传失败获取错误信息
                     $file->getError();
                }
            }else{
                    $photo = '';
            }
        if($photo !== ''){
            return ['code'=>1,'msg'=>'成功','photo'=>$photo];
        }else{
            return ['code'=>404,'msg'=>'失败'];
        }
    }
    private function fileSave($direct='',$data='',$name='')
    {
        $dir = iconv("UTF-8", "GBK", $direct);
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
            //echo '创建文件夹成功';
        } else {
            //echo '需创建的文件夹已经存在';
        }
        $myfile = fopen($direct.'/'.$name.'.jpg', "w") or die("Unable to open file!");
        fwrite($myfile,$data);
        fclose($myfile);
    }
}
