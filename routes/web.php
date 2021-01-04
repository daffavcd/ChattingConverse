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
Route::get('/', 'Chat\ChatController@index');
Route::get('/showContact/{id}', 'Chat\ChatController@showContact');
Route::resource('chat', 'Chat\ChatController');
Route::get('/chat/{id}/showMessages', 'Chat\ChatController@showMessages');
Route::get('/findContact/{key}', 'Chat\ChatController@findContact');

Route::group(['middleware' => 'auth'], function () {
    Route::get('profile', 'ProfileController@edit')->name('profile.edit');
    Route::patch('profile', 'ProfileController@update')->name('profile.update');
});