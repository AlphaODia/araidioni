@extends('layouts.client.app')

@section('title', 'Détails du Colis - AriDioni Logistique')

@section('content')
<div class="min-h-screen bg-gray-50 py-12" style="padding-top: 100px;">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <!-- En-tête avec numéro de suivi et statut -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Détails du colis #{{ $colis['numero_tracking'] ?? '' }}</h2>
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        @if($colis['statut'] == 'livré') bg-green-100 text-green-800
                        @elseif($colis['statut'] == 'en_transit') bg-blue-100 text-blue-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ str_replace('_', ' ', $colis['statut']) }}
                    </span>
                </div>

                <!-- Le reste de votre contenu reste inchangé -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- Informations de base -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informations du colis</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Type de colis</p>
                                <p class="font-medium">{{ $colis['type_de_colis'] ?? 'N/A' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Poids</p>
                                    <p class="font-medium">{{ $colis['poids'] ?? 'N/A' }} kg</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Valeur déclarée</p>
                                    <p class="font-medium">{{ isset($colis['valeur_declaree']) ? number_format($colis['valeur_declaree'], 0, ',', ' ') : 'N/A' }} GNF</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="font-medium">{{ $colis['description'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dates et prix -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Dates et paiement</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Date d'envoi</p>
                                <p class="font-medium">{{ $colis['date_envoi'] ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date de livraison estimée</p>
                                <p class="font-medium">{{ $colis['date_livraison'] ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Prix total</p>
                                <p class="font-bold text-blue-600">{{ isset($colis['prix']) ? number_format($colis['prix'], 0, ',', ' ') : 'N/A' }} GNF</p>
                            </div>
                        </div>
                    </div>
                </div>

                                <!-- Section Expéditeur/Destinataire -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- Expéditeur -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Expéditeur</h3>
                        <div class="space-y-2">
                            <p class="font-medium">{{ $colis['expediteur'] ?? 'N/A' }}</p>
                            <p class="text-gray-600">{{ $colis['adresse_expediteur'] ?? 'N/A' }}</p>
                            <p class="text-gray-600">{{ $colis['telephone_expediteur'] ?? 'N/A' }}</p>
                            <p class="text-gray-600">{{ $colis['email_expediteur'] ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Destinataire -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Destinataire</h3>
                        <div class="space-y-2">
                            <p class="font-medium">{{ $colis['destinataire'] ?? 'N/A' }}</p>
                            <p class="text-gray-600">{{ $colis['adresse_destinataire'] ?? 'N/A' }}</p>
                            <p class="text-gray-600">{{ $colis['telephone_destinataire'] ?? 'N/A' }}</p>
                            <p class="text-gray-600">{{ $colis['email_destinataire'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Carte Google Maps -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Position actuelle du colis</h3>
                    <div class="bg-gray-100 rounded-lg overflow-hidden" style="height: 400px;">
                        <div id="map" style="height: 100%; width: 100%;"></div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 text-center">
                        Dernière mise à jour: {{ now()->format('d/m/Y H:i') }}
                    </p>
                </div>

                <!-- Historique des statuts -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Historique du colis</h3>
                    <div class="space-y-4">
                        @if(isset($colis['historique']) && is_array($colis['historique']))
                            @foreach($colis['historique'] as $event)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium">{{ $event['statut'] ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $event['date'] ?? 'N/A' }}</p>
                                    @if(isset($event['emplacement']))
                                    <p class="text-sm text-gray-500">{{ $event['emplacement'] }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">Aucun historique disponible pour le moment.</p>
                        @endif
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('colis.track') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-md transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Nouvelle recherche
                    </a>
                    <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors">
                        <i class="fas fa-print mr-2"></i> Imprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Intégration de Google Maps -->
<script>
    function initMap() {
        // 1. Préparation des données en PHP pur avant le JavaScript
        <?php
            // Coordonnées par défaut (Conakry)
            $defaultLat = 9.6412;
            $defaultLng = -13.5784;
            
            // Récupération des valeurs avec vérifications strictes
            $currentLat = isset($villeActuelle['latitude']) ? $villeActuelle['latitude'] : $defaultLat;
            $currentLng = isset($villeActuelle['longitude']) ? $villeActuelle['longitude'] : $defaultLng;
            
            // Préparation des données de destination si existantes
            $hasDestination = isset($villeDestination) && isset($villeDestination['latitude']) && isset($villeDestination['longitude']);
            $destLat = $hasDestination ? $villeDestination['latitude'] : null;
            $destLng = $hasDestination ? $villeDestination['longitude'] : null;
        ?>
        
        // 2. Initialisation de la carte avec les données PHP
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: { lat: <?= $currentLat ?>, lng: <?= $currentLng ?> },
            mapTypeId: "roadmap"
        });

        // 3. Marqueur position actuelle
        new google.maps.Marker({
            position: { lat: <?= $currentLat ?>, lng: <?= $currentLng ?> },
            map: map,
            title: "Position actuelle du colis"
        });

        // 4. Marqueur destination (uniquement si les données existent)
        <?php if ($hasDestination): ?>
            new google.maps.Marker({
                position: { lat: <?= $destLat ?>, lng: <?= $destLng ?> },
                map: map,
                title: "Destination",
                icon: { url: "https://maps.google.com/mapfiles/ms/icons/green-dot.png" }
            });
        <?php endif; ?>
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap"></script>
@endsection