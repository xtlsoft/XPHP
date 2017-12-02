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

    namespace X;

    class Core {

        public static $container;
        public static $event;
        public static $global;

        public static function init(){
            self::$container = new \League\Container\Container();
            self::$event = new \League\Event\Emitter();
        }

        public static function run(){

            //Error Controlling
            try{
                $core_error = self::get('Core.Error');
            }catch(\League\Container\Exception\NotFoundException $e){
                
            }
            if($core_error){
                $core_error->pushFormatter(self::get("Core.Error.Formatter"));
                $core_error->register();
            }

        }

    }

    Core::init();