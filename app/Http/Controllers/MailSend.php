<?php

namespace App\Http\Controllers;




use App\Mail\ContactUS;
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
       
    } 
    public function contact(Request $request)
    {
        // Définir l'adresse email de destination
        $emailApp = "freelancerpulse@gmail.com";
        
        // Récupérer les données du formulaire et les convertir en chaînes de caractères
        $emailSender = (string) $request->email;
        $message = (string) $request->message;
        $firstName = (string) $request->firstName;
        $lastName = (string) $request->lastName;
    
        try {
            // Essayer d'envoyer l'email
            Mail::to($emailApp)->send(new ContactUS($emailSender, $firstName, $lastName, $message));
            
            // Retourner une réponse JSON en cas de succès
            return response()->json(['message' => 'Email envoyé'], 200);
        } catch (\Exception $e) {
            // Capturer les exceptions et retourner une réponse JSON avec un message d'erreur
            return response()->json([
                'error' => 'Une erreur est survenue lors de l\'envoi de l\'email.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    

  
  
}
