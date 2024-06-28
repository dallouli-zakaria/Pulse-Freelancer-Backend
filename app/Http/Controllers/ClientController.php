<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Dotenv\Exception\ValidationException;
use App\Models\Client; 
use App\Models\User; 
use Illuminate\Support\Facades\DB;
class ClientController extends Controller
{
    public function index()
     {
        try{
            $clients = Client::with('user:id,name,email')->get();

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
                'email' => 'required|email',
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
            
            $client = Client::with('user:id,name,email')->findOrFail($id);

            return response()->json($client);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Client not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => 'nullable|string|min:6',
                'profession' => 'nullable|string|max:255',
            ]);
    
            $user = User::findOrFail($id);
            $client = Client::findOrFail($id);
    
       
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
    
          
            $client->profession = $request->profession;
            $client->save();
    
            return response()->json('updated');
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
    public function destroy($id)
    {
        try {
        

                User::where('id', $id)->delete();
        

            return response()->json(['message' => 'Client deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete client: ' . $e->getMessage()], 500);
        }
    }
    public function count(){
        $clientCount = Client::count();
        return response()->json($clientCount);
    }
}
