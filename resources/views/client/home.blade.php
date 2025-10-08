@extends('layouts.client.app')

@section('title', 'Transport Guinée-Sénégal - Accueil')

@section('styles')
<style>
    /* Styles spécifiques à la page d'accueil */
    .hero {
        padding: 8rem 0 3rem;
        margin-bottom: 2rem;
    }
    
    .hero-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        max-width: 600px;
        color: rgba(255, 255, 255, 0.9);
    }
    
    /* Improved Search Form */
    .search-form {
        border-radius: 1rem;
        padding: 2rem;
        max-width: 900px;
        width: 100%;
    }
    
    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-group {
        flex: 1;
        min-width: 200px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: white;
    }
    
    .search-input, .search-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .search-input:focus, .search-select:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        background: rgba(255, 255, 255, 0.15);
    }
    
    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
    
    .btn-search {
        background: #7c3aed;
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        width: 100%;
        margin-top: 0.5rem;
    }
    
    .btn-search:hover {
        background: #6d28d9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    /* Main Content */
    .main-content {
        padding: 2rem 0;
    }
    
    .section-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: white;
        margin-bottom: 2rem;
        text-align: center;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Trip Cards */
    .trips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    
    .trip-card {
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .trip-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .trip-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    
    .trip-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .trip-card:hover .trip-image img {
        transform: scale(1.05);
    }
    
    .trip-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(to right, #4f46e5, #7c3aed);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .trip-details {
        padding: 1.5rem;
    }
    
    .trip-route {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: white;
    }
    
    .trip-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .trip-meta {
        display: flex;
        justify-content: space-between;
        margin: 1rem 0;
    }
    
    .trip-meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.875rem;
    }
    
    .trip-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding-top: 1rem;
        margin-top: 1rem;
    }
    
    .price-from {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.8);
    }
    
    .price-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
    }
    
    /* Why Choose Us Section */
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .feature-card {
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.3s;
    }
    
    .feature-card:hover {
        transform: translateY(-4px);
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(to right, #ddd6fe, #c4b5fd);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    
    .feature-icon i {
        font-size: 1.5rem;
        color: #4f46e5;
    }
    
    .feature-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: white;
    }
    
    .feature-description {
        color: rgba(255, 255, 255, 0.8);
    }
    
    /* Testimonials */
    .testimonials {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    
    .testimonial-card {
        border-radius: 1rem;
        padding: 1.5rem;
    }
    
    .testimonial-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .testimonial-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
    }
    
    .testimonial-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .testimonial-name {
        font-weight: 600;
        color: white;
    }
    
    .testimonial-rating {
        color: #f59e0b;
        margin-top: 0.25rem;
    }
    
    .testimonial-text {
        color: rgba(255, 255, 255, 0.8);
        font-style: italic;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero {
            padding: 10rem 0 3rem;
        }
        
        .search-form {
            flex-direction: column;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .form-row {
            flex-direction: column;
            gap: 1rem;
        }
    }
    /* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    border-radius: 1rem;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6b7280;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

/* Seat Selection */
.seat-layout {
    margin-bottom: 2rem;
}

.seat-legend {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 4px;
}

.legend-available {
    background: #bbf7d0;
    border: 1px solid #22c55e;
}

.legend-reserved {
    background: #fed7aa;
    border: 1px solid #f97316;
}

.legend-selected {
    background: #bfdbfe;
    border: 1px solid #3b82f6;
}

.legend-driver {
    background: #ddd6fe;
    border: 1px solid #8b5cf6;
}

.bus-layout, .minicar-layout, .taxi-layout {
    display: grid;
    gap: 0.5rem;
    justify-content: center;
    margin: 0 auto;
}

.bus-layout {
    grid-template-columns: repeat(5, 1fr);
    max-width: 500px;
}

.minicar-layout {
    grid-template-columns: repeat(4, 1fr);
    max-width: 400px;
}

.taxi-layout {
    grid-template-columns: repeat(3, 1fr);
    max-width: 300px;
}

.seat {
    width: 40px;
    height: 40px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    margin: 0 auto;
}

.seat-available {
    background: #bbf7d0;
    border: 1px solid #22c55e;
    color: #22543d;
}

.seat-reserved {
    background: #fed7aa;
    border: 1px solid #f97316;
    color: #742a2a;
    cursor: not-allowed;
}

.seat-selected {
    background: #bfdbfe;
    border: 1px solid #3b82f6;
    color: #2c5282;
}

.seat-driver {
    background: #ddd6fe;
    border: 1px solid #8b5cf6;
    color: #44337a;
    cursor: default;
}

.aisle {
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.aisle::after {
    content: "↔";
    color: #a0aec0;
    font-size: 1.2rem;
}

.selected-seats-info {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

@media (max-width: 768px) {
    .modal-content {
        margin: 1rem;
        width: calc(100% - 2rem);
    }
    
    .seat {
        width: 35px;
        height: 35px;
        font-size: 0.875rem;
    }
    
    .bus-layout {
        grid-template-columns: repeat(5, 1fr);
    }
    
    .seat-legend {
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
}
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Réservez votre voyage en toute sérénité</h1>
            <p class="hero-subtitle">Découvrez les meilleurs trajets entre la Guinée et le Sénégal</p>
            
            <!-- Improved Search Form -->
            <form class="search-form liquid-glass" id="searchForm" method="POST" action="{{ route('voyages.search') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Départ</label>
                        <input type="text" name="depart" class="search-input" placeholder="Ex: Dakar" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Destination</label>
                        <input type="text" name="destination" class="search-input" placeholder="Ex: Conakry" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="search-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type de véhicule</label>
                        <select name="vehicle_type" class="search-select" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="bus">Bus</option>
                            <option value="minicar">Mini-car</option>
                            <option value="taxi">Taxi VIP</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-search">Rechercher</button>
            </form>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        <h2 class="section-title">Trajets disponibles</h2>
        
        <div class="trips-grid" id="tripsContainer">
            <!-- Les trajets seront chargés dynamiquement ici -->
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                    <i class="fas fa-spinner fa-spin text-indigo-600 text-2xl"></i>
                </div>
                <p class="text-white">Chargement des trajets...</p>
            </div>
        </div>
        
        <!-- Why Choose Us Section -->
        <h2 class="section-title">Pourquoi choisir Ari Dioni ?</h2>
        
        <div class="features">
            <div class="feature-card liquid-glass">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">Sécurité garantie</h3>
                <p class="feature-description">Nos véhicules sont régulièrement inspectés et nos conducteurs rigoureusement sélectionnés.</p>
            </div>
            
            <div class="feature-card liquid-glass">
                <div class="feature-icon">
                    <i class="far fa-clock"></i>
                </div>
                <h3 class="feature-title">Ponctualité</h3>
                <p class="feature-description">Nous respectons scrupuleusement les horaires pour que vous arriviez toujours à temps.</p>
            </div>
            
            <div class="feature-card liquid-glass">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="feature-title">Support 24/7</h3>
                <p class="feature-description">Notre équipe est disponible 24h/24 et 7j/7 pour répondre à vos questions.</p>
            </div>
        </div>
        
        <!-- Testimonials Section -->
        <h2 class="section-title">Ce que disent nos clients</h2>
        
        <div class="testimonials">
            <div class="testimonial-card liquid-glass">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Aissatou Diallo">
                    </div>
                    <div>
                        <div class="testimonial-name">Aissatou Diallo</div>
                        <div class="testimonial-rating">★★★★★</div>
                    </div>
                </div>
                <p class="testimonial-text">"Service exceptionnel ! Le trajet était confortable et ponctuel. Je recommande vivement Ari Dioni pour tous vos déplacements."</p>
            </div>
            
            <div class="testimonial-card liquid-glass">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Mamadou Bah">
                    </div>
                    <div>
                        <div class="testimonial-name">Mamadou Bah</div>
                        <div class="testimonial-rating">★★★★★</div>
                    </div>
                </div>
                <p class="testimonial-text">"J'ai été impressionné par le professionnalisme de l'équipe. Le bus était propre et climatisé. Excellent voyage!"</p>
            </div>
            
            <div class="testimonial-card liquid-glass">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Fatoumata Binta">
                    </div>
                    <div>
                        <div class="testimonial-name">Fatoumata Binta</div>
                        <div class="testimonial-rating">★★★★☆</div>
                    </div>
                </div>
                <p class="testimonial-text">"Service ponctuel et sécurisé. J'ai apprécié le suivi en temps réel de mon colis. Merci Ari Dioni!"</p>
            </div>
        </div>
    </div>
</main>
<!-- Seat Selection Modal -->
<div class="modal" id="seatModal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Sélection des sièges</h2>
            <button class="modal-close" onclick="closeSeatSelection()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="seat-layout">
                <div class="seat-legend">
                    <div class="legend-item">
                        <div class="legend-color legend-available"></div>
                        <span>Disponible</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-reserved"></div>
                        <span>Réservé</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-selected"></div>
                        <span>Votre choix</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-driver"></div>
                        <span>Conducteur</span>
                    </div>
                </div>
                
                <!-- Bus Layout (53 seats) -->
                <div id="busLayout" class="bus-layout" style="display: none;">
                    <!-- Layout will be generated by JavaScript -->
                </div>
                
                <!-- Minicar Layout (14 seats) -->
                <div id="minicarLayout" class="minicar-layout" style="display: none;">
                    <!-- Layout will be generated by JavaScript -->
                </div>
                
                <!-- Taxi Layout (6 seats) -->
                <div id="taxiLayout" class="taxi-layout" style="display: none;">
                    <!-- Layout will be generated by JavaScript -->
                </div>
            </div>
            
            <div class="selected-seats-info mt-4 p-4 liquid-glass rounded-lg">
                <h4 class="text-white font-semibold mb-2">Résumé de votre réservation</h4>
                <div id="reservationSummary">
                    <p class="text-white">Aucun siège sélectionné</p>
                </div>
                <div id="selectedSeats" class="text-white mt-2"></div>
                <div id="totalPrice" class="text-xl font-bold text-white mt-2"></div>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeSeatSelection()">Annuler</button>
                <button class="btn btn-primary" onclick="confirmReservation()">Confirmer la réservation</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Configuration et état global
    const CONFIG = {
        glassEffectKey: 'glassEffect',
        apiEndpoints: {
            voyages: '/api/voyages',
            reservedSeats: '/api/voyages/',
            reservation: '/api/reserver',
            search: '{{ route("voyages.search") }}'
        },
        vehicleTypes: {
            bus: { seats: 53, duration: '12h' },
            minicar: { seats: 14, duration: '10h' },
            'taxi-vip': { seats: 6, duration: '9h' },
            taxi: { seats: 6, duration: '9h' }
        }
    };

    // État de l'application
    const APP_STATE = {
        glassEnabled: true,
        selectedSeats: [],
        currentVehicleType: '',
        currentTripId: '',
        currentTripDetails: {},
        allTrips: []
    };

    // Éléments DOM fréquemment utilisés
    const DOM_ELEMENTS = {
        glassToggle: document.getElementById('glassToggleHeader'),
        mobileMenuButton: document.getElementById('mobile-menu-button'),
        mobileMenu: document.getElementById('mobile-menu'),
        tripsContainer: document.getElementById('tripsContainer'),
        searchForm: document.getElementById('searchForm')
    };

    // Initialisation de l'application
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initialisation de l\'application...');
        initializeSearchForm();
        loadTripsFromBackend();
    });

    // Formulaire de recherche
    function initializeSearchForm() {
        if (DOM_ELEMENTS.searchForm) {
            DOM_ELEMENTS.searchForm.addEventListener('submit', handleSearchSubmit);
        }
    }

    async function handleSearchSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(DOM_ELEMENTS.searchForm);
        const searchParams = {
            depart: formData.get('depart'),
            destination: formData.get('destination'),
            date: formData.get('date'),
            vehicle_type: formData.get('vehicle_type')
        };

        try {
            console.log('Recherche avec paramètres:', searchParams);
            
            // Utilise la méthode GET avec des paramètres de query
            const queryString = new URLSearchParams();
            Object.entries(searchParams).forEach(([key, value]) => {
                if (value) queryString.append(key, value);
            });

            const response = await fetch(`${CONFIG.apiEndpoints.search}?${queryString.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`Erreur HTTP: ${response.status}`);
            }

            const result = await response.json();
            console.log('Résultats de recherche:', result);
            
            // Gestion des différents formats de réponse
            let trips = [];
            if (result.success && Array.isArray(result.trajets)) {
                trips = result.trajets;
            } else if (result.success && Array.isArray(result.data)) {
                trips = result.data;
            }
            
            displayTrips(trips);
            
        } catch (error) {
            console.error('Erreur recherche:', error);
            displayError('Erreur lors de la recherche. Veuillez réessayer.');
        }
    }

    // Chargement des voyages
    async function loadTripsFromBackend() {
        try {
            console.log('🌐 Envoi de la requête API...');
            const response = await fetch(CONFIG.apiEndpoints.voyages);
            
            console.log('📨 Réponse reçue:', response);
            console.log('Status HTTP:', response.status);
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('❌ Erreur HTTP:', response.status, errorText);
                throw new Error(`Erreur API: ${response.status}`);
            }

            const result = await response.json();
            console.log('✅ Données JSON:', result);
            
            if (result.success && Array.isArray(result.data)) {
                APP_STATE.allTrips = result.data;
                displayTrips(result.data);
            } else {
                throw new Error('Format de réponse invalide');
            }
            
        } catch (error) {
            console.error('💥 Erreur complète:', error);
            displayError('Erreur lors du chargement: ' + error.message);
        }
    }

    function displayError(message) {
        if (!DOM_ELEMENTS.tripsContainer) return;
        
        DOM_ELEMENTS.tripsContainer.innerHTML = `
            <div class="text-center py-12 rounded-xl liquid-glass border border-red-200">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-medium text-white mb-2">Erreur de chargement</h3>
                <p class="text-white max-w-md mx-auto">${message}</p>
                <button onclick="loadTripsFromBackend()" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Réessayer
                </button>
            </div>
        `;
    }

    function showNoTripsMessage() {
        if (!DOM_ELEMENTS.tripsContainer) return;
        
        DOM_ELEMENTS.tripsContainer.innerHTML = `
            <div class="text-center py-12 rounded-xl liquid-glass border border-indigo-200">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                    <i class="fas fa-info-circle text-indigo-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-medium text-white mb-2">Aucun trajet trouvé</h3>
                <p class="text-white max-w-md mx-auto">Nous n'avons trouvé aucun trajet correspondant à vos critères.</p>
            </div>
        `;
    }

    // Affichage des voyages
    function displayTrips(trips) {
        if (!DOM_ELEMENTS.tripsContainer) return;
        
        if (!trips || trips.length === 0) {
            showNoTripsMessage();
            return;
        }

        console.log('Affichage de', trips.length, 'voyages');
        
        try {
            const tripsHTML = trips.slice(0, 6).map(trip => {
                try {
                    return createTripCard(trip);
                } catch (error) {
                    console.error('Erreur création carte voyage:', error, trip);
                    return '';
                }
            }).join('');
            
            DOM_ELEMENTS.tripsContainer.innerHTML = tripsHTML;
        } catch (error) {
            console.error('Erreur affichage voyages:', error);
            displayError('Erreur lors de l\'affichage des voyages.');
        }
    }

    function createTripCard(trip) {
    const normalizedTrip = normalizeTripData(trip);
    const { departure, arrival, date, time, price, vehicleType, availableSeats, id } = normalizedTrip;
    const duration = CONFIG.vehicleTypes[vehicleType]?.duration || 'N/A';
    const vehicleImage = getVehicleImage(vehicleType);

    return `
        <div class="trip-card liquid-glass">
            <div class="trip-image">
                <img src="${vehicleImage}" alt="${vehicleType}" loading="lazy">
                <div class="trip-badge">${vehicleType.toUpperCase()}</div>
            </div>
            <div class="trip-details">
                <h3 class="trip-route">${escapeHtml(departure)} → ${escapeHtml(arrival)}</h3>
                <div class="trip-info">
                    <i class="far fa-calendar-alt"></i>
                    <span>${formatDate(date)} • ${formatTime(time)}</span>
                </div>
                <div class="trip-meta">
                    <div class="trip-meta-item">
                        <i class="far fa-clock"></i>
                        <span>~${duration}</span>
                    </div>
                    <div class="trip-meta-item">
                        <i class="fas fa-chair"></i>
                        <span>${availableSeats} places restantes</span>
                    </div>
                </div>
                <div class="trip-price">
                    <div>
                        <div class="price-from">À partir de</div>
                        <div class="price-amount">${parseInt(price).toLocaleString()} GNF</div>
                    </div>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition" 
                            onclick="openSeatSelection('${vehicleType}', '${id}', ${JSON.stringify(trip).replace(/'/g, "\\'")})">
                        Choisir un siège
                    </button>
                </div>
            </div>
        </div>
    `;
    }

    function formatDate(dateString) {
        if (!dateString) return 'Date non spécifiée';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        } catch (error) {
            return dateString;
        }
    }

    function formatTime(timeString) {
        if (!timeString) return 'Heure non spécifiée';
        return timeString.substring(0, 5); // Format HH:MM
    }

    function getVehicleImage(vehicleType) {
        const images = {
            bus: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80',
            minicar: 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80',
            taxi: 'https://images.unsplash.com/photo-1542362567-b07e54358753?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80',
            'taxi-vip': 'https://images.unsplash.com/photo-1542362567-b07e54358753?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80'
        };
        return images[vehicleType] || images.bus;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Fonction de debug
    window.debugTrips = function() {
        console.log('Trips chargés:', APP_STATE.allTrips);
        loadTripsFromBackend();
    };

    // Expose les fonctions globales
    window.loadTripsFromBackend = loadTripsFromBackend;

    // Gestion des sièges
let selectedSeats = [];
let currentTrip = null;

function openSeatSelection(vehicleType, tripId, tripDetails) {
    currentTrip = tripDetails;
    selectedSeats = [];
    
    // Afficher le layout approprié
    document.getElementById('busLayout').style.display = 'none';
    document.getElementById('minicarLayout').style.display = 'none';
    document.getElementById('taxiLayout').style.display = 'none';
    
    const layoutMap = {
        'bus': 'busLayout',
        'minicar': 'minicarLayout',
        'taxi': 'taxiLayout',
        'taxi-vip': 'taxiLayout'
    };
    
    const layoutId = layoutMap[vehicleType];
    if (layoutId) {
        generateSeatLayout(layoutId, vehicleType);
        document.getElementById(layoutId).style.display = 'grid';
    }
    
    // Afficher le modal
    document.getElementById('seatModal').style.display = 'flex';
    updateReservationSummary();
}

function generateSeatLayout(layoutId, vehicleType) {
    const layout = document.getElementById(layoutId);
    let html = '';
    
    const layouts = {
        'busLayout': generateBusLayout,
        'minicarLayout': generateMinicarLayout,
        'taxiLayout': generateTaxiLayout
    };
    
    if (layouts[layoutId]) {
        html = layouts[layoutId]();
    }
    
    layout.innerHTML = html;
}

function generateBusLayout() {
    let html = '';
    // Siège conducteur
    html += '<div class="seat seat-driver">D</div>';
    html += '<div class="aisle"></div><div class="aisle"></div><div class="aisle"></div><div class="aisle"></div>';
    
    // Rangées de sièges (53 sièges au total)
    for (let row = 1; row <= 13; row++) {
        for (let col = 1; col <= 4; col++) {
            const seatNumber = (row - 1) * 4 + col;
            if (seatNumber <= 53) {
                html += `<div class="seat seat-available" onclick="toggleSeat(${seatNumber}, this)">${seatNumber}</div>`;
            }
            if (col === 2) {
                html += '<div class="aisle"></div>';
            }
        }
    }
    return html;
}

function generateMinicarLayout() {
    let html = '';
    // Siège conducteur
    html += '<div class="seat seat-driver">D</div>';
    html += '<div class="aisle"></div>';
    html += '<div class="seat seat-available" onclick="toggleSeat(1, this)">1</div>';
    html += '<div class="seat seat-available" onclick="toggleSeat(2, this)">2</div>';
    
    // Rangées suivantes
    for (let i = 3; i <= 14; i++) {
        html += `<div class="seat seat-available" onclick="toggleSeat(${i}, this)">${i}</div>`;
    }
    return html;
}

function generateTaxiLayout() {
    let html = '';
    // Siège conducteur
    html += '<div class="seat seat-driver">D</div>';
    html += '<div class="aisle"></div>';
    html += '<div class="seat seat-available" onclick="toggleSeat(1, this)">1</div>';
    
    // Passagers
    for (let i = 2; i <= 6; i++) {
        html += `<div class="seat seat-available" onclick="toggleSeat(${i}, this)">${i}</div>`;
    }
    return html;
}

function toggleSeat(seatNumber, element) {
    const index = selectedSeats.indexOf(seatNumber);
    
    if (index === -1) {
        // Ajouter le siège
        if (selectedSeats.length < getMaxSeats()) {
            selectedSeats.push(seatNumber);
            element.classList.remove('seat-available');
            element.classList.add('seat-selected');
        } else {
            alert(`Vous ne pouvez sélectionner que ${getMaxSeats()} siège(s) maximum.`);
            return;
        }
    } else {
        // Retirer le siège
        selectedSeats.splice(index, 1);
        element.classList.remove('seat-selected');
        element.classList.add('seat-available');
    }
    
    updateReservationSummary();
}

function getMaxSeats() {
    if (!currentTrip) return 1;
    const vehicleType = currentTrip.vehicule_type || currentTrip.vehicle_type;
    return CONFIG.vehicleTypes[vehicleType]?.seats || 1;
}

function updateReservationSummary() {
    const summaryElement = document.getElementById('reservationSummary');
    const seatsElement = document.getElementById('selectedSeats');
    const priceElement = document.getElementById('totalPrice');
    
    if (!currentTrip) return;
    
    const pricePerSeat = currentTrip.prix || currentTrip.price || 0;
    const totalPrice = pricePerSeat * selectedSeats.length;
    
    if (selectedSeats.length > 0) {
        summaryElement.innerHTML = `
            <p><strong>Trajet:</strong> ${currentTrip.ville_depart} → ${currentTrip.ville_arrivee}</p>
            <p><strong>Date:</strong> ${formatDate(currentTrip.date_depart)}</p>
            <p><strong>Heure:</strong> ${formatTime(currentTrip.heure_depart)}</p>
        `;
        seatsElement.innerHTML = `<strong>Sièges sélectionnés:</strong> ${selectedSeats.join(', ')}`;
        priceElement.innerHTML = `<strong>Total:</strong> ${totalPrice.toLocaleString()} GNF`;
    } else {
        summaryElement.innerHTML = '<p class="text-white">Aucun siège sélectionné</p>';
        seatsElement.innerHTML = '';
        priceElement.innerHTML = '';
    }
}

function closeSeatSelection() {
    document.getElementById('seatModal').style.display = 'none';
    selectedSeats = [];
    currentTrip = null;
}

async function confirmReservation() {
    if (selectedSeats.length === 0) {
        alert('Veuillez sélectionner au moins un siège.');
        return;
    }

    if (!currentTrip) {
        alert('Erreur: informations du voyage non disponibles.');
        return;
    }

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        const response = await fetch('/api/reserver', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                voyage_id: currentTrip.id,
                sieges: selectedSeats,
                nombre_places: selectedSeats.length,
                prix_total: (currentTrip.prix || currentTrip.price) * selectedSeats.length
            })
        });

        const result = await response.json();

        if (result.success) {
            alert('Réservation confirmée avec succès !');
            closeSeatSelection();
            // Rediriger vers la page de confirmation ou le dashboard
            if (result.reservation_id) {
                window.location.href = `/reservations/${result.reservation_id}`;
            }
        } else {
            alert('Erreur: ' + (result.message || 'Échec de la réservation'));
        }
    } catch (error) {
        console.error('Erreur réservation:', error);
        alert('Erreur lors de la réservation. Veuillez réessayer.');
    }
}

// Gestion de la fermeture du modal en cliquant à l'extérieur
window.onclick = function(event) {
    const modal = document.getElementById('seatModal');
    if (event.target === modal) {
        closeSeatSelection();
    }
};
</script>
@endsection