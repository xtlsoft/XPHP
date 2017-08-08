<?php
    /**
     * This file is a part of XPHP.
     * 
     * You may read the LICENSE file to
     * know what you can do.
     * 
     * @pacakge XPHP
     * @author xtl<xtl@xtlsoft.top>
     * @license MIT
     * 
     */
    
    namespace X;
    
    use X\Header;
    use X\View;
    use X\Log;
    
    error_reporting(0);
    
    set_error_handler(function($eno,$eme){
        Error::show($eno,"PHP警告：".$eme);
    },E_WARNING);
    
    set_error_handler(function($eno,$eme){
        Error::show($eno,"PHP警告：".$eme);
    },E_USER_WARNING);
    
    set_exception_handler(function($e){
        Error::show($e->getCode(),"未处理异常：".$e->getMessage().' in '.$e->getFile().' line '.$e->getLine());
    });
    
    register_shutdown_function(function(){
        if($e = error_get_last()){
            if($e['type']!=E_NOTICE && $e['type']!=E_WARNING && $e['type']!=E_USER_WARNING){
                Error::show(null,"PHP致命错误：".$e['message'] . " in " . $e['file'] . ' line ' . $e['line']);
            }
        }
    });
    
    class Error{
        public static function Show($no="",$e,$jump="",$jpsec=3){
            Log::error("#{$no}: $e");
            $var = array("no"=>$no,"e"=>$e,"jump"=>$jump,"sec"=>$jpsec);
            $tpl = new View("System/Error");
            $tpl->bindVars($var);
            $tpl->show();
            die;
            return $tpl;
        }
        
        public static function HTTP_E($code,$msg="",$jump="",$jpsec=3){
            if(!$msg){
                $msg = Header::getStatusByCode($code);
            }
            Log::error("HTTP $code $msg IN ".$_SERVER['REQUEST_URI']." AT ".$_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT']." REMOTE ".$_SERVER['REMOTE_ADDR'].':'.$_SERVER['REMOTE_PORT']);
            Header::code($code,$msg);
            $var = array("code"=>$code,"msg"=>$msg,"jump"=>$jump,"sec"=>$jpsec);
            $tpl = new View("System/HTTP_E");
            $tpl->bindVars($var);
            $tpl->show();
            die;
            return $tpl;
        }
    }
    