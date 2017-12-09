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
            
            $view = $this->app->container->get('Core.View');
            
            // return $this->view("Home/Index", $data);

            return $this->json($data, "success", 1);
            
        }
        
    }
    