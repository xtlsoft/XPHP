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

namespace X\Handler;

use X\Response;

trait CallbackStackTrait
{
    /**
     * @var callable[]
     */
    protected $responseCallbacks = [];

    /**
     * @param callable $callback
     */
    public function addResponseCallback($callback)
    {
        $this->responseCallbacks[] = $callback;
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function handleResponseCallback($response)
    {
        foreach ($this->responseCallbacks as $callback) {
            $callback($response);
        }
        return $response;
    }
}