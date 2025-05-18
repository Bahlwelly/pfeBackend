<?php

namespace App\Http\Controllers\Plainte;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plainte\EnvoyePlainteRequest;
use Illuminate\Http\Request;
use App\Models\Plainte;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PlainteController extends Controller
{
    public function genererCode(){
        do{
        $date=now()->format('ymd');
        $rand=strtoupper(Str::random(4));
        $code="NP-{$date}-{$rand}";
        }while(Plainte::where('code',$code)->exists());
        return $code;
    }
public function envoyePlainte(EnvoyePlainteRequest $request)
{
    try {
        $plainte = new Plainte();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Génère un nom unique pour l'image
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Stocke l'image dans "storage/app/public/images"
            $image->storeAs('public/images', $imageName);
            // Enregistre le chemin correct dans la base de données
            $plainte->image = asset('storage/images/' . $imageName);
        }

        $plainte->user_id = auth()->id();
        $plainte->details = $request->details;
        $plainte->adresse = $request->adresse;
        $plainte->commune = $request->commune;
        $plainte->examiner = "Non examinee";
        $plainte->code =PlainteController::genererCode();

        $plainte->save();

        return response()->json(['success' => 'envoyer']);
        
    } catch (\Exception $e) {
        \Log::error('Erreur lors de l’envoi de la plainte', ['error' => $e->getMessage()]);
        return response()->json(['success' => 'erreur', 'message' => $e->getMessage()], 500);
    }
}

public function recuperePlainte(){
    // Récupérer l'utilisateur connecté
    $user = auth()->user();
    // Filtrer les plaintes où la commune est égale à celle de l'utilisateur connecté et plainte non examinee
    $plaintes = Plainte::with('user:id,name,tel')
         ->where('commune', $user->commune)
        ->where('examiner', 'non examinee')
        ->select('id', 'details', 'commune',"code", 'image', 'adresse', 'examiner', 'user_id')
        ->get();
 // Formatter la réponse pour retourner uniquement les champs voulus
    $formatted = $plaintes->map(function ($plainte) {
        return [
            'details'   => $plainte->details,
            'commune'   => $plainte->commune,
            'examiner'    => $plainte->examiner, 
            'image'     => $plainte->image,
            'adresse'   => $plainte->adresse,
            'user_name' => $plainte->user->name ?? null,
            'telephone' => $plainte->user->tel ?? null,
        ];
    });
    return response()->json($formatted);
}

public function afficherPlainte(){
 // Récupérer l'utilisateur connecté
    $user = auth()->user();
    $plaintes = Plainte::all(['id','details', 'user_id','adresse','image','examiner','commune','created_at'])
        ->map(function ($plainte) {
            $plainte->created_at = Carbon::parse($plainte->created_at)->format('Y-m-d'); // Convertit en chaîne
            return $plainte;
        });
   return response()->json($plaintes, 200, [], JSON_UNESCAPED_SLASHES);
}



public function afficherHistory()
{
    $user = auth()->user();
    // Récupérer uniquement les plaintes appartenant à cet utilisateur
    $plaintes = Plainte::where('user_id', $user->id)
        ->select(['code', 'commune', 'image', 'examiner'])
        ->get()
        ->map(function ($plainte) {
            return [
                'commune'  => $plainte->commune,
                'examiner' => $plainte->examiner,
                'image'    => $plainte->image,
                'code'     => $plainte->code,
            ];
        });
  return response()->json($plaintes);
}


}

