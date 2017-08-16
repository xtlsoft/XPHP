<?php
    /**
     * XPHP Project
     * 
     * Author: xtl(xtl@xtlsoft.top)
     * 
     */
    
    namespace X;
    
    use X\Error;
    use X\Autoloader;
    use X\Route;
    
    class App{
        public static function Run($Application,$Controller,$Action,$var){
            $File = AppDir.$Application."/Controller/".$Controller.".class.php";
            $namespace = "Controller\\$Application\\";
            include($File);
            if(!class_exists($namespace.$Controller)){
                Error::HTTP_E(404);
                return;
            }
            eval('$Controller = new '.$namespace.$Controller.'($var);');
            if(method_exists($Controller,$Action)){
                $Controller->$Action($var);
            }else{
                Error::HTTP_E(404);
            }
        }
        public static function Prepare(){
            
            global $_C;
            if(substr($_C['RouteBase'],(strlen($_C['RouteBase'])-1), 1) == "/"){
                $_C['RouteBase'] = substr($_C['RouteBase'], 0, (strlen($_C['RouteBase'])-1));
            }
            
        }
    }