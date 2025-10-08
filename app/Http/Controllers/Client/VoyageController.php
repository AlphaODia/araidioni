<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class VoyageController extends Controller
{
    protected $database;
    protected $cacheDuration = 300; // 5 minutes

    public function __construct()
    {
        try {
            $firebase = (new Factory)
                ->withServiceAccount(base_path('firebase-credentials.json'))
                ->withDatabaseUri("https://arai-dioni-1b65f-default-rtdb.firebaseio.com/");

            $this->database = $firebase->createDatabase();
        } catch (\Exception $e) {
            Log::error('Firebase initialization error: ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->searchTrips($request);
        }

        return view('client.voyages', [
            'trajets' => [],
            'searchParams' => $request->all()
        ]);
    }

    /**
     * API endpoint pour récupérer tous les voyages
     */
    public function apiIndex(Request $request)
    {
        set_time_limit(60);
        try {
            Log::info('Début de la récupération des voyages depuis Firebase');
            
            $reference = $this->database->getReference('search');
            $snapshot = $reference->getSnapshot();
            
            if (!$snapshot->exists()) {
                Log::warning('Aucune donnée trouvée dans Firebase sous /search');
                return response()->json([
                    'success' => false,
                    'error' => 'Aucune donnée dans Firebase'
                ]);
            }
            
            $allData = $snapshot->getValue();
            $trips = [];
            
            Log::info('Nombre de voyages trouvés: ' . count($allData));
            
            foreach ($allData as $tripId => $trip) {
                if (!is_array($trip)) continue;
                
                $normalizedTrip = $this->normalizeTripData($trip);
                
                // CORRECTION: Gestion correcte des IDs
                $normalizedTrip['id'] = $tripId;
                $normalizedTrip['reserved_seats'] = $this->getReservedSeatsForApp($normalizedTrip, $tripId);
                $normalizedTrip['available_seats'] = $this->calculateTotalSeats($normalizedTrip) - count($normalizedTrip['reserved_seats']);
                
                $trips[] = $normalizedTrip;
            }
            
            Log::info('Récupération des voyages terminée avec succès');
            return response()->json([
                'success' => true,
                'data' => $trips
            ]);
            
        } catch (\Exception $e) {
            Log::error('API voyages error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Erreur de chargement des voyages',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function searchTrips(Request $request)
    {
        set_time_limit(60);
        try {
            Log::info('Recherche de voyages', $request->all());
            
            $depart = $request->input('depart');
            $destination = $request->input('destination');
            $date = $request->input('date');
            $typeVehicule = $request->input('vehicle_type');

            $reference = $this->database->getReference('search');
            $snapshot = $reference->getSnapshot();
            $trajets = [];

            if ($snapshot->exists()) {
                $allTrips = $snapshot->getValue();
                
                foreach ($allTrips as $tripId => $trip) {
                    if (!is_array($trip)) continue;

                    // Normaliser les données
                    $normalizedTrip = $this->normalizeTripData($trip);

                    // CORRECTION: Filtrage amélioré avec gestion de la casse et accents
                    $matchesDeparture = !$depart || $this->stringContains(
                        $this->normalizeString($normalizedTrip['departure'] ?? ''),
                        $this->normalizeString($depart)
                    );
                    
                    $matchesDestination = !$destination || $this->stringContains(
                        $this->normalizeString($normalizedTrip['arrival'] ?? ''),
                        $this->normalizeString($destination)
                    );
                    
                    $matchesDate = !$date || (
                        isset($normalizedTrip['date']) && 
                        $this->normalizeDate($normalizedTrip['date']) === $this->normalizeDate($date)
                    );
                    
                    $matchesVehicleType = !$typeVehicule || $this->matchVehicleType(
                        $normalizedTrip['vehicle_type'] ?? '',
                        $typeVehicule
                    );

                    if ($matchesDeparture && $matchesDestination && $matchesDate && $matchesVehicleType) {
                        $normalizedTrip['reserved_seats'] = $this->getReservedSeatsForApp($normalizedTrip, $tripId);
                        $normalizedTrip['available_seats'] = $this->calculateTotalSeats($normalizedTrip) - count($normalizedTrip['reserved_seats']);
                        $normalizedTrip['id'] = $tripId;
                        $trajets[] = $normalizedTrip;
                    }
                }
            }

            Log::info('Recherche terminée: ' . count($trajets) . ' résultats');
            return response()->json([
                'success' => true,
                'trajets' => $trajets
            ]);
            
        } catch (\Exception $e) {
            Log::error('Search trips error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Une erreur s\'est produite lors de la recherche',
                'trajets' => []
            ], 500);
        }
    }

    /**
     * Nouvelle méthode pour normaliser les chaînes (accents, casse)
     */
    private function normalizeString($string)
    {
        return mb_strtolower(trim($string), 'UTF-8');
    }

    public function ticket($reservationId)
    {
        try {
            // Récupérer les détails de la réservation depuis Firebase
            $reservationRef = $this->database->getReference('reservations/' . $reservationId);
            $reservationSnapshot = $reservationRef->getSnapshot();
            
            if (!$reservationSnapshot->exists()) {
                abort(404, 'Réservation non trouvée');
            }
            
            $reservation = $reservationSnapshot->getValue();
            $reservation['id'] = $reservationId;
            
            // Formater les données pour l'affichage
            $ticketData = [
                'reservation_id' => $reservationId,
                'client_nom' => $reservation['client_nom'] ?? $reservation['nom'] ?? 'Non spécifié',
                'client_email' => $reservation['client_email'] ?? $reservation['email'] ?? 'Non spécifié',
                'client_telephone' => $reservation['client_telephone'] ?? $reservation['telephone'] ?? 'Non spécifié',
                'departure' => $reservation['departure'] ?? 'Non spécifié',
                'arrival' => $reservation['arrival'] ?? 'Non spécifié',
                'date' => $reservation['date'] ?? 'Non spécifié',
                'time' => $reservation['time'] ?? $reservation['departure_time'] ?? 'Non spécifié',
                'seats' => is_array($reservation['seats']) ? 
                           implode(', ', $reservation['seats']) : 
                           ($reservation['seats'] ?? $reservation['sieges'] ?? 'Non spécifié'),
                'price' => $reservation['price'] ?? 0,
                'vehicle_type' => $reservation['vehicle_type'] ?? 'Non spécifié',
                'status' => $reservation['status'] ?? $reservation['statut'] ?? 'confirmé',
                'created_at' => $reservation['created_at'] ?? now()->toISOString()
            ];
            
            return view('client.ticket', compact('ticketData'));
            
        } catch (\Exception $e) {
            Log::error('Ticket error: ' . $e->getMessage());
            abort(500, 'Erreur lors de l\'affichage du ticket');
        }
    }

    /**
     * Nouvelle méthode pour vérifier si une chaîne en contient une autre
     */
    private function stringContains($haystack, $needle)
    {
        if (empty($needle)) return true;
        return strpos($haystack, $needle) !== false;
    }

    /**
     * Nouvelle méthode pour normaliser les dates
     */
    private function normalizeDate($dateString)
    {
        try {
            return date('Y-m-d', strtotime($dateString));
        } catch (\Exception $e) {
            return $dateString;
        }
    }

    /**
     * Nouvelle méthode pour matcher les types de véhicules
     */
    private function matchVehicleType($tripVehicleType, $searchVehicleType)
    {
        $equivalents = [
            'taxi' => ['taxi', 'taxi-vip'],
            'taxi-vip' => ['taxi', 'taxi-vip'],
            'bus' => ['bus'],
            'minicar' => ['minicar', 'mini-car']
        ];

        $tripType = mb_strtolower($tripVehicleType);
        $searchType = mb_strtolower($searchVehicleType);

        if (isset($equivalents[$searchType])) {
            return in_array($tripType, $equivalents[$searchType]);
        }

        return $tripType === $searchType;
    }

    /**
     * Calcule le nombre total de sièges
     */
    private function calculateTotalSeats($trajet)
    {
        $vehicleType = mb_strtolower($trajet['vehicle_type'] ?? '');
        
        switch ($vehicleType) {
            case 'bus':
                return 53;
            case 'minicar':
            case 'mini-car':
                return 14;
            case 'taxi':
            case 'taxi-vip':
                return 6;
            default:
                return 0;
        }
    }

    /**
     * Normalise les données du trajet
     */
    private function normalizeTripData($trip)
    {
        $normalized = [];
        
        // Départ
        $normalized['departure'] = $trip['ville_depart'] ?? $trip['departure'] ?? $trip['depart'] ?? '';
        
        // Arrivée
        $normalized['arrival'] = $trip['ville_arrivee'] ?? $trip['arrival'] ?? $trip['arrivee'] ?? '';
        
        // Date - formatage uniforme
        $rawDate = $trip['date_depart'] ?? $trip['date'] ?? '';
        try {
            $normalized['date'] = date('Y-m-d', strtotime($rawDate));
        } catch (\Exception $e) {
            $normalized['date'] = $rawDate;
        }
        
        // Heure de départ - formatage uniforme
        $rawTime = $trip['heure_depart'] ?? $trip['departure_time'] ?? $trip['time'] ?? '';
        try {
            $normalized['departure_time'] = date('H:i', strtotime($rawTime));
        } catch (\Exception $e) {
            $normalized['departure_time'] = $rawTime;
        }
        
        // Prix
        if (isset($trip['prix'])) {
            $normalized['price'] = is_numeric($trip['prix']) ? (float)$trip['prix'] : 0;
        } else if (isset($trip['price'])) {
            $normalized['price'] = is_numeric($trip['price']) ? (float)$trip['price'] : 0;
        } else {
            $normalized['price'] = 0;
        }
        
        // Type de véhicule - normalisation
        $vehicleType = $trip['vehicule_type'] ?? $trip['vehicle_type'] ?? $trip['type_vehicule'] ?? '';
        $normalized['vehicle_type'] = $this->normalizeVehicleType($vehicleType);
        
        return $normalized;
    }

    /**
     * Normalise les types de véhicules
     */
    private function normalizeVehicleType($vehicleType)
    {
        $equivalents = [
            'taxi-vip' => 'taxi-vip',
            'taxi vip' => 'taxi-vip',
            'vip' => 'taxi-vip',
            'minicar' => 'minicar',
            'mini-car' => 'minicar',
            'mini car' => 'minicar',
            'bus' => 'bus',
            'autobus' => 'bus'
        ];

        $lowerType = mb_strtolower(trim($vehicleType));
        return $equivalents[$lowerType] ?? $vehicleType;
    }

    /**
     * MÉTHODE ADAPTÉE POUR L'APPLICATION : Récupère les sièges réservés au format App
     */
    private function getReservedSeatsForApp($trajet, $voyageId)
    {
        try {
            $reservedSeats = [];
            $reservationsRef = $this->database->getReference('reservations');
            
            // Recherche comme dans l'application Flutter : par date + filtrage manuel
            $query = $reservationsRef
                ->orderByChild('date')
                ->equalTo($trajet['date'] ?? '');
                
            $snapshot = $query->getSnapshot();
            
            if ($snapshot->exists()) {
                $reservations = $snapshot->getValue();
                
                foreach ($reservations as $reservation) {
                    if (!is_array($reservation)) continue;
                    
                    // Vérification exactement comme dans l'app Flutter
                    $matchesDeparture = ($reservation['departure'] ?? '') === ($trajet['departure'] ?? '');
                    $matchesArrival = ($reservation['arrival'] ?? '') === ($trajet['arrival'] ?? '');
                    $matchesTime = $this->normalizeTimeForApp($reservation['time'] ?? '') === $this->normalizeTimeForApp($trajet['departure_time'] ?? '');
                    
                    // Vérification supplémentaire par voyage_id (comme dans l'app)
                    $matchesVoyageId = isset($reservation['voyage_id']) && $reservation['voyage_id'] === $voyageId;
                    $matchesVoyageKey = isset($reservation['voyage_key']) && $reservation['voyage_key'] === $voyageId;
                    
                    if (($matchesDeparture && $matchesArrival && $matchesTime) || $matchesVoyageId || $matchesVoyageKey) {
                        $seats = $this->extractSeatsForApp($reservation);
                        $reservedSeats = array_merge($reservedSeats, $seats);
                    }
                }
            }
            
            return array_unique($reservedSeats);
            
        } catch (\Exception $e) {
            Log::error('Get reserved seats for app error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Extrait les sièges au format Application (string)
     */
    private function extractSeatsForApp($reservation)
    {
        if (!is_array($reservation)) {
            return [];
        }
        
        $seats = $reservation['seats'] ?? $reservation['sieges'] ?? '';
        
        if ($seats === null || $seats === '') {
            return [];
        }
        
        // FORMAT APPLICATION : toujours retourner un tableau à partir d'une string
        if (is_string($seats)) {
            // "26" ou "26,27,28" → ["26"] ou ["26", "27", "28"]
            return !empty(trim($seats)) ? array_map('trim', explode(',', $seats)) : [];
        } 
        
        // Si c'est un tableau (ancien format site web), le convertir en format app
        if (is_array($seats)) {
            return array_filter($seats, function($seat) {
                return $seat !== null && $seat !== '';
            });
        }
        
        return [];
    }

    /**
     * Normalise le temps pour la comparaison (comme dans l'app)
     */
    private function normalizeTimeForApp($timeString)
    {
        if (empty($timeString)) return '';
        
        try {
            // Format simple HH:MM comme dans l'application
            $time = strtotime($timeString);
            if ($time === false) return $timeString;
            
            return date('H:i', $time);
        } catch (\Exception $e) {
            return $timeString;
        }
    }

    /**
     * MÉTHODE DE RÉSERVATION PRINCIPALE - CORRIGÉE
     */
    public function reserver(Request $request)
    {
        try {
            $validated = $request->validate([
                'voyage_id' => 'required|string',
                'seats' => 'required|array',
                'seats.*' => 'string',
                'nom' => 'required|string|max:255',
                'email' => 'required|email',
                'telephone' => 'required|string|max:20',
                'user_id' => 'sometimes|string' // Pour la compatibilité avec l'app
            ]);

            // Vérifier si les sièges sont disponibles
            $voyageRef = $this->database->getReference('search/' . $validated['voyage_id']);
            $voyageSnapshot = $voyageRef->getSnapshot();
            
            if (!$voyageSnapshot->exists()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Voyage non trouvé'
                ], 404);
            }
            
            $voyage = $voyageSnapshot->getValue();
            $normalizedTrip = $this->normalizeTripData($voyage);
            
            // Vérification des sièges réservés (format application)
            $reservedSeats = $this->getReservedSeatsForApp($normalizedTrip, $validated['voyage_id']);
            
            $requestedSeats = $validated['seats'];
            $alreadyReserved = array_intersect($requestedSeats, $reservedSeats);
            
            if (!empty($alreadyReserved)) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Certains sièges sont déjà réservés: ' . implode(', ', $alreadyReserved)
                ], 400);
            }

            // FORMAT APPLICATION : seats en string séparée par des virgules
            $seatsString = is_array($validated['seats']) ? implode(',', $validated['seats']) : $validated['seats'];

            // Créer la réservation avec le FORMAT APPLICATION
            $reservationData = [
                'voyage_id' => $validated['voyage_id'], // Comme dans l'app
                'seats' => $seatsString, // FORMAT APP: "26" ou "26,27"
                'status' => 'confirmé',
                'created_at' => now()->timestamp * 1000, // Format timestamp
                
                // Clé de voyage comme dans l'app
                'voyage_key' => $validated['voyage_id'], // Utilise l'ID du voyage comme dans l'app
                
                // Informations du voyage
                'departure' => $normalizedTrip['departure'],
                'arrival' => $normalizedTrip['arrival'],
                'date' => $normalizedTrip['date'],
                'time' => $normalizedTrip['departure_time'],
                'price' => $normalizedTrip['price'],
                'vehicle_type' => $normalizedTrip['vehicle_type']
            ];
            
            // Informations client
            $reservationData['nom'] = $validated['nom'];
            $reservationData['email'] = $validated['email'];
            $reservationData['telephone'] = $validated['telephone'];
            
            // Gestion user_id (comme dans l'app)
            if (isset($validated['user_id'])) {
                $reservationData['user_id'] = $validated['user_id'];
            } elseif (Auth::check()) {
                $reservationData['user_id'] = Auth::id();
            }

            // Sauvegarder dans Firebase
            $reservationsRef = $this->database->getReference('reservations');
            $newReservation = $reservationsRef->push($reservationData);
            $reservationId = $newReservation->getKey();

            // Ajouter l'ID de réservation (comme dans l'app)
            $this->database->getReference('reservations/' . $reservationId . '/reservation_id')
                ->set($reservationId);

            // Rediriger vers la page du ticket après réservation
            return response()->json([
                'success' => true, 
                'reservation_id' => $reservationId,
                'redirect_url' => url("/ticket/{$reservationId}"),
                'message' => 'Réservation effectuée avec succès'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Reservation error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Erreur lors de la réservation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * NOUVELLE MÉTHODE : API pour les réservations (utilisée par JavaScript)
     */
    public function apiReserver(Request $request)
    {
        // Cette méthode est un alias de la méthode reserver() pour l'API
        return $this->reserver($request);
    }

    /**
     * Nouvelle méthode pour afficher le formulaire de réservation pour non authentifiés
     */
    public function showReservationForm($voyageId)
    {
        try {
            $reference = $this->database->getReference('search/' . $voyageId);
            $snapshot = $reference->getSnapshot();
            
            if (!$snapshot->exists()) {
                abort(404, 'Voyage non trouvé');
            }
            
            $voyage = $snapshot->getValue();
            $voyageData = $this->normalizeTripData($voyage);
            $voyageData['id'] = $voyageId;
            $voyageData['reserved_seats'] = $this->getReservedSeatsForApp($voyageData, $voyageId);
            $voyageData['available_seats'] = $this->calculateTotalSeats($voyageData) - count($voyageData['reserved_seats']);
            
            return view('client.reservation-form', compact('voyageData'));
            
        } catch (\Exception $e) {
            Log::error('Reservation form error: ' . $e->getMessage());
            abort(500, 'Erreur lors du chargement du formulaire');
        }
    }

    /**
     * Méthode pour la recherche POST
     */
    public function search(Request $request)
    {
        return $this->searchTrips($request);
    }

    /**
     * Méthode de debug pour vérifier les données Firebase
     */
    public function debugTrips()
    {
        try {
            $reference = $this->database->getReference('search');
            $snapshot = $reference->getSnapshot();
            
            if (!$snapshot->exists()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Aucune donnée dans Firebase'
                ]);
            }
            
            $allData = $snapshot->getValue();
            
            return response()->json([
                'success' => true,
                'count' => count($allData),
                'data' => $allData
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les détails d'un voyage spécifique
     */
    public function show($id)
    {
        try {
            $reference = $this->database->getReference('search/' . $id);
            $snapshot = $reference->getSnapshot();
            
            if (!$snapshot->exists()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Voyage non trouvé'
                ], 404);
            }
            
            $voyage = $snapshot->getValue();
            $voyageData = $this->normalizeTripData($voyage);
            
            // Utiliser la méthode adaptée pour l'application
            $voyageData['reserved_seats'] = $this->getReservedSeatsForApp($voyageData, $id);
            $voyageData['available_seats'] = $this->calculateTotalSeats($voyageData) - count($voyageData['reserved_seats']);
            
            return response()->json([
                'success' => true,
                'voyage' => $voyageData
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les sièges réservés pour un voyage (format application)
     */
    public function getSiegesReserves($voyageId)
    {
        try {
            $reference = $this->database->getReference('search/' . $voyageId);
            $snapshot = $reference->getSnapshot();
            
            if (!$snapshot->exists()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Voyage non trouvé'
                ], 404);
            }
            
            $voyage = $snapshot->getValue();
            $voyageData = $this->normalizeTripData($voyage);
            
            // Version adaptée pour l'application
            $reservedSeats = $this->getReservedSeatsForApp($voyageData, $voyageId);
            
            return response()->json([
                'success' => true,
                'reserved_seats' => $reservedSeats
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
 * Méthode unifiée de réservation (alias pour compatibilité)
 */
public function createReservationUnified(Request $request)
{
    // Cette méthode appelle simplement la méthode reserver() principale
    return $this->reserver($request);
}

    /**
     * Obtenir les réservations d'un utilisateur
     */
    public function mesReservations()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Utilisateur non connecté'
                ], 401);
            }
            
            $userId = Auth::id();
            $reservationsRef = $this->database->getReference('reservations');
            
            $query = $reservationsRef->orderByChild('user_id')->equalTo($userId);
            $snapshot = $query->getSnapshot();
            
            $userReservations = [];
            if ($snapshot->exists()) {
                $reservations = $snapshot->getValue();
                foreach ($reservations as $reservationId => $reservation) {
                    if (is_array($reservation) && isset($reservation['user_id']) && $reservation['user_id'] == $userId) {
                        $reservation['id'] = $reservationId;
                        $userReservations[] = $reservation;
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'reservations' => $userReservations
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    /**
     * Annuler une réservation
     */
    public function annulerReservation($reservationId)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Utilisateur non connecté'
                ], 401);
            }
            
            $reference = $this->database->getReference('reservations/' . $reservationId);
            $snapshot = $reference->getSnapshot();
            
            if (!$snapshot->exists()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Réservation non trouvée'
                ], 404);
            }
            
            $reservation = $snapshot->getValue();
            
            if (!isset($reservation['user_id']) || $reservation['user_id'] != Auth::id()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Non autorisé'
                ], 403);
            }
            
            // Marquer comme annulée
            $reference->update([
                'status' => 'annulée',
                'updated_at' => now()->toISOString()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Réservation annulée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Méthode pour convertir les réservations existantes au format application
     */
    public function convertToAppFormat()
    {
        try {
            Log::info('Début de la conversion au format application');
            
            $reservationsRef = $this->database->getReference('reservations');
            $snapshot = $reservationsRef->getSnapshot();
            
            $convertedCount = 0;
            
            if ($snapshot->exists()) {
                $reservations = $snapshot->getValue();
                
                foreach ($reservations as $reservationId => $reservation) {
                    if (!is_array($reservation)) continue;
                    
                    $updates = [];
                    
                    // Convertir les sièges en string si c'est un tableau
                    if (isset($reservation['seats']) && is_array($reservation['seats'])) {
                        $updates['seats'] = implode(',', $reservation['seats']);
                    }
                    
                    // S'assurer que voyage_key = voyage_id (comme dans l'app)
                    if (isset($reservation['voyage_id']) && !isset($reservation['voyage_key'])) {
                        $updates['voyage_key'] = $reservation['voyage_id'];
                    }
                    
                    // Appliquer les conversions
                    if (!empty($updates)) {
                        $this->database->getReference('reservations/' . $reservationId)
                            ->update($updates);
                        $convertedCount++;
                        Log::info("Réservation {$reservationId} convertie: " . json_encode($updates));
                    }
                }
            }
            
            Log::info("Conversion terminée: {$convertedCount} réservations converties");
            
            return response()->json([
                'success' => true, 
                'message' => "{$convertedCount} réservations converties au format application",
                'converted_count' => $convertedCount
            ]);
            
        } catch (\Exception $e) {
            Log::error('Conversion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}