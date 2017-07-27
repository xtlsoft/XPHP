<?php
    
    namespace XDO;
    
    use XDO\Database;
    use XDO\Tool;
    use XDO\XDOError;
    
    if(!defined("XData_Base_Path")) define("XData_Base_Path",dirname(__FILE__).'/');
    
    class XDO{
        public static $DataDir = "";
        public static $Cache = true;
        public static $Models;
        public static function setDir($DataDir){
            self::$DataDir = $DataDir;
        }
        public static function Database($ModelName){
            if(!self::$DataDir){
                self::$DataDir = XData_Base_Path. 'Data/';
            }
            if(!in_array($ModelName,self::getModels())){
                throw new XDOError("MODEL_NOT_FOUND",0001);
                return;
            }
            return new Database($ModelName);
        }
        public static function getModels(){
            if(!self::$Models){
                self::$Models = Tool::getJson("Models");
            }
            return self::$Models;
        }
        
        public static function createModel($ModelName){
            $Models = self::getModels();
            if(in_array($ModelName,$Models)){
                return false;
            }
            
            mkdir(self::$DataDir."Cache/".$ModelName);
            mkdir(self::$DataDir."Database/".$ModelName);
            mkdir(self::$DataDir."Upload/".$ModelName);
            
            $Models[] = $ModelName;
            return Tool::putJson("Models",$Models);
        }
        
        public static function removeModel($ModelName){
            Tool::delDir("Cache/".$ModelName);
            Tool::delDir("Database/".$ModelName);
            Tool::delDir("Upload/".$ModelName);
            
            $Models = self::getModels();
            
            if(array_search($ModelName,$Models)) unset($Models[array_search($ModelName,$Models)]);
            
            return Tool::putJson("Models",$Models);
        }
    }