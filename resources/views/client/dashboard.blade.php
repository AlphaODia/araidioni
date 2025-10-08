<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Client - Arai Dioni</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .card-hover {
            transition: all 0.3s ease;
            transform: translateY(0);
            border-left: 4px solid var(--primary);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.15);
        }
        
        .user-avatar {
            width: 120px;
            height: 120px;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stats-card {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border-radius: 12px;
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(67, 97, 238, 0); }
            100% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0); }
        }
        
        .tab-active {
            border-bottom: 3px solid var(--accent);
            color: var(--primary);
            font-weight: 600;
        }
        
        .floating-btn {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .floating-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header amélioré -->
        <header class="bg-gradient-to-r from-blue-600 to-indigo-800 text-white shadow-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white p-2 rounded-full">
                            <i class="fas fa-user-circle text-blue-600 text-2xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold">Arai Dioni </h1>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="hidden md:flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 py-1 px-3 rounded-full">
                                <i class="fas fa-coins mr-2"></i>
                                <span>1250 pts</span>
                            </div>
                            <div class="bg-white bg-opacity-20 py-1 px-3 rounded-full">
                                <i class="fas fa-bell mr-2"></i>
                                <span>3 notifications</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="hidden md:inline">Bienvenue, {{ auth()->user()->name }}</span>
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white">
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-white bg-opacity-20 hover:bg-opacity-30 py-2 px-4 rounded-lg transition-all duration-300">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content amélioré -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Section profil utilisateur -->
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="relative mb-6 md:mb-0 md:mr-8">
                            <div class="user-avatar rounded-full overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Profile" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-blue-500 text-white p-2 rounded-full pulse">
                                <i class="fas fa-crown"></i>
                            </div>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-3xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                            <p class="text-gray-600 mb-4">Membre depuis Janvier 2023</p>
                            <div class="flex flex-wrap justify-center md:justify-start gap-4">
                                <div class="bg-blue-50 text-blue-700 py-2 px-4 rounded-full flex items-center">
                                    <i class="fas fa-envelope mr-2"></i>
                                    <span>{{ auth()->user()->email }}</span>
                                </div>
                                <div class="bg-green-50 text-green-700 py-2 px-4 rounded-full flex items-center">
                                    <i class="fas fa-phone-alt mr-2"></i>
                                    <span>+33 6 12 34 56 78</span>
                                </div>
                                <div class="bg-purple-50 text-purple-700 py-2 px-4 rounded-full flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>Paris, France</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 md:mt-0">
                            <button class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-3 px-6 rounded-xl flex items-center floating-btn">
                                <i class="fas fa-edit mr-2"></i> Modifier le profil
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="stats-card p-6 flex items-center">
                        <div class="bg-white bg-opacity-20 p-4 rounded-full mr-4">
                            <i class="fas fa-suitcase-rolling text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-80">Voyages effectués</p>
                            <p class="text-2xl font-bold">12</p>
                        </div>
                    </div>
                    
                    <div class="stats-card p-6 flex items-center">
                        <div class="bg-white bg-opacity-20 p-4 rounded-full mr-4">
                            <i class="fas fa-box text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-80">Colis envoyés</p>
                            <p class="text-2xl font-bold">8</p>
                        </div>
                    </div>
                    
                    <div class="stats-card p-6 flex items-center">
                        <div class="bg-white bg-opacity-20 p-4 rounded-full mr-4">
                            <i class="fas fa-hotel text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-80">Réservations</p>
                            <p class="text-2xl font-bold">5</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation par onglets -->
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-8">
                            <a href="#" class="py-4 px-1 tab-active">
                                <i class="fas fa-th-large mr-2"></i> Tableau de bord
                            </a>
                            <a href="#" class="py-4 px-1 text-gray-500 hover:text-gray-700 font-medium">
                                <i class="fas fa-history mr-2"></i> Historique
                            </a>
                            <a href="#" class="py-4 px-1 text-gray-500 hover:text-gray-700 font-medium">
                                <i class="fas fa-cog mr-2"></i> Paramètres
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Cartes de services -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Card 1: Voyages -->
                    <div class="bg-white rounded-2xl shadow-md p-6 card-hover">
                        <div class="flex justify-between items-start mb-4">
                            <div class="bg-blue-100 p-3 rounded-xl">
                                <i class="fas fa-plane-departure text-blue-600 text-2xl"></i>
                            </div>
                            <span class="bg-green-100 text-green-800 text-xs font-medium py-1 px-2 rounded-full">3 nouveaux</span>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">Voyages</h2>
                        <p class="text-gray-600 mb-4">Gérez vos réservations de voyage et découvrez de nouvelles destinations.</p>
                        <a href="{{ route('voyages') }}" class="inline-flex items-center text-blue-600 font-medium group">
                            Voir les voyages
                            <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>

                    <!-- Card 2: Colis -->
                    <div class="bg-white rounded-2xl shadow-md p-6 card-hover">
                        <div class="flex justify-between items-start mb-4">
                            <div class="bg-green-100 p-3 rounded-xl">
                                <i class="fas fa-box-open text-green-600 text-2xl"></i>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium py-1 px-2 rounded-full">En transit</span>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">Suivi de Colis</h2>
                        <p class="text-gray-600 mb-4">Suivez et gérez vos envois de colis en temps réel.</p>
                        <a href="{{ route('colis.index') }}" class="inline-flex items-center text-green-600 font-medium group">
                            Suivi colis
                            <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>

                    <!-- Card 3: Hébergement -->
                    <div class="bg-white rounded-2xl shadow-md p-6 card-hover">
                        <div class="flex justify-between items-start mb-4">
                            <div class="bg-purple-100 p-3 rounded-xl">
                                <i class="fas fa-hotel text-purple-600 text-2xl"></i>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium py-1 px-2 rounded-full">Promo</span>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">Hébergement</h2>
                        <p class="text-gray-600 mb-4">Réservez votre hébergement parmi nos partenaires privilégiés.</p>
                        <a href="{{ route('hebergements') }}" class="inline-flex items-center text-purple-600 font-medium group">
                            Voir hébergements
                            <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer amélioré -->
        <footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Arai Dioni</h3>
                        <p class="text-gray-400">Votre partenaire de confiance pour tous vos voyages et envois.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">À propos</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contactez-nous</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                    <p>© 2024 Arai Dioni. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Animation simple pour les éléments
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card-hover');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.classList.add('shadow-lg');
                });
                
                card.addEventListener('mouseleave', () => {
                    card.classList.remove('shadow-lg');
                });
            });
            
            // Simuler un chargement de notifications
            const notificationBadge = document.querySelector('.bg-white.bg-opacity-20:last-child');
            if (notificationBadge) {
                setInterval(() => {
                    notificationBadge.classList.toggle('bg-opacity-30');
                }, 1000);
            }
        });
    </script>
</body>
</html>