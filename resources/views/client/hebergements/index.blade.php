<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ARAÏ DIONI')</title>
    <!-- Vos balises meta, liens CSS, etc. -->
    
    @include('partials.head')
</head>
<body>
    @include('partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    @yield('scripts')
</body>
</html>