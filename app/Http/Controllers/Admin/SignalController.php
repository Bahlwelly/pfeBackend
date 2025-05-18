<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SignalController extends Controller
{
   public function updateSignal($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Plainte non trouvée'], 404);
    }

    $user->signal = 1; // Mettre à jour signal
    $user->save();

    return response()->json(['message' => 'Signal mis à jour', 'plainte' => $plainte], 200);
}
}
