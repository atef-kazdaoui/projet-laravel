<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventUserController extends Controller
{
    public function registerToEvent(Request $request, Event $event)
    {
        // Récupérer l'utilisateur authentifié
        $userId = Auth::id();

        // Vérifier si l'utilisateur est déjà inscrit à l'événement
        if ($event->users()->where('user_id', $userId)->exists()) {
            return response()->json(['message' => 'L\'utilisateur est déjà inscrit à cet événement'], 409);
        }

        // Inscrire l'utilisateur à l'événement
        $event->users()->attach($userId);

        return response()->json(['message' => 'Inscription réussie']);
    }
}
