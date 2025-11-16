// Configuration et état global pour la page d'accueil
const HOME_CONFIG = {
    apiEndpoints: {
        voyages: '/api/voyages',
        reservedSeats: '/api/voyages/',
        reservation: '/api/reserver',
        search: '/voyages',
        payment: '/payment/initiate'
    },
    vehicleTypes: {
        bus: { seats: 53, duration: '12h' },
        minicar: { seats: 14, duration: '10h' },
        'taxi-vip': { seats: 6, duration: '9h' },
        taxi: { seats: 6, duration: '9h' }
    }
};

// État de l'application pour la page d'accueil
const HOME_STATE = {
    selectedSeats: [],
    currentVehicleType: '',
    currentTripId: '',
    currentTripDetails: {},
    allTrips: [],
    currentReservationId: null
};

// Éléments DOM pour la page d'accueil
const HOME_ELEMENTS = {
    searchForm: document.getElementById('searchForm'),
    tripsContainer: document.getElementById('tripsContainer'),
    loadingState: document.getElementById('loadingState'),
    seatModal: document.getElementById('seatModal'),
    reservationFormModal: document.getElementById('reservationFormModal'),
    selectedSeatsDisplay: document.getElementById('selectedSeats'),
    busLayout: document.getElementById('busLayout'),
    minicarLayout: document.getElementById('minicarLayout'),
    taxiLayout: document.getElementById('taxiLayout')
};

// Initialisation de la page d'accueil
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initialisation de la page d\'accueil...');
    initializeHomeSearchForm();
    loadTripsFromBackend();
    initializePaymentCallbacks();
});

// Initialiser le formulaire de recherche de la page d'accueil
function initializeHomeSearchForm() {
    if (HOME_ELEMENTS.searchForm) {
        HOME_ELEMENTS.searchForm.addEventListener('submit', handleHomeSearchSubmit);
    }
}

