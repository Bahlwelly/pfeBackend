<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Hash;

class AdminController extends Controller
{
    public function login(Request $request){
    //on a quune seule admin
    $admin = Admin::first();
    if ($admin && Hash::check($request->password, $admin->password)) {
        return response()->json(['success' => 200, 'message' => 'Connexion réussie']);
    } else {
        return response()->json(['message' => 'Mot de passe incorrect'], 401);
    }
}
}
