<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Avis;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AvisController extends Controller
{
    /**
     * Soumettre un avis
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service_type' => 'required|string|in:voyage,colis,hebergement',
            'message' => 'required|string|min:10|max:1000',
            'telephone' => 'sometimes|string|max:20',
            'rating' => 'sometimes|integer|between:1,5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez corriger les erreurs',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['nom', 'email', 'telephone', 'service_type', 'message', 'rating']);

        // Sauvegarder dans Firebase
        $avisId = Avis::saveToFirebase($data);

        if ($avisId) {
            return response()->json([
                'success' => true,
                'message' => 'Merci pour votre avis! Nous le traiterons rapidement.',
                'avis_id' => $avisId
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'envoi de votre avis'
        ], 500);
    }

    /**
     * Récupérer tous les avis
     */
    public function index()
    {
        try {
            $avis = Avis::getAllFromFirebase();

            return response()->json([
                'success' => true,
                'avis' => $avis,
                'count' => count($avis)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de récupération des avis'
            ], 500);
        }
    }

    /**
     * Récupérer les avis approuvés pour affichage public
     */
    public function getApprovedAvis()
    {
        try {
            $database = Firebase::database();
            $avisRef = $database->getReference('demandes_avis')
                ->orderByChild('status')
                ->equalTo('approved')
                ->getSnapshot();

            $avis = $avisRef->exists() ? $avisRef->getValue() : [];

            return response()->json([
                'success' => true,
                'avis' => $avis,
                'count' => count($avis)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de récupération des avis'
            ], 500);
        }
    }
}