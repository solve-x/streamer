<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/users', 'UsersController@index')->name('users');
Route::get('/streams', 'StreamController@index')->name('streams');
Route::post('/streams', 'StreamController@addEdit')->name('addEditStream');

Route::get('/stream/live/{streamPart}', 'StreamController@live');

// {}