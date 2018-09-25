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
use League\Event\Emitter;
use League\Container\Exception\NotFoundException as ContainerNotFoundException;

class Core
{

    /**
     * @var Container
     */
    public static $container;

    /**
     * @var Emitter
     */
    public static $event;
    public static $global;

    public static function init()
    {
        self::$container = new Container();
        self::$event = new Emitter();
    }

    public static function run()
    {
        //Error Controlling
        try {
            $core_error = self::get('Core.Error');
        } catch (ContainerNotFoundException $e) {

        }
        if ($core_error) {
            $core_error->pushFormatter(self::get("Core.Error.Formatter"));
            $core_error->register();
        }
    }
}

Core::init();