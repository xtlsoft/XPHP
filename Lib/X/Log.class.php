<?php
    /**
     * This file is a part of XPHP.
     * 
     * You may read the LICENSE file to
     * know what you can do.
     * 
     * @package XPHP
     * @author xtl<xtl@xtlsoft.top>
     * @license MIT
     * 
     */
    
    namespace X;
    
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    
    class Log{
        
        public static $info;
        // public static $warning;
        public static $error;
        
        public static function init(){
            
            $log = $GLOBALS['_C']['Log'];
            
            self::$info = new Logger('XPHP');
            self::$info->pushHandler(new StreamHandler($log['INFO'], Logger::INFO));
            
            // self::$warning = new Logger('XPHP');
            // self::$warning->pushHandler(new StreamHandler($log['WARNING'], Logger::WARNING));
            
            self::$error = new Logger('XPHP');
            self::$error->pushHandler(new StreamHandler($log['ERROR'], Logger::ERROR));
            
        }
        
        public static function info($info){
            self::$info->addInfo($info);
        }
        
        // public static function warning($w){
        //     self::$warning->addWarning($w);
        // }
        
        public static function error($e){
            self::$error->addError($e);
        }
        
    }
    
    \X\Log::init();
    
    \X\Log::info("REQUEST ".$_SERVER['REQUEST_URI']." AT ".$_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT']." REMOTE ".$_SERVER['REMOTE_ADDR'].':'.$_SERVER['REMOTE_PORT']);