<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ari Dioni - @yield('title', 'Accueil')</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Liquid Glass CSS -->
    <link rel="stylesheet" href="{{ asset('css/liquid-glass.css') }}">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            transition: all 0.5s ease;
        }
        
        /* Styles pour la compatibilité */
        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        
        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }
        
        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
        }
        
        @media (min-width: 992px) {
            .container {
                max-width: 960px;
            }
        }
        
        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-50 @if(request()->is('colis/track')) no-liquid-glass @endif" id="main-body">
    @include('layouts.client.header')

    <main class="min-h-screen" id="main-content">
        @yield('content')
    </main>

    @include('layouts.client.footer')

    <!-- Liquid Glass JavaScript -->
    <script src="{{ asset('js/liquid-glass.js') }}"></script>
    
    <!-- Scripts personnalisés -->
    @stack('scripts')
</body>
</html>