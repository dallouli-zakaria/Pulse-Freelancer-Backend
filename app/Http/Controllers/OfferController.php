<?php


namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class OfferController extends Controller
{
    public function index()
    {
        try {
            $offers = Offer::all();
            return response()->json($offers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch offers.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'selected'=>'required|string',
                'freelancer_id'=>'required|numeric',
                'post_id'=>'required|numeric'
            ]);
            
            $offer = Offer::create($request->all());
            return response()->json($offer, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create offer.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $offer = Offer::findOrFail($id);
            return response()->json($offer);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Offer not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch offer.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                // Validation rules here
            ]);

            $offer = Offer::findOrFail($id);
            $offer->update($request->all());
            return response()->json($offer, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Offer not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update offer.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $offer = Offer::findOrFail($id);
            $offer->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Offer not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete offer.'], 500);
        }
    }
}
