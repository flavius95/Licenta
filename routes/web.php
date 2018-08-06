<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', 'SaveController@save');
//Route::get('urls', 'UrlsController@index');
//Route::get('url/{id}', 'UrlsController@show');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/url/create', 'SaveController@create');
Route::post('/url/save', 'SaveController@store')->name('save');
