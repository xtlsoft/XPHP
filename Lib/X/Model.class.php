<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace X;
    
    use X\Error;
    use XDO\XDO;
    use X\Log;
    use \ORM;
    use \PDO;
    
    abstract class Model{
        
        public $XDODB = false;
        public $ORM = false;
        
        public final function __construct($table=__CLASS__){
            global $_C;
            if($_C['enableORM']){
                $this->ORM($table);
            }
        }
        
        public final function ORM($table){
            ORM::configure($GLOBALS['_C']['ORMDB']);
            ORM::configure('logger', function($log_string, $query_time) {
                Log::info('QUERY ' . $log_string . ' IN ' . $query_time);
            });
            $this->ORM = ORM::for_table($table);
            return $this->ORM;
        }
        
        public final function XDODB($db){
            if($this->XDODB === false) $this->XDODB = XDO::Database($db);
            return $this->XDODB;
        }
        
        public function __call($name, $arg){
            $arg = implode(', ', $arg);
            return eval("return \$this->ORM->{$name}({$arg});");
        }
        
    }