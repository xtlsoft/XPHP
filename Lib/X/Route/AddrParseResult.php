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
    
    namespace X\Route;
    
    class AddrParseResult {
        
        /**
         * Keys
         * 
         * @var $keys
         * 
         */
        public $keys;
        
        /**
         * Regex
         * 
         * @var $preg;
         * 
         */
        public $preg;
        
        /**
         * Assign Result.
         * 
         * @param array The result.
         * 
         * @return self
         * 
         */
        public function assign($arr){
            
            $this->keys = $arr['keys'];
            $this->preg = $arr['preg'];
            
            return $this;
            
        }
        
    }