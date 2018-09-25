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

use X\Request;

class Http implements \X\Interfaces\Handler
{
    use CallbackStackTrait;

    /**
     * @var array
     */
    public $statusMap = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    ];

    /**
     * @return \X\Request
     */
    public function getRequest()
    {
        $request = new Request();
        $request->set([
            "method" => $_SERVER['REQUEST_METHOD'],
            "data" => [
                "get" => $_GET,
                "post" => $_POST,
                "cookie" => $_COOKIE,
                "server" => $_SERVER
            ],
            "uri" => explode('?', $_SERVER['REQUEST_URI'])[0]
        ]);
        return $request;
    }

    /**
     * @param \X\Response $response
     */
    public function response($response)
    {
        $response = $this->handleResponseCallback($response);
        $stat = $response->dump()->status;
        header("HTTP/1.1 " . $stat . " " . $this->statusMap[$stat]);
        header("Status: $stat");
        foreach ($response->dump()->headers as $k => $v) {
            header("$k: $v");
        }
        echo $response->dump()->content;
    }
}