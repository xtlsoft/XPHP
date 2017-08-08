<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace X;
    
    use X\Error;
    use XDO\XDO;
    
    abstract class Model{
        
        public $XDODB = false;
        
        public function XDODB($db){
            if($this->XDODB === false) $this->XDODB = XDO::Database($db);
            return $this->XDODB;
        }
        
    }