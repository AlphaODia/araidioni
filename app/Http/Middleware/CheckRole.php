<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class CheckRole
{
    protected $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Synchroniser avec Firebase si le rôle est "user" (ancienne valeur par défaut)
        if ($user->role === 'user') {
            try {
                $firebaseUser = $this->firebaseAuth->getUser($user->uid);
                $customClaims = $firebaseUser->customClaims ?? [];
                
                // Mettre à jour le rôle de l'utilisateur
                $user->role = $customClaims['role'] ?? 'client';
            } catch (\Exception $e) {
                // En cas d'erreur, on garde le rôle actuel
            }
        }

        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }
        
        abort(403, 'Accès non autorisé');
    }
}