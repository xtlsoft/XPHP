<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace Controller\Home;
    
    use X\Controller;
    use X\Log;
    
    class IndexController extends Controller {
        public function index($req){
            
            $data = array(
                    "version" => X,
                    "welcome" => "欢迎"
                );
            
            //return $this->View("Home/index");
            
            $view = $this->app->container->get('Core.View');

            @\ob_start();
            //var_dump($this->Data, $req->get()->uri, $req->get()->data->get);
            echo $view->render("Home/index", $data);
            $d = \ob_get_clean();
            // echo $d;
            
            return (new \X\Response(200))->
                write($d);
            
        }
        
    }
    