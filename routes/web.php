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

Route::get('/', function () {
    return view('home');
});

Route::get('appointment','appointmentController@index');
Route::post('appointment/create','appointmentController@create');
Route::post('appointment/update','appointmentController@update');
Route::post('appointment/delete','appointmentController@destroy');