// Gérer la soumission du formulaire de recherche sur la page d'accueil
async function handleHomeSearchSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(HOME_ELEMENTS.searchForm);
    const searchParams = {
        depart: formData.get('depart'),
        destination: formData.get('destination'),
        date: formData.get('date'),
        vehicle_type: formData.get('vehicle_type')
    };

    try {
        showLoadingState();
        console.log('Recherche depuis la page d\'accueil:', searchParams);
        
        const queryString = new URLSearchParams();
        Object.entries(searchParams).forEach(([key, value]) => {
            if (value) queryString.append(key, value);
        });

        const response = await fetch(`${HOME_CONFIG.apiEndpoints.search}?${queryString.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }

        const result = await response.json();
        console.log('Résultats de recherche page d\'accueil:', result);
        
        let trips = [];
        if (result.success && Array.isArray(result.trajets)) {
            trips = result.trajets;
        } else if (result.success && Array.isArray(result.data)) {
            trips = result.data;
        }
        
        displayTrips(trips);
        hideLoadingState();
        
    } catch (error) {
        console.error('Erreur recherche page d\'accueil:', error);
        displayError('Erreur lors de la recherche. Veuillez réessayer.');
        hideLoadingState();
    }
}

// Afficher l'état de chargement
function showLoadingState() {
    if (HOME_ELEMENTS.loadingState) {
        HOME_ELEMENTS.loadingState.classList.remove('hidden');
    }
    if (HOME_ELEMENTS.tripsContainer) {
        HOME_ELEMENTS.tripsContainer.innerHTML = '';
    }
}

// Cacher l'état de chargement
function hideLoadingState() {
    if (HOME_ELEMENTS.loadingState) {
        HOME_ELEMENTS.loadingState.classList.add('hidden');
    }
}

// Charger tous les voyages au chargement de la page
async function loadTripsFromBackend() {
    try {
        showLoadingState();
        console.log('🌐 Chargement des voyages pour la page d\'accueil...');
        
        const response = await fetch(HOME_CONFIG.apiEndpoints.voyages);
        
        if (!response.ok) {
            throw new Error(`Erreur API: ${response.status}`);
        }

        const result = await response.json();
        console.log('✅ Données reçues pour page d\'accueil:', result);
        
        if (result.success && Array.isArray(result.data)) {
            HOME_STATE.allTrips = result.data;
            // Afficher seulement les 6 premiers voyages
            displayTrips(result.data.slice(0, 6));
        } else {
            throw new Error('Format de réponse invalide');
        }
        
        hideLoadingState();
    } catch (error) {
        console.error('💥 Erreur chargement page d\'accueil:', error);
        displayError('Erreur lors du chargement des voyages: ' + error.message);
        hideLoadingState();
    }
}

// Afficher les erreurs
function displayError(message) {
    if (!HOME_ELEMENTS.tripsContainer) return;
    
    HOME_ELEMENTS.tripsContainer.innerHTML = `
        <div class="col-span-3 text-center py-12 rounded-xl liquid-glass border border-red-200">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-medium text-white mb-2">Erreur de chargement</h3>
            <p class="text-white max-w-md mx-auto">${message}</p>
            <button onclick="loadTripsFromBackend()" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Réessayer
            </button>
        </div>
    `;
}

// Afficher le message "Aucun trajet"
function showNoTripsMessage() {
    if (!HOME_ELEMENTS.tripsContainer) return;
    
    HOME_ELEMENTS.tripsContainer.innerHTML = `
        <div class="col-span-3 text-center py-12 rounded-xl liquid-glass border border-indigo-200">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-medium text-white mb-2">Aucun trajet trouvé</h3>
            <p class="text-white max-w-md mx-auto">Nous n'avons trouvé aucun trajet correspondant à vos critères.</p>
        </div>
    `;
}

// Afficher les voyages
function displayTrips(trips) {
    if (!HOME_ELEMENTS.tripsContainer) return;
    
    if (!trips || trips.length === 0) {
        showNoTripsMessage();
        return;
    }

    console.log('Affichage de', trips.length, 'voyages sur la page d\'accueil');
    
    try {
        const tripsHTML = trips.map(trip => createTripCard(trip)).join('');
        HOME_ELEMENTS.tripsContainer.innerHTML = tripsHTML;
    } catch (error) {
        console.error('Erreur affichage voyages page d\'accueil:', error);
        displayError('Erreur lors de l\'affichage des voyages.');
    }
}

// Créer une carte de voyage
function createTripCard(trip) {
    const normalizedTrip = normalizeTripData(trip);
    const { departure, arrival, date, time, price, vehicleType, availableSeats, id } = normalizedTrip;
    const duration = HOME_CONFIG.vehicleTypes[vehicleType]?.duration || 'N/A';
    const vehicleImage = getVehicleImage(vehicleType);

    return `
        <div class="trip-card liquid-glass rounded-xl overflow-hidden transition-transform duration-300 hover:scale-105">
            <div class="trip-image h-48 overflow-hidden relative">
                <img src="${vehicleImage}" alt="${vehicleType}" class="w-full h-full object-cover">
                <div class="trip-badge absolute top-4 right-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    ${vehicleType.toUpperCase()}
                </div>
            </div>
            <div class="trip-details p-6">
                <h3 class="trip-route text-xl font-bold mb-2 text-white">${escapeHtml(departure)} → ${escapeHtml(arrival)}</h3>
                <div class="trip-info flex items-center text-white/80 mb-2">
                    <i class="far fa-calendar-alt mr-2"></i>
                    <span>${formatDate(date)} • ${formatTime(time)}</span>
                </div>
                <div class="trip-meta flex justify-between mb-4">
                    <div class="trip-meta-item flex items-center text-white/80">
                        <i class="far fa-clock mr-1"></i>
                        <span>~${duration}</span>
                    </div>
                    <div class="trip-meta-item flex items-center text-white/80">
                        <i class="fas fa-chair mr-1"></i>
                        <span>${availableSeats} places</span>
                    </div>
                </div>
                <div class="trip-price flex justify-between items-center pt-4 border-t border-white/20">
                    <div>
                        <div class="price-from text-sm text-white/80">À partir de</div>
                        <div class="price-amount text-2xl font-bold text-white">${parseInt(price).toLocaleString()} CFA</div>
                    </div>
                    <button class="btn-primary px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition" 
                            onclick="openSeatSelection('${escapeQuotes(vehicleType)}', '${escapeQuotes(id)}', ${escapeQuotes(JSON.stringify(trip))})">
                        Réserver
                    </button>
                </div>
            </div>
        </div>
    `;
}

// Normaliser les données du voyage
function normalizeTripData(trip) {
    return {
        departure: trip.ville_depart || trip.departure || trip.depart || '',
        arrival: trip.ville_arrivee || trip.arrival || trip.arrivee || '',
        date: trip.date_depart || trip.date || '',
        time: trip.heure_depart || trip.departure_time || trip.time || '',
        price: trip.prix || trip.price || 0,
        vehicleType: trip.vehicule_type || trip.vehicle_type || trip.type_vehicule || '',
        availableSeats: trip.available_seats || trip.places_restantes || 0,
        id: trip.id || ''
    };
}

// Formater la date
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

// Formater l'heure
function formatTime(timeString) {
    if (!timeString) return 'Heure non spécifiée';
    return timeString.substring(0, 5);
}

// Obtenir l'image du véhicule depuis les fichiers locaux
function getVehicleImage(vehicleType) {
    const images = {
        bus: "/images/bus.jpg",
        minicar: "/images/mini-car.jpg",
        taxi: "/images/taxi-vip.jpg",
        'taxi-vip': "/images/taxi-vip.jpg"
    };
    return images[vehicleType] || "/images/bus.jpg";
}

// Échapper les guillemets
function escapeQuotes(value) {
    if (typeof value === 'string') {
        return value.replace(/"/g, '&quot;').replace(/'/g, '&#x27;');
    }
    return JSON.stringify(value).replace(/"/g, '&quot;').replace(/'/g, '&#x27;');
}

// Échapper le HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// === FONCTIONS DE GESTION DES SIÈGES ===

async function openSeatSelection(vehicleType, tripId, tripDetails) {
    HOME_STATE.currentVehicleType = vehicleType;
    HOME_STATE.currentTripId = tripId;
    HOME_STATE.currentTripDetails = typeof tripDetails === 'string' ? JSON.parse(tripDetails) : tripDetails;
    HOME_STATE.selectedSeats = [];

    hideAllLayouts();
    showCorrectLayout(vehicleType);
    await loadReservedSeats(tripId);

    if (HOME_ELEMENTS.seatModal) {
        HOME_ELEMENTS.seatModal.classList.remove('hidden');
        // Scroll vers le haut pour s'assurer que le bouton est visible
        HOME_ELEMENTS.seatModal.scrollTop = 0;
    }
    if (HOME_ELEMENTS.selectedSeatsDisplay) {
        HOME_ELEMENTS.selectedSeatsDisplay.textContent = 'Aucun siège sélectionné';
    }
}

function hideAllLayouts() {
    if (HOME_ELEMENTS.busLayout) HOME_ELEMENTS.busLayout.classList.add('hidden');
    if (HOME_ELEMENTS.minicarLayout) HOME_ELEMENTS.minicarLayout.classList.add('hidden');
    if (HOME_ELEMENTS.taxiLayout) HOME_ELEMENTS.taxiLayout.classList.add('hidden');
}

function showCorrectLayout(vehicleType) {
    const layoutMap = {
        'bus': HOME_ELEMENTS.busLayout,
        'minicar': HOME_ELEMENTS.minicarLayout,
        'taxi': HOME_ELEMENTS.taxiLayout,
        'taxi-vip': HOME_ELEMENTS.taxiLayout
    };

    const layout = layoutMap[vehicleType];
    if (layout) {
        if (vehicleType === 'bus') {
            generateBusLayout();
        } else if (vehicleType === 'minicar') {
            generateMinicarLayout();
        } else if (vehicleType === 'taxi' || vehicleType === 'taxi-vip') {
            generateTaxiLayout();
        }
        layout.classList.remove('hidden');
    }
}

function generateBusLayout() {
    if (!HOME_ELEMENTS.busLayout) return;
    
    let html = '<div class="seat seat-driver w-10 h-10 bg-purple-200 border border-purple-500 rounded flex items-center justify-center cursor-default">D</div>';
    
    for (let i = 0; i < 4; i++) {
        html += '<div class="aisle w-10 h-10 flex items-center justify-center text-gray-400">↔</div>';
    }
    
    for (let row = 1; row <= 12; row++) {
        for (let seatNum = 1; seatNum <= 4; seatNum++) {
            const seatNumber = (row - 1) * 4 + seatNum;
            html += `<div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '${seatNumber}')">${seatNumber}</div>`;
            
            if (seatNum === 2) {
                html += '<div class="aisle w-10 h-10 flex items-center justify-center text-gray-400">↔</div>';
            }
        }
    }
    
    for (let i = 49; i <= 53; i++) {
        html += `<div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '${i}')">${i}</div>`;
    }

    HOME_ELEMENTS.busLayout.innerHTML = html;
}

