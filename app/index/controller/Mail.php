<?php
namespace app\index\controller;
use think\Controller;
use phpMailer\PHPMailer;
use phpMailer\Exception;
use think\Db;
class Mail extends Controller
{
    public function index()
    {
        $email="";
        $account="";
        $password="";
        $imgpass="";
        $date = date("Y-m-d:h:i");//&&isset($_GET["imgpass"])
        if(isset($_GET["email"])&&isset($_GET["password"])){
            $email=$_GET["email"];
            $account=md5($email.rand(0,999));
            $password=md5($_GET["password"]);
           
            $title="恭喜,您已经成功注册了账号！";
            $content="亲爱的".$email."用户您成功开通账户,感谢您的注册测试，我们将继续改进。";
            $this->sendEmail("2433026700@qq.com","nirgiwvbydurdigg","latefly",$email,$title,$content);
            //echo $email."<br/>";
            //echo substr($email,0,strlen($email)-2);//om 负数从结尾开始取
        }
        //  */
        /*try{
            $db = Db::name("user"); 
            $exist = (int) Db::query("select *from get_user where email='". $email."'"); 
           if($exist){
             //如果存在此用户
            echo  " 用户已存在";
           }else{
             //如果用户不存在
            //插入
             $count = $db->insert([
                'account'        =>  $account,
                'password'       =>  $password,
                'email'          =>  $email,
                'regist_date'    =>  $date
             ]);
             //写入cookie session 或者token
             //返回主页
             $title="恭喜,您已经成功注册了账号！";
             $content="亲爱的".$email."用户您成功开通账户,感谢您的注册测试，我们将继续改进。";
             $this->sendEmail("286348794@qq.com","ptaxdvymuwmbbhbh","南下.牧风",$email,$title,$content);
             $this->redirect(config("localhost").'/Index'); 
           }
           
         
        }catch(Exception $e){
           backPage("添加文章失败","500",config("localhost")."/admin.php/Add");
        }*/
       
    }
    public function sendEmail($from,$code,$nickName,$toUser,$title,$content,$attachment=""){
        // 实例化PHPMailer核心类
        $mail = new PHPMailer();
        // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        //$mail->SMTPDebug = 1;
        // 使用smtp鉴权方式发送邮件
        $mail->isSMTP();
        // smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;
        // 链接qq域名邮箱的服务器地址
        $mail->Host = 'smtp.qq.com';
        // 设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';
        // 设置ssl连接smtp服务器的远程服务器端口号
        $mail->Port = 465;
        // 设置发送的邮件的编码
        $mail->CharSet = 'UTF-8';
        // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = $nickName;
        // smtp登录的账号 QQ邮箱即可
        $mail->Username = $from;
        // smtp登录的密码 使用生成的授权码
        $mail->Password = $code;
        // 设置发件人邮箱地址 同登录账号
        $mail->From = $from;
        // 邮件正文是否为html编码 注意此处是一个方法
        $mail->isHTML(true);
        // 设置收件人邮箱地址
        $mail->addAddress($toUser);
        // 添加多个收件人 则多次调用方法即可
        //$mail->addAddress('1931946508@qq.com');
        // 添加该邮件的主题
        $mail->Subject = $title;
        // 添加邮件正文
        $mail->Body = $content;
        // 为该邮件添加附件
        if($attachment!=""){
        $mail->addAttachment($attachment);
        }
        // 发送邮件 返回状态
        $status = $mail->send();
       // echo $status;
    }

}
