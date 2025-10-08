// Configuration et état global
const CONFIG = {
    apiEndpoints: {
        voyages: '/api/voyages',
        reservedSeats: '/api/voyages/',
        reservation: '/api/reserver',
        search: '/voyages'
    },
    vehicleTypes: {
        bus: { seats: 53, duration: '12h' },
        minicar: { seats: 14, duration: '10h' },
        'taxi-vip': { seats: 6, duration: '9h' },
        taxi: { seats: 6, duration: '9h' }
    }
};

const APP_STATE = {
    selectedSeats: [],
    currentVehicleType: '',
    currentTripId: '',
    currentTripDetails: {},
    allTrips: []
};

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    initializeSearchForm();
    loadTripsFromBackend();
});

// Gestion du formulaire de recherche
function initializeSearchForm() {
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearchSubmit);
    }
}

async function handleSearchSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const searchParams = Object.fromEntries(formData.entries());
    
    try {
        const queryString = new URLSearchParams(searchParams).toString();
        const response = await fetch(`${CONFIG.apiEndpoints.search}?${queryString}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error(`Erreur HTTP: ${response.status}`);

        const result = await response.json();
        const trips = result.trajets || result.data || [];
        displayTrips(trips);
        
    } catch (error) {
        console.error('Erreur recherche:', error);
        displayError('Erreur lors de la recherche. Veuillez réessayer.');
    }
}

// Chargement des voyages
async function loadTripsFromBackend() {
    try {
        const response = await fetch(CONFIG.apiEndpoints.voyages);
        if (!response.ok) throw new Error(`Erreur API: ${response.status}`);

        const result = await response.json();
        if (result.success && Array.isArray(result.data)) {
            APP_STATE.allTrips = result.data;
            displayTrips(result.data);
        } else {
            throw new Error('Format de réponse invalide');
        }
        
    } catch (error) {
        console.error('Erreur chargement:', error);
        displayError('Erreur lors du chargement: ' + error.message);
    }
}

// Affichage des voyages
function displayTrips(trips) {
    const container = document.getElementById('tripsContainer');
    if (!container) return;
    
    if (!trips || trips.length === 0) {
        container.innerHTML = `
            <div class="col-span-3 text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-600 mb-2">Aucun trajet trouvé</h3>
                <p class="text-gray-500">Aucun trajet ne correspond à vos critères de recherche.</p>
            </div>
        `;
        return;
    }

    // Utiliser le composant Blade via une requête AJAX ou générer le HTML directement
    container.innerHTML = trips.map(trip => `
        <div class="trip-card liquid-glass rounded-xl overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            ${generateTripCardHTML(trip)}
        </div>
    `).join('');
}

function generateTripCardHTML(trip) {
    const normalizedTrip = normalizeTripData(trip);
    const { departure, arrival, date, time, price, vehicleType, availableSeats, id } = normalizedTrip;
    const duration = CONFIG.vehicleTypes[vehicleType]?.duration || 'N/A';
    const vehicleImage = getVehicleImage(vehicleType);
    
    // Échapper les données pour JavaScript
    const tripJson = JSON.stringify(trip).replace(/'/g, "\\'");

    return `
        <div class="trip-image relative h-48 overflow-hidden">
            <img src="${vehicleImage}" alt="${vehicleType}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
            <div class="trip-badge absolute top-4 right-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                ${vehicleType.toUpperCase()}
            </div>
        </div>
        
        <div class="trip-details p-6">
            <h3 class="trip-route text-xl font-semibold mb-2">${escapeHtml(departure)} → ${escapeHtml(arrival)}</h3>
            
            <div class="trip-info flex items-center text-gray-300 mb-3">
                <i class="far fa-calendar-alt mr-2"></i>
                <span>${formatDate(date)} • ${formatTime(time)}</span>
            </div>
            
            <div class="trip-meta flex justify-between mb-4">
                <div class="trip-meta-item flex items-center">
                    <i class="far fa-clock mr-2"></i>
                    <span>~${duration}</span>
                </div>
                <div class="trip-meta-item flex items-center">
                    <i class="fas fa-chair mr-2"></i>
                    <span>${availableSeats} places</span>
                </div>
            </div>
            
            <div class="trip-price flex justify-between items-center pt-4 border-t border-gray-600">
                <div>
                    <div class="price-from text-sm text-gray-300">À partir de</div>
                    <div class="price-amount text-2xl font-bold">${parseInt(price).toLocaleString()} GNF</div>
                </div>
                <button class="btn-reserve bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition"
                        onclick="openSeatSelection('${escapeQuotes(vehicleType)}', '${escapeQuotes(id)}', '${tripJson}')">
                    Réserver
                </button>
            </div>
        </div>
    `;
}

function createTripCardHTML(trip) {
    // Utilisez le composant Blade si disponible, sinon générez le HTML directement
    return `
        <div class="trip-card" data-trip-id="${trip.id || ''}">
            <!-- Le contenu sera généré par le composant Blade -->
        </div>
    `;
}

// Gestion des sièges (fonctions similaires à votre code original)
async function openSeatSelection(vehicleType, tripId, tripDetails) {
    APP_STATE.currentVehicleType = vehicleType;
    APP_STATE.currentTripId = tripId;
    APP_STATE.currentTripDetails = typeof tripDetails === 'string' ? JSON.parse(tripDetails) : tripDetails;
    APP_STATE.selectedSeats = [];

    const modal = document.getElementById('seatModal');
    if (modal) {
        modal.classList.remove('hidden');
        await loadReservedSeats(tripId);
        updateSelectedSeatsDisplay();
    }
}

function closeSeatSelection() {
    const modal = document.getElementById('seatModal');
    if (modal) modal.classList.add('hidden');
}

// Export des fonctions globales
window.openSeatSelection = openSeatSelection;
window.closeSeatSelection = closeSeatSelection;
window.loadTripsFromBackend = loadTripsFromBackend;