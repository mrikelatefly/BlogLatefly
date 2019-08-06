<?php
use think\Env;
return [
    'app_status'           =>Env::get('status','dev'),
    'atuo_bind_module'     =>true,
    'url_route_on'           => true,
    'url_route_must'         => false,
    // 视图输出字符串内容替换
    'view_replace_str'       => [
      '__CSS__'  => '/static/index/css',
      '__JS__'  => '/static/index/js',
      '__IMG__'  => '/static/index/images'
    ],
     // 视图输出字符串内容替换
     'database'               => [
        // 数据库类型
        'type'            => 'mysql',
        // 数据库连接DSN配置
        'dsn'             => '',
        // 服务器地址
        'hostname'        => '127.0.0.1',
        // 数据库名
        'database'        => 'blog',
        // 数据库用户名
        'username'        => 'root',
        // 数据库密码
        'password'        => 'latefly',
        // 数据库连接端口
        'hostport'        => '3306',
        // 数据库连接参数
        'params'          => [],
        // 数据库编码默认采用utf8
        'charset'         => 'utf8',
        // 数据库表前缀
        'prefix'          => 'blog_',
        // 数据库调试模式
        'debug'           => false,
        // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'deploy'          => 0,
        // 数据库读写是否分离 主从式有效
        'rw_separate'     => false,
        // 读写分离后 主服务器数量
        'master_num'      => 1,
        // 指定从服务器序号
        'slave_no'        => '',
        // 是否严格检查字段是否存在
        'fields_strict'   => true,
        // 数据集返回类型
        'resultset_type'  => 'array',
        
        // 自动写入时间戳字段
        'auto_timestamp'  => false,
        // 时间字段取出后的默认时间格式
        'datetime_format' => 'Y-m-d H:i:s',
        // 是否需要进行SQL性能分析
        'sql_explain'     => false,
    ],
    "upload_config" =>/* 前后端通信相关的配置,注释只允许使用多行方式 */
    [
        /* 上传图片配置项 */
        "imageActionName"=> "uploadimage", /* 执行上传图片的action名称 */
        "imageFieldName"=> "upfile", /* 提交的图片表单名称 */
        "imageMaxSize"=> 2048000, /* 上传大小限制，单位B */
        "imageAllowFiles"=> [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 上传图片格式显示 */
        "imageCompressEnable"=> true, /* 是否压缩图片,默认是true */
        "imageCompressBorder"=> 1600, /* 图片压缩最长边限制 */
        "imageInsertAlign"=> "none", /* 插入的图片浮动方式 */
        "imageUrlPrefix"=> "", /* 图片访问路径前缀 */
        "imagePathFormat"=> "/ueditor/php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                                    /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
                                    /* {rand=>6} 会替换成随机数,后面的数字是随机数的位数 */
                                    /* {time} 会替换成时间戳 */
                                    /* {yyyy} 会替换成四位年份 */
                                    /* {yy} 会替换成两位年份 */
                                    /* {mm} 会替换成两位月份 */
                                    /* {dd} 会替换成两位日期 */
                                    /* {hh} 会替换成两位小时 */
                                    /* {ii} 会替换成两位分钟 */
                                    /* {ss} 会替换成两位秒 */
                                    /* 非法字符 \ => * ? " < > | */
                                    /* 具请体看线上文档=> fex.baidu.com/ueditor/#use-format_upload_filename */
    
        /* 涂鸦图片上传配置项 */
        "scrawlActionName"=> "uploadscrawl", /* 执行上传涂鸦的action名称 */
        "scrawlFieldName"=> "upfile", /* 提交的图片表单名称 */
        "scrawlPathFormat"=> "/ueditor/php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "scrawlMaxSize"=> 2048000, /* 上传大小限制，单位B */
        "scrawlUrlPrefix"=> "", /* 图片访问路径前缀 */
        "scrawlInsertAlign"=> "none",
    
        /* 截图工具上传 */
        "snapscreenActionName"=> "uploadimage", /* 执行上传截图的action名称 */
        "snapscreenPathFormat"=> "/ueditor/php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "snapscreenUrlPrefix"=> "", /* 图片访问路径前缀 */
        "snapscreenInsertAlign"=> "none", /* 插入的图片浮动方式 */
    
        /* 抓取远程图片配置 */
        "catcherLocalDomain"=> ["127.0.0.1", "localhost", "img.baidu.com"],
        "catcherActionName"=> "catchimage", /* 执行抓取远程图片的action名称 */
        "catcherFieldName"=> "source", /* 提交的图片列表表单名称 */
        "catcherPathFormat"=> "/ueditor/php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "catcherUrlPrefix"=> "", /* 图片访问路径前缀 */
        "catcherMaxSize"=> 2048000, /* 上传大小限制，单位B */
        "catcherAllowFiles"=> [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 抓取图片格式显示 */
    
        /* 上传视频配置 */
        "videoActionName"=> "uploadvideo", /* 执行上传视频的action名称 */
        "videoFieldName"=> "upfile", /* 提交的视频表单名称 */
        "videoPathFormat"=> "/ueditor/php/upload/video/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "videoUrlPrefix"=> "", /* 视频访问路径前缀 */
        "videoMaxSize"=> 102400000, /* 上传大小限制，单位B，默认100MB */
        "videoAllowFiles"=> [
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"], /* 上传视频格式显示 */
    
        /* 上传文件配置 */
        "fileActionName"=> "uploadfile", /* controller里,执行上传视频的action名称 */
        "fileFieldName"=> "upfile", /* 提交的文件表单名称 */
        "filePathFormat"=> "/ueditor/php/upload/file/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "fileUrlPrefix"=> "", /* 文件访问路径前缀 */
        "fileMaxSize"=> 51200000, /* 上传大小限制，单位B，默认50MB */
        "fileAllowFiles"=> [
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
        ], /* 上传文件格式显示 */
    
        /* 列出指定目录下的图片 */
        "imageManagerActionName"=> "listimage", /* 执行图片管理的action名称 */
        "imageManagerListPath"=> "/ueditor/php/upload/image/", /* 指定要列出图片的目录 */
        "imageManagerListSize"=> 20, /* 每次列出文件数量 */
        "imageManagerUrlPrefix"=> "", /* 图片访问路径前缀 */
        "imageManagerInsertAlign"=> "none", /* 插入的图片浮动方式 */
        "imageManagerAllowFiles"=> [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 列出的文件类型 */
    
        /* 列出指定目录下的文件 */
        "fileManagerActionName"=> "listfile", /* 执行文件管理的action名称 */
        "fileManagerListPath"=> "/ueditor/php/upload/file/", /* 指定要列出文件的目录 */
        "fileManagerUrlPrefix"=> "", /* 文件访问路径前缀 */
        "fileManagerListSize"=> 20, /* 每次列出文件数量 */
        "fileManagerAllowFiles"=> [
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
        ] /* 列出的文件类型 */
    
    ]
  ];