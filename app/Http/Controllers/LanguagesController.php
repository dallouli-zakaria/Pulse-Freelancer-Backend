<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\languages;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LanguagesController extends Controller
{
    public function index()
    {
        try {
            $languages = languages::all();
            return response()->json($languages);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch languages.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'level' => 'required|string',
                'freelancer_id'=>'required|numeric'
            ]);

            $language = languages::create($validatedData);

            return response()->json(['message' => 'Created successfully!', 'data' => $language], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create language.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $language = languages::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'string',
                'level' => 'string',
            ]);

            $language->update($validatedData);

            return response()->json(['message' => 'Updated successfully!', 'data' => $language]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update language.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $language = languages::findOrFail($id);
            return response()->json($language);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Language not found.'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $language = languages::findOrFail($id);
            $language->delete();

            return response()->json(['message' => 'Deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete language.'], 500);
        }
    }
}
