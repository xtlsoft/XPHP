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
    
    class Response {
        
        /**
         * Status code
         * 
         * @var $status
         * 
         */
        public $status = 200;
        
        /**
         * Headers
         * 
         * @var $header
         * 
         */
        public $header = [];
        
        /**
         * Content
         * 
         * @var $content
         * 
         */
        public $content = "";
        
        /**
         * Constructor
         * 
         * @param int statusCode
         * 
         * @return void
         * 
         */
        public function __construct($code=200){
            
            $this->status = $code;
            
        }
        
        /**
         * Set Header
         * 
         * @param \Rqo\Http\Header The Header Object.
         * 
         * @return self   
         * 
         */
        public function header(\X\Header $header){
            
            $this->header = $header->dump();
            
            return $this;
            
        }
        
        /**
         * Write Result to Buffer
         * 
         * @param string The Data
         * 
         * @return self   
         * 
         */
        public function write($data){
            
            $this->content .= $data;
            
            return $this;
            
        }
        
        /**
         * Dump the data
         * 
         * @return self   
         * 
         */
        public function dump(){
            
            return $this;
            
        }
        
    }