<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Utilisateur\UserController;
use App\Http\Controllers\Evenement\EvenementController;


Route::post('/inscription', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/add-event', [EvenementController::class, 'addEvenement']);



