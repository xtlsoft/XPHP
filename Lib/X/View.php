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

    class View implements \X\Interfaces\View, \X\Interfaces\NeedApplication {

        public function render($name, $data){

            $viewDir = $this->app->config['SysDir'] . $this->app->config['Path']['View']['Template'];
            $tplCollection = $this->app->config['View']['Template'];

            $tplFile = $viewDir. $tplCollection. '/'. $name. '.tpl';

            $tpl = file_get_contents($tplFile);

            $complied = LightnCandy::complie($template);

            $render = LightnCandy::prepare($complied);

            return $render($data);

        }

    }