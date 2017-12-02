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

    use \X\Core;

    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    /**
     * Composer Vendor Directory
     */
    defined("COMPOSER_DIR") or define("COMPOSER_DIR", dirname(__DIR__) . '/vendor/');

    // Require the composer
    require_once COMPOSER_DIR . 'autoload.php';

    $configure = [
        "SysDir"  => SysDir,
        "Path"    => [
            "Route"       => "Var/Route/",
            "Application" => "App/",
            "Template"    => "Var/Template/",
        ], 
        "View"    => [
            "Start"    => "{{",
            "End"      => "}}",
            "Template" => "default"
        ],
        "Route"   => [
            "Base"     => ""
        ],
        "Version" => X,
        "Debug"   => true
    ];

    $App = new \X\Application($configure);

    $App->runScript("Register.php");

    $App->container->add('Request.Handler', '\X\Handler\Http');

    $App->runScript("Config.php");

    $App->init();

    $App->run();
