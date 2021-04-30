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

$router->get('tour/getByCountry/{country}', 'TourController@getByCountry');
$router->get('tour/getByType/{type}', 'TourController@getByType');
$router->get('tour/getByMeals/{meals}', 'TourController@getByMeals');
$router->get('tour/getByHotel/{hotel}', 'TourController@getByHotel');
$router->get('tour/find/{type}[/{start_date}[/{end_date}]]', 'TourController@find');
$router->get('tour/create/{hotel_id}/{name}/{country}/{type}/{meals}/{start_date}/{end_date}', 'TourController@create');

$router->get('hotel/create/{name}/{stars}/{country}/{city}/{address}/', 'HotelController@create');
