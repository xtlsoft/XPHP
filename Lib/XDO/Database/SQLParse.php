<?php
    
    namespace XDO\Database;
    
    use XDO\XDO;
    use XDO\Database;
    use XDO\XDOError;
    
    class SQLParse{
        public static function getParser($exp,$json,$cache,$returnData=1){
            $XSQL = explode("[",$exp[1]);
            return eval("return self::_getParse_".$XSQL[0].'($XSQL[1],$json,$cache,$returnData);');
        }
        public static function _getParse_where($sql,$json,$cache,$returnData=1){
            $sql = substr($sql,0,strlen($sql)-1);
            if($cache[$sql]){
                $return = array();
                foreach($cache[$sql] as $v){
                    $return[$v] = $json[$v];
                }
                if($returnData) return $return; 
                else{ $cache['sql']["_whereForCache"]=0; return $cache[$sql]; }
            }
            $exp = explode("=",$sql);
            $i = 0;
            $return = array();
            $currentSql = $sql;
            $exp[1] = str_replace("/","\\/",$exp[1]);
            $exp[1] = str_replace("%","[\s\S]*",$exp[1]);
            $exp[1] = "/^".$exp[1]."$/";
            foreach($json as $val){
                if(preg_match($exp[1],$val[$exp[0]])){
                    if($returnData){
                        $return["#".$i] = $json["#".$i];
                    }else{
                        $return[] = "#".$i;
                    }
                }
                ++$i;
            }
            if($returnData == false){
                $return["_whereForCache"] = $currentSql;
            }
            return $return;
        }
    }