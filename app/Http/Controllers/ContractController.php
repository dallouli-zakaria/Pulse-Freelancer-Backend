<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContractController extends Controller
{
    public function index()
    {
        try {
            $contracts = Contract::all();
            return response()->json($contracts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch contracts.'], 500);
        }
    }
  
    public function indexPagination(Request $request)
{
    try {
        $page = $request->query('page', 1);
        $perPage = 7;

        // Paginate the User model directly
        $users = Contract::orderBy('created_at', 'DESC')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($users);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'period' => 'nullable|string',
                'budget' => 'nullable|numeric',
                'project_description' => 'required|string',
                'client_id'=>'',
                'freelancer_id'=>''
            ]);

            $contract = Contract::create($validatedData);
            return response()->json(['message' => 'Contract created successfully', 'data' => $contract], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create contract.'."erreur".$e], 500);
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
                'title' => 'string',
                'period' => 'nullable|string',
                'budget' => 'nullable|numeric',
                'project_description' => 'string',
            ]);

            $contract = Contract::findOrFail($id);
            $contract->update($validatedData);

            return response()->json(['message' => 'Contract updated successfully', 'data' => $contract]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
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




    //counte contract
    public function count(){
        $contract=Contract::count();
        return response()->json($contract);
    }
}
