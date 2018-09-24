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

namespace X\Middleware;

use X\Middleware as IMiddleware;

class Filter extends IMiddleware
{

    /**
     * @param $event
     * @param \X\Request $request
     */
    public function handle($event, $request)
    {
        $j = $request->getArray();
        $request->set($j);
    }

    /**
     * @param $event
     * @param \X\Response $response
     */
    public function response($event, $response)
    {
        $response->header([
            "x-xphp-version" => "xphp/" . X,
            "x-time" => date('Y-m-d h:i:s')
        ]);
    }

}