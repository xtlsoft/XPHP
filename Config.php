<?php
    
    $GLOBALS['_C']['Template'] = "default"; //模板 Template
    $GLOBALS['_C']['Language'] = "zh_cn"; //语言 Language
    
    $GLOBALS['_C']['RouteBase'] = "/XPHP"; //index.php所在相对站点根目录路径
    $GLOBALS['_C']['Log'] = array( //日志文件名 Log Filename
            "INFO" => SysDir."Var/Log/info.log",
            // "WARNING" => SysDir.'Var/Log/warning.log',
            "ERROR" => SysDir.'Var/Log/error.log'
        );
    