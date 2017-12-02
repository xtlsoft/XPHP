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

    class Request {

        protected $data;
        protected $data_obj;

        public function __construct($data = []){
            return $this->set($data);
        }

        public function set($data){
            $this->data = $data;
            $this->data_obj = json_decode(json_encode($this->data));
        }

        public function get(){
            return $this->data_obj;
        }

        public function getArray(){
            return $this->data;
        }

    }