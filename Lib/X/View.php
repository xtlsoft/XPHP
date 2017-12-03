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
    class View implements \X\Interfaces\View, \X\Interfaces\NeedApplication {

        public function getTemplate($name){

            $viewDir = $this->app->config['SysDir'] . $this->app->config['Path']['Template'];
            $tplCollection = $this->app->config['View']['Template'];

            $tplFile = $viewDir. $tplCollection. '/'. $name. $this->app->config['View']['ExtName'];

            if(isset($this->viewDir)){
                $tplFile = $this->viewDir . $name . $this->viewExt;
            }

            return file_get_contents($tplFile);

        }

        public function render($name, $data = []){

            if($this->app->config['View']['Cache']){
                $render = $this->getCache($name);
                if($render === false){
                    $render = $this->getRender($this->getTemplate($name));
                    $this->updateCache($name, $render);
                }
            }else{
                $render = $this->getRender($this->getTemplate($name));
            }

            $render = $this->prepareRender($render);

            $viewDir = $this->app->config['SysDir'] . $this->app->config['Path']['Template'];
            $tplCollection = $this->app->config['View']['Template'];

            $tplFile = $viewDir. $tplCollection. '/';

            $data['_viewdir'] = $tplFile;
            $data['_viewext'] = $this->app->config['View']['ExtName'];

            return $render($data);
            
        }

        public function updateCache($name, $data){

            $dir = $this->app->config['SysDir'] . $this->app->config['Path']['Cache'] . 'View/';
            $file = $dir . base64_encode($name) . ".tmp";

            file_put_contents($file, $data);

            return $data;

        }

        public function getCache($name){

            $dir = $this->app->config['SysDir'] . $this->app->config['Path']['Cache'] . 'View/';
            $file = $dir . base64_encode($name) . ".tmp";

            if(file_exists($file))
                return file_get_contents($file);
            else
                return false;

        }

    }