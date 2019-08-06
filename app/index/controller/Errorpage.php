<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
class Errorpage extends Controller
{
    public function index(Request $request)
    {
       return view("index/errorpage");
      
    }
    
}
