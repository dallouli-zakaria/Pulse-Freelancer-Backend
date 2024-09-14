<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions',
        ]);

        $permission = Permission::create(['name' => $request->name]);
        return response()->json($permission, 201);
    }

    public function show(Permission $permission)
    {
        return response()->json($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);
        return response()->json($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, 204);
    }




    public function getUsersWithPermission($permission)
    {
        $usersWithPermission = User::permission($permission)->get();

        return response()->json(['users_with_permission' => $usersWithPermission]);
    }



    public function getRolePermissions($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $permissions = $role->permissions;

        return response()->json(['permissions' => $permissions]);
    }



    public function getUserPermissions($userId)
    {
        $user = User::findOrFail($userId);

        $permissions = $user->permissions;

        return response()->json(['permissions' => $permissions]);
    }



    public function getUsersWithPermissions()
    {
        $usersWithPermissions = User::with('permissions')->get();

        return response()->json(['users_with_permissions' => $usersWithPermissions]);
    }


    public function getRolesWithPermissions()
    {
        $rolesWithPermissions = Role::with('permissions')->get();

        return response()->json(['roles_with_permissions' => $rolesWithPermissions]);
    }


    // Grant permission to user
    public function grantPermissionToUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $permissionName = $request->input('name');

        $user->givePermissionTo($permissionName);

        return response()->json(['message' => 'Permission granted successfully']);
    }
    
}
