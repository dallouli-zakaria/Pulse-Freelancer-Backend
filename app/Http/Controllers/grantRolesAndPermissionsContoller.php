<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class grantRolesAndPermissionsContoller extends Controller
{
      // Create role and assign permissions to users
      public function grantRolesAndPermissions(Request $request)
      {
          try {
              $role = Role::create(['name' => $request->name]);
  
              foreach ($request->permission as $permission) {
                  $role->givePermissionTo($permission);
              }
  
              foreach ($request->users as $user) {
                  $user = User::findOrFail($user);
                  $user->assignRole($role->name);
              }
  
              return response()->json(['message' => 'Roles and permissions granted successfully']);
          } catch (\Exception $e) {
              return response()->json(['error' => 'Failed to grant roles and permissions: ' . $e->getMessage()], 500);
          }
      }
  
      // Grant permissions to role
      public function grantPermissionsToRole(Request $request)
      {
          try {
              $role = Role::where('name', $request->name)->firstOrFail();
  
              foreach ($request->permission as $permission) {
                  $role->givePermissionTo($permission);
              }
  
              return response()->json(['message' => 'Permissions granted to role successfully']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['error' => 'Role not found'], 404);
          } catch (\Exception $e) {
              return response()->json(['error' => 'Failed to grant permissions to role: ' . $e->getMessage()], 500);
          }
      }
  
      // Grant role to user
      public function grantRoleToUser(Request $request)
      {
          try {
              $role = Role::where('name', $request->name)->firstOrFail();
  
              foreach ($request->users as $user) {
                  $user = User::findOrFail($user);
                  $user->assignRole($role->name);
              }
  
              return response()->json(['message' => 'Role granted to user(s) successfully']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['error' => 'Role not found'], 404);
          } catch (\Exception $e) {
              return response()->json(['error' => 'Failed to grant role to user(s): ' . $e->getMessage()], 500);
          }
      }
}
