<?php

namespace App\Http\Controllers;

use App\Models\ClientContract;
use App\Models\Contract;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ClientContractController extends Controller
{
    public function index()
    {
        try {
            $contracts = ClientContract::orderBy('created_at', 'DESC')->get();
            return response()->json($contracts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch contracts.'], 500);
        }
    }
    public function indexPagination(Request $request){
        try {
            $page = $request->query('page', 1);
            $perPage = 8;
    
            $contracts = ClientContract::orderBy('created_at', 'DESC')
                                 ->paginate($perPage);
    
            return response()->json($contracts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

  
   
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'project_description' => 'required|string',
                'client_id' => 'required|integer',
            ]);
    
            // Rename keys to match your database columns
            $contractData = [
                'title' => $validatedData['title'],
                'start_date' => Carbon::parse($validatedData['start_date']),
                'end_date' => Carbon::parse($validatedData['end_date']), 
                'project_description' => $validatedData['project_description'],
            ];
    
            $contract = Contract::create(attributes: $contractData);
    
            // Create ClientContract entry with freelancer_id and contract_id
            ClientContract::create(attributes: [
                'client_id' => $validatedData['client_id'],
                'id' => $contract->id,
            ]);
    
            // Retrieve the client by ID
            $client = User::find($validatedData['client_id']);
    
            // Verify that the client exists
            if ($client) {
                // Send an email to the client
                Mail::send('contract-client', [
                    'contract' => $contract,
                    'formatted_start_date' => $contract->start_date->format('d/m/Y'),
                    'formatted_end_date' => $contract->end_date->format('d/m/Y'),
                ], function ($message) use ($client) {
                    $message->to($client->email)
                            ->subject('Nouveau Contrat Créé');
                });
            }
    
            return response()->json(['message' => 'Contract created successfully', 'data' => $contract], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create contract. ' . $e->getMessage()], 500);
        }
    }
    

    public function show($id)
    {
        try {
            $contract = ClientContract::findOrFail($id);
            return response()->json(['data' => $contract]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Contract not found.'], 404);
        }
    }

    public function update(Request $request, $id)
{
    try {
        $validatedData = $request->validate([
            'client_Id' => 'required|integer',

        ]);

        $contract = ClientContract::findOrFail($id);

        $contract->update($validatedData);

        return response()->json(['message' => 'Contract updated successfully', 'data' => $contract], 200);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Contract not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update contract.'], 500);
    }
}
    

    public function destroy($id)
    {
        try {
            $contract = ClientContract::findOrFail($id);
            $contract->delete();
            return response()->json(['message' => 'Contract deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete contract.'], 500);
        }
    }
}
