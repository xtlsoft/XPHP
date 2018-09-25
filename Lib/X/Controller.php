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

use X\Interfaces\NeedApplication as INeedApplication;
use League\Container\Argument\RawArgument;

class Controller implements INeedApplication
{

    protected $data = [];

    /**
     * @param string $data
     * @param array $header
     * @param int $status
     * @return Response
     */
    protected function response($data = "", $header = [], $status = 200)
    {
        return new Response($status, $header, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return Response
     */
    protected function view($name, $data = [])
    {
        $view = $this->app->container->get('Core.View');
        return $this->response($view->render($name, array_merge($this->data, $data)));
    }

    /**
     * @param string $name
     * @param array $params
     * @return Model
     */
    protected function model($name, $params = [])
    {
        $nameSp = str_replace("\\", "/", $name);
        $nameSp = explode("/", $nameSp);
        $path = $this->app->config['SysDir'] . $this->app->config['Path']['Application'] . $nameSp[0] . '/Model/' . $nameSp[1] . '.class.php';
        include_once($path);
        $name = "\\Model\\" . str_replace("/", "\\", $name);
        $model = $this->app->container->add("Core._.Model." . $name, $name);
        foreach ($params as $param) {
            $model->withArgument(new RawArgument($param));
        }
        return $this->app->container->get("Core._.Model." . $name);
    }

    /**
     * @param array $data
     * @param int $status
     * @param int $pretty
     * @return Response
     */
    protected function json($data = [], $status = null, $pretty = 0)
    {
        if ($status !== null) {
            $data = [
                "status" => $status,
                "result" => $data
            ];
        }
        $response = json_encode(array_merge($this->data, $data), ($pretty ? JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING : JSON_BIGINT_AS_STRING));
        if (@isset($this->app->request->data->get->jsonp)) {
            $response = $this->app->request->data->get->jsonp . "(" . $response . ");";
        }
        return $this->response($response, ["content-type" => "application/json"]);
    }

}