<section class="pt-32 pb-20 px-4 bg-gradient-to-b from-indigo-50 to-white">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row items-center">
            <!-- Texte -->
            <div class="md:w-1/2 mb-12 md:mb-0 hero-text">
                <h1 class="hero-title text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                    Voyagez entre la Guinée et le Sénégal en toute sérénité
                </h1>
                <p class="hero-subtitle text-xl text-gray-600 mb-8">
                    Transport de personnes, envoi de colis et hébergement - Une solution complète pour vos déplacements
                </p>
                <div class="flex space-x-4">
                    <a href="{{ route('voyages') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                        Réserver un voyage
                    </a>
                    <a href="{{ route('colis.index') }}" class="text-gray-600 hover:text-indigo-600">Colis</a>
                        Envoyer un colis
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="md:w-1/2">
                <img src="{{ asset('images/hero-image.png') }}" alt="Voyage entre pays" class="rounded-lg shadow-xl transform hover:scale-105 transition duration-500">
            </div>
        </div>
    </div>
</section>