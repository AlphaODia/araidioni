<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kreait\Laravel\Firebase\Facades\Firebase;

class Colis extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function () { return false; });
        static::updating(function () { return false; });
        static::deleting(function () { return false; });
    }

public static function all($columns = ['*'])
{
    $data = Firebase::database()->getReference('colis')->getValue();
    
    return collect($data)->map(function ($item, $id) {
        return [
            'id' => $id,
            'numero_tracking' => $item['numero_tracking'] ?? null,
            'expediteur' => $item['expediteur'] ?? null,
            'adresse_expediteur' => $item['adresse_expediteur'] ?? null,
            'destinataire' => $item['destinataire'] ?? null,
            'adresse_destinataire' => $item['adresse_destinataire'] ?? null,
            'groupe_colis_id' => $item['groupe_colis_id'] ?? null,
            'statut' => $item['statut'] ?? 'pending_payment',
            'poids' => $item['poids'] ?? null,
            'type_de_colis' => $item['type_de_colis'] ?? null,
            'date_envoi' => $item['date_envoi'] ?? null,
            'date_livraison' => $item['date_livraison'] ?? null,
            'prix' => $item['prix'] ?? null,
        ];
    })->toArray();
}

public static function find($id)
{
    $data = Firebase::database()->getReference('colis/'.$id)->getValue();
    
    if (!$data) return null;
    
    return [
        'id' => $id,
        'numero_tracking' => $data['numero_tracking'] ?? null,
        'expediteur' => $data['expediteur'] ?? null,
        'adresse_expediteur' => $data['adresse_expediteur'] ?? null,
        'destinataire' => $data['destinataire'] ?? null,
        'adresse_destinataire' => $data['adresse_destinataire'] ?? null,
        'groupe_colis_id' => $data['groupe_colis_id'] ?? null,
        'statut' => $data['statut'] ?? 'unknown',
        'poids' => $data['poids'] ?? null,
        'type_de_colis' => $data['type_de_colis'] ?? null,
        'date_envoi' => $data['date_envoi'] ?? null,
        'date_livraison' => $data['date_livraison'] ?? null,
        'prix' => $data['prix'] ?? null,
    ];
}

    public static function create(array $attributes = [])
    {
        $firebaseAttributes = [
            'numero_tracking' => $attributes['tracking_number'],
            'expediteur' => $attributes['sender_name'],
            'adresse_expediteur' => $attributes['sender_address'],
            'destinataire' => $attributes['recipient_name'],
            'adresse_destinataire' => $attributes['recipient_address'],
            'poids' => $attributes['weight'],
            'description' => $attributes['description'],
            'statut' => $attributes['status'] ?? 'pending_payment',
            'created_at' => now()->toDateTimeString(),
        ];

        $ref = Firebase::database()->getReference('colis')->push($firebaseAttributes);
        return $ref->getKey();
    }


    public static function findByTrackingNumber($trackingNumber)
{
    $reference = Firebase::database()->getReference('colis');
    $query = $reference->orderByChild('numero_tracking')->equalTo($trackingNumber);
    $snapshot = $query->getSnapshot();
    
    if (!$snapshot->exists()) {
        return null;
    }
    
    $data = $snapshot->getValue();
    
    // Vérification supplémentaire pour s'assurer que les données existent
    if (empty($data)) {
        return null;
    }
    
    $id = array_key_first($data);
    
    // Vérification finale avant de retourner les données
    if (!isset($data[$id])) {
        return null;
    }
    
    return array_merge(['id' => $id], $data[$id]);
}
}
