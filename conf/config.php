<?php
use think\Env;
return [
    'app_status'           =>Env::get('status','dev'),
    'atuo_bind_module'     =>true,
    'url_route_on'           => true,
    'url_route_must'         => false,
     //主机地址配置
     'localhost'             =>'http://localhost',

     // 视图输出字符串内容替换
     'view_replace_str'       => [
         '__CSS__'  => '/static/index/css',
         '__JS__'  => '/static/index/js',
         '__IMG__'  => '/static/index/images'
     ],
     
    'database_article'     =>'article_test',
    'database_user'        =>'user',
     'database_label'      =>'label',

    'localhost'             =>"http://localhost",
    
     'show_error_msg'         => true,
        //应用调试模式
      'app_debug'              => true,
    //应用Trace
    // 'app_trace'              => true,
];

