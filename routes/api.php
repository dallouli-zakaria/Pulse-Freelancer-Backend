<?php

use App\Http\Controllers\ClientCompanyController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientModelController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\UserContoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Routes for Posts, Freelancers and Clients
Route::resources([
    'clients' => ClientController::class,
    'freelancers' => FreelancerController::class,
    'posts' => PostController::class,
    'contract'=>ContractController::class,
    'skills'=>SkillsController::class,
    'language'=>LanguagesController::class,
]);



//Routes for user authentification
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [UserContoller::class, 'register']);
    Route::post('login', [UserContoller::class, 'login'])->name('login');
    Route::get('user', [UserContoller::class, 'user']);
    Route::get('user/{id}', [UserContoller::class, 'show']);
});



//routes for Roles

route::prefix('role')->group(function(){
    route::get('index',[RoleController::class,'getAllRole']);
    route::post('add',[RoleController::class,'createRole']);
    route::delete('delete/{id}',[RoleController::class,'deleteRole']);
    route::get('permissionRole/{id}',[RoleController::class,'permissionOfRole']);
});

//Routes for Persmissions
route::prefix('permission')->group(function(){
    route::get('index',[PermissionController::class,'getAllPermission']);
    route::post('add',[PermissionController::class,'createPermission']);
    route::delete('delete',[PermissionController::class,'deletePermission']);
    route::post('assign/{id_role}/{id_permission}',[PermissionController::class,'assingPermissionToRole']);
});


