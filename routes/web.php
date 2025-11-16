<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\VoyageController;
use App\Http\Controllers\Client\ColisController;
use App\Http\Controllers\Client\HebergementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GestionUtilisateursController;
use App\Http\Controllers\Admin\GestionReservationsController;
use App\Http\Controllers\Admin\GestionPaiementsController;
use App\Http\Controllers\Admin\GestionHebergementsController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\HebergementTicketController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\Client\PaymentController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes pour les voyages
Route::get('/voyages', [VoyageController::class, 'index'])->name('voyages');
Route::post('/rechercher-voyages', [VoyageController::class, 'rechercher'])->name('voyages.rechercher');
Route::get('/voyages/{id}', [VoyageController::class, 'show'])->name('voyages.details');
Route::get('/sieges-reserves/{voyageId}', [VoyageController::class, 'siegesReserves'])->name('voyages.sieges-reserves');
Route::post('/reserver', [VoyageController::class, 'reserver'])->name('voyages.reserver');
Route::get('/ticket/{reservationId}', [VoyageController::class, 'ticket'])->name('voyages.ticket');
Route::get('/mes-reservations', [VoyageController::class, 'mesReservations'])->name('voyages.mes-reservations');
Route::post('/annuler-reservation/{reservationId}', [VoyageController::class, 'annulerReservation'])->name('voyages.annuler');

// Route pour le formulaire de réservation
Route::get('/reservation/{voyageId}', [VoyageController::class, 'showReservationForm'])->name('reservation.form');
Route::get('/voyages/convert-to-app', [VoyageController::class, 'convertToAppFormat']);

// Routes API pour les voyages
Route::get('/api/voyages', [VoyageController::class, 'apiIndex'])->name('voyages.api');
Route::get('/api/voyages/{voyageId}/sieges', [VoyageController::class, 'getSiegesReserves'])->name('voyages.api.sieges');
Route::post('/api/reserver', [VoyageController::class, 'reserver'])->name('voyages.api.reserver');

// Route de debug Firebase
Route::get('/debug-firebase', [VoyageController::class, 'debugTrips']);

// Routes pour les hébergements
Route::get('/hebergements', [HebergementController::class, 'index'])->name('hebergements');
Route::post('/hebergements/reserver', [HebergementController::class, 'reserver'])->name('hebergements.reserver');
Route::get('/api/hebergements', [HebergementController::class, 'apiHebergements'])->name('hebergements.api');
Route::get('/hebergements/{id}', [HebergementController::class, 'show'])->name('hebergements.show');

// Route pour le ticket d'hébergement
Route::get('/hebergement/ticket/{reservationId}', [HebergementTicketController::class, 'show'])->name('hebergement.ticket');

// Routes informations
Route::get('/a-propos', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Routes pour les témoignages
Route::get('/temoignages', [HomeController::class, 'temoignages'])->name('temoignages');
Route::post('/temoignages', [HomeController::class, 'storeTemoignage'])->name('temoignages.store');

// Routes pour les colis
Route::prefix('colis')->name('colis.')->group(function () {
    Route::get('/', [ColisController::class, 'index'])->name('index');
    Route::get('/create', [ColisController::class, 'create'])->name('create');
    Route::post('/', [ColisController::class, 'store'])->name('store');
    Route::get('/track', [ColisController::class, 'track'])->name('track');
    Route::post('/track', [ColisController::class, 'search'])->name('search');
    Route::get('/{id}', [ColisController::class, 'show'])->name('show');
});

// ==================== ROUTES DE PAIEMENT ====================
Route::prefix('payment')->group(function () {
    Route::get('/test', [PaymentController::class, 'testConnection'])->name('payment.test'); // AJOUTÉ
    Route::post('/initiate', [PaymentController::class, 'initPayment'])->name('payment.initiate');
    Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
    Route::post('/webhook', [PaymentController::class, 'paymentWebhook'])->name('payment.webhook');
    Route::get('/status/{paymentId}', [PaymentController::class, 'checkPaymentStatus'])->name('payment.status');

    Route::get('/payment/test-connection', [PaymentController::class, 'testPaydunyaConnection'])
    ->name('payment.test.connection');
    });
// ==================== FIN ROUTES PAIEMENT ====================

// Routes de recherche
Route::post('/rechercher-voyages', [VoyageController::class, 'search'])->name('voyages.search');

// Routes pour la newsletter
Route::get('/newsletter/inscription', [NewsletterController::class, 'showForm'])->name('newsletter.form');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/subscribers', [NewsletterController::class, 'getSubscribers'])->name('newsletter.subscribers')->middleware('auth');

// Routes pour les avis
Route::get('/avis/public', [AvisController::class, 'showApproved'])->name('avis.public');
Route::get('/avis', [AvisController::class, 'create'])->name('avis.create');
Route::post('/avis', [AvisController::class, 'store'])->name('avis.store');
Route::get('/avis/approved', [AvisController::class, 'getApprovedAvis'])->name('avis.approved');

// Routes de dashboard par rôle
Route::prefix('client')->name('client.')->middleware(['auth', 'role:client'])->group(function() {
    Route::get('/dashboard', function() {
        return view('client.dashboard');
    })->name('dashboard');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::prefix('agent-voyage')->name('agent_voyage.')->middleware(['auth', 'role:agent_de_voyage'])->group(function() {
    Route::get('/dashboard', function() {
        return view('agent_voyage.dashboard');
    })->name('dashboard');
});

// Route dashboard générale (fallback)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Routes de profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('utilisateurs', GestionUtilisateursController::class);
    Route::resource('reservations', GestionReservationsController::class);
    Route::resource('paiements', GestionPaiementsController::class);
    Route::resource('hebergements', GestionHebergementsController::class);
    
    // Routes supplémentaires
    Route::get('statistiques', [DashboardController::class, 'statistiques'])->name('statistiques');
    Route::get('audit', [DashboardController::class, 'audit'])->name('audit');
});

// Routes Admin supplémentaires
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/newsletter', [NewsletterController::class, 'getSubscribers'])->name('admin.newsletter');
    Route::get('/admin/avis', [AvisController::class, 'index'])->name('admin.avis');
    Route::post('/admin/avis/{avisId}/approve', [AvisController::class, 'approve'])->name('admin.avis.approve');
});

require __DIR__.'/auth.php';
require __DIR__.'/payment.php';