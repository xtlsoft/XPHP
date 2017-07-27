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
        public static function Run($Plugin,$Controller,$Action,$var){
            $File = PluginDir.$Plugin."/Controller/".$Controller.".class.php";
            $namespace = "Controller\\$Plugin\\";
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
    }