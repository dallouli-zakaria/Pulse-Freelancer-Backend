<?php

namespace App\Http\Controllers;




use App\Models\Offer;
use App\Mail\ProfilMail;
use App\Notifications\OfferApply;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OfferValidated;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MailSend extends Controller
{
    public function send(Request $request){
         
     
           
        try {
            
             $user = User::where("id",$request->id)->firstOrFail();
           $message=$request->message;
            Mail::to($user->email)->send(new ProfilMail($user,$message));

            return response()->json("message sedde to".$user->email, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
       
    } public function index()
    {
        $offers = Offer::all();
        return view('offers', ['offers' => $offers]);
    }

    public function validateOffer(Request $request, $offerId)
    {
        $offer = Offer::find($offerId);
        $offer->validated = true;
        $offer->save();

        $offer->user->notify(new OfferValidated($offer));

        return response()->json(['message' => 'Offer validated and notification sent.']);
    }

    public function applyOffer(Request $requist,$freelancer_id){
 
         $offers = Offer::where('freelancer_id', $freelancer_id)->get();
         $offers->user->notify(new OfferApply($offers));
         return response()->json(['message' => 'Offer validated and notification sent.']);
    }

  
}
