<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kreait\Firebase\Database;

class Vehicule extends Model
{
    /**
     * Le nom de la collection dans Firebase
     */
    protected $table = 'vehicules';

    /**
     * Les attributs qui sont assignables en masse.
     */
    protected $fillable = [
        'type',
        'capacite',
        'modele',
        'immatriculation'
    ];

    /**
     * Les attributs à caster.
     */
    protected $casts = [
        'capacite' => 'integer'
    ];

    /**
     * Relation avec les voyages
     */
    public function voyages()
    {
        return $this->hasMany(Voyage::class);
    }

    /**
     * Méthodes personnalisées pour Firebase
     */

    /**
     * Récupérer tous les véhicules depuis Firebase
     */
    public static function allFromFirebase()
    {
        $database = app('firebase.database');
        $reference = $database->getReference('vehicules');
        $vehicules = $reference->getValue();
        
        return collect($vehicules)->map(function($vehiculeData, $key) {
            $vehicule = new self();
            $vehicule->id = $key;
            $vehicule->fill($vehiculeData);
            return $vehicule;
        });
    }

    /**
     * Trouver un véhicule par son ID dans Firebase
     */
    public static function findFromFirebase($id)
    {
        $database = app('firebase.database');
        $reference = $database->getReference("vehicules/{$id}");
        $vehiculeData = $reference->getValue();
        
        if (!$vehiculeData) {
            return null;
        }
        
        $vehicule = new self();
        $vehicule->id = $id;
        $vehicule->fill($vehiculeData);
        return $vehicule;
    }
}