<?php

namespace App\Http\Controllers\EvenementUser;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventUser;
use App\Models\Event; // Assurez-vous d'importer le modèle Event si vous souhaitez vérifier l'existence de l'événement.

class EvenementUserController extends Controller
{
    public function store(Request $request, $id_event)
{
    // Vérifie si l'événement existe
    $event = Event::find($id_event);
    

    if (Auth::check() && $event) {
        $user_id = Auth::id();
        // Crée une nouvelle entrée dans la table pivot event_user
        EventUser::create([
            'event_id' => $id_event, // Utilisez directement $id_event
            'user_id' => $user_id,
        ]);

        // Retourne une réponse en cas de succès
        return response()->json(['message' => 'User successfully attached to event'], 201);
    } else {
        // Retourne une réponse en cas d'échec
        return response()->json(['message' => 'Unauthorized or event not found'], 404);
    }
}

    
}
