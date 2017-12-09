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

    namespace X\Database;

    use \ORM;

    class Idiorm implements \X\Interfaces\Database, \X\Interfaces\NeedApplication, \X\Interfaces\Bootable {

        public function bootup(){

            $config = $this->app->config['Database'];
            ORM::configure($config);
            $db = $this;
            ORM::configure('logger', function($log, $time) use ($db){
                $db->app->event->emit('Core.Log', ["type"=>"info", "event"=>"DB_QUERY", "message"=>"$log IN $time"]);
            });

        }

        public function getTable($table){

            return ORM::forTable($table);

        }

    }