<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Pack;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $pack=Pack::all();
      return response()->json($pack);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'client_ids' => 'nullable|array'
        ]);

        $pack = Pack::create($validation);
        
        return response()->json(['message' => 'Pack created', 'pack' => $pack], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $pack = Pack::findOrFail($id);
            return response()->json($pack);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pack not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch pack.'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $pack = Pack::findOrFail($id);
            
            $validation = $request->validate([
                'title' => 'sometimes|required|string',
                'description' => 'sometimes|required|string',
                'price' => 'nullable|numeric',
                'client_ids' => 'nullable|array'
            ]);

            $pack->update($validation);
            
            return response()->json(['message' => 'Pack updated', 'pack' => $pack]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pack not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update pack.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pack = Pack::findOrFail($id);
            $pack->delete();

            return response()->json(['message' => 'Pack deleted.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pack not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete pack: ' . $e->getMessage()], 500);
        }
    }



    public function addClientId(Request $request, $id)
    {
        try {
            $request->validate([
                'client_id' => 'required|integer'
            ]);

            $pack = Pack::findOrFail($id);
            
            // Check if the client exists
            $client = Client::findOrFail($request->client_id);

            $clientIds = $pack->client_ids ?? [];
            
            if (!in_array($client->id, $clientIds)) {
                $clientIds[] = $client->id;
                $pack->client_ids = $clientIds;
                $pack->save();

                return response()->json([
                    'message' => 'Client ID added successfully',
                    'pack' => $pack
                ]);
            }

            return response()->json([
                'message' => 'Client ID already exists in the pack',
                'pack' => $pack
            ]);

        } catch (ModelNotFoundException $e) {
            if ($e->getModel() === Client::class) {
                return response()->json(['error' => 'Client not found.'], 404);
            }
            return response()->json(['error' => 'Pack not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add client ID: ' . $e->getMessage()], 500);
        }
    }



    public function getClientDetails($id)
    {
        try {
            $pack = Pack::findOrFail($id);
            
            $clientIds = $pack->client_ids ?? [];
            
            $clients = Client::whereIn('id', $clientIds)->get();

            return response()->json([
                'pack' => $pack,
                'clients' => $clients
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pack not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve client details: ' . $e->getMessage()], 500);
        }
    }

    public function getPackByClientId($client_id)
    {
        try {
            // Fetch the packs associated with the given client_id
            $packs = Pack::whereJsonContains('client_ids', $client_id)
                ->get()
                ->map(function ($pack) {
                    return [
                        'id' => $pack->id,
                        'title' => $pack->title,
                        'description' => $pack->description,
                        'price' => $pack->price,
                        'client_ids' => $pack->client_ids,
                        'created_at' => $pack->created_at,
                        'updated_at' => $pack->updated_at,
                    ];
                });
    
            return response()->json($packs);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve packs: ' . $e->getMessage()], 500);
        }
    }

    public function revokeClientId($packId, $clientId)
    {
        try {
            $pack = Pack::findOrFail($packId);
            $client = Client::findOrFail($clientId);

            $clientIds = $pack->client_ids ?? [];
            
            if (($key = array_search($clientId, $clientIds)) !== false) {
                unset($clientIds[$key]);
                $pack->client_ids = array_values($clientIds);  // Re-index the array
                $pack->save();

                return response()->json([
                    'message' => 'Client ID revoked successfully from the pack',
                    'pack' => $pack
                ]);
            }

            return response()->json([
                'message' => 'Client ID was not found in the pack',
                'pack' => $pack
            ]);

        } catch (ModelNotFoundException $e) {
            if ($e->getModel() === Client::class) {
                return response()->json(['error' => 'Client not found.'], 404);
            }
            return response()->json(['error' => 'Pack not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to revoke client ID: ' . $e->getMessage()], 500);
        }
    }




}
