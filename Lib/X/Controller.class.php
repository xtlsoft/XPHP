<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace X;
    
    use X\Error;
    use X\View;
    use X\Route;
    
    abstract class Controller{
        public $Data = array();
        
        public final function View($viewName){
            $tpl = new View($viewName);
            $tpl->bindVars($this->Data);
            $tpl->show();
            return $tpl;
        }
        
        public final function Json($echo=1){
            $json = json_encode($this->Data);
            if($echo) echo $json;
            return $json;
        }
        
        public final function Model($model, $args=array()){
            $e = 'return new \\Model\\';
            $e .= Route::$Application;
            $e .= '\\';
            $e .= $model;
            $args = implode(", ", $args);
            $e .= '('.$args.');';
            return eval($e);
        }
        
    }