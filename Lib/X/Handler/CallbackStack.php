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

    namespace X\Handler;

    trait CallbackStack {

        protected $responseCallbacks = [];

        public function addResponseCallback(Callable $callback){

            $this->responseCallbacks[] = $callback;

        }

        protected function handleResponseCallback(\X\Response $resp){

            foreach ($this->responseCallbacks as $v){
                $v($resp);
            }

            return $resp;

        }

    }