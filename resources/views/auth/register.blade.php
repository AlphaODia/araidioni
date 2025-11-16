<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Arai Dioni</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .auth-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }
        .register-header {
            background: #4a5568;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .register-body {
            padding: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #4a5568;
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn-register {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-register:hover {
            background: #5a67d8;
        }
        .register-links {
            margin-top: 20px;
            text-align: center;
        }
        .register-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        .register-links a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="register-card">
            <div class="register-header">
                <h2 class="text-2xl font-bold">Inscription</h2>
            </div>
            <div class="register-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <!-- Champ caché pour le rôle client -->
                    <input type="hidden" name="role" value="client">

                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Confirmer le mot de passe</label>
                        <input type="password" id="password-confirm" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn-register">S'inscrire</button>
                </form>

                <div class="register-links">
                    <a href="{{ route('login') }}">Déjà inscrit? Se connecter</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>