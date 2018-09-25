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

use Monolog\Logger;
use X\Interfaces\NeedApplication as INeedApplication;
use X\Interfaces\Bootable;

class Log implements Bootable, INeedApplication
{

    public $logger = [];

    public function bootup()
    {

        $this->app->log = $this;

    }

    /**
     * @param string $name
     * @return Log
     */
    public function addLogger($name)
    {
        $this->logger[$name] = new Logger($name);
        return $this;
    }

    /**
     * @param string $name
     * @param \X\Interfaces\Handler $handler
     * @return Log
     */
    public function pushHandler($name, $handler)
    {
        $this->{$name}->pushHandler($handler);
        return $this;
    }

    /**
     * @param string $event
     * @param string $name
     * @param string $method
     * @return Log
     */
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