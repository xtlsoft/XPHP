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
    
    class Route implements \X\Interfaces\NeedApplication {
        
        /**
         * Routers
         * 
         * @var $route
         * 
         */
        protected $route = [];
        
        /**
         * Register A Handle
         * 
         * @param string $method
         * @param string $addr
         * @param callable $callback
         * 
         * @return \Rqo\Http\Route
         * 
         */
        public function on($method, $addr, callable $callback){
            
            $rslt = self::parseAddr($addr);
            
            if(! ($rslt instanceof \X\Route\AddrParseResult) ){
                throw new \Exception("Route Expecting \X\Route\AddrParseResult, Other Given.");
            }
            
            $route = ["method"=>$method, "keys"=>$rslt->keys, "preg"=>$rslt->preg, "callback"=>$callback];
            
            $this->route[] = $route;
            
            return $this;
            
        }
        
        /**
         * Handle A Request
         * 
         * @param string $method
         * @param string $addr
         * 
         * @return \X\Response 
         * 
         */
        public function handle($method, $addr){
            
            $method = strtolower($method);
            $rb = $this->app->config['Route']['Base'];

            $addr = substr($addr, ( strlen($rb) ));
            
            foreach($this->route as $v){
                
                if($v['method'] == $method){
                    
                    $rslt = self::comparePregAndPath($v['preg'], $addr);
                    
                    if($rslt){
                        
                        $vars = self::toAssocByKeyAndValue($v['keys'], $rslt);
                        
                        $callback = $v['callback'];
                        
                        return ["vars"=>$vars, "callback"=>$callback];
                        
                    }
                    
                }
                
            }
            
            // When 404
            return 404;
        }
        
        /**
         * Call Func(Register)
         * 
         * @param string Method
         * @param array Parameters
         * 
         * @return mixed
         * 
         */
        public function __call($name, $param){
            
            return $this->on($name, $param[0], $param[1]);
            
        }
        
        /**
         * Parse A Route Addr
         * 
         * @param string $addr
         * 
         * @return \X\Route\AddrParseResult
         * 
         */
        public static function parseAddr($addr){
            
            $key = [];
            
            // if(str_replace("{","",$addr) == $addr){
            //     $addr = "/".str_replace(array("/", "."), array("\\/", "\\."), $addr)."/";
            //     return (new \Rqo\Http\Route\AddrParseResult())->assign(["keys"=>[], "preg"=>$addr]);
            // }
            
            // Dump the keys & Replacement
            $preg = preg_replace_callback("/\\{[a-zA-Z]*\\}/", function($a) use (&$key){
                $key[] = substr($a[0], 1, -1);
                return "<<<>>>";
            }, $addr);
            
            // Generate The Regex 
            $preg = "/^".str_replace(array("/", ".", "<<<>>>"), array("\\/", "\\.", "(.*)"), $preg)."$/";
            
            return (new \X\Route\AddrParseResult())->assign(["keys"=>$key, "preg"=>$preg]);
            
        }
        
        /**
         * Compare And Work Out The Vars
         * 
         * @param string Regex
         * @param string Addr
         * 
         * @return bool/array
         * 
         */
        public static function comparePregAndPath($preg, $addr){
            
            $rslt = [];
            
            if(preg_match($preg, $addr, $rslt)){
                unset($rslt[0]);
                if(!$rslt){
                    $rslt = ["____"];
                }
                return $rslt;
            }else{
                return false;
            }
            
        }
        
        /**
         * Get Assoc By Keys And Values
         * 
         * @param string[] $key
         * @param string[] $value
         * 
         * @return string[]
         * 
         */
        public static function toAssocByKeyAndValue($key, $value){
            
            $rslt = [];
            
            foreach($value as $k=>$v){
                
                if(isset($key[$k-1])){
                    $rslt[$key[$k-1]] = urldecode($v);
                }
                
            }
            
            return $rslt;
            
        }
        
    }