<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class revokeRolesAndPermissions extends Controller
{
    public function RevokeRoles(Request $request,User $user, Role $role){
          
        $user=$request->userId;
       // $role=$request->roleId;

       try {
           $user->removeRole('admin');
           return response()->json(['message' => 'Role removed from user successfully'], 200);
       } catch (ModelNotFoundException $e) {
           return response()->json(['error' => 'User or role not found'], 404);
       } catch (\Exception $e) {
           return response()->json(['error' => 'Failed to remove role from user'], 500);
       }
   }


   public function removeRoleFromUser(Request $request, User $user, Role $role)
   {
       // Check if the user has the specified role
       if (!$user->hasRole($role)) {
           return response()->json(['error' => 'User does not have the specified role'], 404);
       }

       // Remove the role from the user
       $user->removeRole($role);

       return response()->json(['message' => 'Role removed from user successfully']);
   }


   public function revokePermission(Role $role, Permission $permission)
   {
       try {
           $role->revokePermissionTo($permission);
           return response()->json(['message' => 'Permission revoked from role successfully'], 200);
       } catch (ModelNotFoundException $e) {
           return response()->json(['error' => 'Role or permission not found'], 404);
       } catch (\Exception $e) {
           return response()->json(['error' => 'Failed to revoke permission from role'], 500);
       }
   }


   // public function displayrolestest(Request $request){
   //     $user = User::find($request->id);
   //     $roles = $user->roles;

   //     return response()->json($roles);

   // } 
}
