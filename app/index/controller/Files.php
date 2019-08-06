<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
use think\Cookie;
use think\Db;
class Files extends Controller
{
    public function index(Request $request)
    {
        // $list=scandir('./');
        // dump($list);
       $account='';
       $lists=scandir('./share');
       if(isLogin()){//登录用户信息
            $account = Cookie::get("account");
        

            
            return view("index/files",[
                "account"  => $account,
                "lists"    =>$lists  
                ]);
        }
        else
        {
            return view("index/files",[
                "account"  => '',
                "lists"    =>$lists  
                ]);
        }
    }
}


//     public function carrier()
//     {
//         $db1 = Db::name("article");
//         $db2 = Db::name("article_test");
//         $article =  $db1->select();
//         foreach($article as $v){
//             $count = $db2->insert([
//                 'title'    => $v['title'],
//                 'summary'  => $v['summary'],
//                 'from_user' => $v['fromuser'],
//                 'type'     => $v['type'],
//                 'release_time'  => $v['daytime'],
//                 'authority'=> $v['authority'],
//                 'views'    => $v['views'],
//                 'is_publish'  => $v['isok'],
//                 'img_url'   => $v['img'],
//                 'ulove'    => $v['ulove'],
//                 'uhate'    => 0
//             ]);
//             echo "<br/>".$count;
//          }
//     }
//     public function carriercontent()
//     {
//         $db1 = Db::name("article");
//         $article =  $db1->select();
//         $i=61;
//         foreach($article as $v){
//             $content=$v['content'];
//             $this->savearticle("user/".$v['fromuser']."/article/".explode(" ",$v['daytime'])[0],$content,$i);
//             $i+=1;
//             echo "<br/>".$i;
//          }
//     }

//     private function savearticle($direct='',$arts='',$title='')
//     {
//         $dir = iconv("UTF-8", "GBK", $direct);
//         if (!file_exists($dir)){
//             mkdir ($dir,0777,true);
//             echo '创建文件夹成功';
//         } else {
//             echo '需创建的文件夹已经存在';
//         }
//         $myfile = fopen($direct.'/'.$title.'.html', "w") or die("Unable to open file!");
//         fwrite($myfile,$arts);
//         fclose($myfile);
//     }
    
// }
