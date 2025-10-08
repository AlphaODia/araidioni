<section class="py-16 bg-gradient-to-b from-indigo-50 to-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-indigo-800 mb-4">Ce que disent nos clients</h2>
            <p class="text-lg text-indigo-600 max-w-2xl mx-auto">Découvrez les expériences authentiques de ceux qui ont voyagé avec nous</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                // Récupérer les 5 meilleurs témoignages depuis la base de données
                $testimonials = [
                    [
                        'name' => 'Aissatou Diallo',
                        'comment' => 'Service exceptionnel ! Le trajet était confortable et ponctuel. Je recommande vivement Ari Dioni pour tous vos déplacements.',
                        'rating' => 5,
                        'avatar' => 'https://randomuser.me/api/portraits/women/32.jpg'
                    ],
                    [
                        'name' => 'Mamadou Bah',
                        'comment' => 'J\'ai été impressionné par le professionnalisme de l\'équipe. Le bus était propre et climatisé. Excellent voyage!',
                        'rating' => 5,
                        'avatar' => 'https://randomuser.me/api/portraits/men/45.jpg'
                    ],
                    [
                        'name' => 'Fatoumata Binta',
                        'comment' => 'Service ponctuel et sécurisé. J\'ai apprécié le suivi en temps réel de mon colis. Merci Ari Dioni!',
                        'rating' => 4,
                        'avatar' => 'https://randomuser.me/api/portraits/women/65.jpg'
                    ],
                    [
                        'name' => 'Ibrahima Sarr',
                        'comment' => 'Voyage très confortable à un prix abordable. Le chauffeur était professionnel et courtois. À refaire!',
                        'rating' => 5,
                        'avatar' => 'https://randomuser.me/api/portraits/men/22.jpg'
                    ],
                    [
                        'name' => 'Kadiatou Camara',
                        'comment' => 'Service impeccable ! J\'ai particulièrement apprécié la ponctualité et la propreté du véhicule.',
                        'rating' => 5,
                        'avatar' => 'https://randomuser.me/api/portraits/women/55.jpg'
                    ]
                ];
            @endphp

            @foreach ($testimonials as $testimonial)
            <div class="bg-white rounded-xl shadow-md p-6 border border-indigo-100 transform transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center mb-4">
                    <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full object-cover border-2 border-indigo-200">
                    <div class="ml-4">
                        <h4 class="font-bold text-indigo-800">{{ $testimonial['name'] }}</h4>
                        <div class="flex text-yellow-400 mt-1">
                            @for ($i = 0; $i < $testimonial['rating']; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <p class="text-indigo-600 italic">"{{ $testimonial['comment'] }}"</p>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                Voir tous les témoignages
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</section>