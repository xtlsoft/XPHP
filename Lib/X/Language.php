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

class Language implements \X\Interfaces\NeedApplication, \X\Interfaces\Bootable
{

    protected $langDir;
    protected $lang;

    public function bootup()
    {

        $this->langDir = $this->app->config['SysDir'] . $this->app->config['Path']['Language'];

        $this->lang = $this->app->config['Language'];

        $view = $this->app->get("Core.View");

        $view->addHelper("lang", function ($key) use ($view) {

            $lang = $view->app->container->get("Core.Language");

            return $lang->get($key);

        });

    }

    public function get($key)
    {

        $split = explode("/", $key);

        $content = file_get_contents($this->langDir . $this->lang . '.json');

        $content = json_decode($content, 1);

        foreach ($split as $v) {

            if (isset($content[$v])) {
                $content = $content[$v];
            } else {
                $content = $key;
                break;
            }

        }

        return $content;

    }

}