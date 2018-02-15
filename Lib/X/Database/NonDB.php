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

    use \NonDB\NonDB as NDB;

    class NonDB implements \X\Interfaces\Database, \X\Interfaces\NeedApplication, \X\Interfaces\Bootable {

        protected $db;

        public function bootup(){
            
            $config = $this->app->config['Database']['Driver'];
            
            $this->db = new NDB(NDB::driver($config));

        }

        public function getTable($table){

            return $this->db->table($table);

        }

    }