<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace X;
    
    use X\Glob;
    use X\Error;
    use X\View;
    
    class Controller{
        public $Data = array();
        
        public final function View($viewName){
            $tpl = new View($viewName);
            $tpl->bindVars($this->Data);
            $tpl->show();
            return $tpl;
        }
    }