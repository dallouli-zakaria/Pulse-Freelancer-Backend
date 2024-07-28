<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    
    public function addToWishlist($client_id,$freelnacer_id)
{

    $wishlist = Wishlist::create([
        'client_id' =>  $client_id,
        'freelancer_id' => $freelnacer_id,
    ]);

    return response()->json(['message' => 'Freelancer added to wishlist', 'wishlist' => $wishlist], 201);
}

public function removeFromWishlist($client_id,$freelnacer_id)
{
    $wishlist = Wishlist::where('client_id', $client_id)
                        ->where('freelancer_id',  $freelnacer_id)
                        ->firstOrFail();

    $wishlist->delete();

    return response()->json(['message' => 'Freelancer removed from wishlist']);
}

public function getWishlist($client_id)
{
    $wishlists = Wishlist::where('client_id', $client_id)->with('freelancer')->get();

    return response()->json($wishlists);
}


public function getWishlistfreelancerdetails($client_id)
{
    $wishlists = Wishlist::where('client_id', $client_id)
        ->with('freelancer') // Eager load the freelancer relationship
        ->get()
        ->map(function ($wishlist) {
            return [
                    'id' => $wishlist->freelancer->id,
                    'title' => $wishlist->freelancer->title,
                    'dateOfBirth' => $wishlist->freelancer->dateOfBirth,
                    'city' => $wishlist->freelancer->city,
                    'TJM' => $wishlist->freelancer->TJM,
                    'summary' => $wishlist->freelancer->summary,
                    'availability' => $wishlist->freelancer->availability,
                    'adress' => $wishlist->freelancer->adress,
                    'phone' => $wishlist->freelancer->phone,
                    'portfolio_Url' => $wishlist->freelancer->portfolio_Url,
                    'status' => $wishlist->freelancer->status,
                    'user' => $wishlist->freelancer->user ,
                    'skills' => $wishlist->freelancer->skills // Include freelancer skills
                
            ];
        });

    return response()->json($wishlists);
}

}
