<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Avis;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;

class AvisController extends Controller
{
    /**
     * Afficher le formulaire d'avis
     */
    public function create()
    {
        return view('avis.create');
    }

    /**
     * Soumettre un avis - Version corrigée avec messages détaillés
     */
    public function store(Request $request)
    {
        // Log pour debug
        Log::info('Avis store request received', [
            'all_data' => $request->all(),
            'content_type' => $request->header('Content-Type')
        ]);

        // Récupérer les données selon le format
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $data = $request->json()->all();
        } else {
            $data = $request->all();
        }

        // Validation des données avec messages personnalisés en français
        $validator = Validator::make($data, [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service_type' => 'required|string|in:voyage,colis,hebergement,transfert',
            'message' => 'required|string|min:10|max:1000',
            'telephone' => 'sometimes|string|max:20|nullable',
            'rating' => 'sometimes|integer|between:1,5'
        ], [
            // Messages personnalisés en français
            'nom.required' => 'Le nom complet est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères valide.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            
            'service_type.required' => 'Veuillez sélectionner un type de service.',
            'service_type.in' => 'Le type de service sélectionné n\'est pas valide.',
            
            'message.required' => 'Le message est obligatoire.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'message.max' => 'Le message ne doit pas dépasser 1000 caractères.',
            
            'telephone.string' => 'Le numéro de téléphone doit être valide.',
            'telephone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères.',
            
            'rating.integer' => 'La note doit être un nombre entier.',
            'rating.between' => 'La note doit être entre 1 et 5.',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                'data' => $data
            ]);
            
            // Réponse JSON détaillée pour les requêtes AJAX
            if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Veuillez corriger les erreurs du formulaire',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }
            
            // Pour les requêtes normales, redirection avec les erreurs
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();
        Log::info('Data validated successfully', ['validated_data' => $validatedData]);

        try {
            // Sauvegarder dans Firebase
            $avisId = Avis::saveToFirebase($validatedData);

            if ($avisId) {
                Log::info('Avis saved successfully', ['avis_id' => $avisId]);
                
                // Réponse JSON pour les requêtes AJAX
                if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Merci pour votre avis! Nous le traiterons rapidement.',
                        'avis_id' => $avisId
                    ], 200);
                }
                
                return redirect()->back()
                    ->with('success', 'Merci pour votre avis! Nous le traiterons rapidement.');
            }

            Log::error('Avis save returned false');
            
            if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'envoi de votre avis. Veuillez réessayer.'
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'envoi de votre avis')
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Avis save exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de connexion au serveur: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Erreur de connexion au serveur: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Récupérer les avis approuvés pour affichage public
     */
    public function showApproved()
    {
        try {
            $database = Firebase::database();
            $avisRef = $database->getReference('demandes_avis')
                ->orderByChild('status')
                ->equalTo('approved')
                ->getSnapshot();

            $avis = $avisRef->exists() ? $avisRef->getValue() : [];

            return view('avis.public', compact('avis'));

        } catch (\Exception $e) {
            Log::error('Error fetching approved avis', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Erreur de récupération des avis');
        }
    }

    /**
     * Approuver un avis (admin)
     */
    public function approve($avisId)
    {
        try {
            $database = Firebase::database();
            $database->getReference("demandes_avis/{$avisId}/status")
                ->set('approved');

            Log::info('Avis approved', ['avis_id' => $avisId]);

            return redirect()->back()
                ->with('success', 'Avis approuvé avec succès');

        } catch (\Exception $e) {
            Log::error('Error approving avis', [
                'avis_id' => $avisId,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'approbation');
        }
    }

    /**
     * Méthode de test pour vérifier la connexion Firebase
     */
    public function testFirebase()
    {
        try {
            $database = Firebase::database();
            $testRef = $database->getReference('test_connection');
            $testRef->set([
                'timestamp' => now()->toDateTimeString(),
                'message' => 'Test de connexion Firebase'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Connexion Firebase réussie'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur Firebase: ' . $e->getMessage()
            ], 500);
        }
    }
}