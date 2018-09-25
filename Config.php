<?php
/**
 * XPHP Configure File
 *
 * You can add your providers here.
 *
 */

/**
 * @param \X\Application $app
 */
return function ($app) {

    $app->boot('\X\Middleware\Filter');

};