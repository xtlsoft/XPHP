<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace Controller\Home;
    
    use X\Controller;
    use X\Log;
    
    class IndexController extends Controller{
        public function index($req){
            
            $this->Data = array(
                    "Version" => X
                );
            
            //return $this->View("Home/index");
            
            @\ob_start();
            var_dump($this->Data, $req->get()->uri, $req->get()->data->get);
            $d = \ob_get_clean();
            // echo $d;

            return (new \X\Response(200))->
                header(new \X\Header())->
                write($d);
            
        }
        
    }
    