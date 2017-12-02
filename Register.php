<?php
    /**
     * XPHP Configure File
     * 
     * You can add your providers here.
     * 
     */

    return function ($App) {
        
        $App->container->add('Core.Error', '\League\BooBoo\BooBoo')->
            withArgument(new League\Container\Argument\RawArgument([]))->
            withMethodCall('pushFormatter', ['Core.Error.Formatter'])->
            withMethodCall('register', []);

        $App->addBatch([
            ['Core.Error.Formatter', '\League\BooBoo\Formatter\HtmlTableFormatter'],
            ['Core.Route', '\X\Route'],
            ['Core.Log',   '\X\Log']
        ]);
        
    };