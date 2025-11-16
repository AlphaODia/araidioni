<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Arai Dioni</title>
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
        .password-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }
        .password-header {
            background: #4a5568;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .password-body {
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
        .btn-password {
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
        .btn-password:hover {
            background: #5a67d8;
        }
        .password-links {
            margin-top: 20px;
            text-align: center;
        }
        .password-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        .password-links a:hover {
            text-decoration: underline;
        }
        .info-message {
            color: #4a5568;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
            line-height: 1.5;
        }
        .success-message {
            color: #38a169;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
            padding: 10px;
            background: #f0fff4;
            border-radius: 8px;
            border: 1px solid #9ae6b4;
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
        <div class="password-card">
            <div class="password-header">
                <h2 class="text-2xl font-bold">Mot de passe oublié</h2>
            </div>
            <div class="password-body">
                <div class="info-message">
                    Mot de passe oublié ? Aucun problème. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation de mot de passe.
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Adresse Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-password">
                        Envoyer le lien de réinitialisation
                    </button>
                </form>

                <div class="password-links">
                    <a href="{{ route('login') }}">Retour à la connexion</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>