<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Models\Colis;

class ColisController extends Controller
{
    public function index()
    {
        $colisData = Colis::all();
        
        $colis = [];
        foreach ($colisData as $id => $item) {
            $groupeColis = $this->getGroupeColis($item['groupe_colis_id']);
            $position = $this->getVillePosition($groupeColis['ville_actuelle'] ?? null);
            
            $colis[$id] = $item;
            $colis[$id]['position'] = $position;
        }
        
        return view('client.colis.index', compact('colis'));
    }

    private function getGroupeColis($groupeId)
    {
        if (!$groupeId) return [];
        
        $data = Firebase::database()->getReference('groupesColis/'.$groupeId)->getValue();
        return is_array($data) ? $data : [];
    }

    private function getVillePosition($villeId)
    {
        if (!$villeId) return ['lat' => 0, 'lng' => 0];
        
        $data = Firebase::database()->getReference('villes/'.$villeId)->getValue();
        
        return [
            'lat' => $data['latitude'] ?? 0,
            'lng' => $data['longitude'] ?? 0
        ];
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string'
        ]);

        try {
            // Normaliser le numéro de tracking
            $trackingNumber = $request->tracking_number;
            
            // Vérifier si le numéro contient un préfixe avec chiffre (TR01-, TR02-, etc.)
            if (preg_match('/^TR\d{2}-/', $trackingNumber)) {
                // Format déjà correct, on ne change rien
                $normalizedTracking = $trackingNumber;
            } 
            // Vérifier si c'est le format TR- sans chiffres
            else if (preg_match('/^TR-/', $trackingNumber)) {
                // Convertir TR- en TR00- pour la compatibilité
                $normalizedTracking = 'TR00-' . substr($trackingNumber, 3);
            }
            // Si c'est juste un numéro sans préfixe
            else if (is_numeric($trackingNumber)) {
                // Ajouter le préfixe TR00- par défaut
                $normalizedTracking = 'TR00-' . $trackingNumber;
            }
            // Autre format non reconnu
            else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Format de numéro de tracking non reconnu. Formats acceptés: TR123456, TR-123456, TR01-123456');
            }

            $colis = Colis::findByTrackingNumber($normalizedTracking);

            if (!$colis) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Le numéro de suivi "'.$request->tracking_number.'" est introuvable. Veuillez vérifier et réessayer.');
            }

            return redirect()->route('colis.show', $colis['id']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la recherche. Veuillez réessayer.');
        }
    }

    public function show($id)
    {
        $colis = Colis::find($id);
        
        if (!$colis) {
            abort(404, 'Colis non trouvé');
        }

        // Récupérer les informations de la ville actuelle depuis Firebase
        $villeActuelle = [];
        if (isset($colis['groupe_colis_id'])) {
            $groupeColis = Firebase::database()
                ->getReference('groupesColis/'.$colis['groupe_colis_id'])
                ->getValue();
            
            if ($groupeColis && isset($groupeColis['ville_actuelle'])) {
                $villeActuelle = Firebase::database()
                    ->getReference('villes/'.$groupeColis['ville_actuelle'])
                    ->getValue();
            }
        }

        // Récupérer les informations de la ville de destination
        $villeDestination = [];
        if (isset($colis['ville_destination'])) {
            $villeDestination = Firebase::database()
                ->getReference('villes/'.$colis['ville_destination'])
                ->getValue();
        }

        return view('client.colis.show', [
            'colis' => $colis,
            'villeActuelle' => $villeActuelle,
            'villeDestination' => $villeDestination
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string'
        ]);

        // Normaliser le numéro de tracking
        $trackingNumber = $request->tracking_number;
        
        // Vérifier si le numéro contient un préfixe avec chiffre (TR01-, TR02-, etc.)
        if (preg_match('/^TR\d{2}-/', $trackingNumber)) {
            // Format déjà correct, on ne change rien
            $normalizedTracking = $trackingNumber;
        } 
        // Vérifier si c'est le format TR- sans chiffres
        else if (preg_match('/^TR-/', $trackingNumber)) {
            // Convertir TR- en TR00- pour la compatibilité
            $normalizedTracking = 'TR00-' . substr($trackingNumber, 3);
        }
        // Si c'est juste un numéro sans préfixe
        else if (is_numeric($trackingNumber)) {
            // Ajouter le préfixe TR00- par défaut
            $normalizedTracking = 'TR00-' . $trackingNumber;
        }
        // Autre format non reconnu
        else {
            return back()->with('error', 'Format de numéro de tracking non reconnu. Formats acceptés: TR123456, TR-123456, TR01-123456');
        }

        $colis = Colis::findByTrackingNumber($normalizedTracking);

        if (!$colis) {
            return back()->with('error', 'Numéro de suivi introuvable');
        }

        return redirect()->route('colis.show', $colis['id']);
    }
}