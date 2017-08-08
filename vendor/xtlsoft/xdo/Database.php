<?php
    
    namespace XDO;
    
    use XDO\XDO;
    use XDO\Tool;
    use XDO\XDOError;
    use XDO\Database\SQLParse;
    
    class Database {
        protected $ModelName = "Main";
        protected $Json = array();
        protected $KeyCache = array();
        
        public function __construct($ModelName){
            $this->ModelName = $ModelName;
        }
        public function get($Query){
            $exp = explode(".",$Query);
            switch(count($exp)){
                case 1:
                    if(!$this->Json[$exp[0]]){
                        $this->Json[$exp[0]] = Tool::getJson("Database/$this->ModelName/$Query/Data");
                    }
                    return $this->Json[$exp[0]];
                    break;
                case 2:
                    if(substr($exp[1],0,1) == "#"){
                        if(!$this->Json[$exp[0]]){
                            $this->Json[$exp[0]] = Tool::getJson("Database/$this->ModelName/$exp[0]/Data")[$exp[1]];
                        }
                        return $this->Json[$exp[0]];
                    }
                    $this->Json[$exp[0]] or ($this->Json[$exp[0]] = Tool::getJson("Database/$this->ModelName/$exp[0]/Data"));
                    if(XDO::$Cache){
                        $this->KeyCache[$exp[0]] or ($this->KeyCache[$exp[0]] = Tool::getJson("Database/$this->ModelName/$exp[0]/KeyCache"));
                    }
                    if(XDO::$Cache){
                        $XSQL = explode("[",$exp[1]);
                        $parse = SQLParse::_getParse_where($XSQL[1],
                            $this->Json[$exp[0]],
                            $this->KeyCache[$exp[0]],
                            false);
                        if($parse['_whereForCacheSuccess']){
                            $cacheKey = $parse['_whereForCache'];
                            unset($parse['_whereForCache']);
                            unset($parse['_whereForCacheSuccess']);
                            $this->KeyCache[$exp[0]][$cacheKey] = $parse;
                            Tool::putJson(
                                    "Database/$this->ModelName/$exp[0]/KeyCache",
                                    $this->KeyCache[$exp[0]]
                                );
                        }
                    }
                    return SQLParse::getParser($exp,
                        $this->Json[$exp[0]],
                        $this->KeyCache[$exp[0]]);
                    break;
                default:
                    throw new XDOError("SQL_METHOD_ERROR",1001);
            }
        }
        
        public function put($Query,$data){
            $exp = explode(".",$Query);
            if(!$this->Json[$exp[0]]){
                $this->get($Query);
            }
            switch(count($exp)){
                case 1:
                    $this->Json[$exp[0]] = array_merge($this->Json[$exp[0]],$data);
                    return Tool::putJson("Database/$this->ModelName/$Query/Data",$this->Json[$exp[0]]);
                    break;
                case 2:
                    if(substr($exp[1],0,1) == "#"){
                        //if(!$this->Json[$exp[0]]){
                            $this->Json[$exp[0]]=Tool::getJson("Database/$this->ModelName/$exp[0]/Data");
                        //}
                        $this->Json[$exp[0]][$exp[1]] = array_merge($this->Json[$exp[0]][$exp[1]],$data);
                        //var_dump($this->Json[$exp[0]]);
                        return Tool::putJson("Database/$this->ModelName/$exp[0]/Data",$this->Json[$exp[0]]);
                    }
                    if(XDO::$Cache){
                        $this->KeyCache[$exp[0]] or ($this->KeyCache[$exp[0]] = Tool::getJson("Database/$this->ModelName/$exp[0]/KeyCache"));
                    }
                    if(XDO::$Cache){
                        $XSQL = explode("[",$exp[1]);
                        $parse = SQLParse::_getParse_where($XSQL[1],
                            $this->Json[$exp[0]],
                            $this->KeyCache[$exp[0]],
                            false);
                        if($parse['_whereForCacheSuccess']){
                            $cacheKey = $parse['_whereForCache'];
                            unset($parse['_whereForCache']);
                            unset($parse['_whereForCacheSuccess']);
                            $this->KeyCache[$exp[0]][$cacheKey] = $parse;
                            Tool::putJson(
                                    "Database/$this->ModelName/$exp[0]/KeyCache",
                                    $this->KeyCache[$exp[0]]
                                );
                        }
                    }
                    $Parse = SQLParse::getParser($exp,
                        $this->Json[$exp[0]],
                        $this->KeyCache[$exp[0]],
                        0);
                    foreach($Parse as $v){
                        if(substr($v,0,1) == "#"){
                            $this->put($exp[0].'.'.$v,$data);
                        }
                    }
                    break;
                    
                default:
                    throw new XDOError("SQL_METHOD_ERROR",1001);
            }
        }
        
        public function ins($Query,$data){
            XDO::$Cache = false;
            $this->get($Query);
            $this->Json[$Query]["#".count($this->Json[$Query])] = $data;
            Tool::putJson("Database/$this->ModelName/$Query/Data",$this->Json[$Query]);
            XDO::$Cache = true;
            return true;
        }
        
        public function del($Query){
            $exp = explode(".",$Query);
            if(count($exp)!=2){
                throw new XDOError("SQL_METHOD_ERROR",1001);
                return false;
            }
            $this->get($exp[0]);
            if(substr($exp[1],0,1) == "#"){
                unset($this->Json[$exp[0]][$exp[1]]);
                Tool::putJson("Database/$this->ModelName/$exp[0]/Data",$this->Json[$exp[0]]);
                return true;
            }
            if(XDO::$Cache){
                    $this->KeyCache[$exp[0]] or ($this->KeyCache[$exp[0]] = Tool::getJson("Database/$this->ModelName/$exp[0]/KeyCache"));
                }
                if(XDO::$Cache){
                    $XSQL = explode("[",$exp[1]);
                    $parse = SQLParse::_getParse_where($XSQL[1],
                        $this->Json[$exp[0]],
                        $this->KeyCache[$exp[0]],
                        false);
                    if($parse['_whereForCacheSuccess']){
                        $cacheKey = $parse['_whereForCache'];
                        unset($parse['_whereForCache']);
                        unset($parse['_whereForCacheSuccess']);
                        $this->KeyCache[$exp[0]][$cacheKey] = $parse;
                        Tool::putJson(
                                "Database/$this->ModelName/$exp[0]/KeyCache",
                                $this->KeyCache[$exp[0]]
                            );
                    }else{
                        $cacheKey = $parse['_whereForCache'];
                        unset($parse['_whereForCache']);
                    }
                }
                $Parse = SQLParse::getParser($exp,
                    $this->Json[$exp[0]],
                    $this->KeyCache[$exp[0]],
                    0);
                foreach($Parse as $v){
                    //echo ($exp[0].".".$v);
                    if(substr($v,0,1) == "#"){
                        $this->del($exp[0].".".$v);
                    }
                }
                if(XDO::$Cache){
                    unset($this->KeyCache[$exp[0]][$cacheKey]);
                    Tool::putJson(
                                "Database/$this->ModelName/$exp[0]/KeyCache",
                                $this->KeyCache[$exp[0]]
                            );
                }
                return true;
        }
        
        public function showTables(){
            return Tool::listDir("Database/$this->ModelName");
        }
        
        public function createTable($tableName){
            mkdir(XDO::$DataDir."Database/$this->ModelName/$tableName");
            Tool::putJson(
                    "Database/$this->ModelName/$tableName/Data",
                    array()
                );
            Tool::putJson(
                    "Database/$this->ModelName/$tableName/KeyCache",
                    array()
                );
            return true;
        }
        
        public function removeTable($tableName){
            
            unlink(XDO::$DataDir."Database/$this->ModelName/$tableName/Data.json");
            unlink(XDO::$DataDir."Database/$this->ModelName/$tableName/KeyCache.json");
            rmdir(XDO::$DataDir."Database/$this->ModelName/$tableName");
            return true;
        }
        
        public function getAssoc($data,$name="name",$value=false){
            $result = array();
            if($value){
                foreach($data as $v){
                    $result[$v[$name]] = $v[$value];
                }
            }else{
                foreach($data as $v){
                    $result[$v[$name]] = $v;
                }
            }
            return $result;
        }
        
        public function clearCache($Table){
            $Table = explode(".",$Table);
            if($Table[1]){
                $ex = explode("[",$Table);
                $ex = $ex[1];
                $ex = substr($ex, 0, (strlen($ex)-1));
                unset($this->KeyCache[$Table[0]][$ex]);
                return true;
            }
            unset($this->KeyCache[$Table[0]]);
            return true;
        }
        
    }