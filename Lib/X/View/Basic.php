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

class Basic extends \X\View
{

    public $vars;

    public function __construct()
    {
        $view = $this;
        $this->addHelper('need', function ($name) use ($view) {
            return $view->render($name, $view->vars);
        });
        $this->addHelper('shortcut', function ($name) use ($view) {
            return eval($view->shortcut[$name]);
        });
    }

    public function __call($name, $args)
    {
        return call_user_func_array($this->helper[$name], $args);
    }

    /**
     * @param string $content Template content
     * @return string
     */
    public function getRender($content)
    {
        return $this->process($content);
    }

    /**
     * @param string $render
     * @return callable
     */
    public function prepareRender($render)
    {
        $view = $this;
        return function ($var) use ($render, $view) {
            $view->vars = $var;
            $pre = '';
            $pre .= 'foreach($view->vars as $key => $value) {' . "\n";
            $pre .= '   eval(\'$\' . $k . \' = \' . $v . \';\');' . "\n";
            $pre .= '}' . "\n";
            $pre .= '$var = $view->vars;' . "\n";
            @ob_start();
            eval($pre . $render);
            return ob_get_clean();
        };
    }

    /**
     * @param string $content Template content
     * @return string
     */
    protected function process($content)
    {
        $patterns = array($this->app->config['View']['Start'] . "#", $this->app->config['View']['Start'], $this->app->config['View']['End']);
        $replaces = array("<?php", "<?=", "?>");
        $render = str_replace($patterns, $replaces, $content);
        $preEval = '';
        $preEval .= '$Base = $view->app->config["Route"]["Base"]."/";' . "\n";
        $preEval .= '$StaticDir = $Base . "Static/" . $view->app->config["View"]["Template"] . "/";' . "\n";
        $preEval .= '?>' . "\n";
        return ($preEval . $render);
    }
}