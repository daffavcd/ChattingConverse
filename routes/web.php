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
Auth::routes();
Route::get('/','Chat\ChatController@index');
Route::get('/showContact/{id}','Chat\ChatController@showContact');
Route::resource('chat', 'Chat\ChatController');
Route::get('/chat/{id}/showMessages','Chat\ChatController@showMessages');

