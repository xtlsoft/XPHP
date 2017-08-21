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
        
        public final function Json($json=null, $echo=1){
            
            if($json === null){
                $json = $this->Data;
            }
            
            $json = json_encode($json);
            
            if($echo) echo $json;
            return $json;
        }
        
        public final function Model($model, $args=array()){
            $e = 'return new \\Model\\';
            $e .= Route::$Application;
            $e .= '\\';
            $e .= $model;
            //$args = implode(", ", $args);
            $GLOBALS['_TMP_']['_XPHP_MODEL_CALL_TMP'] = $args;
            $str = "";
            foreach($args as $k=>$v){
                $str .= "\$GLOBALS['_TMP_']['_XPHP_MODEL_CALL_TMP'][$k]";
                if($k < (count($args)-1)){
                    $str .= ", ";
                }
            }
            $e .= '('.$str.');';
            
            return eval($e);
        }
        
    }