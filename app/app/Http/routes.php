<?php

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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'places', 'namespace' => 'App\Http\Controllers'], function () use ($app) {
    $app->get('/', 'PlacesController@getPlaces');
    $app->get('/unbooking', 'PlacesController@getUnBookingPlaces');
});

$app->group(['prefix' => 'booking', 'namespace' => 'App\Http\Controllers'], function () use ($app) {
    $app->get('/fire', 'BookingController@getFire');
    $app->get('{id}', 'BookingController@getBooking');
    $app->post('/{id}', 'BookingController@postBooking');
});

