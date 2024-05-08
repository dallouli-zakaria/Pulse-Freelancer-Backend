<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function index()
    {
        try {
            $clients = ClientModel::all();
            return response()->json($clients);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch clients.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:client_models,email',
                'password' => 'required|string|min:6',
                'profession' => 'required|string|max:255',
            ]);

            $client = ClientModel::create($request->all());

            return response()->json($client, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create client.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $client = ClientModel::findOrFail($id);
            return response()->json($client);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Client not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $client = ClientModel::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:client_models,email,' . $id,
                'password' => 'required|string|min:6',
                'profession' => 'required|string|max:255',
            ]);

            $client->update($request->all());

            return response()->json($client, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update client.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $client = ClientModel::findOrFail($id);
            $client->delete();

            return response()->json(['message' => 'Client deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete client.'], 500);
        }
    }
}