function generateMinicarLayout() {
    if (!HOME_ELEMENTS.minicarLayout) return;
    
    let html = `
        <div class="seat seat-driver w-10 h-10 bg-purple-200 border border-purple-500 rounded flex items-center justify-center cursor-default">D</div>
        <div class="aisle w-10 h-10 flex items-center justify-center text-gray-400">↔</div>
        <div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '1')">1</div>
        <div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '2')">2</div>
    `;
    
    // Rows 1-3
    for (let row = 1; row <= 3; row++) {
        for (let seatNum = 1; seatNum <= 4; seatNum++) {
            const seatNumber = (row - 1) * 4 + seatNum + 2;
            html += `<div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '${seatNumber}')">${seatNumber}</div>`;
        }
    }

    HOME_ELEMENTS.minicarLayout.innerHTML = html;
}

function generateTaxiLayout() {
    if (!HOME_ELEMENTS.taxiLayout) return;
    
    let html = `
        <div class="seat seat-driver w-10 h-10 bg-purple-200 border border-purple-500 rounded flex items-center justify-center cursor-default">D</div>
        <div class="aisle w-10 h-10 flex items-center justify-center text-gray-400">↔</div>
        <div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '1')">1</div>
        
        <div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '2')">2</div>
        <div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '3')">3</div>
        <div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '4')">4</div>
        
        <div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '5')">5</div>
        <div class="aisle w-10 h-10 flex items-center justify-center text-gray-400">↔</div>
        <div class="seat seat-available w-10 h-10 bg-green-200 border border-green-500 rounded flex items-center justify-center cursor-pointer hover:bg-green-300 transition" onclick="toggleSeat(this, '6')">6</div>
    `;

    HOME_ELEMENTS.taxiLayout.innerHTML = html;
}

