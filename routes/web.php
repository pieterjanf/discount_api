<?php
/**
 * Web routes file
 * 
 * @category Routes
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return '<img alt="nothing to see here" src="https://media.giphy.com/media/13d2jHlSlxklVe/giphy.gif" />';
});

$router->group(
    ['prefix' => '/api/v1/'],
    function() use ($router) {
        $router->get('/', function () use ($router) {
            return json_encode(
                array('version' => $router->app->version())
            );
        });

        // discounts
        $router->group(
            ['prefix' => '/discount/'],
            function() use ($router) {
                $router->post(
                    '/',
                    [
                        'as' => 'discount',
                        'uses' => 'DiscountController@postIndex'
                    ]
                );
            }
        );
    }
);