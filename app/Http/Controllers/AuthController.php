<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Http\Requests\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
       // Login method
       public function login(Login $request)
       {
           try {
               $token = auth()->attempt($request->validated());
               if ($token) {
                   return $this->responseWithToken($token);
               } else {
                   return response()->json([
                       'status' => 'failed',
                       'message' => 'Invalid credentials'
                   ], 401);
               }
           } catch (\Exception $e) {
               return response()->json([
                   'status' => 'error',
                   'message' => $e->getMessage()
               ], 500);
           }
       }
   
       // Registration method
       public function register(Register $request)
       {
           try {
               $user = User::create($request->validated());
               if ($user) {
                   $token = auth()->login($user);
                   return $this->responseWithToken($token);
               } else {
                   return response()->json([
                       'status' => 'failed',
                       'message' => 'An error has occurred while trying to create user'
                   ], 500);
               }
           } catch (\Exception $e) {
               return response()->json([
                   'status' => 'error',
                   'message' => $e->getMessage()
               ], 500);
           }
       }
   
       // Return JWT access token
    //    public function responseWithToken($token, $user)
    //    {
    //        return response()->json([
    //            'status' => 'success',
    //            'user' => $user,
    //            'access_token' => $token,
    //            'type' => 'bearer'
    //        ]);
    //    }


       public function responseWithToken($token)
       {
           return response()->json([
               'status' => 'success',
               'access_token' => $token,
               'type' => 'bearer'
           ]);
       }
   
       // Logout method
       public function logout()
       {
           try {
               auth()->logout();
               return response()->json(['message' => 'Successfully logged out']);
           } catch (\Exception $e) {
               return response()->json([
                   'status' => 'error',
                   'message' => $e->getMessage()
               ], 500);
           }
       }
   
       public function user()
       {
        try {
            $user = Auth::user(); // Retrieve the authenticated user
    
            if (!$user) {
                return response()->json([
                    'error' => 'User not found'
                ], 404);
            }
    
            // Load roles eagerly to avoid N+1 query problem
            $userWithRoles = User::with('roles')->find($user->id);
    
            // Extract role names from the loaded relationship
            $roles = $userWithRoles->roles->pluck('name');
    
            // Return JSON response with user and roles
            return response()->json([
                'user' => $userWithRoles,
                'roles' => $roles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch user roles',
                'message' => $e->getMessage()
            ], 500);
        }
       }
   
       // Show user
       public function show($id)
{
    try {
        // Fetch the user data by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get the roles associated with the user
        $roles = $user->getRoleNames(); // This returns a collection of role names

        // Prepare the response data
        $responseData = [
            'user' => $user,
            'roles' => $roles
        ];

        // Return the combined response data as JSON
        return response()->json($responseData);
    } catch (\Exception $e) {
        // Handle any exceptions that occur
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}



       
}
