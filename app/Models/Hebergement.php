<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hebergement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hebergements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'description',
        'prix_nuit',
        'ville',
        'pays',
        'type_logement',
        'capacite',
        'superficie',
        'nombre_chambres',
        'nombre_salles_de_bain',
        'adresse_complete',
        'est_disponible',
        'agent_id',
        'coordonnees_lat',
        'coordonnees_lng'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'prix_nuit' => 'decimal:2',
        'est_disponible' => 'boolean',
        'coordonnees_lat' => 'decimal:8',
        'coordonnees_lng' => 'decimal:8'
    ];

    /**
     * Relation avec l'agent (utilisateur) qui gère l'hébergement
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Relation avec les réservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Scope pour les hébergements disponibles
     */
    public function scopeDisponible($query)
    {
        return $query->where('est_disponible', true);
    }

    /**
     * Scope pour filtrer par ville
     */
    public function scopeParVille($query, $ville)
    {
        return $query->where('ville', $ville);
    }

    /**
     * Accessor pour l'URL complète de l'image principale
     */
    public function getImagePrincipaleUrlAttribute()
    {
        if ($this->image_principale) {
            return asset('storage/' . $this->image_principale);
        }
        
        return asset('images/default-hebergement.jpg');
    }
}