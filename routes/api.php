<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Entry\RegisterUserController;
use App\Http\Controllers\Entry\LoginUserController;
use App\Http\Controllers\Entry\ForgetPasswordController;
use App\Http\Controllers\Plainte\PlainteController;
use App\Http\Controllers\AdminController;

//register user
Route::prefix('register/')->name('register.')->group(function (){
    Route::post('11',[RegisterUserController::class,'register1']);
    Route::post('12',[RegisterUserController::class,'register2']);
    Route::post('13',[RegisterUserController::class,'registerComplete']);
 });

//login
Route::post('loginUser',[LoginUserController::class,'login']);

//forgetPassword
Route::prefix('forgetPassword/')->name('forgetpassword.')->group(function (){
    Route::post('envoyeCode',[ForgetPasswordController::class,'forgetPassword']);
    Route::post('verifiCode',[ForgetPasswordController::class,'verifiecode']);
    Route::post('nouveauPassword',[ForgetPasswordController::class,'nouveauPassword']);
 });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('envoyePlainte', [PlainteController::class, 'envoyePlainte']);
    Route::post('recuperePlainte', [PlainteController::class, 'recuperePlainte']);
     Route::get('myhistory',[PlainteController::class,'afficherHistory']);
    Route::post('logout',[RegisterUserController::class,'logout']);


});


//afficher tous les utilisateurs
Route::prefix('afficher/')->name('afficher.')->group(function (){
  Route::get('utilisateur',[RegisterUserController::class,'afficher']);
  Route::get('utilisateur/{id}',[RegisterUserController::class,'afficherUser']);
  Route::get('plainte',[PlainteController::class,'afficher']);

});

//Login pour Admin
Route::post('loginAdmin',[AdminController::class,'login']);