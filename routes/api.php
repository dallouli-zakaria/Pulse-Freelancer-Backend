<?php

use App\Http\Controllers\ClientModelController;
use App\Http\Controllers\FreelancerModelController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostModelController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserContoller;
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
route::prefix('role')->group(function(){
    route::get('index',[RoleController::class,'getAllRole']);
    route::post('add',[RoleController::class,'createRole']);
    route::delete('delete/{id}',[RoleController::class,'deleteRole']);
});
route::prefix('permission')->group(function(){
    route::get('index',[PermissionController::class,'getAllPermission']);
    route::post('add',[PermissionController::class,'createPermission']);
    route::delete('delete/{id}',[PermissionController::class,'deletePermission']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [UserContoller::class, 'register']);
    Route::post('login', [UserContoller::class, 'login'])->name('login');
    Route::get('user', [UserContoller::class, 'user']);
    Route::get('user/{id}', [UserContoller::class, 'show']);
});

