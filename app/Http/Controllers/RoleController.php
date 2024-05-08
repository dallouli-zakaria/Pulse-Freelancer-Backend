<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;

class RoleController extends Controller
{
     public function    getAllRole(){
        $role=Role::all();
        return response()->json($role);
     }
     public function createRole(Request $request){
        $role=new Role;
        $role->name=$request->name;
        $role->save();
        return response()->json(['message'=>'role had been created']);
     }
     
     public function deleteRole($id){
        $role=Role::find($id);
        $role->delete();
        return response()->json(['message'=>'role had been deleted']);
     }



     public function permissionOfRole($id){
      $role = Role::find($id);

    // Check if the role exists
  

    // Retrieve the permission names associated with the role
    $permissionNames = DB::table('roles')
        ->join('role_permission', 'roles.id', '=', 'role_permission.role_id')
        ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
        ->select('permissions.name')
        ->where('roles.id', $role->id)
        ->pluck('name'); // Retrieve only the 'name' column
    // Return the permission names as a JSON response
    return response()->json($permissionNames);
  }
 }
