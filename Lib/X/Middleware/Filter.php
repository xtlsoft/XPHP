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

    namespace X\Middleware;

    class Filter extends \X\Middleware {

        public function handle($event, \X\Request $request){

            $j = $request->getArray();
            
            $request->set($j);

        }

        public function response($event, \X\Response $response){

            $response->header([
                "x-xphp-version" => "xphp/" . X,
                "x-time"       => date('Y-m-d h:i:s')
            ]);

        }

    }