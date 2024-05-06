<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('freelancer')->group(function () {
    Route::get('auth', 'AdminController@dashboard');
    Route::get('login', 'AdminController@users');
    Route::get('user', 'AdminController@users');
});

Route::prefix('client')->group(function () {
    Route::get('auth', 'AdminController@dashboard');
    Route::get('login', 'AdminController@users');
    Route::get('user', 'AdminController@users');
});
