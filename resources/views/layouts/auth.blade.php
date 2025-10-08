<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication - Arai Dioni</title>
    <!-- Inclure les styles CSS ici -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        @yield('content')
    </div>
    <!-- Inclure les scripts JS ici -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>