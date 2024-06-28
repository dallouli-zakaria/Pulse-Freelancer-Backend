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
            $freelancers = Freelancers::with('user:id,name,email')->get();
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
                'email' => 'required|email',
                'password' => 'required|string|min:6',
                'title' => 'required|string|max:255',
                'dateOfBirth' => 'required|date',
                'city' => 'required|string|max:255',
                'TJM' => 'required|numeric',
                'summary' => 'required|string',
                'availability' => 'required|string',
                'adress' => '',
                'phone' => 'required|string|max:20',
                'portfolio_Url' => '',
                'CV' => 'nullable|string',
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
            $freelancers->CV = $request->CV;
            $freelancers->save();
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
            return response()->json($freelancers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Freelancer not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => '',
                'email' => '' ,
                'password' => 'nullable|string|max:100',
                'title' => '',
                'dateOfBirth' => 'nullable|date',
                'city' => 'nullable|string|max:255',
                'TJM' => 'nullable|numeric',
                'summary' => 'nullable|string',
                'availability' => 'nullable|string',
                'adress' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'portfolio_Url' => 'nullable|url|max:255',
                'CV' => 'nullable|string',
            ]);
    
            // Find the user and freelancer by id
            $user = User::findOrFail($id);
            $freelancer = Freelancers::findOrFail($id);
    
            // Update user attributes
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
    
            // Update freelancer attributes
            $freelancer->title = $request->title;
            $freelancer->dateOfBirth = $request->dateOfBirth;
            $freelancer->city = $request->city;
            $freelancer->TJM = $request->TJM;
            $freelancer->summary = $request->summary;
            $freelancer->availability = $request->availability;
            $freelancer->adress = $request->adress;
            $freelancer->phone = $request->phone;
            $freelancer->portfolio_Url = $request->portfolio_Url;
            $freelancer->CV = $request->CV;
            $freelancer->save();
    
            return response()->json('updated');
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e], 422);
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
