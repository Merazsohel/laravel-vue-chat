<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('userList', 'MessageController@userList')->name('user.list');
Route::get('userMessage/{id}', 'MessageController@userMessage')->name('user.message');
Route::post('sendMessage', 'MessageController@sendMessage')->name('user.message.send');
Route::get('deleteMessage/{id}', 'MessageController@deleteMessage')->name('user.message.delete');
Route::get('deleteAllMessage/{id}', 'MessageController@deleteAllMessage')->name('user.message.allDelete');
