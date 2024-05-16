<?php

namespace App\Http\Controllers;

use App\Models\FreelancerModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FreelancerController extends Controller
{
    public function index()
    {
        try {
            $freelancers = FreelancerModel::all();
            return response()->json($freelancers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch freelancers.'], 500);
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

            $freelancer = FreelancerModel::create($request->all());

            return response()->json($freelancer, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create freelancer.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $freelancer = FreelancerModel::findOrFail($id);
            return response()->json($freelancer);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Freelancer not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $freelancer = FreelancerModel::findOrFail($id);
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
            $freelancer = FreelancerModel::findOrFail($id);
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
