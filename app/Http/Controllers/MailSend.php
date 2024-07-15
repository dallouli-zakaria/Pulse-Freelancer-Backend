<?php

namespace App\Http\Controllers;




use App\Mail\ProfilMail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;
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
       
    }
}
