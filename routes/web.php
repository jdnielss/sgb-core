<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'member'], function () {
   Route::get('/join', function () {
       return view('join');
   });
    Route::get('/rejoin', function () {
        return view('rejoin');
    });
});
