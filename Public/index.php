<?php
    /**
     * XPHP - PHP Framework
     * 
     * This project is licensed
     * under MIT. Please use it
     * under the license and law.
     * 
     * @author xtl<xtl@xtlsoft.top>
     * @package XPHP
     * @category framework
     * @license MIT
     * @link https://github.com/xtlsoft/XPHP
     * 
     */
    
    namespace X\Temp\Instance;

    /**
     * Composer Vendor Directory
     */
    defined("COMPOSER_DIR") or define("COMPOSER_DIR", dirname(__DIR__) . '/vendor/');

    // Require the composer
    require (COMPOSER_DIR . 'autoload.php');

    