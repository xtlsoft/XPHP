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

    use \LightnCandy\LightnCandy;

    class ViewLightnCandy extends \X\View {

        public function getRender($template){

            $view = $this;

            return LightnCandy::compile($template, array(
                "helpers" => [
                    "include" => function ($file, $options) use ($view){
                        return $view->render($file, $options['_this']);
                    }
                ],
                "flags"  => LightnCandy::FLAG_NAMEDARG 
            ));

        }

        public function prepareRender($render){

            $view = $this;

            return eval(
                str_replace("return function (\$in = null, \$options = null)", 
                    "return function (\$in = null, \$options = null) use (\$view)", 
                    $render
                )
            );

        }

    }