function toggleSeat(element, seatNumber) {
    if (element.classList.contains('seat-reserved') || element.classList.contains('seat-driver')) {
        return;
    }

    const isSelected = element.classList.contains('seat-selected');
    
    if (isSelected) {
        element.classList.remove('seat-selected', 'bg-blue-200', 'border-blue-500');
        element.classList.add('seat-available', 'bg-green-200', 'border-green-500');
        HOME_STATE.selectedSeats = HOME_STATE.selectedSeats.filter(seat => seat !== seatNumber);
    } else {
        element.classList.remove('seat-available', 'bg-green-200', 'border-green-500');
        element.classList.add('seat-selected', 'bg-blue-200', 'border-blue-500');
        HOME_STATE.selectedSeats.push(seatNumber);
    }

    updateSelectedSeatsDisplay();
}

function updateSelectedSeatsDisplay() {
    if (HOME_ELEMENTS.selectedSeatsDisplay) {
        HOME_ELEMENTS.selectedSeatsDisplay.textContent = HOME_STATE.selectedSeats.length > 0 ?
            `Sièges sélectionnés: ${HOME_STATE.selectedSeats.join(', ')}` :
            'Aucun siège sélectionné';
    }
}

async function loadReservedSeats(voyageId) {
    try {
        const response = await fetch(`${HOME_CONFIG.apiEndpoints.reservedSeats}${voyageId}/sieges`);
        if (!response.ok) {
            throw new Error(`Erreur: ${response.status}`);
        }
        
        const responseText = await response.text();
        let cleanedResponse = responseText.trim();
        if (cleanedResponse.startsWith('//')) {
            cleanedResponse = cleanedResponse.substring(cleanedResponse.indexOf('\n') + 1);
        }
        
        const result = JSON.parse(cleanedResponse);
        const reservedSeats = result.reserved_seats || [];

        document.querySelectorAll('.seat').forEach(seat => {
            const seatNumber = seat.textContent.trim();
            if (reservedSeats.includes(seatNumber) && !seat.classList.contains('seat-driver')) {
                seat.classList.remove('seat-available', 'seat-selected', 'bg-green-200', 'bg-blue-200', 'border-green-500', 'border-blue-500');
                seat.classList.add('seat-reserved', 'bg-orange-200', 'border-orange-500');
                seat.onclick = null;
                seat.classList.remove('cursor-pointer', 'hover:bg-green-300');
                seat.classList.add('cursor-not-allowed');
            }
        });
    } catch (error) {
        console.error("Error loading reserved seats:", error);
    }
}

