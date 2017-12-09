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
    
    if (!defined("X")) {
    
        /**
         * The base directory the system in.
         */
        define("SysDir", dirname(__DIR__) . '/');
        /**
         * The version constant.
         */
        define("X", "1.0.3-stable");

    }
    
    // \X\Core::add('Core.Error', '\League\BooBoo\BooBoo')
    //     ->withArgument(new League\Container\Argument\RawArgument([]));

    // // Add the services.
    // \X\Core::addBatch([
    //     ['Core.Log', '\X\Log'],
    //     ['Core.Error.Formatter', '\League\BooBoo\Formatter\HtmlTableFormatter'],
    //     ['Core.Route', '\X\Route'],
    // ]);