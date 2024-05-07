<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use Illuminate\Http\Request;

class ClientModelController extends Controller
{
    public function index()
    {
        $clients = ClientModel::all();
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:client_models,email',
            'password' => 'required|string|min:6',
            'profession' => 'required|string|max:255',
        ]);

        $client = ClientModel::create($request->all());

        return response()->json($client, 201);
    }

    public function show($id)
    {
        $client = ClientModel::findOrFail($id);
        return response()->json($client);
    }

    public function update(Request $request, $id)
    {
        $client = ClientModel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:client_models,email,',
            'password' => 'required|string|min:6',
            'profession' => 'required|string|max:255',
        ]);

        $client->update($request->all());

        return response()->json($client, 200);
    }

    public function destroy($id)
    {
        $client = ClientModel::findOrFail($id);
        $client->delete();

        return response()->json(null, 204);
    }
}
