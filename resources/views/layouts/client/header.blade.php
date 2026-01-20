<header class="fixed w-full z-50 liquid-glass-header">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container mx-auto px-4 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center justify-between">
            <!-- Logo - Version responsive -->
            <a href="{{ route('home') }}" class="flex items-center bg-white rounded-lg p-1 sm:p-2">
                <span class="ml-2 sm:ml-3 text-lg sm:text-xl font-bold" style="
                     background: linear-gradient(90deg, #333333, #666666, #999999);
                     -webkit-background-clip: text;
                     -webkit-text-fill-color: transparent;
                     font-weight: bold;
                     font-size: 1.25rem;
                     ">
                     ARAI DIONI
                </span>
                <img src="{{ asset('images/logo.png') }}" alt="Ari Dioni" class="h-8 sm:h-10">
            </a>

            <!-- Navigation Desktop -->
            <nav class="hidden lg:flex space-x-6 xl:space-x-8">
                <a href="{{ route('voyages') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-3 sm:px-4 rounded-lg transition text-sm sm:text-base">Voyages</a>
                <a href="{{ route('colis.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-3 sm:px-4 rounded-lg transition text-sm sm:text-base">Colis</a>
                <a href="{{ route('hebergements') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-3 sm:px-4 rounded-lg transition text-sm sm:text-base">Hébergements</a>
            </nav>

            <!-- Boutons CTA et Glass Toggle -->
            <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">
                @auth
                    <a href="{{ route('client.dashboard') }}" class="px-3 py-1.5 sm:px-4 sm:py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm sm:text-base">
                        <span class="hidden sm:inline">Mon compte</span>
                        <i class="fas fa-user sm:hidden text-sm"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-3 rounded-lg transition">Connexion</a>
                    <a href="{{ route('register') }}" class="px-3 py-1.5 sm:px-4 sm:py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm sm:text-base">
                        <span class="hidden sm:inline">Inscription</span>
                        <span class="sm:hidden">S'inscrire</span>
                    </a>
                @endauth
                
                <!-- Glass Effect Toggle Button - Responsive -->
                @unless(request()->is('colis/track'))
                    <button type="button" class="glass-toggle-header w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-lg hover:bg-white/20 transition cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-transparent"
                            id="glassToggleHeader"
                            title="Activer/Désactiver l'effet Glass"
                            aria-label="Effet Glass">
                        <i class="fas fa-glass-whiskey text-base sm:text-lg"></i>
                    </button>
                @endunless
                
                <!-- Menu Mobile Toggle -->
                <button id="mobile-menu-button" 
                        class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white/20 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-transparent"
                        aria-label="Menu mobile"
                        aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menu Mobile - Amélioré -->
        <div id="mobile-menu" class="lg:hidden hidden absolute top-full left-0 w-full bg-white/95 dark:bg-gray-900/95 backdrop-filter backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 shadow-xl transform transition-all duration-300 ease-in-out">
            <div class="px-4 py-6 space-y-6">
                <!-- Navigation Mobile -->
                <nav class="flex flex-col space-y-4">
                    <a href="{{ route('voyages') }}" 
                       class="flex items-center text-gray-800 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium py-3 px-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition group">
                        <i class="fas fa-plane mr-3 text-gray-400 group-hover:text-indigo-500 transition"></i>
                        Voyages
                    </a>
                    <a href="{{ route('colis.index') }}" 
                       class="flex items-center text-gray-800 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium py-3 px-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition group">
                        <i class="fas fa-box mr-3 text-gray-400 group-hover:text-indigo-500 transition"></i>
                        Colis
                    </a>
                    <a href="{{ route('hebergements') }}" 
                       class="flex items-center text-gray-800 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium py-3 px-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition group">
                        <i class="fas fa-hotel mr-3 text-gray-400 group-hover:text-indigo-500 transition"></i>
                        Hébergements
                    </a>
                </nav>
                
                <!-- Séparateur -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <!-- Actions Auth -->
                    <div class="space-y-3">
                        @guest
                            <a href="{{ route('login') }}" 
                               class="flex items-center justify-center text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium py-2.5 px-4 rounded-lg border border-gray-300 dark:border-gray-600 hover:border-indigo-300 transition">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" 
                               class="flex items-center justify-center bg-indigo-600 text-white font-medium py-2.5 px-4 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-user-plus mr-2"></i>
                                Créer un compte
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('client.dashboard') }}" 
                               class="flex items-center text-gray-800 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium py-3 px-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition group">
                                <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-indigo-500 transition"></i>
                                Tableau de bord
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center w-full text-left text-gray-800 dark:text-gray-200 hover:text-red-600 dark:hover:text-red-400 font-medium py-3 px-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition group">
                                    <i class="fas fa-sign-out-alt mr-3 text-gray-400 group-hover:text-red-500 transition"></i>
                                    Déconnexion
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
                
                <!-- Options supplémentaires -->
                <div class="pt-4">
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>Effet Glass:</span>
                        <div class="relative">
                            <div class="glass-toggle-header-mobile w-12 h-6 flex items-center rounded-full p-1 cursor-pointer bg-gray-200 dark:bg-gray-700" 
                                 id="glassToggleMobile"
                                 role="switch"
                                 aria-checked="false">
                                <div class="toggle-dot w-4 h-4 rounded-full bg-white shadow transform transition-transform duration-300"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Gestion du menu mobile améliorée
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            // Toggle menu mobile
            mobileMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                mobileMenu.classList.toggle('hidden');
                mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                
                // Animation du bouton hamburger
                mobileMenuButton.classList.toggle('active');
            });
            
            // Fermer le menu quand on clique sur un lien
            mobileMenu.querySelectorAll('a, button[type="submit"]').forEach(item => {
                item.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                    mobileMenuButton.classList.remove('active');
                });
            });
            
            // Fermer le menu quand on clique à l'extérieur
            document.addEventListener('click', function(event) {
                if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                    mobileMenuButton.classList.remove('active');
                }
            });
            
            // Gérer la touche Escape
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                    mobileMenuButton.classList.remove('active');
                }
            });
        }
        
        // Synchroniser les boutons glass toggle (mobile et desktop)
        const glassToggleHeader = document.getElementById('glassToggleHeader');
        const glassToggleMobile = document.getElementById('glassToggleMobile');
        
        if (glassToggleHeader && glassToggleMobile) {
            // Fonction pour basculer l'état
            function toggleGlassEffect() {
                const header = document.querySelector('.liquid-glass-header');
                const isActive = header.classList.contains('glass-active');
                
                if (isActive) {
                    header.classList.remove('glass-active');
                    localStorage.setItem('glassEffect', 'disabled');
                    if (glassToggleMobile) {
                        glassToggleMobile.classList.remove('bg-indigo-600');
                        glassToggleMobile.querySelector('.toggle-dot').style.transform = 'translateX(0)';
                    }
                } else {
                    header.classList.add('glass-active');
                    localStorage.setItem('glassEffect', 'enabled');
                    if (glassToggleMobile) {
                        glassToggleMobile.classList.add('bg-indigo-600');
                        glassToggleMobile.querySelector('.toggle-dot').style.transform = 'translateX(1.5rem)';
                    }
                }
            }
            
            // Événements pour desktop
            glassToggleHeader.addEventListener('click', toggleGlassEffect);
            
            // Événements pour mobile
            glassToggleMobile.addEventListener('click', toggleGlassEffect);
            
            // Restaurer l'état depuis le localStorage
            const glassEffectState = localStorage.getItem('glassEffect');
            const header = document.querySelector('.liquid-glass-header');
            if (glassEffectState === 'enabled') {
                header.classList.add('glass-active');
                if (glassToggleMobile) {
                    glassToggleMobile.classList.add('bg-indigo-600');
                    glassToggleMobile.querySelector('.toggle-dot').style.transform = 'translateX(1.5rem)';
                }
            }
        }
    });
