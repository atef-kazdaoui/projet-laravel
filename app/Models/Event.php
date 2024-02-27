<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'organizer_id', 
    ];

    // Relation Many-to-One avec l'utilisateur connecté (organisateur)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Override la méthode boot pour automatiquement définir l'organisateur lors de la création
    protected static function boot()
    {
        parent::boot();

        // Événement lors de la création d'un nouvel événement
        static::creating(function ($event) {
            $event->organizer_id = Auth::id(); // Utilisateur actuellement authentifié
        });
    }
}
