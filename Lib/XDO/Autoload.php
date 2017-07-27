<?php
    
    namespace XDO;
    
    define("XData_Base_Path", dirname(__FILE__).'/');
    
    class Autoload{
        public static function load($name){
            $rplc = str_replace("\\","/",$name);
            $real = substr($rplc,4,strlen($rplc)-4);
            require_once(XData_Base_Path. $real .'.php');
        }
    }
    
    spl_autoload_register("XDO\\Autoload::load");