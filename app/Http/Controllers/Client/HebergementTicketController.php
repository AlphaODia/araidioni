<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HebergementTicketController extends Controller
{
    public function show($reservationId)
    {
        try {
            // Récupérer les données de réservation depuis Firebase
            $reservationRef = Firebase::database()
                ->getReference('ReserverHebergement/' . $reservationId);
                
            $reservation = $reservationRef->getValue();
            
            if (!$reservation) {
                abort(404, 'Réservation non trouvée');
            }
            
            // Récupérer les détails de l'hébergement
            $hebergementRef = Firebase::database()
                ->getReference('hebergements/' . $reservation['hebergementId']);
                
            $hebergement = $hebergementRef->getValue();
            
            if (!$hebergement) {
                abort(404, 'Hébergement non trouvé');
            }
            
            // Formater les données pour le ticket
            $ticketData = [
                'reservation_id' => $reservationId,
                'client_nom' => $reservation['userNom'] ?? 'Non spécifié',
                'client_email' => $reservation['userEmail'] ?? 'Non spécifié',
                'client_telephone' => $reservation['userTelephone'] ?? 'Non spécifié',
                'hebergement_nom' => $hebergement['titre'] ?? $hebergement['nom'] ?? 'Hébergement sans nom',
                'hebergement_localisation' => $hebergement['adresseComplete'] ?? $hebergement['localisation'] ?? 'Localisation non spécifiée',
                'ville' => $hebergement['ville'] ?? 'Non spécifiée',
                'pays' => $hebergement['pays'] ?? 'Non spécifié',
                'date_arrivee' => isset($reservation['arrivee']) ? \Carbon\Carbon::parse($reservation['arrivee'])->format('d/m/Y') : 'Non spécifiée',
                'date_depart' => isset($reservation['depart']) ? \Carbon\Carbon::parse($reservation['depart'])->format('d/m/Y') : 'Non spécifiée',
                'nuits' => $reservation['nombreNuits'] ?? 1,
                'prix_total' => $reservation['prixTotal'] ?? 0,
                'statut' => $reservation['statut'] ?? 'en_attente',
                'date_reservation' => isset($reservation['dateReservation']) ? \Carbon\Carbon::parse($reservation['dateReservation'])->format('d/m/Y H:i') : now()->format('d/m/Y H:i')
            ];
            
            return view('client.hebergement-ticket', compact('ticketData'));
            
        } catch (\Exception $e) {
            Log::error('Erreur affichage ticket hébergement: ' . $e->getMessage());
            abort(500, 'Erreur lors du chargement du ticket');
        }
    }
}