<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function    getAllPermission(){
        $permission=Permission::all();
        return response()->json($permission);
     }
     public function createPermission(Request $request){
        $permission=new Permission;
        $permission->name=$request->name;
        $permission->save();
        return response()->json(['message'=>'Permission had been created']);
     }
     
     public function deletePermission($id){
        $permission=Permission::find($id);
        $permission->delete();
        return response()->json(['message'=>'Permission had been deleted']);
     }
     public function assingPermissionToRole($id_role,$id_permission){
      $role=Role::find($id_role);
      $permission=Permission::find($id_permission);
  DB::table('role_permission')->insert(['role_id' => $role->id,'permission_id'=>$permission->id]);
  
  return response()->json();
     }
}
