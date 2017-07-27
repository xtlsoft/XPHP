<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace X;
    
    use X\Error;
    
    class Route{
        public static $isLoad = false;
        public static $Application = "";
        public static $Controller = "";
        public static $Action = "";
        public static $var = array();
        
        public static function load($file){
            if(!self::$isLoad){
                $_G = array();
                $_G['REQUEST_URI'] = explode("?",$_SERVER['REQUEST_URI'])[0];
                $arr = json_decode(file_get_contents($file),1);
                foreach($arr as $v){
                    $count = strlen($v['base']);
                    if(substr($_G['REQUEST_URI'],0,$count) == $v['base']){
                        $url = substr($_G['REQUEST_URI'],$count,strlen($_G['REQUEST_URI'])-$count);
                        foreach($v['rule'] as $rule=>$con){
                            $ruleParse = self::parseRule($rule);
                            if(preg_match($ruleParse[1],$url)){
                                $vars = self::parseVars($ruleParse,$url);
                                $exp = explode(":",$con);
                                $exp2 = explode(".",$exp[0]);
                                if($vars['Application']){
                                    self::$Application = $vars['Application'];
                                }else{
                                    self::$Application = $exp2[0];
                                }
                                if($vars['Controller']){
                                    self::$Controller = $vars['Controller'];
                                }else{
                                    self::$Controller = $exp2[1];
                                }
                                if($vars['Action']){
                                    self::$Action = $vars['Action'];
                                }else{
                                    self::$Action = $exp[1];
                                }
                                self::$var = $vars;
                                self::$isLoad = true;
                                return true;
                            }
                        }
                    }
                }
            }
        }
        
        public static function parseRule($rule){
            $varArr = array();
            $exp1 = explode("{",$rule);
            foreach($exp1 as $exp1for){
                $exp2 = explode('}',$exp1for);
                if(count($exp2) != 1){
                    $varArr[] = $exp2[0];
                }
            }
            $preg = $rule;
            $sscanf = $rule;
            foreach($varArr as $var){
                $preg = str_replace("{".$var."}","(.+?)",$preg);
            }
            $preg = "/^".str_replace("/","\\/",$preg)."$/";
            return array($varArr,$preg);
        }
        
        public static function parseVars($ruleParse,$txt){
            $return = array();
            $evalText = 'preg_replace(\''.$ruleParse[1].'\',"';
            for($i = 0; $i<=count($ruleParse[1]); ++$i){
                $evalText .= '$'.($i+1)."__X_TMP__";
            }
            $evalAft = '",\''.$txt.'\')';
            eval('$exp = explode("__X_TMP__",'.$evalText.$evalAft.");");
            unset($exp[count($exp)-1]);
            $i = 0;
            foreach($ruleParse[0] as $var){
                $return[$var] = urldecode($exp[$i]);
                ++$i;
            }
            return $return;
        }
        
    }