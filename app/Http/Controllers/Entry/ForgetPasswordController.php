<?php

namespace App\Http\Controllers\Entry;

use App\Http\Requests\Entry\ForgetPasswordRequest;
use App\Http\Requests\Entry\ResetPasswordRequest;
use App\Http\Requests\Entry\NouveauPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use App\Services\ChinguisoftSmsService;

class ForgetPasswordController extends Controller
{ 
    protected $smsService;

    public function __construct(ChinguisoftSmsService $smsService)
    {
        $this->smsService = $smsService;
    }
    public function forgetPassword(ForgetPasswordRequest $request){
        
            $user = User::where('tel', $request->tel)->first();
            if (!$user) {
              return response()->json(['message' => 'Utilisateur introuvable.'], 404);
           }
            
          try {
              $smsResponse = $this->smsService->sendValidationSms($user->tel, 'ar');
              // Vérification de la réponse de l'API SMS
              if (!empty($smsResponse['code'])) {
                $user->code = $smsResponse['code'];
                $user->code_expire_at = now()->addMinutes(10);
                $user->save();
                return response()->json(['message' => 'Code envoyé avec succès.'], 201);
              }
          } catch (\Exception $e) {
              
              return response()->json(['message' => 'Erreur lors de l\'envoi du SMS : ' . $e->getMessage()], 500);
          }
       }

       public function verifieCode(ResetPasswordRequest $request){
        // Chercher l'utilisateur par téléphone
        $user = User::where('tel', $request->tel)->first();
          // Vérifie si le code correcte et s'il est valide
     if ($user->code !== $request->code || now()->gt($user->code_expire_at)) { //gt=>(superieur ou egal)
         return response()->json(['message' => 'Code invalide ou expiré'], 422);
     }else{
         $user->reset_code();
         $user->password = null;
         $user->save();
     }
     return response()->json(['message' => 'Code vérifié avec succès.']);
     }
    
     public function nouveauPassword(NouveauPasswordRequest $request){
        $user = User::where('tel', $request->tel)->first();
        $user->password=Hash::make($request->password);
        $user->save();

        $success['token']=$user->createToken('user',['app::all'])->plainTextToken;
        $success['name']=$user->name;
        $success['success']=true;
        $success['message']='mot de pass modifier.';
            
        return response()->json($success,200); 

     }

}
