<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

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
}
