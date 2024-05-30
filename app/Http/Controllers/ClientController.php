<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Dotenv\Exception\ValidationException;
use App\Models\Client; // Add this import statement
use App\Models\User; 

class ClientController extends Controller
{
    public function index()
     {
        try{
            $clients = Client::all(); // Use the correct model name
            $clients = client::all();
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
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'profession' => 'required|string|max:255',
            ]);
    
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
    
            $client = new Client;
            $client->id = $user->id;
            $client->profession = $request->profession;
            $client->save();
            return response()->json('created');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create client: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $client = client::findOrFail($id);
            return response()->json($client);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Client not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $client = client::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:client_models,email,' . $id,
                'password' => 'required|string|min:6',
                'profession' => 'required|string|max:255',
            ]);

            $client->update($request->all());

            return response()->json($client, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update client.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();

            return response()->json(['message' => 'Client deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete client.'], 500);
        }
    }

}