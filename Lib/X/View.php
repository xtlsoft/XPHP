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

use X\Interfaces\View as IView;
use X\Interfaces\NeedApplication as INeedApplication;

class View implements IView, INeedApplication
{

    /**
     * @var callable[]
     */
    protected $helper = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string[]
     */
    protected $shortcut = [];

    /**
     * @param string $name
     * @return bool|string
     */
    public function getTemplate($name)
    {
        $viewDir = $this->app->config['SysDir'] . $this->app->config['Path']['Template'];
        $tplCollection = $this->app->config['View']['Template'];
        $tplFile = $viewDir . $tplCollection . '/' . $name . $this->app->config['View']['ExtName'];
        if (isset($this->viewDir)) {
            $tplFile = $this->viewDir . $name . $this->viewExt;
        }
        return file_get_contents($tplFile);
    }

    /**
     * @param string $name
     * @param callable $helper
     * @return View
     */
    public function addHelper($name, $helper)
    {
        $this->helper[$name] = $helper;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return View
     */
    public function addData($name, $value)
    {
        $this->data[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return View
     */
    public function addShortcut($name, $value)
    {
        $this->shortcut[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @param array $data
     * @return mixed
     */
    public function render($name, $data = [])
    {
        if ($this->app->config['View']['Cache']) {
            $render = $this->getCache($name);
            if ($render === false) {
                $render = $this->getRender($this->getTemplate($name));
                $this->updateCache($name, $render);
            }
        } else {
            $render = $this->getRender($this->getTemplate($name));
        }
        $render = $this->prepareRender($render);
        $viewDir = $this->app->config['SysDir'] . $this->app->config['Path']['Template'];
        $tplCollection = $this->app->config['View']['Template'];
        $tplFile = $viewDir . $tplCollection . '/';
        $data = array_merge($this->data, $data);
        return $render($data);
    }

    /**
     * @param string $name
     * @param string $data
     * @return mixed
     */
    public function updateCache($name, $data)
    {
        $dir = $this->app->config['SysDir'] . $this->app->config['Path']['Cache'] . 'View/';
        $file = $dir . base64_encode($name) . ".tmp";
        file_put_contents($file, $data);
        return $data;
    }

    /**
     * @param string $name
     * @return string|bool
     */
    public function getCache($name)
    {
        $dir = $this->app->config['SysDir'] . $this->app->config['Path']['Cache'] . 'View/';
        $file = $dir . base64_encode($name) . ".tmp";
        if (file_exists($file)) {
            return file_get_contents($file);
        } else {
            return false;
        }
    }

}