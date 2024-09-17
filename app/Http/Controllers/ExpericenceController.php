<?php

namespace App\Http\Controllers;

use App\Models\Expericence;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExpericenceController extends Controller
{

    public function index()
    {
        try {
            $expericence = Expericence::all();
            return response()->json($expericence);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch expericence.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([

                'title' => 'required|string',
                'companyName' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'startDate' => 'required|date',
                'endDate' => 'required|date',
                'description' => 'required|string',
                'freelancer_id'=>'required|numeric'
            ]);

            $expericence = Expericence::create($validatedData);
            return response()->json($expericence, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function show($id)
    {
        try {
            $expericence = Expericence::findOrFail($id);
            return response()->json($expericence);
        } catch (\Exception $e) {
            return response()->json(['error' => 'expericence not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'companyName' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'startDate' => 'required|date',
                'endDate' => 'required|date',
                'description' => 'required|string'
            ]);

            $expericence = Expericence::findOrFail($id);
            $expericence->update($validatedData);

            return response()->json($expericence);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update expericence.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $expericence = Expericence::findOrFail($id);
            $expericence->delete();
            return response()->json(['message' => 'expericence deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete expericence.'], 500);
        }
    }




    public function getByFreelancerId($freelancerId)
    {
        try {
            $experiences = Expericence::where('freelancer_id', $freelancerId)->orderBy('created_at', 'desc')->get();
            
            if ($experiences->isEmpty()) {
                return response()->json(['message' => 'No experiences found for this freelancer.'], 404);
            }
            
            return response()->json($experiences);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch experiences for the freelancer.'], 500);
        }
    }

    public function getExperienceDetails($freelancer_id, $title, $companyName)
    {
        try {
            $experience = Expericence::where('freelancer_id', $freelancer_id)
                ->where('title', $title)
                ->where('companyName', $companyName)
                ->first();
            
            if (!$experience) {
                return response()->json(['message' => 'Experience not found.'], 404);
            }
            
            return response()->json($experience);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch experience details.'], 500);
        }
    }



}


