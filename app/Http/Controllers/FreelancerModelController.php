<?php

namespace App\Http\Controllers;

use App\Models\FreelancerModel;
use App\Models\User;
use Illuminate\Http\Request;

class FreelancerModelController extends Controller
{
    
    public function index()
    {
        $freelancers = FreelancerModel::all();
        return response()->json($freelancers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:freelancers,email',
            'password' => 'required|string|min:6',
            'freelancer_profession' => 'required|string|max:255',
            'freelancer_description' => 'nullable|string',
            'freelancer_city' => 'required|string|max:255',
            'freelancer_phone_number' => 'required|string|max:20',
            'freelancer_adress' => 'required|string|max:20',
            'freelancer_birth_date' => 'required|date',
            'portfolio_URL' => 'required|string|max:20',
            'CV' => '',

        ]);

        $freelancer = FreelancerModel::create($request->all());

        return response()->json($freelancer, 201);
    }

    public function show($id)
    {
        $freelancer = FreelancerModel::findOrFail($id);
        return response()->json($freelancer);
    }

    public function update(Request $request, $id)
    {
        $freelancer = FreelancerModel::findOrFail($id);
        $freelancer->update($request->all());

        return response()->json($freelancer, 200);
    }

    public function destroy($id)
    {
        $freelancer = FreelancerModel::findOrFail($id);
        $freelancer->delete();

        return response()->json(null, 204);
    }









    //assign role to freelancer
    public function assignRoleToUser($id)
        {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->assignRole('role_name'); // Replace 'role_name' with the actual role name you want to assign

            return response()->json(['message' => 'Role assigned successfully'], 200);
        }
}
