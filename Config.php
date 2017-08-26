<?php
    
    $GLOBALS['_C']['Template'] = "default"; //模板 Template
    $GLOBALS['_C']['Language'] = "zh_cn"; //语言 Language
    
    $GLOBALS['_C']['RouteBase'] = "/XPHP"; //index.php所在相对站点根目录路径
    $GLOBALS['_C']['Log'] = array( //日志文件名 Log Filename
            "INFO" => SysDir."Var/Log/info.log",
            // "WARNING" => SysDir.'Var/Log/warning.log',
            "ERROR" => SysDir.'Var/Log/error.log'
        );
    
    $GLOBALS['_C']['View']['Start'] = "{{";
    $GLOBALS['_C']['View']['End'] = "}}";
    
    $GLOBALS['_C']['enableORM'] = true; //开启ORMDB
    //-----------------ORMDB MySQL Example-----------------
    $GLOBALS['_C']['ORMDB'] = array( //ORM数据库配置 ORMDB Configure
            'connection_string' => 'mysql:host=localhost;dbname=xphp;charset=utf8', //DSN
            'driver_options'    => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'), //PDO Option
            'username'          => 'root', //用户名 username
            'password'          => '', //密码 password
            'logging'           => true, //开启Query日志 Enable Query Log
            'caching'           => true, //开启缓存 Enable Cache
            'caching_auto_clear'=> true //自动清理缓存 Auto Clear Cache
        );
    //-----------------ORMDB SQLite Example-----------------
    // $GLOBALS['_C']['ORMDB'] = array( //ORM数据库配置 ORMDB Configure
    //         'connection_string' => 'sqlite:'.DatDir.'xphp.db', //DSN
    //         'logging'           => true //开启Query日志 Enable Query Log
    //         'caching'           => true, //开启缓存 Enalble Cache
    //         'caching_auto_clear'=> true //自动清理缓存 Auto Clear Cache
    //     );
