<?php

// app/Http/Controllers/Utilisateur/UserController.php
namespace App\Http\Controllers\Utilisateur;

use App\Http\Controllers\Controller; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Ajout de Hash pour utiliser la fonction Hash::make()
use Illuminate\Validation\ValidationException; // Ajout de ValidationException
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Récupération des données sans validation
            $userData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')), // Toujours hasher le mot de passe
            ];
    
            // Création de l'utilisateur
            $user = User::create($userData);
    
            // Réponse en cas de succès
            return response()->json($user, 201);
    
        } catch (\Exception $e) {
            // Réponse en cas d'erreur serveur
            return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Modification de la méthode pour supprimer tous les tokens de l'utilisateur
        return response()->json(['message' => 'Logged out']);
    }
    public function updateProfile(Request $request)
{
    try {
        // Validation des données envoyées
        $request->validate([
            'name' => 'nullable|string|max:255', // nullable signifie que l'utilisateur peut ne pas modifier son nom
            'password' => 'nullable|string|min:8', // nullable signifie que l'utilisateur peut ne pas modifier son mot de passe
        ]);

        $user = Auth::user(); // Récupérer l'utilisateur actuellement authentifié

        // Mise à jour du nom si fourni
        if ($request->has('name') && $request->name != '') {
            $user->name = $request->input('name');
        }

        // Mise à jour du mot de passe si fourni
        if ($request->has('password') && $request->password != '') {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save(); // Sauvegarder les modifications

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    } catch (\Exception $e) {
        // Réponse en cas d'erreur serveur
        return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
    }
}

}
