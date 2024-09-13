<?php


namespace App\Http\Controllers;

use Log;
use App\Models\Post;
use App\Models\User;
use App\Models\Offer;
use App\Models\Freelancers;
use App\Notifications\CandidateSended;
use App\Notifications\NewCandidateApply;
use Illuminate\Http\Request;
use App\Notifications\Postcreation;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
                'selected'=>'required|string',
                'freelancer_id'=>'nullable|numeric',
                'post_id'=>'nullable|numeric'
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

        public function count(){
        $OfferCount = Offer::count();
        return response()->json($OfferCount);
    }



    public function showByFreelancerId($freelancer_id)
    {
        try {
            $offers = Offer::where('freelancer_id', $freelancer_id)->get();
            if ($offers->isEmpty()) {
                return response()->json(['error' => 'No offers found for this freelancer.'], 404);
            }
            return response()->json($offers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch offers.'], 500);
        }
    }

    public function showByPostId($post_id)
    {
        try {
            $offers = Offer::where('post_id', $post_id)->get();
            if ($offers->isEmpty()) {
                return response()->json(['error' => 'No offers found for this freelancer.'], 404);
            }
            return response()->json($offers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch offers.'], 500);
        }
    }

    public function getFreelancerDetailsByPostId($postId)
    {
        try {
            // Retrieve offers with given post_id
            $offers = Offer::where('post_id', $postId)->get();
            
            // Extract freelancer ids from offers
            $freelancerIds = $offers->pluck('freelancer_id')->unique()->toArray();
            
            // Retrieve freelancers details for the extracted ids
            $freelancers = Freelancers::whereIn('id', $freelancerIds)
            ->with('user:id,name,email') 
            ->orderBy('created_at', 'DESC')
            ->get();
            
            return response()->json($freelancers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch freelancer details.'], 500);
        }
    }

    public function showByPostAndFreelancerId($post_id, $freelancer_id)
    {
        try {
            $offer = Offer::where('post_id', $post_id)
                          ->where('freelancer_id', $freelancer_id)
                          ->first();
    
            if (is_null($offer)) {
                return response()->json(['error' => 'No offers found for this post and freelancer.'], 404);
            }
    
            return response()->json($offer);
        } catch (\Exception $e) {
            // Return a more general error message without exposing exception details
            return response()->json(['error' => 'Failed to fetch offer.'], 500);
        }
    }


    public function getFreelancerDetailsByPostIdTrue($postId)
    {
        try {
            // Retrieve offers with given post_id
            $offers = Offer::where('post_id', $postId)->where('selected', 'true')->get();
            
            // Extract freelancer ids from offers
            $freelancerIds = $offers->pluck('freelancer_id')->unique()->toArray();
            
            // Retrieve freelancers details for the extracted ids
            $freelancers = Freelancers::whereIn('id', $freelancerIds)
            ->with('user:id,name,email') 
            ->orderBy('created_at', 'DESC')
            ->get();
            
            return response()->json($freelancers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch freelancer details.'], 500);
        }
    }


    public function getFreelancerDetailsByPostIdFalse($postId)
    {
        try {
            // Retrieve offers with given post_id
            $offers = Offer::where('post_id', $postId)->where('selected', 'false')->get();
            
            // Extract freelancer ids from offers
            $freelancerIds = $offers->pluck('freelancer_id')->unique()->toArray();
            
            // Retrieve freelancers details for the extracted ids
            $freelancers = Freelancers::whereIn('id', $freelancerIds)
            ->with('user:id,name,email') 
            ->orderBy('created_at', 'DESC')
            ->get();
            
            return response()->json($freelancers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch freelancer details.'], 500);
        }
    }
    

    public function getFreelancerDetailsByPostIdDeclined($postId)
    {
        try {
            // Retrieve offers with given post_id
            $offers = Offer::where('post_id', $postId)->where('selected', 'declined')->get();
            
            // Extract freelancer ids from offers
            $freelancerIds = $offers->pluck('freelancer_id')->unique()->toArray();
            
            // Retrieve freelancers details for the extracted ids
            $freelancers = Freelancers::whereIn('id', $freelancerIds)
            ->with('user:id,name,email') 
            ->orderBy('created_at', 'DESC')
            ->get();
            
            return response()->json($freelancers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch freelancer details.'], 500);
        }
    }


    public function freelancerExistsInOffer( $freelancer_id,$post_id)
    {
        try {
            $offerExists = Offer::where('post_id', $post_id)
                                ->where('freelancer_id', $freelancer_id)
                                ->exists();
    
            if ($offerExists) {
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to check if freelancer exists in offer.'], 500);
        }
    }


    
}
