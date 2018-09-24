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

use \Monolog\Logger;

class Log implements \X\Interfaces\NeedApplication, \X\Interfaces\Bootable
{

    public $logger = [];

    public function bootup()
    {

        $this->app->log = $this;

    }

    public function addLogger($name)
    {

        $this->logger[$name] = new Logger($name);

        return $this;

    }

    public function pushHandler($name, $handler)
    {

        $this->{$name}->pushHandler($handler);

        return $this;

    }

    public function mapEvent($event, $name, $method = "addInfo")
    {

        $logger = $this->{$name};

        $this->app->event->addListener($event, function ($event, $log) use ($logger, $method) {
            call_user_func([$logger, $method], $log);
        });

        return $this;

    }

    public function __get($name)
    {

        return $this->logger[$name];

    }

}