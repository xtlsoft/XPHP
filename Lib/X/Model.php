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

class Model implements \X\Interfaces\NeedApplication, \X\Interfaces\Bootable
{

    public $db;

    public function bootup()
    {
        $this->db = $this->table($this->table);
    }

    public function table($name)
    {
        return $this->app->container->get("Core.Model.Database")->getTable($name);
    }

    public function __call($name, $args)
    {
        return call_user_func_array([$this->db, $name], $args);
    }

    public function __get($name)
    {
        return @$this->db->{$name};
    }

    public function __set($name, $value)
    {
        @$this->db->{$name} = $value;
    }

    public function __unset($name)
    {
        unset($this->db->{$name});
    }

}