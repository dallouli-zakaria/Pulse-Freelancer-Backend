<?php
use Illuminate\Http\Request;
use App\Http\Controllers\MailSend;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserContoller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackController;
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
use App\Http\Controllers\FreelancerSkillController;
use App\Http\Controllers\revokeRolesAndPermissions;
use App\Http\Controllers\grantRolesAndPermissionsContoller;
use App\Http\Controllers\PostSkillController;
use App\Http\Controllers\WishlistController;

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
    'role'=>RolesController::class,
    'freelancer_skills'=>FreelancerSkillController::class,
    'post_skills'=>PostSkillController::class,
    'pack'=>PackController::class
]);

//refresh token route
Route::post('refresh', [AuthController::class, 'refresh']);
// verif client post
Route::get('verify-client-post/{client_id}/{post_id}', [PostController::class, 'verifyClientPost']);
//verif freelancer offer and post
Route::get('verify-freelancer-post/{freelancer_id}/{post_id}', [OfferController::class, 'freelancerExistsInOffer']);


//sersch bar
Route::get('/searchBar',[FreelancersController::class,'searchBar']);
Route::get('/clientsearchBar',[ClientController::class,'searchBar']);
//pagination
Route::get('/freelancerPagination',[FreelancersController::class,'indexPagination']);
Route::get('/clientPagination',[ClientController::class,'indexPagination']);
Route::get('/userPagination',[UserContoller::class,'indexPagination']);
Route::get('/contractPagination',[ContractController::class,'indexPagination']);
Route::get('/postPagination',[PostController::class,'indexPagination']);

//wishlist
Route::get('/wishlist/add/{client_id}/{freelancer_id}', [WishlistController::class, 'addToWishlist']);
Route::delete('/wishlist/remove/{client_id}/{freelancer_id}', [WishlistController::class, 'removeFromWishlist']);
Route::get('/wishlist/client/{client_id}', [WishlistController::class, 'getWishlist']);
Route::get('/wishlist/client/{client_id}/freelancers', [WishlistController::class, 'getWishlistfreelancerdetails']);

//show open posts
Route::get('/posts/open/all', [PostController::class, 'showOpenPosts']);


//get posts related to freelancer:
Route::get('/posts/freelancer/{freelancer_id}', [PostController::class, 'getPostDetailsByFreelancerId']);

//get posts related to a client
Route::get('/posts/client/{client_id}', [PostController::class, 'showPostsByClient']);
Route::get('/offers/freelancer/{freelancer_id}', [OfferController::class, 'showByFreelancerId']);
Route::get('/offers/post/{post_id}', [OfferController::class, 'showByPostId']);
Route::get('/posts/post_id/{post_id}', [PostController::class, 'showByPostId']);
Route::get('/posts/{postId}/freelancers/{freelancerId}/offer', [PostController::class, 'checkFreelancerOffer']);
Route::get('/offer/freelancers/{postId}', [OfferController::class, 'getFreelancerDetailsByPostId']);
// get freelancer details from offer_id true
Route::get('/offer/freelancerTrue/{postId}', [OfferController::class, 'getFreelancerDetailsByPostIdTrue']);  
// get freelancer details from offer_id false
Route::get('/offer/freelancerFalse/{postId}', [OfferController::class, 'getFreelancerDetailsByPostIdFalse']);  
// get freelancer details from offer_id declined
Route::get('/offer/freelancerDeclined/{postId}', [OfferController::class, 'getFreelancerDetailsByPostIdDeclined']);

Route::get('/posts/{post_id}/client', [PostController::class, 'getClientDetailsByPostId']);
//show form post and freelancer ids
Route::get('offers/{post_id}/{freelancer_id}', [OfferController::class, 'showByPostAndFreelancerId']);
//check if post exists in offer:
    Route::get('/posts/{post_id}/check-offer', [PostController::class, 'checkIfOfferExists']);

//delete byfreelancerId and skillId
Route::delete('/freelancer/{freelancer_id}/skill/{skill_id}', [FreelancerSkillController::class, 'deleteSkillbyfreelancerId']);

//get posts with freelancer_id where freelancer is included and status is closeed
Route::get('/posts/closed-by-freelancer/{freelancer_id}', [PostController::class, 'getClosedPostsByFreelancer']);

//Routes for authentification


Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('user', [AuthController::class, 'user']);
    Route::get('user/{id}', [AuthController::class, 'show']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Email verification routes
    

    Route::post('email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent.']);
    })->middleware(['throttle:6,1'])->name('verification.send');
});


//email verification
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
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
Route::post('grantRoleToUser', [grantRolesAndPermissionsContoller::class, 'grantRoleToUser']);
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


Route::get('/freelancer/{freelancer_id}/skill', [FreelancerSkillController::class, 'showSkillsByFreelancerId']);
Route::get('/freelancer/{freelancer_id}/skills', [FreelancerSkillController::class, 'showSkillsByFreelancer']);
Route::get('/skills/search', [SkillsController::class, 'searchByTitle']);
Route::get('/experience/freelancer/{freelancerId}', [ExpericenceController::class, 'getByFreelancerId']);
Route::get('/details/{freelancerId}/{title}/{companyName}', [ExpericenceController::class, 'getExperienceDetails']);


//permissions tests
Route::post('/users/{userId}/permissions/{permissionName}', [grantRolesAndPermissionsContoller::class, 'assignPermissionToUser']);
Route::get('/users-with-permissionss', [grantRolesAndPermissionsContoller::class, 'getAllUsersWithPermissionss']);


Route::get('/post/{post_id}/skill', [PostSkillController::class, 'showSkillsByPostId']);
Route::get('/post/{post_id}/skills', [PostSkillController::class, 'showSkillsByPost']);


//assing skills to freelancer
Route::post('/freelancers/{id}/assign-skills', [FreelancersController::class, 'assignSkills']);
//get freelancerskills
Route::get('/freelancers/{id}/skills', [FreelancersController::class, 'getSkills']);
//get post skiils
Route::get('/posts/{id}/skills', [PostController::class, 'getSkills']);
//match skills score
Route::get('/freelancers/{freelancerId}/posts/{postId}/skills-match-score', [SkillsController::class, 'checkFreelancerSkillsMatchWithScore']);




Route::get('/freelancers/{freelancerId}/skills', [FreelancersController::class, 'getFreelancerSkills']);
Route::get('/freelancers/skills/{skillId}', [FreelancersController::class, 'getFreelancersBySkill']);
//update freelancer skills
Route::put('/freelancers/{freelancerId}/skills', [FreelancersController::class, 'updateFreelancerSkills']);
Route::get('/freelancers/{freelancerId}/matching-posts', [FreelancersController::class, 'getMatchingPostsForFreelancer']);
Route::get('/freelancers/{freelancerId}/profile', [FreelancersController::class, 'getFreelancerProfile']);



//get verified freelancers
Route::get('freelancer/verified', [FreelancersController::class, 'getVerifiedFreelancers']);


//assign pack to client
Route::post('packs/{id}/add-client', [PackController::class, 'addClientId']);


//get client details from a given pack
Route::get('packs/{id}/clients', [PackController::class, 'getClientDetails']);

//get pack details from given clientId
Route::get('/packs/client/{client_id}', [PackController::class, 'getPackByClientId']);

//remove client from pack
Route::delete('packs/{packId}/revoke-client/{clientId}', [PackController::class, 'revokeClientId']);

