<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserContoller extends Controller
{
     //login method
 public function login(Request $request)
 {
    //  $token =  auth()->attempt($request->validated());
    //  if ($token) {
    //      return $this->responseWithToken($token, auth()->user());
    //  } else {
    //      return response()->json([
    //          'status' => 'failed',
    //          'message' => 'invalid credentials'
    //      ], 401);
    //  }



    $credentials = $request->only('email', 'password');
    if (!Auth::attempt($credentials)) {
        return response()->json(['error' => 'Invalid email or password'], 401);
    }
    
    // Authentication successful, return success message or redirect to dashboard
    return response()->json(['message' => 'Success'], 200);

        // if (!$token = auth()->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return $this->responseWithToken($token, auth()->user());
 }

 //registration method

 public function register(Request $request)
 {
    //  $user = User::create($request->validated());
    //  if ($user) {
    //      $token = auth()->login($user);
    //      return $this->responseWithToken($token, $user);
    //  } else {
    //      return response()->json([
    //          'status' => 'failed',
    //          'message' => 'An error has accured while trying to create user'
    //      ], 500);
    //  }


     $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        return response()->json($user);

        // $token = auth()->login($user);

        // return $this->responseWithToken($token, $user);
 }

 //return JWT access token
//  public function responseWithToken($token, $user)
//  {
//      return response()->json([
//          'status' => 'success',
//          'user' => $user,
//          'access_token' => $token,
//          'type' => 'bearer'
//      ]);
//  }


 //logout method

 public function logout()
 {

    auth()->logout();

    return response()->json(['message' => 'Successfully logged out']);
 }

 public function user()
 {
    //  $user = Auth::user(); // Retrieve the authenticated user
    //  if ($user) {
    //      return response()->json([
    //          'status' => 'success',
    //          'user' => $user,
             
    //      ]);
    //  } else {
    //      return response()->json([
    //          'status' => 'failed',
    //          'message' => 'User not authenticated'
    //      ], 401);
    //  }


    $user = Auth::user();

    return response()->json(['user' => $user]);
 }

 //show user
 public function show($id)
 {
     $user = User::find($id);
     if (!$user) {
         return response()->json(['error' => 'user not found'], 404);
     }
     return response()->json($user);
 }




public function index(){
    $user=User::all();
    return response()->json($user);
}

public function store(Request $request){
    $vlaidaton=$request->validate([
       'name' =>'required|min=6',
        'email'=>'required|email',
        'password'=>[
            'required',
            'string',
            'min:8', 
            'regex:/[A-Z]/', // Must contain at least one uppercase letter
            'regex:/[a-z]/', // Must contain at least one lowercase letter
            'regex:/[0-9]/', // Must contain at least one number
        ],
    ]);
    $user=User::create($vlaidaton);
return response()->json(['message'=>$user]);
}

public function update($id,Request $request){
    $user=User::findOrFail($id);
    $vlaidaton=$request->validate([
        'name' =>'required|min=6',
         'email'=>'required|email',
         'password'=>[
             'required',
             'string',
             'min:8', 
             'regex:/[A-Z]/', // Must contain at least one uppercase letter
             'regex:/[a-z]/', // Must contain at least one lowercase letter
             'regex:/[0-9]/', // Must contain at least one number
         ],
     ]);
    $user->update($vlaidaton);

return response()->json(['message'=>'user updated']);
}
public function destroy($id){
    $user=User::findOrFail($id);
    $user->delete();
     return response()->json(['message'=>'user deleted']);
}
public function verifyId($id){
    

}
}
