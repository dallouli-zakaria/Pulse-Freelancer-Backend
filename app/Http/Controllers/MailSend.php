<?php

namespace App\Http\Controllers;

<<<<<<< HEAD



use App\Mail\ProfilMail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
=======
use App\Mail\ProfileMail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
>>>>>>> ab68d83de276447d5a74118da53dff0a4844acb8

class MailSend extends Controller
{
    public function send(Request $request){
         
     
           
        try {
            
             $user = User::where("id",$request->id)->firstOrFail();
<<<<<<< HEAD
            Mail::to($user->email)->send(new ProfilMail($user));
=======
            Mail::to($user->email)->send(new ProfileMail($user));
>>>>>>> ab68d83de276447d5a74118da53dff0a4844acb8
            return response()->json("message sedde to".$user->email, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
       
    }
}
