<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
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


//      public function assingRoleToUser($id){
//       $user=User::find($id);
//      $this->assingRoleToUser($user);
//      return response()->json();
//      }
 }
