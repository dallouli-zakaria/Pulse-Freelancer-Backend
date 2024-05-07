<?php

namespace App\Http\Controllers;

use App\Models\Client_Company;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientCompanyController extends Controller
{
    public function index()
    {
        try {
            $clients = Client_Company::all();
            return response()->json($clients);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch client companies.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'field' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'email' => 'required|email|max:255',
                'ICE' => 'required|string|max:255',
                'adresse' => 'required|string|max:255',
                'website' => 'nullable|string|max:255',
            ]);

            $clientCompany = Client_Company::create($validatedData);

            return response()->json(['message' => 'Client company created successfully', 'data' => $clientCompany], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create client company.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $clientCompany = Client_Company::findOrFail($id);
            return response()->json(['data' => $clientCompany]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Client company not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'string|max:255',
                'field' => 'string|max:255',
                'phone_number' => 'string|max:20',
                'email' => 'email|max:255|unique:client_companies,email,' . $id,
                'ICE' => 'string|max:255|unique:client_companies,ICE,' . $id,
                'adresse' => 'string|max:255',
                'website' => 'nullable|string|max:255',
            ]);

            $clientCompany = Client_Company::findOrFail($id);
            if (!$clientCompany) {
                return response()->json(['error' => 'Client company not found'], 404);
            }
            $clientCompany->update($validatedData);

            return response()->json(['message' => 'Client company updated successfully', 'data' => $clientCompany]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update client company.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $clientCompany = Client_Company::findOrFail($id);
            $clientCompany->delete();

            return response()->json(['message' => 'Client company deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete client company.'], 500);
        }
    }
}
