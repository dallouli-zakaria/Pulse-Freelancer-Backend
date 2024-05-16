<?php

use Illuminate\Http\Request;
use App\Http\Controllers\MailSend;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserContoller;

use App\Http\Controllers\PostController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\ContractController;

use App\Http\Controllers\EducationController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ExpericenceController;
use App\Http\Controllers\FreelancersController;
use App\Http\Controllers\revokeRolesAndPermissions;
use App\Http\Controllers\grantRolesAndPermissionsContoller;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





//Routes for Posts, Freelancers and Clients
Route::resources([
    'clients' => ClientController::class,
    'freelancers' => FreelancersController::class,
    'posts' => PostController::class,
    'client-company'=>ClientController::class,
    'contract'=>ContractController::class,
    'skills'=>SkillsController::class,
    'language'=>LanguagesController::class,
    'experience'=>ExpericenceController::class,
    'offers'=>OfferController::class,
    'education'=>EducationController::class,

]);

//Routes for user authentification
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [UserContoller::class, 'register']);
    Route::post('login', [UserContoller::class, 'login'])->name('login');
    Route::get('user', [UserContoller::class, 'user']);
    Route::get('user/{id}', [UserContoller::class, 'show']);
});




//ROLES AND PERMISSIONS 
//manage roles and permissions
Route::apiResource('permissions', PermissionController::class);
Route::apiResource('roles', RolesController::class);
Route::apiResource('roles', RolesController::class);

//grant roles and permissions to user
Route::get('grantRolesAndPermissions', [grantRolesAndPermissionsContoller::class, 'grantRolesAndPermissions']);
Route::get('grantPermissionsToRole', [grantRolesAndPermissionsContoller::class, 'grantPermissionsToRole']);
Route::get('grantRoleToUser', [grantRolesAndPermissionsContoller::class, 'grantRoleToUser']);


//delete roles and permissions
Route::delete('/users/{user}/roles/{role}', [revokeRolesAndPermissions::class, 'removeRoleFromUser']);
Route::delete('roles/{role}/permissions/{permission}', [RevokeRolesAndPermissions::class, 'revokePermission']);



//Route::get('RevokeRolesAndPermissions', [RevokeRolesAndPermissions::class, 'RevokeRoles']);
//email seder
Route::post('email',[MailSend::class,'send']);

















//routes for Roles

route::prefix('role')->group(function(){
    route::get('index',[RolesController::class,'getAllRole']);
    route::post('add',[RolesController::class,'createRole']);
    route::delete('delete/{id}',[RolesController::class,'deleteRole']);
    route::get('permissionRole/{id}',[RolesController::class,'permissionOfRole']);
});

//Routes for Persmissions
route::prefix('permission')->group(function(){
    route::get('index',[PermissionController::class,'getAllPermission']);
    route::post('add',[PermissionController::class,'createPermission']);
    route::delete('delete',[PermissionController::class,'deletePermission']);
    route::post('assign/{id_role}/{id_permission}',[PermissionController::class,'assingPermissionToRole']);
});


