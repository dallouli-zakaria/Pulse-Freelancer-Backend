<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EducationController extends Controller
{
    public function index()
    {
        try {
            $education = Education::all();
            return response()->json(['data' => $education]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch education.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'startDate' => 'required|date',
                'endDate' => 'required|date',
                'institution' => 'required|string',
                'city' => 'required|string'
            ]);

            $education = Education::create($validatedData);
            return response()->json(['message' => 'Education created successfully', 'data' => $education], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create education.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $education = Education::findOrFail($id);
            return response()->json(['data' => $education]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Education not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'startDate' => 'required|date',
                'endDate' => 'required|date',
                'institution' => 'required|string',
                'city' => 'required|string'
            ]);

            $education = Education::findOrFail($id);
            $education->update($validatedData);

            return response()->json(['message' => 'Education updated successfully', 'data' => $education]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update education.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $education = Education::findOrFail($id);
            $education->delete();
            return response()->json(['message' => 'Education deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete education.'], 500);
        }
    }
}
