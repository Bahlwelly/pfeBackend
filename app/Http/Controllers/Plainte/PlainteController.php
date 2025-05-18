<?php

namespace App\Http\Controllers\Plainte;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plainte\EnvoyePlainteRequest;
use Illuminate\Http\Request;
use App\Models\Plainte;
use Illuminate\Supporte\Str;

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
        $plainte->examen = "Non examinee";
        $plainte->code =genererCode();

        $plainte->save();

        return response()->json(['success' => 'envoyer']);
        
    } catch (\Exception $e) {
        \Log::error('Erreur lors de l’envoi de la plainte', ['error' => $e->getMessage()]);
        return response()->json(['success' => 'erreur', 'message' => $e->getMessage()], 500);
    }
}


//    public function recuperePlainte(){
//     $plaintes = Plainte::with('user:id,name,tel')
//         ->select('id', 'details', 'commune', 'image', 'adresse','examen', 'user_id')
//         ->get();

//     // Formatter la réponse pour retourner uniquement les champs voulus
//     $formatted = $plaintes->map(function ($plainte) {
//         return [
//             'details'   => $plainte->details,
//             'commune'   => $plainte->commune,
//             'examen'   =>$plainte->examen, 
//             'image'     => $plainte->image,
//             'adresse'   => $plainte->adresse,
//             'user_name' => $plainte->user->name ?? null,
//             'telephone' => $plainte->user->tel ?? null,
//         ];
//     });

//     return response()->json($formatted);
//    }

public function recuperePlainte(){
    // // Récupérer l'utilisateur connecté
    $user = auth()->user();
    // Filtrer les plaintes où la commune est égale à celle de l'utilisateur connecté
    $plaintes = Plainte::with('user:id,name,tel')
         ->where('commune', $user->commune)
        ->where('examen', 'non examinee')
        ->select('id', 'details', 'commune',"code", 'image', 'adresse', 'examen', 'user_id')
        ->get();

    // Formatter la réponse pour retourner uniquement les champs voulus
    $formatted = $plaintes->map(function ($plainte) {
        return [
            'details'   => $plainte->details,
            'commune'   => $plainte->commune,
            'examen'    => $plainte->examen, 
            'image'     => $plainte->image,
            'adresse'   => $plainte->adresse,
            'user_name' => $plainte->user->name ?? null,
            'telephone' => $plainte->user->tel ?? null,
        ];
    });

    return response()->json($formatted);
}

public function afficher(){
    $plaintes=Plainte::all(['id','details', 'user_id','adresse','image','examen']);
    return response()->json($plaintes);
}

public function affichePlainte(){
      $plaintes = Plainte::with('user:id,tel')
         ->where('commune', $user->commune)
        ->where('examen', 'non examiner')
        ->select('id','code',  'examiner', 'user_id','date')
        ->get();
}

}

