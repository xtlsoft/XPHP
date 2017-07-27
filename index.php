<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    use X\Autoloader;
    use X\Error;
    use X\Route;
    use X\App;
    use XDO\Tool as XDOTool;
    use XDO\XDO;
    
    define("X",true);
    define("XPHP_VERSION","0.1.0-alpha");
    define("SysDir",dirname(__FILE__).'/');
    define("LibDir",SysDir.'Lib/');
    define("AppDir",SysDir.'App/');
    define("TemplateDir",SysDir.'Var/Template/');
    define("LangDir",SysDir.'Var/Lang/');
    define("DatDir",SysDir.'Var/Data/');
    define("RouteDir",SysDir.'Var/Route/');
    
    $GLOBALS['_C']['Template'] = "default";
    $GLOBALS['_C']['Language'] = "zh_cn";
    
    require(LibDir.'X/Autoloader.php');
    
    Autoloader::load("X\Error");
    
    @session_start();
    
    XDO::setDir(DatDir);
    
    foreach(XDOTool::listDir(RouteDir,0) as $v){
        Route::load(RouteDir. $v);
    }
    
    if(Route::$isLoad){
        App::Run(Route::$Application,Route::$Controller,Route::$Action,Route::$var);
    }else{
        Error::HTTP_E(404);
    }
    