function closeSeatSelection() {
    if (HOME_ELEMENTS.seatModal) {
        HOME_ELEMENTS.seatModal.classList.add('hidden');
    }
}

// === NOUVELLES FONCTIONS PAIEMENT PAYDUNIA ===

/**
 * Initialiser les callbacks de paiement
 */
function initializePaymentCallbacks() {
    // Vérifier si on est sur une page de callback Paydunia
    const urlParams = new URLSearchParams(window.location.search);
    const paymentId = urlParams.get('payment_id');
    
    if (paymentId) {
        if (window.location.pathname.includes('/payment/success')) {
            handlePaymentSuccess(paymentId);
        } else if (window.location.pathname.includes('/payment/cancel')) {
            handlePaymentCancel(paymentId);
        }
    }
}

/**
 * Gérer le succès du paiement
 */
async function handlePaymentSuccess(paymentId) {
    try {
        showPaymentAlert('⏳ Vérification du paiement en cours...', 'info');
        
        const payment = await checkPaymentStatus(paymentId);
        
        if (payment && payment.status === 'completed') {
            showPaymentAlert('✅ Paiement réussi ! Votre réservation est confirmée.', 'success');
            
            // Rediriger vers le ticket après 3 secondes
            setTimeout(() => {
                if (payment.reservation_id) {
                    window.location.href = `/ticket/${payment.reservation_id}`;
                } else {
                    window.location.href = '/mes-reservations';
                }
            }, 3000);
        } else {
            showPaymentAlert('⏳ Paiement en cours de traitement...', 'info');
        }
    } catch (error) {
        console.error('Erreur vérification paiement:', error);
        showPaymentAlert('⏳ Paiement en cours de validation...', 'info');
    }
}

/**
 * Gérer l'annulation du paiement
 */
function handlePaymentCancel(paymentId) {
    showPaymentAlert('❌ Paiement annulé. Vous pouvez réessayer ultérieurement.', 'warning');
    
    // Rediriger vers les réservations après 3 secondes
    setTimeout(() => {
        window.location.href = '/reservations';
    }, 3000);
}

/**
 * Vérifier le statut d'un paiement
 */
async function checkPaymentStatus(paymentId) {
    try {
        const response = await fetch(`/payment/status/${paymentId}`);
        const result = await response.json();
        
        if (result.success) {
            return result.payment;
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Erreur vérification statut:', error);
        return null;
    }
}

/**
 * Afficher une alerte de paiement
 */
function showPaymentAlert(message, type = 'info') {
    // Utiliser SweetAlert si disponible, sinon alert classique
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type,
            title: message,
            timer: type === 'success' ? 3000 : 5000,
            showConfirmButton: type !== 'info',
            confirmButtonText: 'OK'
        });
    } else {
        alert(message);
    }
}

/**
 * Processus de réservation avec paiement Paydunia
 */
async function processReservationWithPayment(guestInfo = null) {
    try {
        if (HOME_STATE.selectedSeats.length === 0) {
            alert('Veuillez sélectionner au moins un siège.');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        if (!csrfToken) {
            throw new Error('Token CSRF non trouvé');
        }

        // 1. Créer la réservation d'abord
        const reservationData = {
            voyage_id: HOME_STATE.currentTripId,
            seats: HOME_STATE.selectedSeats
        };

        if (guestInfo) {
            Object.assign(reservationData, guestInfo);
        }

        console.log('📝 Création réservation:', reservationData);

        showPaymentAlert('⏳ Création de votre réservation...', 'info');

        const reservationResponse = await fetch(HOME_CONFIG.apiEndpoints.reservation, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(reservationData)
        });

        const reservationResult = await reservationResponse.json();

        if (!reservationResult.success) {
            throw new Error(reservationResult.message || 'Erreur lors de la création de la réservation');
        }

        console.log('✅ Réservation créée:', reservationResult);

        // 2. Initialiser le paiement Paydunia
        const paymentData = {
            reservation_id: reservationResult.reservation_id,
            amount: HOME_STATE.currentTripDetails.price || HOME_STATE.currentTripDetails.prix || 0,
            currency: 'XOF',
            customer_email: guestInfo?.email || '',
            customer_phone: guestInfo?.telephone || '',
            customer_name: guestInfo?.nom || ''
        };

        console.log('💰 Initialisation paiement:', paymentData);

        showPaymentAlert('⏳ Redirection vers Paydunia...', 'info');

        const paymentResponse = await fetch(HOME_CONFIG.apiEndpoints.payment, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(paymentData)
        });

        const paymentResult = await paymentResponse.json();

        if (paymentResult.success) {
            // Rediriger vers la page de paiement Paydunia
            console.log('🔗 Redirection vers:', paymentResult.payment_url);
            window.location.href = paymentResult.payment_url;
        } else {
            throw new Error(paymentResult.message || 'Erreur lors de l\'initialisation du paiement');
        }

    } catch (error) {
        console.error('❌ Erreur processus réservation:', error);
        showPaymentAlert('❌ Erreur: ' + error.message, 'error');
    }
}

