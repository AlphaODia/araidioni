<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Newsletter;
use Kreait\Laravel\Firebase\Facades\Firebase;

class NewsletterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription
     */
    public function showForm()
    {
        return view('newsletter.subscribe');
    }
    
    /**
     * Ajouter un email à la newsletter
     */
public function subscribe(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|max:255'
    ]);

    if ($validator->fails()) {
        // Si c'est une requête AJAX, retourner JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Adresse email invalide',
                'errors' => $validator->errors()
            ], 422);
        }
        
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $email = $request->input('email');

    // Vérifier si l'email existe déjà
    if (Newsletter::checkEmailExists($email)) {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Cet email est déjà inscrit à notre newsletter'
            ], 409);
        }
        
        return redirect()->back()
            ->with('error', 'Cet email est déjà inscrit à notre newsletter')
            ->withInput();
    }

    // Sauvegarder dans Firebase
    $subscriberId = Newsletter::saveToFirebase($email);

    if ($subscriberId) {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Inscription à la newsletter réussie! Merci de votre abonnement.',
                'subscriber_id' => $subscriberId
            ], 200);
        }
        
        return redirect()->back()
            ->with('success', 'Inscription à la newsletter réussie! Merci de votre abonnement.');
    }

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'inscription'
        ], 500);
    }
    
    return redirect()->back()
        ->with('error', 'Erreur lors de l\'inscription')
        ->withInput();
}

    /**
     * Récupérer tous les abonnés (pour l'admin)
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

            return view('admin.newsletter.subscribers', compact('subscribers'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur de récupération des abonnés');
        }
    }
}