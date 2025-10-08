@extends('layouts.client.app')

@section('title', $hebergement['titre'] ?? 'Détails de l\'hébergement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="mb-6">
        <nav class="flex items-center text-sm text-gray-600 mb-4">
            <a href="{{ route('hebergements.index') }}" class="hover:text-blue-600">Hébergements</a>
            <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span>{{ $hebergement['ville'] ?? '' }}, {{ $hebergement['pays'] ?? '' }}</span>
            <svg class="h-4 w-4 mx-2" fill="none" stroke="current极" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">{{ $hebergement['titre'] ?? '' }}</span>
        </nav>
        
        <h1 class="text-3xl font-bold text-gray-900">{{ $hebergement['titre'] ?? 'Sans titre' }}</h1>
        <div class="flex items-center mt-2">
            <div class="flex items-center bg-blue-50 px-3 py-1 rounded-full">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3极921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                <span class="ml-1 font-medium">{{ $hebergement['rating'] ?? '4.5' }}</span>
                <span class="ml-2 text-gray-600">({{ round(($hebergement['rating'] ?? 4.5) * 20) }} avis)</span>
            </div>
            <span class="ml-4 text-gray-600">
                <svg class="h-5 w-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 极 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ $hebergement['adresseComplete'] ?? ($hebergement['localisation'] ?? 'Adresse non disponible') }}
            </span>
        </div>
    </div>
    
    <!-- Galerie d'images -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-8">
        @php
            $imageUrl = 'https://via.placeholder.com/800x600?text=Hébergement';
            if (!empty($hebergement['imagesUrls'])) {
                $images = is_array($hebergement['imagesUrls']) ? $hebergement['imagesUrls'] : [$hebergement['imagesUrls']];
            } else {
                $images = [$imageUrl];
            }
        @endphp
        
        <div class="lg:col-span-2 row-span-2">
            <img src="{{ $images[0] }}" 
                 alt="{{ $hebergement['titre'] ?? 'Hébergement' }}" class="w-full h-full object-cover rounded-lg">
        </div>
        
        @for($i = 1; $i < min(5, count($images)); $i++)
            <div class="{{ $i === 4 ? 'lg:极ol-span-2' : '' }}">
                <img src="{{ $images[$i] }}" 
                     alt="{{ $hebergement['titre'] ?? 'Hébergement' }}" class="w-full h-full object-cover rounded-lg">
            </div>
        @endfor
    </div>
    
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Détails principaux -->
        <div class="lg:w-2/3">
            <!-- Description -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">À propos de cet hébergement</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($hebergement['description'] ?? 'Description non disponible')) !!}
                </div>
            </div>
            
            <!-- Équipements -->
            @if(!empty($hebergement['equipements']))
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Équipements</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($hebergement['equipements'] as $equipement)
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $equipement }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Règles -->
            @if(!empty($hebergement['regles']))
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Règles de la maison</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($hebergement['regles'])) !!}
                </div>
            </div>
            @endif
            
            <!-- Carte -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Localisation</h2>
                <div id="map-detail" class="h-96 rounded-lg"></div>
                <p class="mt-2 text-gray-600">{{ $hebergement['adresseComplete'] ?? ($hebergement['localisation'] ?? '') }}</p>
            </div>
        </div>
        
        <!-- Réservation -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-2xl font-bold text-blue-600">{{ number_format($hebergement['prixNuit'] ?? 0, 0, ',', ' ') }} FCFA</span>
                        <span class="text-gray-500">/nuit</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034极-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81极3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="ml-1">{{ $hebergement['rating'] ?? '4.5' }}</span>
                        <span class="ml-1 text-gray-600">({{ round(($hebergement['rating'] ?? 4.5) * 20) }} avis)</span>
                    </div>
                </div>
                
                <form action="{{ route('hebergements.reserver', $id) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Arrivée</label>
                                <input type="date" name="arrivee" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Départ</label>
                                <input type="date" name="depart" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Voyageurs</极>
                            <select name="voyageurs" class="w-full border-gray-300 rounded-md shadow-sm">
                                @for($i = 1; $i <= ($hebergement['capacite'] ?? 10); $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'personne' : 'personnes' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Réserver maintenant
                    </button>
                    
                    <div class="text-center text-sm text-gray-500">
                        Vous ne serez pas débité tout de suite
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between mb-2">
                            <span>{{ number_format($hebergement['prixNuit'] ?? 0, 0, ',', ' ') }} FCFA x 3 nuits</span>
                            <span>{{ number_format(($hebergement['prixNuit'] ?? 0) * 3, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Frais de service</span>
                            <span>{{ number_format(($hebergement['prixNuit'] ?? 0) * 0.1, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg pt-2 border-t border-gray-200">
                            <span>Total</span>
                            <span>{{ number_format(($hebergement['prixNuit'] ?? 0) * 3 * 1.1, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Carte de détail -->
<script>
    function initDetailMap() {
        // Préparation des données en PHP pur avant le JavaScript
        <?php
            $hasCoords = isset($hebergement['coordonnees']) && 
                         isset($hebergement['coordonnees']['lat']) && 
                         isset($hebergement['coordonnees']['lng']);
            $lat = $hasCoords ? $hebergement['coordonnees']['lat'] : 0;
            $lng = $hasCoords ? $hebergement['coordonnees']['lng'] : 0;
            $nom = $hebergement['titre'] ?? 'Emplacement';
        ?>
        
        // Initialisation de la carte uniquement si les données existent
        <?php if ($hasCoords && $lat != 0 && $lng != 0): ?>
            const position = { 
                lat: <?= $lat ?>, 
                lng: <?= $lng ?>
            };
            
            const map = new google.maps.Map(document.getElementById("map-detail"), {
                center: position,
                zoom: 15,
                mapTypeId: "roadmap"
            });
            
            new google.maps.Marker({
                position: position,
                map: map,
                title: "<?= $nom ?>",
                icon: {
                    url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                }
            });
        <?php else: ?>
            document.getElementById('map-detail').innerHTML = '<div class="p-4 text-center text-gray-500">Localisation non disponible</div>';
        <?php endif; ?>
    }
</script>

@if(config('services.google.maps_api_key'))
<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initDetailMap">
</script>
@else
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('map-detail').innerHTML = '<div class="p-4 text-center text-red-500">Clé API Google Maps non configurée</div>';
    });
</script>
@endif
@endsection