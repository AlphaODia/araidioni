<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Newsletter;
use Kreait\Laravel\Firebase\Facades\Firebase;

class NewsletterController extends Controller
{
    
    /**
     * Ajouter un email à la newsletter
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Adresse email invalide',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->input('email');

        // Vérifier si l'email existe déjà
        if (Newsletter::checkEmailExists($email)) {
            return response()->json([
                'success' => false,
                'message' => 'Cet email est déjà inscrit à notre newsletter'
            ], 409);
        }

        // Sauvegarder dans Firebase
        $subscriberId = Newsletter::saveToFirebase($email);

        if ($subscriberId) {
            return response()->json([
                'success' => true,
                'message' => 'Inscription à la newsletter réussie!',
                'subscriber_id' => $subscriberId
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'inscription'
        ], 500);
    }

    /**
     * Récupérer tous les abonnés
     */
    public function getSubscribers()
    {
        try {
            $database = Firebase::database();
            $subscribersRef = $database->getReference('newsletter_subscribers')
                ->orderByChild('created_at')
                ->getSnapshot();

            $subscribers = [];
            if ($subscribersRef->exists()) {
                $subscribers = $subscribersRef->getValue();
            }

            return response()->json([
                'success' => true,
                'subscribers' => $subscribers,
                'count' => count($subscribers)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de récupération des abonnés'
            ], 500);
        }
    }
}