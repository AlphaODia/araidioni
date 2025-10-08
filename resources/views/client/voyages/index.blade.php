<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Guinée-Sénégal - Voyages</title>
    
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/liquid-glass.css') }}" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        'primary-dark': '#4338ca',
                        secondary: '#7c3aed',
                        light: '#f3f4f6',
                        dark: '#1f2937',
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body id="main-body" class="liquid-glass-enabled">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Header -->
    <header class="liquid-glass-header fixed w-full z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center bg-white">
                    <span class="ml-3 text-xl font-bold" style="
                         background: linear-gradient(90deg, #333333, #666666, #999999);
                         -webkit-background-clip: text;
                         -webkit-text-fill-color: transparent;
                         font-weight: bold;
                         font-size: 1.5rem;
                         ">
                         ARAI DIONI
                    </span>
                    <img src="{{ asset('images/logo.png') }}" alt="Ari Dioni" class="h-10">
                </a>

                <!-- Navigation Desktop -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('voyages') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-4 rounded-lg transition">Voyages</a>
                    <a href="{{ route('colis.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-4 rounded-lg transition">Colis</a>
                    <a href="{{ route('hebergements') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-4 rounded-lg transition">Hébergements</a>
                </nav>

                <!-- Boutons CTA et Glass Toggle -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('client.dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Mon compte
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-4 rounded-lg transition">Connexion</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Inscription
                        </a>
                    @endauth
                    
                    <!-- Glass Effect Toggle Button -->
                    <div class="glass-toggle-header" id="glassToggleHeader">
                        <i class="fas fa-glass-whiskey"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    @include('client.voyages.partials.hero')

    <!-- Main Content -->
    <main id="main-content" class="main-content">
        <div class="container">
            <!-- Trips Grid -->
            @include('client.voyages.partials.trips-grid')
            
            <!-- Features Section -->
            @include('client.voyages.partials.features')
            
            <!-- Testimonials Section -->
            @include('client.voyages.partials.testimonials')
        </div>
    </main>

    <!-- Footer -->
    @include('client.voyages.partials.footer')

    <!-- Seat Selection Modal -->
    @include('client.voyages.components.modal-seats')

    <!-- Scripts -->
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-database-compat.js"></script>
    <script src="{{ asset('js/liquid-glass.js') }}"></script>
    <script src="{{ asset('js/voyages.js') }}"></script>
</body>
</html>