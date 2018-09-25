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

    /**
     * @var string
     */
    protected $langDir;

    /**
     * @var string
     */
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

    /**
     * @param string $keyPath
     * @return mixed
     */
    public function get($keyPath)
    {
        $content = json_decode(file_get_contents($this->langDir . $this->lang . '.json'), true);
        foreach (explode("/", $keyPath) as $key) {
            if (isset($content[$key])) {
                $content = $content[$key];
            } else {
                return $keyPath;
            }
        }
        return $content;
    }
}