</script>

<style>
    /* Animations pour le bouton hamburger */
    #mobile-menu-button.active svg {
        transform: rotate(90deg);
    }
    
    #mobile-menu-button svg {
        transition: transform 0.3s ease;
    }
    
    /* Transition fluide pour le menu mobile */
    #mobile-menu {
        transform-origin: top;
        opacity: 0;
        transform: scaleY(0);
    }
    
    #mobile-menu:not(.hidden) {
        animation: slideDown 0.3s ease forwards;
    }
    
    @keyframes slideDown {
        0% {
            opacity: 0;
            transform: scaleY(0);
        }
        100% {
            opacity: 1;
            transform: scaleY(1);
        }
    }
    
    /* Amélioration du glass effect pour mobile */
    @media (max-width: 768px) {
        .liquid-glass-header {
            backdrop-filter: saturate(180%) blur(20px);
            background-color: rgba(255, 255, 255, 0.86);
        }
        
        .liquid-glass-header.glass-active {
            background-color: rgba(255, 255, 255, 0.72);
            backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
        }
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .liquid-glass-header {
            background-color: rgba(17, 24, 39, 0.86);
        }
        
        .liquid-glass-header.glass-active {
            background-color: rgba(17, 24, 39, 0.72);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    }
    
    /* Amélioration du bouton toggle mobile */
    #glassToggleMobile {
        transition: background-color 0.3s ease;
    }
    
    #glassToggleMobile.bg-indigo-600 {
        background-color: #4f46e5;
    }
    
    #glassToggleMobile .toggle-dot {
        transition: transform 0.3s ease, background-color 0.3s ease;
    }
</style>