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

    namespace X;

    class Application {

        public $handler;
        public $container;
        public $event;
        public $config;
        public $route;
        public $request;

        public function __construct($config){

            $this->container = new \League\Container\Container;
            $this->container->delegate(
                new \League\Container\ReflectionContainer
            );            
            $this->container->inflector('X\Interfaces\NeedApplication')->setProperty("app", $this);
            $this->container->inflector('X\Interfaces\Bootable')->invokeMethod('bootup', []);
            // $this->container->inflector('X\Interfaces\Middleware')->invokeMethod('register', []);
            $this->event = new \League\Event\Emitter;

            $this->config = $config;

        }

        public function init(){

            $this->route = $this->container->get('Core.Route');

            if($this->container->has('Core.Error')){
                $this->container->get('Core.Error');
            }

            $this->handler = $this->container->get('Request.Handler');

            $this->request = $this->handler->getRequest();

        }

        public function run(){
            $this->event->emit('Core._.Middleware.Handle', $this->request);
            $app = $this;
            $this->handler->addResponseCallback(function($resp) use ($app){
                $app->event->emit('Core._.Middleware.Response', $resp);
            });

            $rslt = $this->runRoute();
            $arr = $this->request->getArray();
            $arr['data']['route'] = $rslt['vars'];
            $this->request->set($arr);
            $response = $rslt['callback']($this->request);

            $this->handler->response($response);

        }

        public function runScript($fileName){

            $script = @include($this->config['SysDir'] . $fileName);
            return $script($this);

        }

        public function addBatch($arr){

            foreach($arr as $v){
                $this->container->add($v[0], $v[1]);
            }

        }

        public function shareBatch($arr){

            foreach($arr as $v){
                $this->container->share($v[0], $v[1]);
            }

        }

        public function get($name){

            return $this->container->get($name);

        }


        public function boot($name){

            if(!$this->container->has($name))
                $this->container->add($name);
            return $this->container->get($name);

        }

        public function controllerAsCallback($name){
            $instance = $this;
            return function(\X\Request $req) use ($name, $instance){
                $name = explode(":", $name);
                $cls = $name[0]; $method = $name[1];
                $cls = explode(".", $cls);
                $app = $cls[0]; $con = $cls[1];

                $class = "\\Controller\\" . $app . "\\" . $con;
                $file = $app . "/Controller/" . $con . ".class.php";
                
                include($this->config['SysDir'] . $this->config['Path']['Application'] . $file);

                $obj = $instance->boot($class);

                return call_user_func([$obj, $method], $req);
            };
        }

        protected function runRoute(){

            $req = $this->request;

            $method = $req->get()->method;

            $routeDir = $this->config['SysDir'] . $this->config['Path']['Route'];
            
            $rslt = $this->route->handle($method, $req->get()->uri);
            if($rslt !== 404){
                return $rslt;
            }

            foreach(glob($routeDir . "*.json") as $v){
                $ctn = file_get_contents($v);
                $ctn = json_decode($ctn, 1);
                foreach($ctn as $item){
                    $base = $item['base'];
                    if(substr($req->get()->uri, 0, strlen($base)) == $base){
                        $path = substr($req->get()->uri, ( strlen($base) ));
                        foreach($item['rule'] as $rule=>$callback){
                            $rule = explode(" ", $rule);
                            $this->route->on(
                                strtolower($rule[0]), 
                                $rule[1],
                                $this->controllerAsCallback($callback)
                            );
                        }
                        $rslt = $this->route->handle($method, $path);
                        if($rslt !== 404){
                            return $rslt;
                        }
                    }
                }
            }

            return [
                "vars" => [],
                "callback" => function (\X\Request $req){
                    throw new \Exception("404 Not Found", 404);
                }
            ];

        }

    }