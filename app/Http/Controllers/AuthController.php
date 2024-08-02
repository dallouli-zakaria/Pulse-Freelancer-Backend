<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use App\Http\Requests\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
     // Login method
     public function login(Login $request)
{
    try {
        $user = User::where('email', $request->email)->first();
        
        if ($user && $user->email_verified_at === null) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Please verify your email'
            ], 403);
        }else{
            
        $token = auth()->attempt($request->validated());
        
        if ($token) {
            return $this->responseWithToken($token);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials'
            ], 401);
        }
        }
        
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

     public function verifyEmail($id, $hash)
    {
        try {
            // Find the user by ID or fail
            $user = User::findOrFail($id);

            // Verify the hash
            if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
                return view('verify-email')->with('message', 'Invalid verification link');
            }

            // Update the email_verified_at field
            $user->email_verified_at = Carbon::now();

            if ($user->save()) {
                return view('verify-email')->with('message', 'Email verified successfully');
            } else {
                return view('verify-email')->with('message', 'Failed to update user');
            }
        } catch (ModelNotFoundException $e) {
            // Return a response for user not found
            return view('verify-email')->with('message', 'User not found');
        } catch (Exception $e) {
            // Return a response for any other errors
            return view('verify-email')->with('message', 'An error occurred: ' . $e->getMessage());
        }
    }
     // Registration method
     public function register(Register $request)
     {
         try { 
             $user = User::create($request->validated());
             if ($user) {
                 event(new Registered($user)); // Trigger the Registered event to send the email verification
 
                 $token = auth()->login($user);
                 return $this->responseWithToken($token);
             } else {
                 return response()->json([
                     'status' => 'failed',
                     'message' => 'An error has occurred while trying to create user'
                 ], 500);
             }
         } catch (Exception $e) {
             return response()->json([
                 'status' => 'error',
                 'message' => $e->getMessage()
             ], 500);
         }
     }
 
     // Return JWT access token
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
         } catch (Exception $e) {
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
         } catch (Exception $e) {
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
         } catch (Exception $e) {
             // Handle any exceptions that occur
             return response()->json([
                 'status' => 'error',
                 'message' => $e->getMessage()
             ], 500);
         }
     } 
}
