<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $pack=new Pack;
        $validation=$request->validate([
            'title'=>'required|string',
            'description'=>'required|string',
            'price' => 'nullable|numeric'
        ]);
        $pack->create($validation);
        
   return response()->json('pack created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Pack $pack)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pack $pack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

      try {
        $request->validate([
          'title'=>'required|string',
          'description'=>'required|string',
          'price' => 'nullable|numeric'
  
        ]);
        $pack=Pack::find($id);
        $pack->update($request->all());
        return response()->json($pack, 200);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Offer not found.'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update offer.'], 500);
    }
     
     
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
       
            Pack::where('id', $id)->delete();
     

        return response()->json(['message' => 'Pack deleted .']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete pack: ' . $e->getMessage()], 500);
    }
    }
}
