@extends('layouts.client.app')

@section('title', 'À Propos de Nous - AraDioni')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Notre Histoire</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">Découvrez la vision panafricaine qui anime AraDioni et son fondateur, Alpha Oumar DIA</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16">
        <!-- Founder's Story -->
        <div class="flex flex-col lg:flex-row items-center gap-12 mb-16">
            <div class="lg:w-1/2">
                <div class="relative">
                    <img src="{{ asset('images/about-hero.jpg') }}" alt="Alpha Oumar DIA - Fondateur de AraDioni" class="rounded-xl shadow-2xl w-full">
                    <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-xl shadow-lg">
                        <p class="text-sm font-semibold text-blue-600">Alpha Oumar DIA</p>
                        <p class="text-xs text-gray-600">Fondateur & Visionnaire</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Alpha Oumar DIA : Un Étudiant Bâtisseur</h2>
                <div class="space-y-4 text-gray-700">
                    <p>Né d'une mère guinéenne et avec des origines sénégalaises par son arrière-arrière-grand-père, <strong class="text-blue-600">Alpha Oumar DIA</strong> incarne l'essence même de la jeunesse panafricaine. Étudiant entre la Guinée et le Sénégal, il a personnellement vécu les défis complexes des déplacements, des envois de fonds et de colis, ainsi que de la recherche d'hébergement à travers le continent.</p>
                    <p>De ces difficultés est née une conviction : <strong class="text-blue-600">l'Afrique ne pourra prospérer que si ses peuples sont connectés simplement, rapidement et de manière fiable.</strong> AraDioni n'est pas qu'une plateforme ; c'est le fruit de cette conviction, une solution concrète créée par un Africain, pour les Africains.</p>
                </div>
                <div class="bg-blue-50 border-l-4 border-blue-600 p-6 mt-6 rounded-r-lg">
                    <p class="text-xl italic text-gray-800">"Notre force réside dans notre unité. En reliant nos villes, nous boostons nos échanges et construisons une Afrique autonome et fière."</p>
                    <p class="mt-4 font-semibold text-blue-600">— Alpha Oumar DIA, Fondateur</p>
                </div>
            </div>
        </div>

        <!-- Our Mission -->
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Notre Mission : Autonomiser l'Afrique par la Connexion</h2>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto">Nous œuvrons quotidiennement pour faciliter les échanges intra-africains et renforcer l'intégration économique du continent</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-route text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Relier les Villes</h3>
                <p class="text-gray-600">Nous créons des corridors numériques et logistiques pour fluidifier les échanges entre les grandes métropoles et les zones moins desservies.</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-hand-holding-usd text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Booster les Échanges</h3>
                <p class="text-gray-600">En simplifiant les transactions financières et l'envoi de marchandises, nous participons à la création d'un marché intra-africain dynamique.</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-globe-africa text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Rêver l'Autonomie</h3>
                <p class="text-gray-600">Chaque service utilisé sur AraDioni est un pas de plus vers une Afrique moins dépendante des circuits externes.</p>
            </div>
        </div>

        <!-- Our Presence -->
        <div class="bg-gray-100 rounded-xl p-8 mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Notre Présence en Afrique de l'Ouest</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="text-xl font-semibold">Sénégal - Siège Principal</h3>
                    </div>
                    <p class="text-gray-600 mb-2">Dakar, Rue 25 X 20</p>
                    <p class="text-gray-600">Centre névralgique de nos opérations pour l'Afrique de l'Ouest</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="text-xl font-semibold">Guinée - Siège Opérationnel</h3>
                    </div>
                    <p class="text-gray-600 mb-2">Conakry, Cosa</p>
                    <p class="text-gray-600">Plateforme stratégique pour desservir la sous-région</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-12 text-center text-white">
            <h3 class="text-2xl font-bold mb-4">Rejoignez la Révolution AraDioni</h3>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Utilisez des services conçus pour vous, par ceux qui comprennent vos défis et partagent vos ambitions</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-blue-50 font-medium py-3 px-8 rounded-lg transition duration-300">
                    Créer un Compte
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-medium py-3 px-8 rounded-lg transition duration-300">
                    Nous Contacter
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .hover\:shadow-xl {
        transition: all 0.3s ease;
    }
    .hover\:shadow-xl:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endsection