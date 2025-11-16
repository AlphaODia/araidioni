<header class="fixed w-full z-50 liquid-glass-header">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center bg-white rounded-lg p-2">
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
                @unless(request()->is('colis/track'))
                    <div class="glass-toggle-header" id="glassToggleHeader" title="Activer/Désactiver l'effet Glass">
                        <i class="fas fa-glass-whiskey"></i>
                    </div>
                @endunless
            </div>
        </div>

        <!-- Menu Mobile -->
        <div class="md:hidden mt-4">
            <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-white/10 backdrop-filter backdrop-blur-lg border-t border-white/20 mt-2">
                <nav class="flex flex-col space-y-4 p-4">
                    <a href="{{ route('voyages') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Voyages</a>
                    <a href="{{ route('colis.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Colis</a>
                    <a href="{{ route('hebergements') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Hébergements</a>
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Inscription</a>
                    @endguest
                    @auth
                        <a href="{{ route('client.dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Mon compte</a>
                    @endauth
                </nav>
            </div>
        </div>
    </div>
</header>

<script>
    // Gestion du menu mobile
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            // Fermer le menu quand on clique à l'extérieur
            document.addEventListener('click', function(event) {
                if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }
    });
</script>