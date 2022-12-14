<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return $router->app->version();
});

$router->post('todo/create', ['uses' => 'TodoController@create']);
$router->get('todo', ['uses' => 'TodoController@findAll']);
$router->get('todo/{id}', ['uses' => 'TodoController@findById']);
$router->put('todo/{id}', ['uses' => 'TodoController@update']);
$router->delete('todo/{id}', ['uses' => 'TodoController@delete']);
