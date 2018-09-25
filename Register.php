<?php
/**
 * XPHP Configure File
 *
 * You can add your providers here.
 */

/**
 * @param \X\Application $app
 */
return function ($app) {

    $app->container
        ->add('Core.Error', '\Whoops\Run')
        ->withMethodCall('pushHandler', ['Core.Error.Handler'])
        ->withMethodCall('pushHandler', [
            new \League\Container\Argument\RawArgument(function ($exception, $inspector, $run) use ($app) {
                $app->event->emit('Core.Error', $exception, $inspector, $run);
                $app->event->emit('Core.Log.Error', $exception->getMessage());
            })
        ])
        ->withMethodCall('allowQuit', [new \League\Container\Argument\RawArgument(false)])
        ->withMethodCall('register', []);

    $app->addBatch([
        ['Core.Error.Handler', '\Whoops\Handler\PrettyPageHandler'],
        ['Core.Route', '\X\Route'],
        ['Core.Model.Database', '\X\Database\Idiorm']
    ]);

    $app->shareBatch([
        ['Core.Log', '\X\Log'],
        ['Core.View', '\X\View\LightnCandyView'],
        ['Core.Language', '\X\Language']
    ]);

    $app->boot('Core.Log')
        ->addLogger('XPHP')
        ->pushHandler('XPHP', new \Monolog\Handler\StreamHandler(
            $app->config['SysDir'] . $app->config['Path']['Log']['Info'],
            \Monolog\Logger::INFO
        ))
        ->pushHandler('XPHP', new \Monolog\Handler\StreamHandler(
            $app->config['SysDir'] . $app->config['Path']['Log']['Error'],
            \Monolog\Logger::ERROR
        ))
        ->mapEvent('Core.Log', 'XPHP', 'addInfo')
        ->mapEvent('Core.Log.Error', 'XPHP', 'addError');

    $app->boot("Core.Language");

};