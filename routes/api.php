<?php

use App\Http\Controllers\AuthController;
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
// use App\Http\Controllers\LanguagesController;

// use App\Http\Controllers\OfferController;

// use App\Http\Controllers\MailSend;

// use App\Http\Controllers\PermissionController;
// use App\Http\Controllers\PostController;
// use App\Http\Controllers\revokeRolesAndPermissions;

// use App\Http\Controllers\RolesController;
// use App\Http\Controllers\SkillsController;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





//Main routes 
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
    'users'=>UserContoller::class,
    'role'=>RolesController::class

]);



//get posts related to a client
Route::get('/posts/client/{client_id}', [PostController::class, 'showPostsByClient']);
Route::get('/offers/freelancer/{freelancer_id}', [OfferController::class, 'showByFreelancerId']);
Route::get('/posts/post_id/{post_id}', [PostController::class, 'showByPostId']);
Route::get('/posts/{postId}/freelancers/{freelancerId}/offer', [PostController::class, 'checkFreelancerOffer']);



//Routes for authentification

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('user', [AuthController::class, 'user']);
    Route::get('user/{id}', [AuthController::class, 'show']);
});


//count 
Route::get('clientCount',[ClientController::class,'count']);
Route::get('contractCount',[ContractController::class,'count']);
Route::get('freelancerCount',[FreelancersController::class,'count']);
Route::get('postCount',[PostController::class,'count']);

//ROLES AND PERMISSIONS 
//manage roles and permissions
Route::apiResource('permissions', PermissionController::class);
Route::apiResource('roles', RolesController::class);

//grant roles and permissions to user
Route::post('grantRolesAndPermissions', [grantRolesAndPermissionsContoller::class, 'grantRolesAndPermissions']);
Route::post('/grantPermissionsToRole', [grantRolesAndPermissionsContoller::class, 'grantPermissionsToRole']);
Route::get('grantRoleToUser', [grantRolesAndPermissionsContoller::class, 'grantRoleToUser']);
Route::post('/user/{userId}/grant-permission', [PermissionController::class, 'grantPermissionToUser']);

//tests
Route::post('/grantPermissionsToUser', [grantRolesAndPermissionsContoller::class, 'grantPermissionsToUser']);
Route::get('/users-with-permissions', [grantRolesAndPermissionsContoller::class, 'getAllUsersWithPermissions']);

//delete roles and permissions
Route::delete('/users/{user}/roles/{role}', [revokeRolesAndPermissions::class, 'removeRoleFromUser']);
Route::delete('roles/{role}/permissions/{permission}', [RevokeRolesAndPermissions::class, 'revokePermission']);


//ROLES
//get all roles for one user
Route::get('/user/{userId}/roles', [RolesController::class, 'getUserRoles']);
//get users with a given role 
Route::get('/users/role/{roleName}', [RolesController::class, 'getUsersWithRole']);
//get all users with their role
Route::get('/user/roles', [RolesController::class, 'getAllUserRoles']);

//PERMISSIONS

//get all users with given permission
Route::get('/users/with-permission/{permission}', [PermissionController::class, 'getUsersWithPermission']);
//get all permissions with a given user !! changed
Route::get('/user/{userId}/permissions', [grantRolesAndPermissionsContoller::class, 'getUserPermissions']);
//get all users with their permissions
Route::get('/allusers/with-permissions', [PermissionController::class, 'getUsersWithPermissions']);
//get all permissions with a given role
Route::get('/role/{roleName}/permissions', [PermissionController::class, 'getRolePermissions'] );
//get all roles with their permissions
Route::get('/get-roles/with-permissions', [PermissionController::class, 'getRolesWithPermissions']);


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


