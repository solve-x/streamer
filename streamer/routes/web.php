<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/users', 'UsersController@index')->name('users');
Route::get('/streams', 'StreamController@index')->name('streams');

Route::get('/streams/createEdit/{id?}', 'StreamController@createEdit')->name('createEditStream');
Route::post('/streams/createEdit/{id?}', 'StreamController@postCreateEdit')->name('postCreateEditStream');

Route::post('/streams', 'StreamController@addEdit')->name('addEditStream');
Route::delete('/streams/{id}', 'StreamController@deleteStream')->name('deleteStream');
Route::post('/streams/{key}/isLive', 'StreamController@isLive')->name('isStreamLive');

Route::get('/stream/live/{streamPart}', 'StreamController@live');

// {}