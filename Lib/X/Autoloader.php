<?php
    /**
     * XPHP Project
     * 
     * Author: xtl(xtl@xtlsoft.top)
     * 
     */
    
    namespace X;
    
    use X\Error;
    
    class Autoloader{
        public static function load($name){
            $name = str_replace("\\","/",$name);
            $exp = explode("/",$name);
            switch($exp[0]){
                case 'Model':
                    if(count($exp==3)){
                        return self::SafeRequire(AppDir.$exp[1].'/Model/'.$exp[2].'.class.php');
                    }else{
                        return self::SafeRequire(AppDir.$exp[1].'/Model/'.$exp[2].'/'.$exp[3].'.class.php');
                    }
                case 'Controller':
                    if(count($exp==3)){
                        return self::SafeRequire(AppDir.$exp[1].'/Controller/'.$exp[2].'.class.php');
                    }else{
                        return self::SafeRequire(AppDir.$exp[1].'/Controller/'.$exp[2].'/'.$exp[3].'.class.php');
                    }
                default:
                    $result = self::SafeRequire(LibDir.$name.".class.php");
                    if($result == "Fail" && self::SafeRequire(LibDir.$name.".php") == "Fail"){
                        
                        if(self::SafeRequire(LibDir.$exp[0].'/Autoload.php') == "Fail"){
                            self::SafeRequire(LibDir.$exp[0].'/Autoloader.php');
                        }
                    }else{
                        return $result;
                    }
            }
        }
        public static function SafeRequire($File){
            if(file_exists($File)){
                return require_once($File);
            }else{
                return "Fail";
            }
        }
    }
    
    spl_autoload_register('\X\Autoloader::load');