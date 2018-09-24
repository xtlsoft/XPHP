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

class Response
{

    /**
     * @var int
     */
    public $status = 200;

    /**
     * @var array
     */
    public $headers = [];

    /**
     * @var string
     */
    public $content = "";

    /**
     * @param int $code
     * @param array $header
     * @param string $content
     */
    public function __construct($code = 200, $header = [], $content = "")
    {

        $this->status = $code;
        $this->headers = new Header($header);
        $this->content = $content;
    }

    /**
     * Set a header
     *
     * @param string|array $name
     * @param string $value
     * @return Response
     */
    public function header($name, $value = '')
    {
        $this->headers->set($name, $value);
        return $this;
    }

    /**
     * Write result to buffer
     *
     * @param string $data
     * @return Response
     */
    public function write($data)
    {
        $this->content .= $data;
        return $this;
    }

    /**
     * Dump the data
     *
     * @return Response
     */
    public function dump()
    {
        if ($this->headers instanceof Header) {
            $this->headers = $this->headers->dump();
        }
        return $this;
    }

}