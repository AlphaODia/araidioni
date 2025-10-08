@extends('layouts.client.app')

@section('title', 'Contactez-Nous - AraDioni')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Contactez-Nous</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">Votre feedback, vos questions et vos suggestions sont essentiels pour construire ensemble l'Afrique de demain</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Contact Form -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Envoyez-nous un message</h2>
                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Votre Nom Complet *</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Votre nom complet" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Votre Email *</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="votre@email.com" required>
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Sujet du Message *</label>
                            <select id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                                <option value="">Sélectionnez un sujet</option>
                                <option value="service">Service Client</option>
                                <option value="technical">Support Technique</option>
                                <option value="partnership">Partenariat</option>
                                <option value="career">Carrière</option>
                                <option value="career">Témoignage</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Votre Message *</label>
                            <textarea id="message" name="message" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Décrivez-nous votre demande en détail..." required></textarea>
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Pays *</label>
                            <select id="country" name="country" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                                <option value="">Sélectionnez votre pays</option>
                                <option value="senegal">Sénégal</option>
                                <option value="guinea">Guinée</option>
                                <option value="cote-ivoire">Côte d'Ivoire</option>
                                <option value="mali">Mali</option>
                                <option value="other">Autre pays</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i> Envoyer le Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="lg:w-1/3">
                <div class="sticky top-24 space-y-8">
                    <!-- Headquarters -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Nos Sièges</h3>
                        
                        <div class="space-y-6">
                            <!-- Senegal Office -->
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Sénégal - Siège Principal</h4>
                                    <p class="text-gray-600 text-sm mt-1">Dakar, Rue 25 X 20</p>
                                    <p class="text-blue-600 text-sm mt-2">
                                        <i class="fas fa-phone mr-2"></i> +221 77 844 49 33
                                    </p>
                                </div>
                            </div>

                            <!-- Guinea Office -->
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Guinée - Siège Opérationnel</h4>
                                    <p class="text-gray-600 text-sm mt-1">Conakry, Cosa</p>
                                    <p class="text-blue-600 text-sm mt-2">
                                        <i class="fas fa-phone mr-2"></i> +224 623 45 67 89
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Coordonnées</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Email principal</p>
                                    <a href="mailto:contact@aradioni.com" class="text-blue-600 hover:text-blue-800 font-medium">contact@aradioni.com</a>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Support client</p>
                                    <a href="mailto:support@aradioni.com" class="text-blue-600 hover:text-blue-800 font-medium">support@aradioni.com</a>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Horaires d'ouverture</p>
                                    <p class="text-gray-800 font-medium">Lun - Ven: 8h - 18h</p>
                                    <p class="text-gray-800 font-medium">Sam: 9h - 13h</p>
                                </div>
                            </div>
                                <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">les jours de depart </p>
                                    <p class="text-gray-800 font-medium">Lun : 9h - 22h</p>
                                    <p class="text-gray-800 font-medium">Jeu: 9h - 22h</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-3">Urgence Colis</h3>
                        <p class="text-sm text-blue-700 mb-4">Problème avec votre envoi ? Contactez notre service dédié :</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <a href="tel:+221784449333" class="text-blue-600 hover:text-blue-800 font-semibold">+221 78 444 93 33</a>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Suivez-nous</h3>
                        <p class="text-gray-600 mb-4">Restez connecté avec nos actualités et nos projets pour l'Afrique</p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-pink-600 text-white rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="mt-16 bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Nos Implantations en Afrique de l'Ouest</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <div class="w-6 h-6 bg-red-100 text-red-600 rounded-full flex items-center justify-center mr-2">
                            <i class="fas fa-map-pin text-xs"></i>
                        </div>
                        Sénégal - Dakar
                    </h3>
                    <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-map-marked-alt text-3xl mb-2"></i>
                            <p>Carte interactive de notre siège à Dakar</p>
                            <p class="text-sm">Rue 25 X 20</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <div class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-2">
                            <i class="fas fa-map-pin text-xs"></i>
                        </div>
                        Guinée - Conakry
                    </h3>
                    <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-map-marked-alt text-3xl mb-2"></i>
                            <p>Carte interactive de notre siège à Conakry</p>
                            <p class="text-sm">Cosa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .transition {
        transition: all 0.3s ease;
    }
    .transform {
        transform: scale(1);
    }
    .hover\:scale-105:hover {
        transform: scale(1.05);
    }
</style>
@endsection