<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'email', 'telephone', 'service_type', 'message', 'rating', 'status'];

    /**
     * Sauvegarder un avis dans Firebase
     */
    public static function saveToFirebase($data)
    {
        try {
            $database = Firebase::database();
            $avisRef = $database->getReference('demandes_avis');
            
            $newAvis = $avisRef->push([
                'nom' => $data['nom'],
                'email' => $data['email'],
                'telephone' => $data['telephone'] ?? null,
                'service_type' => $data['service_type'],
                'message' => $data['message'],
                'rating' => $data['rating'] ?? null,
                'status' => 'pending',
                'created_at' => time(),
                'updated_at' => time()
            ]);

            return $newAvis->getKey();
        } catch (\Exception $e) {
            Log::error('Erreur sauvegarde avis Firebase: '.$e->getMessage());
            return false;
        }
    }

    /**
     * Récupérer tous les avis
     */
    public static function getAllFromFirebase()
    {
        try {
            $database = Firebase::database();
            $avisRef = $database->getReference('demandes_avis')
                ->orderByChild('created_at')
                ->getSnapshot();

            return $avisRef->exists() ? $avisRef->getValue() : [];
        } catch (\Exception $e) {
            Log::error('Erreur récupération avis: '.$e->getMessage());
            return [];
        }
    }
}