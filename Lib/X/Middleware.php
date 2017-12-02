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

    class Middleware implements \X\Interfaces\Bootable, \X\Interfaces\NeedApplication, \X\Interfaces\Middleware {

        public function bootup(){
            $this->app->event->addListener('Core._.Middleware.Handle', [$this, 'handle']);
            $this->app->event->addListener('Core._.Middleware.Response', [$this, 'response']);
        }

        public function handle($event, \X\Request $request){
        
        }
        public function response($event, \X\Response $response){

        }

    }