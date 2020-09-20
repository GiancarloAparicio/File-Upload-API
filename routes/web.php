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

//Version: 1.0.0   --   Path: api/v1/...
$router->group(['prefix' => 'api/v1'], function () use ($router) {

    //Router: file
    $router->group(['prefix' => 'file'], function () use ($router) {

        //Store resource
        $router->post('/photo', [
            'uses' => 'FileController@store',
            'as' => 'photo.store'
        ]);

        $router->post('/music', [
            'uses' => 'FileController@store',
            'as' => 'music.store'
        ]);

        $router->post('/video', [
            'uses' => 'FileController@store',
            'as' => 'video.store'
        ]);

        //Show resource
        $router->get('/photo/{id}', [
            'uses' => 'FileController@show',
            'as' => 'photo.show'
        ]);

        $router->get('/music/{id}', [
            'uses' => 'FileController@show',
            'as' => 'music.show'
        ]);

        $router->get('/video/{id}', [
            'uses' => 'FileController@show',
            'as' => 'video.show'
        ]);

        //Update resource
        $router->post('/photo/{id}', [
            'uses' => 'FileController@update',
            'as' => 'photo.update'
        ]);

        $router->post('/music/{id}', [
            'uses' => 'FileController@update',
            'as' => 'music.update'
        ]);
        $router->post('/video/{id}', [
            'uses' => 'FileController@update',
            'as' => 'video.update'
        ]);

        //Delete resource
        $router->delete('/photo/{id}', [
            'uses' => 'FileController@destroy',
            'as' => 'photo.destroy'
        ]);
        $router->delete('/music/{id}', [
            'uses' => 'FileController@destroy',
            'as' => 'music.destroy'
        ]);
        $router->delete('/video/{id}', [
            'uses' => 'FileController@destroy',
            'as' => 'video.destroy'
        ]);
    });
});
