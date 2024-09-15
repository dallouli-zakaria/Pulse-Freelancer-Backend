<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\FreelancerContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class FreelancerContractController extends Controller
{
    public function index()
    {
        try {
            $contracts = FreelancerContract::orderBy('created_at', 'DESC')->get();
            return response()->json($contracts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch contracts.'], 500);
        }
    }
    public function indexPagination(Request $request){
        try {
            $page = $request->query('page', 1);
            $perPage = 8;
    
            $contracts = FreelancerContract::orderBy('created_at', 'DESC')
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
                'freelancer_id' => 'required|integer',
            ]);
    
            // Rename keys to match your database columns
            $contractData = [
                'title' => $validatedData['title'],
'start_date' => Carbon::parse($validatedData['start_date']),
                'end_date' => Carbon::parse($validatedData['end_date']), 
                'project_description' => $validatedData['project_description'],
            ];
    
            $contract = Contract::create($contractData);
    
            // Create FreelancerContract entry with freelancer_id and contract_id
            FreelancerContract::create([
                'freelancer_id' => $validatedData['freelancer_id'],
                'id' => $contract->id,
            ]);
    
            // Retrieve the freelancer by ID
            $freelancer = User::find($validatedData['freelancer_id']);
    
            // Verify that the freelancer exists
            if ($freelancer) {
                // Send an email to the freelancer
                Mail::send('contract-freelancer', [
                    'contract' => $contract,
                    'formatted_start_date' => $contract->start_date->format('d/m/Y'),
                    'formatted_end_date' => $contract->end_date->format('d/m/Y'),
                ], function ($message) use ($freelancer) {
                    $message->to($freelancer->email)
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
            $contract = FreelancerContract::findOrFail($id);
            return response()->json(['data' => $contract]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Contract not found.'], 404);
        }
    }

    public function update(Request $request, $id)
{
    try {
        $validatedData = $request->validate([
            'freelancer_id' => 'required|integer',

        ]);

        $contract = FreelancerContract::findOrFail($id);

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
            $contract = FreelancerContract::findOrFail($id);
            $contract->delete();
            return response()->json(['message' => 'Contract deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete contract.'], 500);
        }
    }
}
