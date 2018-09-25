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

namespace X\View;

use X\View;
use LightnCandy\LightnCandy as LC;

class LightnCandyView extends View
{

    public function __construct()
    {
        $view = $this;
        $this->addHelper("include", function ($file, $options) use ($view) {
            return $view->render($file, $options['_this']);
        });
        $this->addHelper("eval", function ($code, $options) use ($view) {
            $result = eval("return " . $code . ";");
            return $result;
        });
    }

    /**
     * @param string $content Template content
     * @return callable
     */
    public function getRender($content)
    {
        return LC::compile($content, array(
            "helpers" => $this->helper,
            "flags" => LC::FLAG_NAMEDARG | LC::FLAG_JSTRUE | LC::FLAG_JSLENGTH,
            "partials" => $this->shortcut
        ));
    }

    /**
     * @param $render
     * @return callable
     */
    public function prepareRender($render)
    {
        $view = $this;
        return eval(str_replace(
            "return function (\$in = null, \$options = null)",
            "return function (\$in = null, \$options = null) use (\$view)",
            $render
        ));
    }

}