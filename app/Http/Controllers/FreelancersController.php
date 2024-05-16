<?php

namespace App\Http\Controllers;

use App\Models\Freelancers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class FreelancersController extends Controller
{
    public function index()
    {
        try {
            $freelancers = Freelancers::all();
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
                'title' => 'required|string|max:255',
                'dateOfBirth' => 'required|date',
                'city' => 'required|string|max:255',
                'TJM' => 'required|numeric',
                'summary' => 'required|string',
                'availability' => 'required|string',
                'adress' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'portfolio_Url' => 'nullable|url|max:255',
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
            $freelancer = Freelancers::findOrFail($id);
            return response()->json($freelancer);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Freelancer not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $freelancer = Freelancers::findOrFail($id);
            $freelancer->update($request->all());

            return response()->json($freelancer, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update freelancer.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $freelancer = Freelancers::findOrFail($id);
            $freelancer->delete();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete freelancer.'], 500);
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
}
