<?php

namespace App\Http\Controllers;

use App\Models\User; 

use App\Models\Client; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Dotenv\Exception\ValidationException;

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


    public function indexPagination(Request $request)
    {
        try {
            $page = $request->query('page', 1);
            $perPage = 7;
    
            $freelancers = Client::with('user:id,name,email')
                                      ->orderBy('created_at', 'DESC')
                                      ->paginate($perPage);
    
            return response()->json($freelancers);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchBar() {
        try {
            if (isset($_GET['query'])) {
                $search_bar_input = $_GET['query'];
                $clients = Client::join('users', 'users.id', '=', 'clients.id')
                              ->orderBy('clients.id', 'DESC')
                              ->where(function($query) use ($search_bar_input) {
                                  $query->where('users.name', 'LIKE', $search_bar_input . '%')
                                        ->orWhere('users.email', 'LIKE', $search_bar_input . '%');
                              })
                              ->select('clients.*', 'users.name', 'users.email')->with('user')
                              ->get();
            } else {
                $clients = Client::join('users', 'users.id', '=', 'clients.id')
                              ->orderBy('clients.id', 'DESC')
                              ->select('clients.*', 'users.name', 'users.email')->with('user')
                              ->get();
            }
            return response()->json($clients, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // Database-related error
            return response()->json(['error' => 'Database query error', 'message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // General error
            return response()->json(['error' => 'An unexpected error occurred', 'message' => $e->getMessage()], 500);
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
            event(new Registered($user));
    
            $client = new Client;
            $client->id = $user->id;
            $client->profession = $request->profession;
            $client->company_name = $request->company_name;
            $client->company_activity = $request->company_activity;
            $client->company_email = $request->company_email;
            $client->save();
            
            $user->assignRole('client_role');


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
                'email_verified_at'=> 'nullable|string',
            ]);
    
            $user = User::findOrFail($id);
            $client = Client::findOrFail($id);
    
       

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

            if ($request->has('email_verified_at')) {
                $user->email_verified_at = $request->email_verified_at;
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
