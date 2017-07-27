<?php
    
    namespace X;
    
    class Header{
        static function jump($url){
            header("location: $url");
        }
        static function set($set){
            header($set);
        }
        static function code($code,$stxt=""){
            if(!$stxt){
                $stxt = self::getStatusByCode($code);
            }
            header("HTTP/1.1 $code $stxt");
            header("Status: $code $stxt");
        }
        static function mime($mime){
            header("Content-type: $mime");
        }
        static function down($fileName){
            self::mime("application/force-download");
            header("Content-Disposition: attachment; filename=".$fileName);
        }
        static function getStatusByCode($code){
            switch($code){
                case 404:
                    $stxt = "Not Found";
                    break;
                case 301:
                    $stxt = "Moved Permanently";
                    break;
                case 304:
                    $stxt = "Not Modified";
                    break;
                case 500:
                $stxt = "Internal Server Error";
                    break;
                case 503:
                    $stxt = "Service Unavailable";
                    break;
                case 400:
                    $stxt = "Bad Request";
                    break;
                case 401:
                    $stxt = "Unauthorized";
                    break;
                case 403:
                    $stxt = "Forbidden";
                    break;
            }
            return $stxt;
        }
    }