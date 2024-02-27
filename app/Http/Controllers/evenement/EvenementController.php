<?php

namespace App\Http\Controllers\Evenement;

use App\Models\Event; // Assurez-vous que le chemin d'accès au modèle est correct
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvenementController extends Controller
{
    public function showEvenement()
    {
        // Cette méthode doit être modifiée pour retourner une réponse JSON si vous souhaitez l'utiliser avec Postman
        return view('home');
    }

    public function addEvenement(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
        ]);

        // Récupérer l'utilisateur associé au token
        $user = Auth::user();

        if (!$user) {
            // Si aucun utilisateur n'est récupéré, retourner une réponse JSON avec une erreur.
            return response()->json(['error' => 'Vous devez être connecté pour ajouter un événement.'], 403);
        }

        try {
            // Créer un nouvel événement
            $event = Event::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'date' => $request->input('date'),
                'location' => $request->input('location'),
                'organizer_id' => $user->id, // Ceci est automatiquement géré par le modèle Event si vous avez configuré la méthode boot correctement
            ]);

            // Retourner une réponse JSON avec l'événement ajouté
            return response()->json(['success' => 'Événement ajouté avec succès!', 'event' => $event], 201);
        } catch (\Exception $e) {
            // En cas d'exception, retourner une réponse JSON avec un message d'erreur.
            return response()->json(['error' => 'Une erreur est survenue lors de l\'ajout de l\'événement.', 'message' => $e->getMessage()], 500);
        }
    }
    public function getAllEvenements()
{
    // Récupérer tous les événements
    $evenements = Event::all();

    // Retourner les événements en réponse
    return response()->json(['evenements' => $evenements]);
}

public function deleteEvenement($id)
    {
        // Rechercher l'événement à supprimer
        $event = Event::find($id);

        // Vérifier si l'événement existe
        if (!$event) {
            return response()->json(['error' => 'Événement non trouvé.'], 404);
        }

        // Vérifier si l'utilisateur connecté est l'organisateur de l'événement
        if (Auth::id() !== $event->organizer_id) {
            return response()->json(['error' => 'Vous n\'avez pas la permission de supprimer cet événement.'], 403);
        }

        try {
            // Supprimer l'événement
            $event->delete();
            
            return response()->json(['success' => 'Événement supprimé avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur lors de la suppression, retourner un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de l\'événement.', 'message' => $e->getMessage()], 500);
        }
    }
   
     public function registerToEvent(Request $request)
    {
        // Récupérer l'utilisateur actuel
        $user = Auth::user();
    
        // Récupérer l'ID de l'événement à partir de la requête HTTP
        $eventId = $request->route('eventId');
    
        // Vérifier si l'utilisateur est déjà inscrit
        if ($user->events()->where('id', $eventId)->exists()) {
            return response()->json(['message' => 'Vous êtes déjà inscrit à cet événement.']);
        }
    
        // Inscrire l'utilisateur à l'événement
        $user->events()->attach($eventId);
    
        return response()->json(['message' => 'Inscription réussie à l\'événement.']);
    }
    



}
