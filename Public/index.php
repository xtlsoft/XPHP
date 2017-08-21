<?php
    /**
     * This file is a part of XPHP.
     * 
     * You may read the LICENSE file to
     * know what you can do.
     * 
     * @pacakge XPHP
     * @author xtl<xtl@xtlsoft.top>
     * @license MIT
     * 
     */
    
    use X\Autoloader;
    use X\Error;
    use X\Route;
    use X\App;
    use X\Log;
    use XDO\Tool as XDOTool;
    use XDO\XDO;
    
    /*********************************/ //@@@@@@@@@@@@@@@@@@
    /*--- Define Path And Version ---*/
    ##################################
    define("X",true); //Make sure you are in XPHP
    define("XPHP_VERSION","0.3.1-stable"); //XPHP Version
    define("SysDir",dirname(__DIR__).'/'); //XPHP Base Directory
    define("LibDir",SysDir.'Lib/'); //XPHP Embedded Library Directory
    define("AppDir",SysDir.'App/'); //XPHP Application Directory
    define("TemplateDir",SysDir.'Var/Template/'); //XPHP Template Directory
    define("LangDir",SysDir.'Var/Lang/'); //XPHP Language Directory
    define("DatDir",SysDir.'Var/Data/'); //XDO Data Directory
    define("RouteDir",SysDir.'Var/Route/'); //XPHP Route Directory
    define("ComposerDir",SysDir.'vendor/'); //Composer Vendor Directory
    ##################################
          /* --- Define End --- */
    /*********************************/ //@@@@@@@@@@@@@@@@@@
    
    //Require the BASE Config file
    require(SysDir. 'Config.php');
    
    //Require XPHP Embedded Library Autoloader
    require_once(LibDir.'X/Autoloader.php');
    
    //Require Composer Autoloader
    require_once(ComposerDir.'autoload.php');
    
    //Load Logger
    Autoloader::load("X\\Log");
    
    //Load Error Proccesser
    Autoloader::load("X\\Error");
    
    //Init the session (Actions with session could do in Config.php)
    @session_start();
    
    //Do Prepare Functions
    App::Prepare();
    
    //Set XDO Dir
    XDO::setDir(DatDir);
    
    //List the routes
    foreach(XDOTool::listDir(RouteDir,0) as $v){
        //Load the Route
        Route::load(RouteDir. $v);
    }
    
    //Run Application
    if(Route::$isLoad){
        App::Run(Route::$Application,Route::$Controller,Route::$Action,Route::$var);
    }else{
        Error::HTTP_E(404);
    }
    
      ###############################################
     /*--------Stop-Reading-Start-Writing!---------*/
    ################################################