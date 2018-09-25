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

namespace X\Interfaces;

interface Handler
{

    public function getRequest();

    /**
     * @param \X\Response $response
     */
    public function response($response);

    /**
     * @param callable $callback
     */
    public function addResponseCallback($callback);
}