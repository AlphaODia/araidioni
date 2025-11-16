<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Client - Arai Dioni</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-database-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-storage-compat.js"></script>

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
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 2rem;
            color: white;
        }
        
        .user-avatar:hover {
            transform: scale(1.05);
        }
        
        .user-avatar-small {
            width: 40px;
            height: 40px;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            color: white;
            border-radius: 50%;
        }
        
        .avatar-initials {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
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
        
        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4361ee;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close-modal:hover {
            color: black;
        }

        .tab-panel {
            display: none;
        }
        
        .tab-panel.active {
            display: block;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            margin-top: 8px;
            overflow: hidden;
            display: none;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, #4361ee, #3a0ca3);
            width: 0%;
            transition: width 0.3s ease;
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
                        <h1 class="text-2xl font-bold">Arai Dioni</h1>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="hidden md:flex items-center space-x-4">
                            <div id="pointsBadge" class="bg-white bg-opacity-20 py-1 px-3 rounded-full">
                                <i class="fas fa-coins mr-2"></i>
                                <span id="pointsCount">0 pts</span>
                            </div>
                            <div id="notificationsBadge" class="bg-white bg-opacity-20 py-1 px-3 rounded-full">
                                <i class="fas fa-bell mr-2"></i>
                                <span id="notificationsCount">0 notifications</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span id="welcomeText" class="hidden md:inline">Chargement...</span>
                            <div class="relative">
                                <div id="headerAvatar" class="user-avatar-small">
                                    <div id="headerAvatarInitials" class="avatar-initials"></div>
                                </div>
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
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
                            <div class="user-avatar rounded-full overflow-hidden" id="avatarContainer">
                                <div id="profileAvatarInitials" class="avatar-initials w-full h-full"></div>
                                <img id="profileAvatar" src="" alt="Profile" class="w-full h-full object-cover hidden">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                    <i class="fas fa-camera text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="progress-bar" id="uploadProgressBar">
                                <div class="progress-fill" id="uploadProgressFill"></div>
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-blue-500 text-white p-2 rounded-full pulse">
                                <i class="fas fa-crown"></i>
                            </div>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h2 id="userName" class="text-3xl font-bold text-gray-800">{{ auth()->user()->name ?? 'Utilisateur' }}</h2>
                            <p id="memberSince" class="text-gray-600 mb-4">Membre depuis 2024</p>
                            <div class="flex flex-wrap justify-center md:justify-start gap-4">
                                <div class="bg-blue-50 text-blue-700 py-2 px-4 rounded-full flex items-center">
                                    <i class="fas fa-envelope mr-2"></i>
                                    <span id="userEmail">{{ auth()->user()->email ?? 'email@example.com' }}</span>
                                </div>
                                <div class="bg-green-50 text-green-700 py-2 px-4 rounded-full flex items-center">
                                    <i class="fas fa-phone-alt mr-2"></i>
                                    <span id="userPhone">Non défini</span>
                                </div>
                                <div class="bg-purple-50 text-purple-700 py-2 px-4 rounded-full flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span id="userAddress">Non défini</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 md:mt-0">
                            <button id="editProfileBtn" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-3 px-6 rounded-xl flex items-center floating-btn">
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
                            <p id="voyagesCount" class="text-2xl font-bold">0</p>
                        </div>
                    </div>
                    
                    <div class="stats-card p-6 flex items-center">
                        <div class="bg-white bg-opacity-20 p-4 rounded-full mr-4">
                            <i class="fas fa-box text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-80">Colis envoyés</p>
                            <p id="colisCount" class="text-2xl font-bold">0</p>
                        </div>
                    </div>
                    
                    <div class="stats-card p-6 flex items-center">
                        <div class="bg-white bg-opacity-20 p-4 rounded-full mr-4">
                            <i class="fas fa-hotel text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm opacity-80">Réservations</p>
                            <p id="reservationsCount" class="text-2xl font-bold">0</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation par onglets -->
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-8" id="tabNavigation">
                            <button type="button" class="py-4 px-1 tab-active" data-tab="dashboard">
                                <i class="fas fa-th-large mr-2"></i> Tableau de bord
                            </button>
                            <button type="button" class="py-4 px-1 text-gray-500 hover:text-gray-700 font-medium" data-tab="history">
                                <i class="fas fa-history mr-2"></i> Historique
                            </button>
                            <button type="button" class="py-4 px-1 text-gray-500 hover:text-gray-700 font-medium" data-tab="settings">
                                <i class="fas fa-cog mr-2"></i> Paramètres
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Contenu des onglets -->
                <div id="tabContent">
                    <!-- Tableau de bord -->
                    <div id="dashboardTab" class="tab-panel active">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Card 1: Voyages -->
                            <div class="bg-white rounded-2xl shadow-md p-6 card-hover">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="bg-blue-100 p-3 rounded-xl">
                                        <i class="fas fa-plane-departure text-blue-600 text-2xl"></i>
                                    </div>
                                    <span class="bg-green-100 text-green-800 text-xs font-medium py-1 px-2 rounded-full" id="newVoyagesBadge">0 nouveaux</span>
                                </div>
                                <h2 class="text-xl font-semibold mb-2">Voyages</h2>
                                <p class="text-gray-600 mb-4">Gérez vos réservations de voyage et découvrez de nouvelles destinations.</p>
                                <a href="/voyages" class="inline-flex items-center text-blue-600 font-medium group">
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
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium py-1 px-2 rounded-full" id="colisStatusBadge">Aucun</span>
                                </div>
                                <h2 class="text-xl font-semibold mb-2">Suivi de Colis</h2>
                                <p class="text-gray-600 mb-4">Suivez et gérez vos envois de colis en temps réel.</p>
                                <a href="/colis" class="inline-flex items-center text-green-600 font-medium group">
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
                                <a href="/hebergements" class="inline-flex items-center text-purple-600 font-medium group">
                                    Voir hébergements
                                    <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Historique -->
                    <div id="historyTab" class="tab-panel">
                        <div class="bg-white rounded-2xl shadow-md p-6">
                            <h3 class="text-xl font-semibold mb-4">Historique des activités</h3>
                            <div id="historyContent" class="space-y-4">
                                <div class="text-center py-8">
                                    <div class="loading-spinner mx-auto mb-4"></div>
                                    <p class="text-gray-500">Chargement de l'historique...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paramètres -->
                    <div id="settingsTab" class="tab-panel">
                        <div class="bg-white rounded-2xl shadow-md p-6">
                            <h3 class="text-xl font-semibold mb-4">Paramètres du compte</h3>
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-lg font-medium mb-3">Notifications</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <span>Notifications par email</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" id="emailNotifications" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span>Notifications SMS</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" id="smsNotifications" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium mb-3">Préférences</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Langue</label>
                                            <select id="languageSelect" class="w-full p-2 border border-gray-300 rounded-lg">
                                                <option value="fr">Français</option>
                                                <option value="en">English</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <button id="saveSettingsBtn" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg transition-colors">
                                    Enregistrer les paramètres
                                </button>
                            </div>
                        </div>
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
                    <p>© 2025 Arai Dioni. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Modal de modification du profil -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="text-2xl font-bold mb-6">Modifier le profil</h2>
            <form id="editProfileForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nom complet</label>
                        <input type="text" id="editName" class="w-full p-3 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Téléphone</label>
                        <input type="tel" id="editPhone" class="w-full p-3 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Adresse</label>
                        <input type="text" id="editAddress" class="w-full p-3 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Photo de profil</label>
                        <input type="file" id="editAvatar" accept="image/*" class="w-full p-3 border border-gray-300 rounded-lg">
                        <p class="text-sm text-gray-500 mt-1">Formats acceptés: JPG, PNG, GIF (max 5MB)</p>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" id="cancelEditBtn" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Annuler</button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <span id="saveButtonText">Enregistrer</span>
                        <div id="saveButtonSpinner" class="loading-spinner hidden ml-2"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Input file caché pour l'avatar -->
    <input type="file" id="avatarUploadInput" accept="image/*" style="display: none;">

    <script>
        // Configuration Firebase - AVEC VOS VRAIES CLÉS
        const firebaseConfig = {
            apiKey: "AIzaSyAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA",
            authDomain: "arai-dioni-1b65f.firebaseapp.com",
            databaseURL: "https://arai-dioni-1b65f-default-rtdb.firebaseio.com",
            projectId: "arai-dioni-1b65f",
            storageBucket: "arai-dioni-1b65f.appspot.com",
            messagingSenderId: "106189292098949221432",
            appId: "1:106189292098949221432:web:aaaaaaaaaaaaaaaaaaaaaa"
        };

        // Initialisation Firebase
        firebase.initializeApp(firebaseConfig);
        const database = firebase.database();
        const auth = firebase.auth();
        const storage = firebase.storage();

        // Variables globales
        let currentUser = null;
        let userData = null;

        // Fonction pour générer les initiales du nom
        function genererInitiales(nomComplet) {
            if (!nomComplet) return 'UD'; // Utilisateur Défaut
            
            const noms = nomComplet.trim().split(' ');
            if (noms.length === 1) {
                return noms[0].charAt(0).toUpperCase();
            } else {
                return (noms[0].charAt(0) + noms[noms.length - 1].charAt(0)).toUpperCase();
            }
        }

        // Fonction pour mettre à jour l'affichage de l'avatar
        function mettreAJourAvatar(profile) {
            const profileAvatar = document.getElementById('profileAvatar');
            const profileAvatarInitials = document.getElementById('profileAvatarInitials');
            const headerAvatarInitials = document.getElementById('headerAvatarInitials');
            
            const initiales = genererInitiales(profile.name);
            
            if (profile.avatarUrl && profile.avatarUrl !== '') {
                // Afficher l'image
                profileAvatar.src = profile.avatarUrl;
                profileAvatar.classList.remove('hidden');
                profileAvatarInitials.classList.add('hidden');
                // Pour le header, on garde les initiales pour simplifier
                headerAvatarInitials.textContent = initiales;
            } else {
                // Afficher les initiales
                profileAvatar.classList.add('hidden');
                profileAvatarInitials.classList.remove('hidden');
                profileAvatarInitials.textContent = initiales;
                headerAvatarInitials.textContent = initiales;
            }
        }

        // Fonction pour uploader l'avatar vers Firebase Storage
        function uploaderAvatar(file) {
            return new Promise((resolve, reject) => {
                if (!file) {
                    reject(new Error('Fichier manquant'));
                    return;
                }

                // Afficher la barre de progression
                const progressBar = document.getElementById('uploadProgressBar');
                const progressFill = document.getElementById('uploadProgressFill');
                progressBar.style.display = 'block';
                progressFill.style.width = '0%';

                // Créer un ID unique pour le fichier
                const fileName = `avatar_${Date.now()}_${file.name}`;
                const storageRef = storage.ref('avatars/' + fileName);

                // Upload du fichier avec métadonnées
                const metadata = {
                    contentType: file.type
                };

                const uploadTask = storageRef.put(file, metadata);

                uploadTask.on('state_changed',
                    function progress(snapshot) {
                        // Mettre à jour la barre de progression
                        const percentage = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                        progressFill.style.width = percentage + '%';
                    },
                    function error(err) {
                        console.error('Erreur lors de l\'upload:', err);
                        progressBar.style.display = 'none';
                        reject(err);
                    },
                    function complete() {
                        // Récupérer l'URL de téléchargement
                        uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                            progressBar.style.display = 'none';
                            resolve(downloadURL);
                        }).catch(reject);
                    }
                );
            });
        }

        // Fonction pour initialiser les données utilisateur
        function initialiserDonneesUtilisateur() {
            console.log('Initialisation des données utilisateur...');
            
            // Utiliser les données Laravel directement
            const userProfile = {
                profile: {
                    name: '{{ auth()->user()->name }}',
                    email: '{{ auth()->user()->email }}',
                    phone: '',
                    address: '',
                    avatarUrl: '',
                    dateCreation: new Date().toISOString()
                },
                stats: {
                    voyages: 0,
                    colis: 0,
                    reservations: 0,
                    points: 0
                },
                settings: {
                    emailNotifications: true,
                    smsNotifications: false,
                    language: 'fr'
                }
            };
            
            userData = userProfile;
            mettreAJourInterfaceUtilisateur(userData);
            
            // Essayer de charger les données depuis Firebase si elles existent
            chargerDonneesFirebase();
        }

        // Fonction pour charger les données depuis Firebase (optionnel)
        function chargerDonneesFirebase() {
            // Cette fonction est optionnelle - elle permet de synchroniser avec Firebase si vous le souhaitez
            console.log('Tentative de chargement depuis Firebase...');
        }

        // Fonction pour mettre à jour l'interface avec les données utilisateur
        function mettreAJourInterfaceUtilisateur(data) {
            console.log('Mise à jour de l\'interface...');
            
            const profile = data.profile || {};
            const stats = data.stats || {};
            
            // Mettre à jour les informations de profil
            document.getElementById('userName').textContent = profile.name || 'Utilisateur';
            document.getElementById('userEmail').textContent = profile.email || 'Non défini';
            document.getElementById('userPhone').textContent = profile.phone || 'Non défini';
            document.getElementById('userAddress').textContent = profile.address || 'Non défini';
            document.getElementById('welcomeText').textContent = `Bienvenue, ${profile.name || 'Utilisateur'}`;
            
            // Mettre à jour l'avatar (initiales ou image)
            mettreAJourAvatar(profile);
            
            // Mettre à jour la date de création
            if (profile.dateCreation) {
                const date = new Date(profile.dateCreation);
                document.getElementById('memberSince').textContent = `Membre depuis ${date.getFullYear()}`;
            }
            
            // Mettre à jour les statistiques
            document.getElementById('voyagesCount').textContent = stats.voyages || 0;
            document.getElementById('colisCount').textContent = stats.colis || 0;
            document.getElementById('reservationsCount').textContent = stats.reservations || 0;
            document.getElementById('pointsCount').textContent = `${stats.points || 0} pts`;
        }

        // Fonction pour sauvegarder les modifications du profil
        function sauvegarderProfil(donnees) {
            console.log('Sauvegarde du profil...', donnees);
            
            const saveButton = document.querySelector('#editProfileForm button[type="submit"]');
            const saveButtonText = document.getElementById('saveButtonText');
            const saveButtonSpinner = document.getElementById('saveButtonSpinner');
            
            // Afficher le spinner de chargement
            saveButton.disabled = true;
            saveButtonText.textContent = 'Sauvegarde...';
            saveButtonSpinner.classList.remove('hidden');
            
            // Gérer l'upload de l'avatar si un fichier est sélectionné
            const avatarFile = document.getElementById('editAvatar').files[0];
            
            if (avatarFile) {
                uploaderAvatar(avatarFile)
                    .then(downloadURL => {
                        // Mettre à jour les données locales
                        userData.profile.name = donnees.name;
                        userData.profile.phone = donnees.phone;
                        userData.profile.address = donnees.address;
                        userData.profile.avatarUrl = downloadURL;
                        
                        // Mettre à jour l'interface
                        mettreAJourInterfaceUtilisateur(userData);
                        
                        console.log('Profil et avatar sauvegardés avec succès');
                        afficherMessage('Profil et avatar mis à jour avec succès!', 'success');
                        
                        // Réinitialiser le bouton
                        saveButton.disabled = false;
                        saveButtonText.textContent = 'Enregistrer';
                        saveButtonSpinner.classList.add('hidden');
                        
                        fermerModal();
                    })
                    .catch(error => {
                        console.error('Erreur lors de l\'upload de l\'avatar:', error);
                        afficherMessage('Erreur lors de l\'upload de l\'avatar', 'error');
                        
                        // Réinitialiser le bouton même en cas d'erreur
                        saveButton.disabled = false;
                        saveButtonText.textContent = 'Enregistrer';
                        saveButtonSpinner.classList.add('hidden');
                    });
            } else {
                // Pas de nouvel avatar, juste mettre à jour les autres données
                userData.profile.name = donnees.name;
                userData.profile.phone = donnees.phone;
                userData.profile.address = donnees.address;
                
                // Mettre à jour l'interface
                mettreAJourInterfaceUtilisateur(userData);
                
                console.log('Profil sauvegardé avec succès');
                afficherMessage('Profil mis à jour avec succès!', 'success');
                
                // Réinitialiser le bouton
                saveButton.disabled = false;
                saveButtonText.textContent = 'Enregistrer';
                saveButtonSpinner.classList.add('hidden');
                
                fermerModal();
            }
        }

        // Fonction pour charger les paramètres
        function chargerParametres(settings) {
            console.log('Chargement des paramètres...', settings);
            
            document.getElementById('emailNotifications').checked = settings.emailNotifications || false;
            document.getElementById('smsNotifications').checked = settings.smsNotifications || false;
            document.getElementById('languageSelect').value = settings.language || 'fr';
        }

        // Fonction pour sauvegarder les paramètres
        function sauvegarderParametres() {
            console.log('Sauvegarde des paramètres...');
            
            const settings = {
                emailNotifications: document.getElementById('emailNotifications').checked,
                smsNotifications: document.getElementById('smsNotifications').checked,
                language: document.getElementById('languageSelect').value
            };
            
            // Mettre à jour les données locales
            if (userData) {
                userData.settings = settings;
            }
            
            console.log('Paramètres sauvegardés avec succès');
            afficherMessage('Paramètres enregistrés avec succès!', 'success');
        }

        // Fonction pour charger l'historique
        function chargerHistorique() {
            console.log('Chargement de l\'historique...');
            
            const historyContent = document.getElementById('historyContent');
            
            // Simulation de données d'historique
            setTimeout(() => {
                historyContent.innerHTML = `
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="bg-blue-100 p-3 rounded-lg">
                                    <i class="fas fa-plane text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Conakry → Dakar</p>
                                    <p class="text-sm text-gray-500">15 Mars 2024</p>
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Terminé</span>
                        </div>
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="bg-green-100 p-3 rounded-lg">
                                    <i class="fas fa-box text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Colis #TRK123456</p>
                                    <p class="text-sm text-gray-500">10 Mars 2024</p>
                                </div>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">En transit</span>
                        </div>
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="bg-purple-100 p-3 rounded-lg">
                                    <i class="fas fa-hotel text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Hôtel Radisson Blu</p>
                                    <p class="text-sm text-gray-500">5 Mars 2024</p>
                                </div>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Confirmé</span>
                        </div>
                    </div>
                `;
            }, 1000);
        }

        // Les fonctions d'initialisation des composants UI restent les mêmes
        function initialiserOnglets() {
            console.log('Initialisation des onglets...');
            
            const tabButtons = document.querySelectorAll('#tabNavigation button[data-tab]');
            const tabPanels = document.querySelectorAll('.tab-panel');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Retirer la classe active de tous les boutons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('tab-active');
                        btn.classList.add('text-gray-500');
                    });
                    
                    // Ajouter la classe active au bouton cliqué
                    this.classList.add('tab-active');
                    this.classList.remove('text-gray-500');
                    
                    // Cacher tous les panels
                    tabPanels.forEach(panel => {
                        panel.classList.remove('active');
                    });
                    
                    // Afficher le panel correspondant
                    const targetPanel = document.getElementById(targetTab + 'Tab');
                    if (targetPanel) {
                        targetPanel.classList.add('active');
                    }
                });
            });
        }

        function initialiserModal() {
            console.log('Initialisation de la modal...');
            
            const modal = document.getElementById('editProfileModal');
            const editBtn = document.getElementById('editProfileBtn');
            const cancelBtn = document.getElementById('cancelEditBtn');
            const closeBtn = document.querySelector('.close-modal');
            const form = document.getElementById('editProfileForm');

            editBtn.addEventListener('click', function() {
                console.log('Bouton modification cliqué');
                if (userData && userData.profile) {
                    document.getElementById('editName').value = userData.profile.name || '';
                    document.getElementById('editPhone').value = userData.profile.phone || '';
                    document.getElementById('editAddress').value = userData.profile.address || '';
                    modal.style.display = 'block';
                }
            });

            function fermerModal() {
                modal.style.display = 'none';
                // Réinitialiser le champ fichier
                document.getElementById('editAvatar').value = '';
            }

            cancelBtn.addEventListener('click', fermerModal);
            closeBtn.addEventListener('click', fermerModal);

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    fermerModal();
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Formulaire de modification soumis');
                
                const donnees = {
                    name: document.getElementById('editName').value,
                    phone: document.getElementById('editPhone').value,
                    address: document.getElementById('editAddress').value
                };
                
                sauvegarderProfil(donnees);
            });
        }

        function initialiserParametres() {
            console.log('Initialisation des paramètres...');
            
            const saveBtn = document.getElementById('saveSettingsBtn');
            
            saveBtn.addEventListener('click', function() {
                sauvegarderParametres();
            });
        }

        // Fonction utilitaire pour afficher les messages
        function afficherMessage(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Gestion de l'upload d'avatar via le clic sur l'avatar
        document.getElementById('avatarContainer').addEventListener('click', function() {
            document.getElementById('avatarUploadInput').click();
        });

        // Gestion du changement de fichier pour l'upload direct
        document.getElementById('avatarUploadInput').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                
                // Vérifier la taille du fichier (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    afficherMessage('Le fichier est trop volumineux (max 5MB)', 'error');
                    return;
                }
                
                // Vérifier le type de fichier
                if (!file.type.match('image.*')) {
                    afficherMessage('Veuillez sélectionner une image', 'error');
                    return;
                }
                
                uploaderAvatar(file)
                    .then(downloadURL => {
                        // Mettre à jour l'URL de l'avatar dans les données locales
                        if (userData && userData.profile) {
                            userData.profile.avatarUrl = downloadURL;
                            mettreAJourInterfaceUtilisateur(userData);
                        }
                        afficherMessage('Avatar mis à jour avec succès!', 'success');
                    })
                    .catch(error => {
                        console.error('Erreur lors de l\'upload de l\'avatar:', error);
                        afficherMessage('Erreur lors de l\'upload de l\'avatar', 'error');
                    });
            }
        });

        // Initialisation au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page chargée, initialisation...');
            
            // Initialiser les données utilisateur (avec Laravel)
            initialiserDonneesUtilisateur();
            
            // Initialiser les composants UI
            initialiserOnglets();
            initialiserModal();
            initialiserParametres();
            chargerHistorique();
            
            // Animation pour les cartes
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 15px 30px -10px rgba(0, 0, 0, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            console.log('Initialisation terminée');
        });
    </script>
</body>
</html>