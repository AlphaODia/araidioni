<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kreait\Firebase\Database;

class Voyage extends Model
{
    /**
     * Le nom de la collection dans Firebase
     */
    protected $table = 'voyages';

    /**
     * Les attributs qui sont assignables en masse.
     */
    protected $fillable = [
        'ville_depart',
        'ville_arrivee',
        'date_depart',
        'heure_depart',
        'prix',
        'places_restantes',
        'vehicule_id'
    ];

    /**
     * Les attributs à caster.
     */
    protected $casts = [
        'date_depart' => 'date',
        'prix' => 'decimal:2',
        'places_restantes' => 'integer'
    ];

    /**
     * Relation avec le véhicule (si vous utilisez une relation)
     */
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    /**
     * Méthodes personnalisées pour Firebase
     */

    /**
     * Récupérer tous les voyages depuis Firebase
     */
    public static function allFromFirebase()
    {
        $database = app('firebase.database');
        $reference = $database->getReference('voyages');
        $voyages = $reference->getValue();
        
        return collect($voyages)->map(function($voyageData, $key) {
            $voyage = new self();
            $voyage->id = $key;
            $voyage->fill($voyageData);
            return $voyage;
        });
    }

    /**
     * Trouver un voyage par son ID dans Firebase
     */
    public static function findFromFirebase($id)
    {
        $database = app('firebase.database');
        $reference = $database->getReference("voyages/{$id}");
        $voyageData = $reference->getValue();
        
        if (!$voyageData) {
            return null;
        }
        
        $voyage = new self();
        $voyage->id = $id;
        $voyage->fill($voyageData);
        return $voyage;
    }

    /**
     * Sauvegarder dans Firebase
     */
    public function saveToFirebase()
    {
        $database = app('firebase.database');
        $reference = $database->getReference("voyages/{$this->id}");
        
        $data = [
            'ville_depart' => $this->ville_depart,
            'ville_arrivee' => $this->ville_arrivee,
            'date_depart' => $this->date_depart,
            'heure_depart' => $this->heure_depart,
            'prix' => $this->prix,
            'places_restantes' => $this->places_restantes,
            'vehicule_id' => $this->vehicule_id
        ];
        
        $reference->set($data);
        return $this;
    }
}