<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->group(['prefix' => '/api/flights'], function () use ($router) {
    $router->get('/all', 'FlightsController@getAll');
    $router->get('/grouping', 'FlightsController@doGroup');
    $router->get('/sort', 'FlightsController@doSort');
    $router->get('/groups', 'FlightsController@groupFlights');
});

