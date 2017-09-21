<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/users', 'UsersController@index')->name('users');
Route::get('/users/createEdit/{id?}', 'UsersController@createEdit')->name('createEditUser');
Route::post('/users/createEdit/{id?}', 'UsersController@postCreateEdit')->name('postCreateEditUser');

Route::get('/streams', 'StreamController@index')->name('streams');
Route::get('/streams/createEdit/{id?}', 'StreamController@createEdit')->name('createEditStream');
Route::post('/streams/createEdit/{id?}', 'StreamController@postCreateEdit')->name('postCreateEditStream');

Route::post('/streams', 'StreamController@addEdit')->name('addEditStream');
Route::delete('/streams/{id}', 'StreamController@deleteStream')->name('deleteStream');
Route::post('/streams/{key}/isLive', 'StreamController@isLive')->name('isStreamLive');

Route::get('/streams/{key}/live', 'StreamController@live')->name('liveStream');
Route::get('/streams/live/{streamPart}', 'StreamController@liveParts')->name('liveStreamParts');

// {}