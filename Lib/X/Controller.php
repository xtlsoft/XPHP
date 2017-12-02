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

    class Controller {

        protected $data;

        public static function asCallback($name){

            return function(\X\Request $req) use ($name){
                $name = explode(":", $name);
                $cls = $name[0]; $method = $name[1];
                $cls = explode(".", $cls);
                $app = $cls[0]; $con = $cls[1];

                $class = "\\Controller\\" . $app . "\\" . $con;
                $file = $app . "/Controller/" . $con . ".class.php";
                
                @include(Core::$global['ApplicationDir'] . $file);

                $obj = eval("return new $class();");

                return call_user_func([$obj, $method], $req);
            };

        }

    }