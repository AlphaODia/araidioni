@extends('layouts.client.app')

@section('title', 'Accueil - Ari Dioni')

@section('content')
<!-- Hero Section -->
<section class="hero pt-20 pb-12">
    <div class="container">
        <div class="hero-content text-center"> <!-- Ajout de text-center ici -->
            <h1 class="hero-title text-4xl md:text-5xl font-bold mb-4">Réservez votre voyage en toute sérénité</h1>
            <p class="hero-subtitle text-xl mb-8">Découvrez les meilleurs trajets entre la Guinée et le Sénégal</p>
            
            <!-- Improved Search Form -->
            <form class="search-form liquid-glass rounded-xl p-6 max-w-4xl mx-auto" id="searchForm" method="GET" action="{{ route('voyages.search') }}">
                @csrf
                <div class="form-row grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div class="form-group">
                        <label class="form-label block mb-2 font-semibold text-white">Départ</label>
                        <input type="text" name="depart" class="search-input w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/70" placeholder="Ex: Dakar" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label block mb-2 font-semibold text-white">Destination</label>
                        <input type="text" name="destination" class="search-input w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/70" placeholder="Ex: Conakry" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label block mb-2 font-semibold text-white">Date</label>
                        <input type="date" name="date" class="search-input w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label block mb-2 font-semibold text-white">Type de véhicule</label>
                        <select name="vehicle_type" class="search-select w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white" required>
                            <option value="" class="text-gray-800">Sélectionnez un type</option>
                            <option value="bus" class="text-gray-800">Bus</option>
                            <option value="minicar" class="text-gray-800">Mini-car</option>
                            <option value="taxi" class="text-gray-800">Taxi VIP</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-search w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                    Rechercher
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="main-content py-12">
    <div class="container">
        <h2 class="section-title text-3xl font-bold text-center mb-8 text-white">Trajets disponibles</h2>
        
        <!-- Loading State -->
        <div id="loadingState" class="text-center py-8 hidden">
            <div class="inline-flex items-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                <span class="ml-3 text-lg text-white">Chargement des trajets...</span>
            </div>
        </div>
        
        <!-- Results Container -->
        <div class="trips-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12" id="tripsContainer">
            <!-- Les trajets seront chargés dynamiquement ici -->
        </div>
        
        <!-- Why Choose Us Section -->
        <h2 class="section-title text-3xl font-bold text-center mb-8 text-white">Pourquoi choisir Ari Dioni ?</h2>
        
        <div class="features grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="feature-card liquid-glass rounded-xl p-6 text-center">
                <div class="feature-icon w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-indigo-600 text-2xl"></i>
                </div>
                <h3 class="feature-title text-xl font-semibold mb-2 text-white">Sécurité garantie</h3>
                <p class="feature-description text-white/80">Nos véhicules sont régulièrement inspectés et nos conducteurs rigoureusement sélectionnés.</p>
            </div>
            
            <div class="feature-card liquid-glass rounded-xl p-6 text-center">
                <div class="feature-icon w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="far fa-clock text-indigo-600 text-2xl"></i>
                </div>
                <h3 class="feature-title text-xl font-semibold mb-2 text-white">Ponctualité</h3>
                <p class="feature-description text-white/80">Nous respectons scrupuleusement les horaires pour que vous arriviez toujours à temps.</p>
            </div>
            
            <div class="feature-card liquid-glass rounded-xl p-6 text-center">
                <div class="feature-icon w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-indigo-600 text-2xl"></i>
                </div>
                <h3 class="feature-title text-xl font-semibold mb-2 text-white">Support 24/7</h3>
                <p class="feature-description text-white/80">Notre équipe est disponible 24h/24 et 7j/7 pour répondre à vos questions.</p>
            </div>
        </div>
        
