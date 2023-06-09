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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->get('/', [
    'as' => 'main-home', 'uses' => 'MainController@home'
]);

// ! CATEGORIES

$router->get('/categories', [
    'as' => 'category-list', 'uses' => 'CategoryController@list'
]);

$router->get('/categories/{categoryId}', 'CategoryController@item');

$router->post('/categories', 'CategoryController@add');

$router->put('/categories/{categoryId}', 'CategoryController@update');

$router->delete('/categories/{categoryId}', 'CategoryController@delete');


// ! TACHES

$router->get('/tasks', [
    'as' => 'task-list', 'uses' => 'TaskController@list'
]);

$router->get('/tasks/{taskId}', 'TaskController@item');
