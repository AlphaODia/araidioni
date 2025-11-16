<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log; 

class HomeController extends Controller
{
    public function index()
    {
        // Récupération des avis depuis Firebase Realtime Database
        $avis = $this->getAvisFromFirebase();

        $featuredVoyages = [
            [
                'trajet' => 'Conakry - Dakar',
                'date' => Carbon::now()->addDays(3)->format('d/m/Y'),
                'prix' => '150 000 GNF'
            ],
            [
                'trajet' => 'Conakry - Bamako',
                'date' => Carbon::now()->addDays(5)->format('d/m/Y'),
                'prix' => '200 000 GNF'
            ]
        ];

        return view('client.home', [
            'featuredVoyages' => $featuredVoyages,
            'avis' => collect($avis) // Conversion en Collection Laravel
        ]);
    }

    /**
     * Récupère les avis depuis Firebase Realtime Database
     */
    private function getAvisFromFirebase()
    {
    try {
        $firebase = app('firebase.database');
        $reference = $firebase->getReference('demandes_avis')
            ->orderByKey()
            ->limitToFirst(10);
        
        $snapshot = $reference->getSnapshot();
        $data = $snapshot->getValue();
        
        Log::info('Données récupérées avec le package Firebase : ' . ($data ? count($data) : 0));
        
        if ($data && is_array($data)) {
            return array_values($data);
        }
        
        return [];
        
    } catch (\Exception $e) {
        Log::error('Erreur package Firebase: ' . $e->getMessage());
        return [];
    }
    }

    // Alternative: Si vous utilisez le package kreait/firebase-php
    private function getAvisWithFirebasePackage()
    {
        try {
            $firebase = app('firebase.database');
            $reference = $firebase->getReference('demandes_avis')
                ->orderByChild('created_at')
                ->limitToFirst(10);
            
            $snapshot = $reference->getSnapshot();
            $data = $snapshot->getValue();
            
            return $data ?: [];
            
        } catch (\Exception $e) {
            logger()->error('Erreur Firebase: ' . $e->getMessage());
            return [];
        }
    }

    public function about()
    {
        return view('client.about');
    }

    public function contact()
    {
        return view('client.contact');
    }
}