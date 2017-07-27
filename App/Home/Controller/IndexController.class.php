<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace Controller\Home;
    
    use X\Controller;
    
    class IndexController extends Controller{
        public function index(){
            
            $this->Data = array(
                    "Version" => XPHP_VERSION
                );
            
            return $this->View("Home/index");
            
        }
        
        public function Wow($var){
            
            echo $var['hi'];
            
        }
        
    }