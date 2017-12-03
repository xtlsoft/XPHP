<?php
    /**
     * XPHP Configure File
     * 
     * You can add your providers here.
     * 
     */

    return function ($App) {
        
        $App->container->add('Core.Error', '\Whoops\Run')->
            withMethodCall('pushHandler', ['Core.Error.Handler'])->
            withMethodCall('pushHandler', [new \League\Container\Argument\RawArgument(function(
                $exception, $inspector, $run
            ) use ($App){
                $App->event->emit('Core.Error', $exception, $inspector, $run);
            })])->
            withMethodCall('register', []);

        $App->addBatch([
            ['Core.Error.Handler', '\Whoops\Handler\PrettyPageHandler'],
            ['Core.Route', '\X\Route'],
            ['Core.Log',   '\X\Log']
        ]);
        
    };