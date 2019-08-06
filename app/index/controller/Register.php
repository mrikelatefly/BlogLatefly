<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
use think\Cookie;
use think\Db;

class Register extends Controller
{
    public function index(Request $request)
    {
        $this->assign('account','');
        $operate=isset($_POST["type"])?$_POST["type"]:"";
        if( $operate=='register')
        {
            
            $varify=isset($_POST["varify"])?$_POST["varify"]:"";
            $vcode=Cookie::get("vcode");
            $varify=md5($varify);
            if($vcode==$varify)
            {
                // $email = $account;
                // $title="恭喜,您已经成功注册了账号！";
                // $randpass = rand(100000,999999);
                // $content="亲爱的".$email."用户您成功开通账户,感谢您的注册测试，我们将继续改进。您的注册验证码是：".$randpass;
                // sendEmail("286348794@qq.com","ptaxdvymuwmbbhbh","南下.牧风",$email,$title,$content);
                $account = isset($_POST["account"])?$_POST["account"]:"";
                $password = isset($_POST["password"])?$_POST["password"]:"";
                $confirm = isset($_POST["confirm"])?$_POST["confirm"]:"";
                $nick_name=isset($_POST["nick_name"])?$_POST["nick_name"]:"";
                $md5password=isset($_POST["md5password"])?$_POST["md5password"]:"";
                //$date = date("Y-m-d h:i");
                $user=[
                    'account'      =>$account,
                    'password'     =>$md5password,
                    'nick_name'    =>$nick_name,
                    'email'        =>'user@qq.com',
                    'authority'     =>2,
                    'account_state' =>1, 
                ];
                $db = Db::name(config('database_user'));
                if($this->insertAccoount($user,$db))
                {
                    resultBackJson("200","registe_sucss",$user);
                }
                else{
                    resultBackJson("401","user exist or other error!",$user);
                }
                
                
            }
            else{
                resultBackJson("201","registe_faild",$vcode.'  '.$varify);
            }
        }
        else
        {
            return view('login/register');
        }
    }
    private function userExisted($account,$db)
    {  
        $exist = false;
        $res =  $db->where("account","=",$account)->page(1,1)->select();
        if(!empty($res)){
            $exist = true;
        }
        return $exist;
    }
    private function insertAccoount($user,$db)
    {  
        $exist = false;
        //判断输入用户
        if(!$this->userExisted($user['account'],$db))
        {
            $db->insert($user);//执行并返回id
            $exist = true;//返回插入成功
        }
        return $exist;
    }
    public function checkImg(){
        /**
         * 字母+数字的验证码生成
         */
        // 开启session
        //session_start();
        //1.创建黑色画布
        $image = imagecreatetruecolor(100, 30);
        
        //2.为画布定义(背景)颜色
        $bgcolor = imagecolorallocate($image, 255, 255, 255);
        
        //3.填充颜色
        imagefill($image, 0, 0, $bgcolor);
        
        // 4.设置验证码内容
        
        //4.1 定义验证码的内容
        $content = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        
        //4.1 创建一个变量存储产生的验证码数据，便于用户提交核对
        $captcha = "";
        for ($i = 0; $i < 4; $i++) {
            // 字体大小
            $fontsize = 20;
            // 字体颜色
            $fontcolor = imagecolorallocate($image, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
            // 设置字体内容
            $fontcontent = substr($content, mt_rand(0, strlen($content)), 1);
            $captcha .= $fontcontent;
            // 显示的坐标
            $x = ($i * 100 / 4) + mt_rand(5, 10);
            $y = mt_rand(5, 10);
            // 填充内容到画布中
            imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
        }
        //$_SESSION["captcha"] = $captcha;md5($captcha[0].$captcha[1].$captcha[2].$captcha[3])
        Cookie::set("vcode",md5($captcha));
        //4.3 设置背景干扰元素
        for ($$i = 0; $i < 200; $i++) {
            $pointcolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
            imagesetpixel($image, mt_rand(1, 99), mt_rand(1, 29), $pointcolor);
        }
        
        //4.4 设置干扰线
        for ($i = 0; $i < 3; $i++) {
            $linecolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
            imageline($image, mt_rand(1, 99), mt_rand(1, 29), mt_rand(1, 99), mt_rand(1, 29), $linecolor);
        }
        ob_clean();
        //5.向浏览器输出图片头信息
        header('content-type:image/png');
        
        //6.输出图片到浏览器
        imagepng($image);
        
        //7.销毁图片
        imagedestroy($image);
    }
}