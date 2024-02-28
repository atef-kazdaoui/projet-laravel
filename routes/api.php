<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Utilisateur\UserController;
use App\Http\Controllers\evenement\EvenementController;
use App\Http\Controllers\EvenementUser\EvenementUserController; 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/inscription', [UserController::class, 'register']);
Route::post('/connexion',[UserController::class,'login']);
Route::put('/user/profile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::post('/evenement/ajout',[EvenementController::class , 'addEvenement'])->middleware('auth:sanctum');
Route::get('/evenements', [EvenementController::class, 'getAllEvenements'])->middleware('auth:sanctum');
Route::delete('/evenements/{id}', [EvenementController::class, 'deleteEvenement'])->middleware('auth:sanctum');
Route::post('/events/{id_event}/users', [EvenementUserController::class, 'store'])->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
