<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\VoyageController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes publiques pour les voyages
Route::get('/voyages', [VoyageController::class, 'apiIndex']);
Route::get('/voyages/{id}', [VoyageController::class, 'show']);
Route::get('/voyages/{voyageId}/sieges-reserves', [VoyageController::class, 'getSiegesReserves']);
Route::post('/reserver', [VoyageController::class, 'reserver']);
Route::post('/reservations/unified', [VoyageController::class, 'createReservationUnified']);

// Routes protégées pour les utilisateurs connectés
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mes-reservations', [VoyageController::class, 'mesReservations']);
    Route::delete('/reservations/{reservationId}', [VoyageController::class, 'annulerReservation']);



});


Route::get('/voyages', [VoyageController::class, 'apiIndex']);
Route::get('/voyages/{voyageId}/sieges', [VoyageController::class, 'getSiegesReserves']);
Route::post('/reservations/unified', [VoyageController::class, 'createReservationUnified']);