@extends('layouts.app')

@section('title', 'Tableau de Bord Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-dark text-white vh-100 position-fixed" id="sidebar">
            <div class="d-flex flex-column p-3">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-4">Menu Admin</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link active" aria-current="page">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.utilisateurs.index') }}" class="nav-link text-white">
                            <i class="fas fa-users me-2"></i>
                            Utilisateurs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reservations.index') }}" class="nav-link text-white">
                            <i class="fas fa-calendar-check me-2"></i>
                            Réservations
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.paiements.index') }}" class="nav-link text-white">
                            <i class="fas fa-credit-card me-2"></i>
                            Paiements
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hebergements.index') }}" class="nav-link text-white">
                            <i class="fas fa-hotel me-2"></i>
                            Hébergements
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.personnel.index') }}" class="nav-link text-white">
                            <i class="fas fa-user-tie me-2"></i>
                            Personnel
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.messages.index') }}" class="nav-link text-white">
                            <i class="fas fa-envelope me-2"></i>
                            Messages
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.statistiques') }}" class="nav-link text-white">
                            <i class="fas fa-chart-bar me-2"></i>
                            Statistiques
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.audit') }}" class="nav-link text-white">
                            <i class="fas fa-shield-alt me-2"></i>
                            Audit Système
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://via.placeholder.com/32" alt="Admin" width="32" height="32" class="rounded-circle me-2">
                        <strong>{{ Auth::user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 16.666667%!important;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tableau de Bord Administrateur</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Partager</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Exporter</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <i class="fas fa-calendar"></i> Cette semaine
                    </button>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Utilisateurs</h5>
                                    <h2 class="card-text">{{ $totalUsers }}</h2>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a href="{{ route('admin.utilisateurs.index') }}" class="small text-white stretched-link">Voir détails</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Réservations</h5>
                                    <h2 class="card-text">{{ $activeReservations }}</h2>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-check fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a href="{{ route('admin.reservations.index') }}" class="small text-white stretched-link">Voir détails</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Revenus</h5>
                                    <h2 class="card-text">{{ number_format($dailyRevenue, 0, ',', ' ') }} FCFA</h2>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-money-bill-wave fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a href="{{ route('admin.paiements.index') }}" class="small text-white stretched-link">Voir détails</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Messages</h5>
                                    <h2 class="card-text">{{ $pendingMessages }}</h2>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-envelope fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a href="{{ route('admin.messages.index') }}" class="small text-white stretched-link">Voir détails</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-1"></i>
                            Revenus hebdomadaires
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart" width="100%" height="50"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Croissance des utilisateurs
                        </div>
                        <div class="card-body">
                            <canvas id="userGrowthChart" width="100%" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dernières activités -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Dernières réservations
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentReservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>{{ $reservation->user->name }}</td>
                                    <td>{{ $reservation->service_type }}</td>
                                    <td>{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $reservation->status === 'confirmé' ? 'success' : 'warning' }}">
                                            {{ $reservation->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Graphique des revenus
    var revenueCtx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            datasets: [{
                label: 'Revenus (FCFA)',
                data: [250000, 320000, 280000, 410000, 380000, 520000, 450000],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique de croissance des utilisateurs
    var userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    var userGrowthChart = new Chart(userGrowthCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            datasets: [{
                label: 'Nouveaux utilisateurs',
                data: [45, 78, 112, 156, 198, 245],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush