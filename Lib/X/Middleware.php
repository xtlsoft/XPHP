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

use X\Interfaces\Bootable;
use X\Interfaces\Middleware as IMiddleware;
use X\Interfaces\NeedApplication as INeedApplication;

class Middleware implements Bootable, IMiddleware, INeedApplication
{

    public function bootup()
    {
        $this->app->event->addListener('Core._.Middleware.Handle', [$this, 'handle']);
        $this->app->event->addListener('Core._.Middleware.Response', [$this, 'response']);
    }

    /**
     * @param $event
     * @param Request $request
     */
    public function handle($event, $request)
    {
    }

    /**
     * @param $event
     * @param Response $response
     */
    public function response($event, $response)
    {
    }

}