<?php

namespace App\Http\Controllers;

use App\Mail\ProfileMail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSend extends Controller
{
    public function send(Request $request){
         
     
           
        try {
            
             $user = User::where("id",$request->id)->firstOrFail();
            Mail::to($user->email)->send(new ProfileMail($user));
            return response()->json("message sedde to".$user->email, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
       
    }
}
