<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Freelancers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContractController extends Controller
{
    public function index()
    {
        try {
            $contracts = Contract::orderBy('created_at', 'DESC')->get();
            return response()->json($contracts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch contracts.'], 500);
        }
    }
    public function indexPagination(Request $request){
        try {
            $page = $request->query('page', 1);
            $perPage = 8;
    
            $contracts = Contract::orderBy('created_at', 'DESC')
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
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
                'project_description' => 'required|string',
                'client_id' => 'required|integer',
                'freelancer_id' => 'required|integer',
            ]);
    
            // Rename keys to match your database columns
            $contractData = [
                'title' => $validatedData['title'],
                'start_date' => Carbon::parse($validatedData['startDate']),
                'end_date' => Carbon::parse($validatedData['endDate']),
                'project_description' => $validatedData['project_description'],
                'client_id' => $validatedData['client_id'],
                'freelancer_id' => $validatedData['freelancer_id'],
            ];
    
            $contract = Contract::create($contractData);
    
            // Récupérer le client et le freelancer
            $client = User::find($contractData['client_id']);
            $freelancer = User::find($contractData['freelancer_id']);
    
            // Vérifier que le client et le freelancer existent
            if ($client && $freelancer) {
                // Envoyer l'email au client et au freelancer
                Mail::send('contract', [
                    'contract' => $contract,
                    'formatted_start_date' => $contract->start_date->format('d/m/Y'),
                    'formatted_end_date' => $contract->end_date->format('d/m/Y'),
                ], function ($message) use ($client, $freelancer) {
                    $message->to($client->email)
                            ->subject('Nouveau Contrat Créé');
                    $message->cc($freelancer->email)
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
            $contract = Contract::findOrFail($id);
            return response()->json(['data' => $contract]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Contract not found.'], 404);
        }
    }

    public function update(Request $request, $id)
{
    try {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'project_description' => 'required|string',
            'client_id' => 'nullable|integer',
            'freelancer_id' => 'nullable|integer',
        ]);

        $contract = Contract::findOrFail($id);

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
            $contract = Contract::findOrFail($id);
            $contract->delete();
            return response()->json(['message' => 'Contract deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete contract.'], 500);
        }
    }


        // Show contracts by freelancer_id
        public function showByFreelancer($freelancer_id)
        {
            try {
                $contracts = Contract::where('freelancer_id', $freelancer_id)->orderBy('created_at', 'DESC')->get();
                return response()->json($contracts);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to fetch contracts for the freelancer.'], 500);
            }
        }
    
        // Show contracts by client_id
        public function showByClient($client_id)
        {
            try {
                $contracts = Contract::where('client_id', $client_id)->orderBy('created_at', 'DESC')->get();
                return response()->json($contracts);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to fetch contracts for the client.'], 500);
            }
        }   




    //counte contract
    public function count(){
        $contract=Contract::count();
        return response()->json($contract);
    }
}