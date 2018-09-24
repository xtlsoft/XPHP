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

class Controller implements \X\Interfaces\NeedApplication
{

    protected $data = [];

    protected function response($data = "", $header = [], $status = 200)
    {

        return new \X\Response($status, $header, $data);

    }

    protected function view($name, $data = [])
    {
        $view = $this->app->container->get('Core.View');
        return $this->response($view->render($name, array_merge($this->data, $data)));
    }

    protected function model($name, $params = [])
    {
        $nm = str_replace("\\", "/", $name);
        $nm = explode("/", $nm);
        $path = $this->app->config['SysDir'] . $this->app->config['Path']['Application'] . $nm[0] . '/Model/' . $nm[1] . '.class.php';
        include_once($path);
        $name = "\\Model\\" . str_replace("/", "\\", $name);
        $model = $this->app->container->add("Core._.Model." . $name, $name);
        foreach ($params as $v) {
            $model->withArgument(new \League\Container\Argument\RawArgument($v));
        }

        return $this->app->container->get("Core._.Model." . $name);
    }

    protected function json($data = [], $status = null, $pretty = 0)
    {

        if ($status !== null) {
            $data = [
                "status" => $status,
                "result" => $data
            ];
        }

        $resp = json_encode(array_merge($this->data, $data), ($pretty ? JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING : JSON_BIGINT_AS_STRING));

        if (@isset($this->app->request->data->get->jsonp)) {
            $resp = $this->app->request->data->get->jsonp . "(" . $resp;
            $resp .= ");";
        }

        return $this->response($resp, ["content-type" => "application/json"]);

    }

}