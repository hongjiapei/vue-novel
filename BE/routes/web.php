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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/novel/categories', 'NovelController@categories');
$router->get('/novel/lists', 'NovelController@lists');
$router->get('/novel/detail', 'NovelController@detail');
$router->get('/novel/chapters', 'NovelController@chapters');
$router->get('/novel/chapterDetail', 'NovelController@chapterDetail');
$router->get('/novel/search', 'NovelController@search');