<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class HebergementController extends Controller
{
    public function index()
    {
        Log::info('Début de la récupération des hébergements');
        
        try {
            $cacheKey = 'hebergements_list_' . md5(serialize(request()->all()));
            
            $data = Cache::remember($cacheKey, 300, function () {
                $hebergements = [];
                
                try {
                    $hebergementsRef = Firebase::database()
                        ->getReference('hebergements');

                    $hebergementsSnapshot = $hebergementsRef->getSnapshot();

                    if (!$hebergementsSnapshot->exists()) {
                        Log::warning('Aucun hébergement trouvé dans Firebase');
                        return [
                            'hebergements' => [],
                            'villes' => [],
                            'types' => []
                        ];
                    }

                    $hebergementsData = $hebergementsSnapshot->getValue();
                    Log::info('Nombre d\'hébergements récupérés de Firebase: ' . count($hebergementsData));
                    
                    $reservations = [];
                    try {
                        $reservationsSnapshot = Firebase::database()
                            ->getReference('ReserverHebergement')
                            ->limitToFirst(100)
                            ->getSnapshot();
                        
                        if ($reservationsSnapshot->exists()) {
                            $reservations = $reservationsSnapshot->getValue();
                        }
                    } catch (\Exception $e) {
                        Log::warning('Erreur récupération réservations: ' . $e->getMessage());
                    }

                    foreach ($hebergementsData as $id => $hebergement) {
                        try {
                            if (($hebergement['isDisponible'] ?? false) === true) {
                                $formattedHebergement = $this->formatHebergementData($id, $hebergement);
                                $formattedHebergement['estDisponible'] = $this->verifierDisponibilite($formattedHebergement, $reservations);
                                $hebergements[$id] = $formattedHebergement;
                            }
                        } catch (\Exception $e) {
                            Log::error('Erreur formatage hébergement ' . $id . ': ' . $e->getMessage());
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Erreur de connexion Firebase: ' . $e->getMessage());
                    return [
                        'hebergements' => [],
                        'villes' => [],
                        'types' => []
                    ];
                }

                $villes = [];
                $types = [];
                
                foreach ($hebergements as $hebergement) {
                    if (!empty($hebergement['ville'])) {
                        $villes[$hebergement['ville']] = $hebergement['ville'];
                    }
                    if (!empty($hebergement['typeLogement'])) {
                        $types[$hebergement['typeLogement']] = $hebergement['typeLogement'];
                    }
                }

                return [
                    'hebergements' => $hebergements,
                    'villes' => array_values($villes),
                    'types' => array_values($types)
                ];
            });

            $data['hebergements'] = $this->nettoyerDonneesUTF8($data['hebergements']);
            $data['hebergementsJson'] = $this->preparerJsonPourVue($data['hebergements']);

            if (empty($data['hebergements'])) {
                Log::info('Aucun hébergement trouvé après traitement');
            } else {
                Log::info('Nombre d\'hébergements retournés: ' . count($data['hebergements']));
            }

            return view('client.hebergements', $data);

        } catch (\Exception $e) {
            Log::error('Erreur de récupération des hébergements: '.$e->getMessage());
            Log::error('Trace: '.$e->getTraceAsString());
            
            return view('client.hebergements', [
                'hebergements' => [],
                'hebergementsJson' => '[]',
                'villes' => [],
                'types' => []
            ]);
        }
    }

    private function formatHebergementData($id, $data)
    {
        $coordsData = $data['coordonnees'] ?? [];
        $coordonnees = [
            'lat' => (isset($coordsData['lat']) ? floatval($coordsData['lat']) : 0.0),
            'lng' => (isset($coordsData['lng']) ? floatval($coordsData['lng']) : 0.0)
        ];

        $titre = 'Sans titre';
        if (isset($data['titre'])) {
            $titre = $data['titre'];
        } else if (isset($data['nom'])) {
            $titre = $data['nom'];
        } else if (isset($data['name'])) {
            $titre = $data['name'];
        }

        return [
            'id' => $id,
            'titre' => $titre,
            'description' => $data['description'] ?? '',
            'localisation' => $data['adresseComplete'] ?? ($data['localisation'] ?? ''),
            'prixNuit' => floatval($data['prixNuit'] ?? 0),
            'typeLogement' => $data['typeLogement'] ?? '',
            'capacite' => intval($data['capacite'] ?? 1),
            'equipements' => $this->convertirListe($data['equipements'] ?? []),
            'regles' => $this->convertirListe($data['regles'] ?? []),
            'imagesUrls' => $this->convertirListe($data['imagesUrls'] ?? []),
            'agentId' => $data['agentId'] ?? '',
            'dateCreation' => isset($data['dateCreation']) ? Carbon::parse($data['dateCreation']) : now(),
            'isDisponible' => $data['isDisponible'] ?? true,
            'servicesSupplementaires' => $this->convertirListe($data['servicesSupplementaires'] ?? []),
            'adresseComplete' => $data['adresseComplete'] ?? '',
            'ville' => $data['ville'] ?? '',
            'superficie' => floatval($data['superficie'] ?? 0),
            'nombreChambres' => intval($data['nombreChambres'] ?? 1),
            'nombreSallesDeBain' => intval($data['nombreSallesDeBain'] ?? 1),
            'coordonnees' => $coordonnees,
            'rating' => $data['rating'] ?? '4.5',
            'estDisponible' => true,
            'pays' => $data['pays'] ?? 'Sénégal'
        ];
    }

    private function convertirListe($data)
    {
        $resultat = [];
        
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_string($value)) {
                    $resultat[] = $value;
                } else if ($value !== null) {
                    $resultat[] = (string)$value;
                }
            }
        }
        
        return $resultat;
    }

    private function verifierDisponibilite($hebergement, $reservations)
    {
        if (isset($hebergement['datesBloquees']) && is_array($hebergement['datesBloquees'])) {
            $aujourdhui = now()->format('Y-m-d');
            foreach ($hebergement['datesBloquees'] as $date => $estBloquee) {
                if ($estBloquee && $date >= $aujourdhui) {
                    return false;
                }
            }
        }
        
        foreach ($reservations as $reservation) {
            if (($reservation['hebergementId'] ?? '') === $hebergement['id'] && 
                ($reservation['statut'] ?? '') === 'confirme') {
                return false;
            }
        }
        
        return true;
    }

    private function nettoyerDonneesUTF8($donnees)
    {
        if (is_array($donnees)) {
            foreach ($donnees as $key => $value) {
                $donnees[$key] = $this->nettoyerDonneesUTF8($value);
            }
            return $donnees;
        } elseif (is_string($donnees)) {
            if (!mb_check_encoding($donnees, 'UTF-8')) {
                $donnees = mb_convert_encoding($donnees, 'UTF-8', 'UTF-8');
            }
            $donnees = preg_replace('/[^\x{0009}\x{000A}\x{000D}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', ' ', $donnees);
            return $donnees;
        }
        return $donnees;
    }

    private function preparerJsonPourVue($donnees)
    {
        try {
            $json = json_encode($donnees, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
            
            if ($json === false) {
                Log::error('Erreur d\'encodage JSON: ' . json_last_error_msg());
                return '[]';
            }
            
            return $json;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la préparation du JSON: ' . $e->getMessage());
            return '[]';
        }
    }

    public function show($id)
    {
        try {
            Log::info('Tentative d\'accès à l\'hébergement: ' . $id);
            
            $cacheKey = 'hebergement_details_' . $id;
            
            $data = Cache::remember($cacheKey, 300, function () use ($id) {
                $hebergement = Firebase::database()
                    ->getReference('hebergements/'.$id)
                    ->getValue();

                if (!$hebergement) {
                    Log::warning('Hébergement non trouvé dans Firebase: ' . $id);
                    return null;
                }

                $formattedHebergement = $this->formatHebergementData($id, $hebergement);
                
                $reservationsRef = Firebase::database()
                    ->getReference('ReserverHebergement')
                    ->orderByChild('hebergementId')
                    ->equalTo($id)
                    ->getSnapshot();
                    
                $reservedDates = [];
                if ($reservationsRef->exists()) {
                    $reservations = $reservationsRef->getValue();
                    
                    foreach ($reservations as $reservation) {
                        $statut = $reservation['statut'] ?? 'en_attente';
                        if ($statut === 'confirme' || $statut === 'en_attente') {
                            $arrivee = Carbon::parse($reservation['arrivee']);
                            $depart = Carbon::parse($reservation['depart']);
                            
                            $currentDate = $arrivee->copy();
                            while ($currentDate->lt($depart)) {
                                $reservedDates[$currentDate->format('Y-m-d')] = true;
                                $currentDate->addDay();
                            }
                        }
                    }
                }

                return [
                    'hebergement' => $formattedHebergement,
                    'id' => $id,
                    'reservedDates' => $reservedDates
                ];
            });

            if (!$data) {
                Log::error('Hébergement non trouvé après traitement: ' . $id);
                abort(404, 'Hébergement non trouvé');
            }

            $data['hebergement'] = $this->nettoyerDonneesUTF8($data['hebergement']);

            Log::info('Affichage des détails de l\'hébergement: ' . $id);
            return view('client.hebergement-details', $data);

        } catch (\Exception $e) {
            Log::error('Erreur de récupération des détails: '.$e->getMessage());
            Log::error('Trace: '.$e->getTraceAsString());
            abort(404, 'Erreur lors du chargement des détails de l\'hébergement');
        }
    }

    public function apiHebergements()
    {
        try {
            $cacheKey = 'hebergements_api';
            
            $hebergements = Cache::remember($cacheKey, 300, function () {
                $hebergementsData = [];
                $hebergementsRef = Firebase::database()
                    ->getReference('hebergements')
                    ->orderByChild('isDisponible')
                    ->equalTo(true)
                    ->limitToFirst(50);

                $hebergementsSnapshot = $hebergementsRef->getSnapshot();

                if ($hebergementsSnapshot->exists()) {
                    $data = $hebergementsSnapshot->getValue();
                    
                    foreach ($data as $id => $hebergement) {
                        if (($hebergement['isDisponible'] ?? false) === true) {
                            $formattedHebergement = $this->formatHebergementData($id, $hebergement);
                            $hebergementsData[$id] = $formattedHebergement;
                        }
                    }
                }

                return $hebergementsData;
            });

            $hebergements = $this->nettoyerDonneesUTF8($hebergements);

            return response()->json($hebergements);
        } catch (\Exception $e) {
            Log::error('Erreur API hébergements: '.$e->getMessage());
            return response()->json([], 500);
        }
    }

    public function reserver(Request $request)
    {
        try {
            $user = Auth::user();
            $hebergementId = $request->input('hebergement_id');
            
            $validated = $request->validate([
                'hebergement_id' => 'required',
                'arrivee' => 'required|date',
                'depart' => 'required|date|after:arrivee',
                'nom' => 'required|string|max:255',
                'email' => 'required|email',
                'telephone' => 'required|string',
                'indicatif' => 'sometimes|string'
            ]);

            $arrivee = Carbon::parse($validated['arrivee'])->setTimezone('UTC')->startOfDay();
            $depart = Carbon::parse($validated['depart'])->setTimezone('UTC')->startOfDay();
            
            // DEBUG: Log des dates reçues
            Log::info('Dates reçues - Arrivée: ' . $arrivee->format('Y-m-d H:i:s'));
            Log::info('Dates reçues - Départ: ' . $depart->format('Y-m-d H:i:s'));
            
            // Vérifier que l'hébergement existe
            $hebergementRef = Firebase::database()
                ->getReference('hebergements/'.$hebergementId);
                
            $hebergement = $hebergementRef->getValue();
                
            if (!$hebergement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hébergement non trouvé'
                ], 404);
            }
            
            // Vérifier la disponibilité
            $disponible = $this->verifierDisponibiliteDates($hebergementId, $arrivee, $depart);
            Log::info('Disponibilité vérifiée: ' . ($disponible ? 'OUI' : 'NON'));
            
            if (!$disponible) {
                // DEBUG: Log des réservations existantes
                $this->logReservationsExistantes($hebergementId);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Ces dates ne sont pas disponibles'
                ], 400);
            }
            
            $nuits = $arrivee->diffInDays($depart);
            $prixTotal = $nuits * ($hebergement['prixNuit'] ?? 0);
            
            $telephoneComplet = ($request->input('indicatif', '+221') . ' ' . $validated['telephone']);
            
            $reservationData = [
                'hebergementId' => $hebergementId,
                'userId' => $user ? $user->uid : 'anonymous',
                'userNom' => $validated['nom'],
                'userEmail' => $validated['email'],
                'userTelephone' => trim($telephoneComplet),
                'arrivee' => $arrivee->format('Y-m-d\TH:i:s.v\Z'),
                'depart' => $depart->format('Y-m-d\TH:i:s.v\Z'),
                'nombreNuits' => $nuits,
                'prixTotal' => $prixTotal,
                'dateReservation' => now()->format('Y-m-d\TH:i:s.v\Z'),
                'statut' => 'en_attente',
                'created_at' => now()->format('Y-m-d\TH:i:s.v\Z'),
                'updated_at' => now()->format('Y-m-d\TH:i:s.v\Z')
            ];
            
            // Créer la réservation
            $newReservationRef = Firebase::database()
                ->getReference('ReserverHebergement')
                ->push($reservationData);
                
            $reservationId = $newReservationRef->getKey();
            
            // Invalider le cache
            Cache::forget('hebergements_list_*');
            Cache::forget('hebergement_details_' . $hebergementId);
            
            Log::info('Réservation créée avec succès', [
                'reservation_id' => $reservationId,
                'hebergement_id' => $hebergementId,
                'user_id' => $user ? $user->uid : 'anonymous'
            ]);
                
            return response()->json([
                'success' => true,
                'message' => 'Réservation effectuée avec succès',
                'reservationId' => $reservationId,
                'redirectUrl' => route('hebergement.ticket', ['reservationId' => $reservationId]), // AJOUT IMPORTANT
                'data' => $reservationData
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation réservation', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la réservation: '.$e->getMessage());
            Log::error('Trace: '.$e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur s\'est produite lors de la réservation. Veuillez réessayer.'
            ], 500);
        }
    }

    private function verifierDisponibiliteDates($hebergementId, $arrivee, $depart)
    {
        try {
            $reservationsRef = Firebase::database()
                ->getReference('ReserverHebergement')
                ->getSnapshot();
                
            if ($reservationsRef->exists()) {
                $reservations = $reservationsRef->getValue();
                
                foreach ($reservations as $reservation) {
                    // Vérifier que c'est la bonne réservation
                    if (($reservation['hebergementId'] ?? '') !== $hebergementId) {
                        continue;
                    }
                    
                    // Vérifier que les dates existent dans la réservation
                    if (!isset($reservation['arrivee']) || !isset($reservation['depart'])) {
                        continue;
                    }
                    
                    try {
                        $reservationArrivee = Carbon::parse($reservation['arrivee'])->startOfDay();
                        $reservationDepart = Carbon::parse($reservation['depart'])->startOfDay();
                        $statut = $reservation['statut'] ?? 'en_attente';
                        
                        // Normaliser les dates de la nouvelle réservation
                        $nouvelleArrivee = $arrivee->copy()->startOfDay();
                        $nouveauDepart = $depart->copy()->startOfDay();
                        
                        // Vérifier les conflits seulement pour les réservations confirmées ou en attente
                        if (($statut === 'confirme' || $statut === 'en_attente') &&
                            $nouvelleArrivee->lt($reservationDepart) && 
                            $nouveauDepart->gt($reservationArrivee)) {
                            Log::info('Conflit détecté avec réservation existante', [
                                'nouvelle_arrivee' => $nouvelleArrivee->format('Y-m-d'),
                                'nouveau_depart' => $nouveauDepart->format('Y-m-d'),
                                'reservation_arrivee' => $reservationArrivee->format('Y-m-d'),
                                'reservation_depart' => $reservationDepart->format('Y-m-d'),
                                'statut' => $statut
                            ]);
                            return false; // Conflit détecté
                        }
                    } catch (\Exception $e) {
                        Log::error('Erreur parsing dates réservation: '.$e->getMessage());
                        continue;
                    }
                }
            }
            
            return true; // Aucun conflit
            
        } catch (\Exception $e) {
            Log::error('Erreur vérification disponibilité: '.$e->getMessage());
            return false; // En cas d'erreur, considérer comme non disponible
        }
    }

    private function logReservationsExistantes($hebergementId)
    {
        try {
            $reservationsRef = Firebase::database()
                ->getReference('ReserverHebergement')
                ->getSnapshot();
                
            if ($reservationsRef->exists()) {
                $reservations = $reservationsRef->getValue();
                $reservationsFiltrees = [];
                
                foreach ($reservations as $reservationId => $reservation) {
                    if (($reservation['hebergementId'] ?? '') === $hebergementId) {
                        $reservationsFiltrees[$reservationId] = $reservation;
                    }
                }
                
                Log::info('Réservations existantes pour hébergement ' . $hebergementId . ': ' . json_encode($reservationsFiltrees));
                
                // Log détaillé de chaque réservation
                foreach ($reservationsFiltrees as $reservationId => $reservation) {
                    Log::info('Réservation ' . $reservationId . ': ' . json_encode([
                        'arrivee' => $reservation['arrivee'] ?? 'N/A',
                        'depart' => $reservation['depart'] ?? 'N/A',
                        'statut' => $reservation['statut'] ?? 'N/A'
                    ]));
                }
            } else {
                Log::info('Aucune réservation existante pour cet hébergement: ' . $hebergementId);
            }
        } catch (\Exception $e) {
            Log::error('Erreur logging réservations: '.$e->getMessage());
        }
    }   

    // Méthode de test pour debugger la disponibilité
    public function testDisponibilite(Request $request, $hebergementId)
    {
        try {
            $arrivee = $request->input('arrivee') ? 
                Carbon::parse($request->input('arrivee'))->startOfDay() : 
                Carbon::now()->addDays(1)->startOfDay();
                
            $depart = $request->input('depart') ? 
                Carbon::parse($request->input('depart'))->startOfDay() : 
                Carbon::now()->addDays(3)->startOfDay();
            
            $disponible = $this->verifierDisponibiliteDates($hebergementId, $arrivee, $depart);
            
            return response()->json([
                'success' => true,
                'disponible' => $disponible,
                'arrivee' => $arrivee->format('Y-m-d'),
                'depart' => $depart->format('Y-m-d'),
                'hebergement_id' => $hebergementId
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
}