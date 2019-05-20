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

Route::get('weeks/{week_number?}', 'MatchController@index');
Route::get('play-all/{week_number}','MatchController@playAll');

Route::post('matches/{id}', 'MatchController@update');