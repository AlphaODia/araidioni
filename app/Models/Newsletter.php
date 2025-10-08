<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'subscribed_at', 'status'];

    /**
     * Sauvegarder un email dans Firebase
     */
    public static function saveToFirebase($email)
    {
        try {
            $database = Firebase::database();
            $newsletterRef = $database->getReference('newsletter_subscribers');
            
            $newSubscriber = $newsletterRef->push([
                'email' => $email,
                'subscribed_at' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'created_at' => time()
            ]);

            return $newSubscriber->getKey();
        } catch (\Exception $e) {
            Log::error('Erreur sauvegarde Firebase: '.$e->getMessage());
            return false;
        }
    }

    /**
     * Vérifier si l'email existe déjà
     */
    public static function checkEmailExists($email)
    {
        try {
            $database = Firebase::database();
            $newsletterRef = $database->getReference('newsletter_subscribers')
                ->orderByChild('email')
                ->equalTo($email)
                ->getSnapshot();

            return $newsletterRef->exists();
        } catch (\Exception $e) {
            Log::error('Erreur vérification email: '.$e->getMessage());
            return false;
        }
    }
}