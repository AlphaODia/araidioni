<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeReservations = Reservation::where('statut', 'confirmé')->count();
        
        // Calcul des revenus journaliers
        $dailyRevenue = Transaction::whereDate('created_at', today())->sum('montant');
        
        // Messages en attente (à adapter selon votre modèle de messages)
        $pendingMessages = 0; // Remplacez par votre logique
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'activeReservations',
            'dailyRevenue',
            'pendingMessages'
        ));
    }
}