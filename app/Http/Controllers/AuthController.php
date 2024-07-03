<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{


    // Login method
    public function login(LoginRequest $request)
    {
        try {
            $token = auth()->attempt($request->validated());
            if ($token) {
                return $this->responseWithToken($token, auth()->user());
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
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            if ($user) {
                $token = auth()->login($user);
                return $this->responseWithToken($token, $user);
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
    public function responseWithToken($token, $user)
    {
        return response()->json([
            'status' => 'success',
            'user' => $user,
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
            if ($user) {
                return response()->json([
                    'status' => 'success',
                    'user' => $user,
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not authenticated'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Show user
    public function show($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
