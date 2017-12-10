<?php
    /**
     * XPHP - PHP Framework
     * 
     * This project is licensed
     * under MIT. Please use it
     * under the license and law.
     * 
     * @category Framework
     * @package  XPHP
     * @author   Tianle Xu <xtl@xtlsoft.top>
     * @license  MIT
     * @link     https://github.com/xtlsoft/XPHP
     * 
     */
    
    namespace X\Temp\Instance;

    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    /**
     * Composer Vendor Directory
     */
    defined("COMPOSER_DIR") or define("COMPOSER_DIR", __DIR__ . '/vendor/');

    // Require the composer
    require_once COMPOSER_DIR . 'autoload.php';

    $configure = [
        "SysDir"  => SysDir,
        "Path"    => [
            "Route"       => "Var/Route/",
            "Application" => "App/",
            "Template"    => "Var/Template/",
            "Cache"       => "Var/Cache/"
        ], 
        "View"    => [
            "Start"    => "{{",
            "End"      => "}}",
            "ExtName"  => ".tpl",
            "Template" => "default",
            "Cache"    => false
        ],
        "Database"=> [
            'connection_string' => 'mysql:host=localhost;dbname=xphp;charset=utf8', //DSN
            'driver_options'    => array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'), //PDO Option
            'username'          => 'root', //用户名 username
            'password'          => '', //密码 password
            'logging'           => true, //开启Query日志 Enable Query Log
            'caching'           => true, //开启缓存 Enalble Cache
            'caching_auto_clear'=> true //自动清理缓存 Auto Clear Cache
        ],
        "Route"   => [
            "Base"     => ""
        ],
        "Version" => X,
        "Debug"   => true
    ];

    $App = new \X\Application($configure);

    $App->runScript("Register.php");

    $App->container->add('Request.Handler', '\X\Handler\CommandLine');

    $App->runScript("Config.php");
    
    $App->container->add('Core.Error.Handler', '\Whoops\Handler\PlainTextHandler');

    $App->init();

    $App->run();
