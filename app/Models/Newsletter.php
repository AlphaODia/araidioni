<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Carbon\Carbon;

class Newsletter extends Model
{
    protected $fillable = ['email'];
    
    public static function checkEmailExists($email)
    {
        try {
            $database = Firebase::database();
            $subscribersRef = $database->getReference('newsletter_subscribers')
                ->orderByChild('email')
                ->equalTo($email)
                ->getSnapshot();
            
            return $subscribersRef->exists() && count($subscribersRef->getValue()) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public static function saveToFirebase($email)
    {
        try {
            $database = Firebase::database();
            $subscribersRef = $database->getReference('newsletter_subscribers');
            
            $newSubscriberRef = $subscribersRef->push([
                'email' => $email,
                'created_at' => Carbon::now()->toDateTimeString(),
                'status' => 'active'
            ]);
            
            return $newSubscriberRef->getKey();
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public static function getAllFromFirebase()
    {
        try {
            $database = Firebase::database();
            $subscribersRef = $database->getReference('newsletter_subscribers')
                ->orderByChild('created_at')
                ->getSnapshot();
            
            return $subscribersRef->exists() ? $subscribersRef->getValue() : [];
        } catch (\Exception $e) {
            return [];
        }
    }
}