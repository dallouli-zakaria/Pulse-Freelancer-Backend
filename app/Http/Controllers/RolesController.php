<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class RolesController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json($roles);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve roles.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:roles',
            ]);
            
            $role = Role::create(['name' => $request->name]);
            return response()->json($role, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create role.'], 500);
        }
    }

    public function show(Role $role)
    {
        try {
            return response()->json($role);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve role.'], 500);
        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:roles,name,' . $role->id,
            ]);

            $role->update(['name' => $request->name]);
            return response()->json($role);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update role.'], 500);
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete role.'], 500);
        }
    }
}
