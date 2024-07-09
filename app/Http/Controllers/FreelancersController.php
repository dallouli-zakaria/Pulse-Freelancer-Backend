<?php

namespace App\Http\Controllers;

use App\Models\Freelancers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
class FreelancersController extends Controller
{
    public function index()
    {
        try {
            $freelancers = Freelancers::with('user:id,name,email')->orderBy('created_at', 'DESC')->get();
            
            return response()->json($freelancers);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'title' => 'nullable|string|max:255',
                'dateOfBirth' => 'nullable|date',
                'city' => 'nullable|string|max:255',
                'TJM' => 'nullable|numeric',
                'summary' => 'nullable|string',
                'availability' => 'nullable|string',
                'adress' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'portfolio_Url' => 'nullable|url|max:255',
                'status'=> 'nullable|string'
            ]);
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
    
            $freelancers = new Freelancers;
            $freelancers->id = $user->id;
            $freelancers->title = $request->title;
            $freelancers->dateOfBirth = $request->dateOfBirth;
            $freelancers->city = $request->city;
            $freelancers->TJM = $request->TJM;
            $freelancers->summary = $request->summary;
            $freelancers->availability = $request->availability;
            $freelancers->adress = $request->adress;
            $freelancers->phone = $request->phone;
            $freelancers->portfolio_Url = $request->portfolio_Url;
            $freelancers->status= $request->status;
            $freelancers->save();
            $user->assignRole('freelancer_role');
            return response()->json('created');
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function show($id)
    {
        try {
            $freelancers = Freelancers::with('user:id,name,email')->findOrFail($id);
            
    
            // Return the combined response data as JSON
            return response()->json($freelancers);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Freelancer not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6',
                'title' => 'nullable|string|max:255',
                'dateOfBirth' => 'nullable|date',
                'city' => 'nullable|string|max:255',
                'TJM' => 'nullable|numeric',
                'summary' => 'nullable|string',
                'availability' => 'nullable|string',
                'adress' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'portfolio_Url' => 'nullable|url|max:255',
                'status'=>'nullable|string'
            ]);
    
            // Find the user and freelancer by id
            $user = User::findOrFail($id);
            $freelancer = Freelancers::findOrFail($id);
    
           // Update user fields only if they are provided in the request
            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update freelancer fields only if they are provided in the request
            if ($request->has('title')) {
                $freelancer->title = $request->title;
            }
            if ($request->has('dateOfBirth')) {
                $freelancer->dateOfBirth = $request->dateOfBirth;
            }
            if ($request->has('city')) {
                $freelancer->city = $request->city;
            }
            if ($request->has('TJM')) {
                $freelancer->TJM = $request->TJM;
            }
            if ($request->has('summary')) {
                $freelancer->summary = $request->summary;
            }
            if ($request->has('availability')) {
                $freelancer->availability = $request->availability;
            }
            if ($request->has('adress')) {
                $freelancer->adress = $request->adress;
            }
            if ($request->has('phone')) {
                $freelancer->phone = $request->phone;
            }
            if ($request->has('portfolio_Url')) {
                $freelancer->portfolio_Url = $request->portfolio_Url;
            }
            if ($request->has('status')) {
                $freelancer->status = $request->status;
            }
            $freelancer->save();
    
            return response()->json('updated');
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function destroy($id)
    {
        try {
       
                User::where('id', $id)->delete();
         

            return response()->json(['message' => 'Freelancer and associated user deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete freelancer: ' . $e->getMessage()], 500);
        }
    }

    public function assignRoleToUser($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->assignRole('role_name'); // Replace 'role_name' with the actual role name you want to assign

            return response()->json(['message' => 'Role assigned successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to assign role to user.'], 500);
        }
    }

    public function count(){
        $freelancer=Freelancers::count();
        return response()->json($freelancer);
    }
}
