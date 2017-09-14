<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/stream/live/{streamPart}', 'StreamController@live');

// {}