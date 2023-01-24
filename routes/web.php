<?php

use App\Http\Controllers;
use App\Models\ApiDetails\ApiDetails;
use App\Http\Controllers\FeaturedProductsController;
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

$router->group(['prefix'=>'api'],function($router){
    $router->post('store','ApiDetailsController@store');
    $router->group(['prefix'=>'product'],function($router){   //,'middleware'=>'CheckToken'
        $router->post('store','FeaturedProductsController@store');
        $router->get('edit/{id}','FeaturedProductsController@edit');
        $router->get('changeStatus/{id}/{status}','FeaturedProductsController@changeStatus');
        $router->post('update/{id}','FeaturedProductsController@update');
        $router->post('list','FeaturedProductsController@list');
        $router->get('index','FeaturedProductsController@index');



    });
});
$router->get('login','Controller@login');