<?php
namespace app\admin\controller;
use think\Request;
use think\Controller;
use think\Cookie;
use think\Session;
use think\Db;
class Category extends Controller{
    public function index()
    {
        if(isLogin())
        {

            if(isset($_POST["edit"]))
            {
                //这里没有进行检验
                $id=$_POST["id"];
                $type1=$_POST["type1"];
                $value1=$_POST["value1"];
                $type2=$_POST["type2"];
                $value2=$_POST["value2"];
                $label=[
                    "id"            =>$id,
                    "type1"         =>$type1,
                    "value1"        =>$value1,
                    "type2"         =>$type2,
                    "value2"        =>$value2
                ];
                //输出分类信息
                $db = Db::name(config('database_label'));
                $db->where('id','=',$id)->update($label);

                resultBackJson("200","edit_ok",$label);
            }
            else
            {
                //输出分类信息
                $db = Db::name(config('database_label'));
                $selectType=$db->where('type1','=',1)->select();
                $account = Cookie::get("account");
                $this->assign('account',$account);
                $this->assign('selectTypet',$selectType);
                return view('index/admin-category');
            }
            
        }
        else
        {
         Header ("Location:/Errorpage");
        }
    }
}