<!-- Testimonials Section -->
<section class="py-16 bg-gradient-to-br from-indigo-900/50 to-purple-900/30">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="section-title text-4xl font-bold mb-4 text-white">Ce que disent nos clients</h2>
            <p class="text-white/70 text-lg max-w-2xl mx-auto">Découvrez les expériences de nos voyageurs satisfaits</p>
        </div>

        <div class="testimonials grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @isset($avis)
                @forelse($avis as $temoignage)
                <div class="testimonial-card liquid-glass rounded-2xl p-6 hover:transform hover:scale-105 transition-all duration-300 border border-white/10 hover:border-white/20">
                    <div class="testimonial-header flex items-start mb-4">
                        <div class="testimonial-avatar w-14 h-14 rounded-full overflow-hidden mr-4 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-base">
                                {{ strtoupper(substr($temoignage['nom'] ?? 'AN', 0, 2)) }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="testimonial-name font-bold text-white text-lg">{{ $temoignage['nom'] ?? 'Anonyme' }}</div>
                                    <div class="testimonial-date text-white/60 text-sm mt-1">
                                        {{ isset($temoignage['created_at']) ? \Carbon\Carbon::parse($temoignage['created_at'])->format('d M Y') : now()->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="testimonial-rating text-yellow-400 text-lg">
                                    @php
                                        $rating = $temoignage['rating'] ?? 0;
                                        $fullStars = intval($rating);
                                        $emptyStars = 5 - $fullStars;
                                    @endphp
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <p class="testimonial-text text-white/90 leading-relaxed mb-4">"{{ $temoignage['message'] ?? 'Avis non disponible' }}"</p>
                    
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-white/10">
                        <span class="text-sm text-white/70 bg-indigo-500/30 px-3 py-1.5 rounded-full font-medium">
                            <i class="fas fa-tag mr-1"></i>
                            {{ ucfirst($temoignage['service_type'] ?? 'voyage') }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <div class="text-white/60">
                        <i class="fas fa-comments text-6xl mb-6 opacity-50"></i>
                        <p class="text-xl mb-2">Aucun témoignage pour le moment</p>
                        <p class="text-sm max-w-md mx-auto">Soyez le premier à partager votre expérience avec notre service de transport !</p>
                    </div>
                </div>
                @endforelse
            @else
            <div class="col-span-3 text-center py-12">
                <div class="text-white/60">
                    <i class="fas fa-comments text-6xl mb-6 opacity-50"></i>
                    <p class="text-xl mb-2">Chargement des témoignages...</p>
                    <p class="text-sm max-w-md mx-auto">Les avis clients seront affichés ici</p>
                </div>
            </div>
            @endisset
        </div>

        <!-- Pagination CORRIGÉE -->
        @if(isset($avis) && count($avis) > 0)
        <div class="flex justify-center mt-12">
            <div class="flex space-x-2">
                <button class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center">1</button>
                <button class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">2</button>
                <button class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">3</button>
                <button class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
        @endif
    </div>
</section>
    </div>
</main>

<!-- Seat Selection Modal -->
<div class="modal fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden" id="seatModal">
    <div class="modal-content bg-white rounded-xl w-full max-w-4xl max-h-[95vh] overflow-hidden flex flex-col">
        <div class="modal-header p-6 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10">
            <h2 class="modal-title text-2xl font-bold text-gray-800">Sélection des sièges</h2>
            <button class="modal-close text-2xl text-gray-500 hover:text-gray-700" onclick="closeSeatSelection()">&times;</button>
        </div>
        
        <div class="modal-body flex-1 overflow-y-auto p-6">
            <div class="seat-layout">
                <div class="seat-legend flex justify-center gap-6 mb-6">
                    <div class="legend-item flex items-center gap-2">
                        <div class="legend-color w-5 h-5 bg-green-200 border border-green-500 rounded"></div>
                        <span class="text-gray-700">Disponible</span>
                    </div>
                    <div class="legend-item flex items-center gap-2">
                        <div class="legend-color w-5 h-5 bg-orange-200 border border-orange-500 rounded"></div>
                        <span class="text-gray-700">Réservé</span>
                    </div>
                    <div class="legend-item flex items-center gap-2">
                        <div class="legend-color w-5 h-5 bg-blue-200 border border-blue-500 rounded"></div>
                        <span class="text-gray-700">Votre choix</span>
                    </div>
                    <div class="legend-item flex items-center gap-2">
                        <div class="legend-color w-5 h-5 bg-purple-200 border border-purple-500 rounded"></div>
                        <span class="text-gray-700">Conducteur</span>
                    </div>
                </div>
                
                <div id="busLayout" class="bus-layout hidden grid grid-cols-5 gap-2 max-w-md mx-auto mb-6"></div>
                <div id="minicarLayout" class="minicar-layout hidden grid grid-cols-4 gap-2 max-w-sm mx-auto mb-6"></div>
                <div id="taxiLayout" class="taxi-layout hidden grid grid-cols-3 gap-2 max-w-xs mx-auto mb-6"></div>
            </div>
            
            <div class="selected-seats p-4 bg-gray-100 rounded-lg text-gray-700" id="selectedSeats">
                Aucun siège sélectionné
            </div>
        </div>
        
        <div class="modal-footer p-6 border-t border-gray-200 bg-white sticky bottom-0">
            <div class="flex justify-end gap-4">
                <button class="btn-outline px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-gray-700" onclick="closeSeatSelection()">
                    Annuler
                </button>
                <button class="btn-primary px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition" onclick="confirmReservation()">
                    Confirmer la réservation
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reservation Form Modal -->
<div class="modal fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden" id="reservationFormModal">
    <div class="modal-content bg-white rounded-xl w-full max-w-md max-h-90vh overflow-y-auto">
        <div class="modal-header p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="modal-title text-2xl font-bold text-gray-800">Informations de réservation</h2>
            <button class="modal-close text-2xl text-gray-500 hover:text-gray-700" onclick="closeReservationForm()">&times;</button>
        </div>
        <div class="modal-body p-6">
            <p class="mb-4 text-gray-600">Veuillez remplir vos informations pour compléter la réservation.</p>
            
        <form id="guestReservationForm">
            <div class="space-y-4">
                <div>
                      <label class="block text-sm font-medium mb-2 text-gray-700">Nom complet *</label>
                      <input type="text" name="nom" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700" 
                        placeholder="Votre nom complet">
                </div>
        
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Email *</label>
                    <input type="email" name="email" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700"
                           placeholder="votre@email.com">
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Téléphone *</label>
                    <input type="tel" name="telephone" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-700"
                           placeholder="+221 XX XXX XX XX">
                </div>
                    </div>

                    <div class="modal-footer mt-6 pt-6 border-t border-gray-200 flex justify-end gap-4">
                        <button type="button" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition" onclick="closeReservationForm()">
                            Annuler
                        </button>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Payer maintenant
                        </button>
            </div>
        </form>
        </div>
    </div>
</div>

<style>
    /* Styles supplémentaires pour améliorer l'affichage */
    .modal-content {
        max-height: 95vh;
    }
    
    .modal-body {
        flex: 1;
        overflow-y: auto;
    }
    
    .modal-footer {
        flex-shrink: 0;
    }
    
    /* Assurer que le layout des sièges est bien contenu */
    .bus-layout,
    .minicar-layout,
    .taxi-layout {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
    }
    
    /* Style pour le scroll */
    .bus-layout::-webkit-scrollbar,
    .minicar-layout::-webkit-scrollbar,
    .taxi-layout::-webkit-scrollbar {
        width: 6px;
    }
    
    .bus-layout::-webkit-scrollbar-track,
    .minicar-layout::-webkit-scrollbar-track,
    .taxi-layout::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .bus-layout::-webkit-scrollbar-thumb,
    .minicar-layout::-webkit-scrollbar-thumb,
    .taxi-layout::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .bus-layout::-webkit-scrollbar-thumb:hover,
    .minicar-layout::-webkit-scrollbar-thumb:hover,
    .taxi-layout::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>
@endsection

@push('scripts')
<script src="{{ asset('js/home.js') }}"></script>
@endpush