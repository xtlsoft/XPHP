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

    class Filter extends \X\Middleware {

        public function handle($event, \X\Request $request){

            $j = $request->getArray();
            @$j['data']['get']['something'] = base64_encode($j['data']['get']['something']);
            $request->set($j);

        }

        public function response($event, \X\Response $response){

            $response->write("
                <hr />
                <i><h3 align=\"center\">Powered By XPHP</h3></i>
            ");
            $header = $response->header + [
                "content-type" => "text/html",
                "x-powered-byme" => "xphp/" . X,
                "x-time"       => date('Y-m-d h:i:s')
            ];

            $response->header = $header;

        }

    }