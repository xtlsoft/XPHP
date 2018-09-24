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

use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Event\Emitter;

class Application
{

    public $handler;

    /**
     * @var \League\Container\Container
     */
    public $container;

    /**
     * @var \League\Event\Emitter
     */
    public $event;

    /**
     * @var array
     */
    public $config;

    /**
     * @var array
     */
    public $route;

    public $request;

    public function __construct($config)
    {
        $this->container = new Container();
        $this->container->delegate(new ReflectionContainer());
        $this->container->inflector('X\Interfaces\NeedApplication')->setProperty("app", $this);
        $this->container->inflector('X\Interfaces\Bootable')->invokeMethod('bootup', []);
        // $this->container->inflector('X\Interfaces\Middleware')->invokeMethod('register', []);
        $this->event = new Emitter();
        $this->config = $config;
    }

    public function init()
    {
        $this->route = $this->container->get('Core.Route');
        if ($this->container->has('Core.Error')) {
            $this->container->get('Core.Error');
        }
        $this->handler = $this->container->get('Request.Handler');
        $this->request = $this->handler->getRequest();
        $this->event->emit("Core.Init");
    }

    public function run()
    {
        $this->event->emit("Core.Run");
        $this->event->emit('Core._.Middleware.Handle', $this->request);
        $app = $this;
        $this->handler->addResponseCallback(function ($resp) use ($app) {
            $app->event->emit('Core._.Middleware.Response', $resp);
        });
        @$this->event->emit("Core.Log", "REQUEST " . $this->request->method . " " . $this->request->uri . " REMOTE " . $this->request->server->REMOTE_ADDR);
        $route = $this->runRoute();
        $requests = $this->request->getArray();
        $requests['data']['route'] = $route['vars'];
        $this->request->set($requests);
        $response = $route['callback']($this->request);
        $this->event->emit("Core.Response");
        if (!$response) {
            $response = new Response(200, [], "");
        }
        $this->handler->response($response);
    }

    /**
     * @param string $scriptFile The path of the script file
     * @return mixed
     */
    public function runScript($scriptFile)
    {
        $script = @include($this->config['SysDir'] . $scriptFile);
        return $script($this);
    }

    public function addBatch($batches)
    {
        foreach ($batches as $batch) {
            $this->container->add($batch[0], $batch[1]);
        }
    }

    public function shareBatch($batches)
    {
        foreach ($batches as $batch) {
            $this->container->share($batch[0], $batch[1]);
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->container->get($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function boot($name)
    {
        if (!$this->container->has($name))
            $this->container->add($name);
        return $this->container->get($name);
    }

    /**
     * @param string $name
     * @return callable
     */
    public function controllerAsCallback($name)
    {
        $instance = $this;
        return function (Request $req) use ($name, $instance) {
            $name = explode(":", $name);
            $cls = $name[0];
            $method = $name[1];
            $cls = explode(".", $cls);
            $app = $cls[0];
            $con = $cls[1];

            $class = "\\Controller\\" . $app . "\\" . $con;
            $file = $app . "/Controller/" . $con . ".class.php";
            include_once($this->config['SysDir'] . $this->config['Path']['Application'] . $file);
            $obj = $instance->boot($class);
            return call_user_func([$obj, $method], $req);
        };
    }

    /**
     * @return array
     */
    protected function runRoute()
    {
        $method = $this->request->get()->method;
        $routeDir = $this->config['SysDir'] . $this->config['Path']['Route'];
        if (($url = $this->route->handle($method, $this->request->get()->uri)) !== 404) {
            return $url;
        }
        foreach (glob($routeDir . "*.json") as $routeFile) {
            $this->route = $this->container->get("Core.Route");
            foreach (json_decode(file_get_contents($routeFile), true) as $item) {
                $base = $item['base'];
                if (substr($this->request->get()->uri, 0, strlen($base)) == $base) {
                    $path = substr($this->request->get()->uri, strlen($base));
                    foreach ($item['rule'] as $rule => $callback) {
                        $rule = explode(" ", $rule);
                        $this->route->on(strtolower($rule[0]), $rule[1], $this->controllerAsCallback($callback));
                    }
                    if (($url = $this->route->handle($method, $path)) !== 404) {
                        return $url;
                    }
                }
            }
        }
        return [
            "vars" => [],
            "callback" => function () {
                return new Response(404);
            }
        ];

    }

}