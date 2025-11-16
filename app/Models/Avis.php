<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Carbon\Carbon;

class Avis extends Model
{
    protected $fillable = ['nom', 'email', 'telephone', 'service_type', 'message', 'rating'];
    
    public static function saveToFirebase($data)
    {
        try {
            $database = Firebase::database();
            $avisRef = $database->getReference('demandes_avis');
            
            $newAvisRef = $avisRef->push([
                'nom' => $data['nom'],
                'email' => $data['email'],
                'telephone' => $data['telephone'] ?? null,
                'service_type' => $data['service_type'],
                'message' => $data['message'],
                'rating' => $data['rating'] ?? 5,
                'status' => 'pending',
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);
            
            return $newAvisRef->getKey();
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public static function getAllFromFirebase()
    {
        try {
            $database = Firebase::database();
            $avisRef = $database->getReference('demandes_avis')
                ->orderByChild('created_at')
                ->getSnapshot();
            
            return $avisRef->exists() ? $avisRef->getValue() : [];
        } catch (\Exception $e) {
            return [];
        }
    }
}