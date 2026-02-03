@extends('layouts.client.app')

@section('title', 'Notre Vision - AraDioni')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-violet-50 to-blue-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-violet-700 to-blue-800 py-20">
        <div class="container mx-auto px-4 text-center">
            <br></br>
       
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Connecter l'Afrique de Demain</h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto">Une plateforme innovante conçue pour accélérer les échanges et l'intégration à l'échelle continentale</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16">
        <!-- Founder's Vision -->
        <div class="flex flex-col lg:flex-row items-center gap-12 mb-16">
            <div class="lg:w-1/2">
                <div class="relative">
                    <img src="{{ asset('images/about-hero.jpg') }}" alt="Alpha Oumar DIA - Fondateur de AraDioni" class="rounded-2xl shadow-2xl w-full ring-4 ring-white ring-offset-4 ring-offset-blue-50">
                    <div class="absolute -bottom-6 -right-6 bg-gradient-to-r from-violet-600 to-blue-600 p-6 rounded-2xl shadow-2xl">
                        <p class="text-lg font-bold text-white">Alpha Oumar DIA</p>
                        <p class="text-sm text-blue-100">Fondateur & Ingénieur en Informatique</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Vision d'un Ingénieur pour l'Afrique</h2>
                <div class="space-y-6 text-gray-800 text-lg leading-relaxed">
                    <p><strong class="text-violet-700">Alpha Oumar DIA</strong>, ingénieur en informatique, porte une vision claire : <strong class="text-blue-600">libérer le potentiel économique de l'Afrique en supprimant les barrières à la connectivité</strong>.</p>
                    <p>Convaincu que la technologie doit servir le développement concret, il a conçu AraDioni comme une réponse aux défis logistiques et d'accès qui entravent encore les échanges intra-africains.</p>
                    <p>Sa philosophie ? Créer des ponts numériques robustes et intuitifs pour que les personnes, les idées et les opportunités circulent librement, d'une ville à l'autre, d'un pays à l'autre.</p>
                </div>
                <div class="bg-gradient-to-r from-violet-600/10 to-blue-600/10 border-l-4 border-violet-600 p-8 mt-8 rounded-r-2xl">
                    <p class="text-2xl italic text-gray-900">"L'autonomie de notre continent passe par sa capacité interne à se connecter. Nous bâtissons l'infrastructure numérique qui manquait."</p>
                    <p class="mt-4 font-bold text-violet-700">— Alpha Oumar DIA, Fondateur</p>
                </div>
            </div>
        </div>

        <!-- Core Mission -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6">Notre Raison d'Être</h2>
            <p class="text-xl text-gray-700 max-w-4xl mx-auto">Transformer la complexité des déplacements et de la logistique en une expérience fluide, fiable et entièrement intégrée</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-20">
            <div class="bg-white p-10 rounded-2xl shadow-xl text-center hover:shadow-2xl transition-all duration-300 border border-gray-100">
                <div class="w-20 h-20 bg-gradient-to-br from-violet-100 to-blue-100 text-violet-700 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-md">
                    <i class="fas fa-shipping-fast text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Logistique Intelligente</h3>
                <p class="text-gray-700">Nous optimisons le suivi et la livraison de colis à travers un réseau fiable, offrant transparence et tranquillité d'esprit à chaque étape.</p>
            </div>
            
            <div class="bg-white p-10 rounded-2xl shadow-xl text-center hover:shadow-2xl transition-all duration-300 border border-gray-100">
                <div class="w-20 h-20 bg-gradient-to-br from-violet-100 to-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-md">
                    <i class="fas fa-bed text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Accès à l'Hébergement</h3>
                <p class="text-gray-700">Nous facilitons la recherche et la réservation d'hébergements adaptés, simplifiant les séjours professionnels ou personnels à travers le continent.</p>
            </div>
            
            <div class="bg-white p-10 rounded-2xl shadow-xl text-center hover:shadow-2xl transition-all duration-300 border border-gray-100">
                <div class="w-20 h-20 bg-gradient-to-br from-violet-100 to-blue-100 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-md">
                    <i class="fas fa-project-diagram text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Intégration Numérique</h3>
                <p class="text-gray-700">Notre plateforme sert de hub central, connectant différents services essentiels pour créer un écosystème numérique unifié et efficient.</p>
            </div>
        </div>

        <!-- Strategic Presence -->
        <div class="bg-gradient-to-r from-white to-blue-50/50 rounded-2xl p-12 mb-16 border border-gray-200 shadow-lg">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-12 text-center">Implantation Stratégique</h2>
            <div class="grid md:grid-cols-2 gap-10">
                <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-blue-600">
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-100 to-violet-100 text-blue-700 rounded-xl flex items-center justify-center mr-5 shadow-sm">
                            <i class="fas fa-map-marked-alt text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Sénégal<br><span class="text-lg font-semibold text-blue-600">Siège Principal & Innovation</span></h3>
                    </div>
                    <p class="text-gray-700"><span class="font-semibold">Dakar</span> – Notre centre de R&D et hub technologique, d'où nous orchestrons le développement de solutions à l'échelle ouest-africaine.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-violet-600">
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 bg-gradient-to-r from-violet-100 to-blue-100 text-violet-700 rounded-xl flex items-center justify-center mr-5 shadow-sm">
                            <i class="fas fa-map-marked-alt text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Guinée<br><span class="text-lg font-semibold text-violet-600">Siège Opérationnel</span></h3>
                    </div>
                    <p class="text-gray-700"><span class="font-semibold">Conakry</span> – Le cœur de nos opérations sur le terrain, assurant la mise en œuvre et l'adaptation locale de nos services.</p>
                </div>
            </div>
        </div>

        <!-- Final CTA -->
        <div class="bg-gradient-to-r from-violet-700 via-blue-700 to-blue-800 rounded-2xl p-16 text-center text-white shadow-2xl">
            <h3 class="text-3xl md:text-4xl font-bold mb-6">Prêt à Repenser la Connectivité Africaine ?</h3>
            <p class="text-xl mb-10 max-w-2xl mx-auto text-blue-100">Rejoignez une plateforme qui place l'innovation technologique au service du développement continental.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('register') }}" class="bg-white text-gray-900 hover:bg-gray-100 font-bold py-4 px-12 rounded-xl transition duration-300 shadow-lg hover:shadow-xl text-lg">
                    Démarrer l'Expérience
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white hover:bg-white/20 font-bold py-4 px-12 rounded-xl transition duration-300 text-lg">
                    Échanger avec Notre Équipe
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .hover\:shadow-2xl:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transform: translateY(-5px);
    }
    .transition-all {
        transition-property: all;
    }
</style>
@endsection