/**
 * Valider l'email
 */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// === FONCTIONS DE RÉSERVATION MISE À JOUR ===

/**
 * Confirmer la réservation (avec paiement Paydunia)
 */
async function confirmReservation() {
    if (HOME_STATE.selectedSeats.length === 0) {
        alert('Veuillez sélectionner au moins un siège.');
        return;
    }

    if (!isUserAuthenticated()) {
        showReservationForm();
        return;
    }

    // Pour les utilisateurs authentifiés, on peut utiliser leurs infos
    const userInfo = getUserInfo();
    await processReservationWithPayment(userInfo);
}

/**
 * Vérifier si l'utilisateur est authentifié
 */
function isUserAuthenticated() {
    return window.userAuthenticated || false;
}

/**
 * Obtenir les infos utilisateur (si authentifié)
 */
function getUserInfo() {
    // À adapter selon ton système d'authentification
    // Retourne { nom: '', email: '', telephone: '' } ou null
    return window.currentUser || null;
}

function showReservationForm() {
    if (HOME_ELEMENTS.reservationFormModal) {
        HOME_ELEMENTS.reservationFormModal.classList.remove('hidden');
    }
}

function closeReservationForm() {
    if (HOME_ELEMENTS.reservationFormModal) {
        HOME_ELEMENTS.reservationFormModal.classList.add('hidden');
    }
}

/**
 * Traiter la réservation d'un invité avec paiement Paydunia
 */
async function processGuestReservationWithPayment(form) {
    const formData = new FormData(form);
    const guestInfo = {
        nom: formData.get('nom'),
        email: formData.get('email'),
        telephone: formData.get('telephone')
    };

    // Validation des données
    if (!guestInfo.nom || !guestInfo.email || !guestInfo.telephone) {
        alert('Veuillez remplir tous les champs obligatoires.');
        return;
    }

    if (!validateEmail(guestInfo.email)) {
        alert('Veuillez entrer une adresse email valide.');
        return;
    }

    await processReservationWithPayment(guestInfo);
}

// Fermer les modales en cliquant à l'extérieur
if (HOME_ELEMENTS.seatModal) {
    HOME_ELEMENTS.seatModal.addEventListener('click', function(event) {
        if (event.target === HOME_ELEMENTS.seatModal) {
            closeSeatSelection();
        }
    });
}

if (HOME_ELEMENTS.reservationFormModal) {
    HOME_ELEMENTS.reservationFormModal.addEventListener('click', function(event) {
        if (event.target === HOME_ELEMENTS.reservationFormModal) {
            closeReservationForm();
        }
    });
}

// Gérer la soumission du formulaire de réservation
document.addEventListener('DOMContentLoaded', function() {
    const reservationForm = document.getElementById('guestReservationForm');
    if (reservationForm) {
        reservationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            processGuestReservationWithPayment(this);
        });
    }
});

// Exposer les fonctions globalement
window.openSeatSelection = openSeatSelection;
window.toggleSeat = toggleSeat;
window.closeSeatSelection = closeSeatSelection;
window.confirmReservation = confirmReservation;
window.closeReservationForm = closeReservationForm;
window.loadTripsFromBackend = loadTripsFromBackend;
window.processGuestReservationWithPayment = processGuestReservationWithPayment;