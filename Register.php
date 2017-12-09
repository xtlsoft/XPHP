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
            withMethodCall('allowQuit', [new \League\Container\Argument\RawArgument(false)])->
            withMethodCall('register', []);

        $App->addBatch([
            ['Core.Error.Handler', '\Whoops\Handler\PrettyPageHandler'],
            ['Core.Route', '\X\Route'],
            ['Core.Model.Database', '\X\Database\Idiorm']
        ]);

        $App->shareBatch([
            ['Core.Log',   '\X\Log'],
            ['Core.View',  '\X\ViewLightnCandy'],
        ]);
        
    };