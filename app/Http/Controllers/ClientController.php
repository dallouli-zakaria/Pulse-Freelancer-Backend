<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Dotenv\Exception\ValidationException;
use App\Models\Client; 
use App\Models\User; 
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    public function index()
     {
        try{
            $clients = Client::with('user:id,name,email')->orderBy('created_at', 'DESC')->get();

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
                'profession' => 'nullable|string|max:255',
                'company_name' => 'nullable|string|max:255',
                'company_activity' => 'nullable|string|max:255',
                'company_email' => 'nullable|email',
            ]);
    
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
    
            $client = new Client;
            $client->id = $user->id;
            $client->profession = $request->profession;
            $client->company_name = $request->company_name;
            $client->company_activity = $request->company_activity;
            $client->company_email = $request->company_email;
            $client->save();
            
            $user->assignRole('client_role');

            // $role = Role::where('name', $request->name)->firstOrFail();
  
            // foreach ($request->users as $user) {
            //     $user = Client::findOrFail($user);
            //     $user->assignRole($role->name);
            // }
            return response()->json('created');
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
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
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6',
                'profession' => 'nullable|string|max:255',
                'company_name' => 'nullable|string|max:255',
                'company_activity' => 'nullable|string|max:255',
                'company_email' => 'nullable|email',
            ]);
    
            $user = User::findOrFail($id);
            $client = Client::findOrFail($id);
    
       
            // $user->name = $request->name;
            // $user->email = $request->email;
            // if ($request->password) {
            //     $user->password = Hash::make($request->password);
            // }
            // $user->save();
    
          
            // $client->profession = $request->profession;
            // $client->company_name = $request->company_name;
            // $client->company_activity = $request->company_activity;
            // $client->company_email = $request->company_email;
            // $client->save();
    

            // Update user fields only if they are provided in the request
            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update client fields only if they are provided in the request
            if ($request->has('profession')) {
                $client->profession = $request->profession;
            }
            if ($request->has('company_name')) {
                $client->company_name = $request->company_name;
            }
            if ($request->has('company_activity')) {
                $client->company_activity = $request->company_activity;
            }
            if ($request->has('company_email')) {
                $client->company_email = $request->company_email;
            }
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
