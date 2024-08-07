<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
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
              return response()->json($e->getMessage(), 404);
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

      public function grantPermissionsToUser(Request $request)
      {
          // Validate the incoming request
       
      
          try {
              // Fetch the user by ID
              $user = User::findOrFail($request->id);
      
              // Loop through each permission in the request
              foreach ([$request->permissions]as $permissionName) {
                  // Find the permission by its name
                  $permission = Permission::where('name', $permissionName)->firstOrFail();
      
                  // Give the permission to the user if not already assigned
                  if (!$user->hasPermissionTo($permission)) {
                      $user->givePermissionTo($permission);
                  }
              }
      
              return response()->json(['message' => 'Permissions granted to user successfully']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['error' => 'User or permission not found',$e->getMessage()], 404);
          } catch (\Exception $e) {
              return response()->json(['error' => 'Failed to grant permissions to user: ' . $e->getMessage()], 500);
          }
      }

      public function getAllUsersWithPermissions()
    {
        // Retrieve all users with their permissions
        $users = User::with('permissions')->get();

        return response()->json($users);
    }
      

    public function getUserPermissions($userId)
    {
        try {
            // Retrieve the user by ID with their permissions
            $user = User::findOrFail($userId);
            
            // Get permissions using Spatie's HasRoles trait
            $permissions = $user->getAllPermissions()->pluck('name');

            return response()->json(['permissions' => $permissions]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user permissions: ' . $e->getMessage()], 500);
        }
    }


    public function grantPermission($userId, $permissionName)
    {
        // Find the user by ID
        $user = User::findOrFail($userId);

        // Find or create the permission
        $permission = Permission::firstOrCreate(['name' => $permissionName]);

        // Assign the permission to the user
        $user->givePermissionTo($permission);

        return response()->json([
            'message' => 'Permission granted successfully.',
           
        ]);
    }
      

    public function getAllUsersWithPermissionss()
    {
        // Get all users with their permissions
        $users = User::with('permissions')->get();

        return response()->json([
            'message' => 'Users retrieved successfully.',
            'users' => $users,
        ]);
    }

    public function assignPermissionToUser(User $user, string $permissionName)
{
    try {
        // Check if the permission exists
        $permission = Permission::where('name', $permissionName)->firstOrFail();
        
        // Assign the permission to the user
        $user->givePermissionTo($permission);
        
        return true;
    } catch (\Exception $e) {
        log('Error assigning permission: ' . $e->getMessage());
        return false;
    }
}
}
