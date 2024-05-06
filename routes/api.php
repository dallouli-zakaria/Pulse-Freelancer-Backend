<?php

use App\Http\Controllers\ClientModelController;
use App\Http\Controllers\FreelancerModelController;
use App\Http\Controllers\PostModelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resources([
    'clients' => ClientModelController::class,
    'freelancers' => FreelancerModelController::class,
    'posts' => PostModelController::class,
]);