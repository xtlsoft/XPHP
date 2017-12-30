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
    
    namespace X\View;
    
    class Basic extends \X\View{

        public $vars;

        public function __construct(){
            
            $view = $this;

            $this->addHelper('need', function ($name) use ($view){

                return $view->render($name, $view->vars);

            });

            $this->addHelper('shortcut', function ($name) use ($view){

                return eval($view->shortcut[$name]);

            });

        }

        public function getRender($template){

            return $this->process($template);

        }

        public function prepareRender($render){

            $view = $this;

            return function ($var) use ($render, $view) {

                $view->vars = $var;

                $pre = '
                foreach($view->vars as $k=>$v){
                    eval("\$".$k." = \$v;");
                }
                $var = $view->vars;
                ';

                @ob_start();

                eval($pre . $render);

                return ob_get_clean();

            };

        }
        
        protected function process($tpl){

            $rpl  = array($this->app->config['View']['Start']."#", $this->app->config['View']['Start'], $this->app->config['View']['End']);
            $torp = array("<?php",                             "<?=",                           "?>" );
            $render = str_replace($rpl,$torp,$tpl);
            $preEval = '$Base = $view->app->config["Route"]["Base"]."/";
$StaticDir = $Base . "Static/" . $view->app->config["View"]["Template"] . "/";
?>';
            return ($preEval . $render);
        }

        public function __call($name, $args){

            return call_user_func_array($this->helper[$name], $args);

        }
        
    }