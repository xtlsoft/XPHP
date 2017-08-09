<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace Controller\Home;
    
    use X\Controller;
    use X\Log;
    use Model\Home\IndexModel;
    
    class IndexController extends Controller{
        public function index(){
            
            $this->Data = array(
                    "Version" => XPHP_VERSION
                );
            
            return $this->View("Home/index");
            
        }
        
        public function Wow($var){
            
            //Run This in Your MySQL Database
            //to see the ORM and Model 
            
// -- Adminer 4.3.1 MySQL dump

// SET NAMES utf8;
// SET time_zone = '+00:00';
// SET foreign_key_checks = 0;
// SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

// CREATE DATABASE `xphp` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
// USE `xphp`;

// DROP TABLE IF EXISTS `test`;
// CREATE TABLE `test` (
//   `id` int(200) NOT NULL AUTO_INCREMENT,
//   `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
//   `value` text COLLATE utf8_unicode_ci,
//   PRIMARY KEY (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

// INSERT INTO `test` (`id`, `name`, `value`) VALUES
// (1,	'time',	'21sqse2sswqw12s'),
// (2,	'hi',	'hi,too!'),
// (3,	'anything',	'something is better');

// -- 2017-08-09 04:59:24
            
            $Model = $this->Model("IndexModel",array("test"));
            
            $var['ORMDB_Result'] = $Model->get('hi');
            
            return $this->Json($var);
            
        }
        
    }