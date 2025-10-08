<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Models\ActeurGare;


class AuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct() {
        $this->firebaseAuth = app('firebase.auth');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    try {
        $signInResult = $this->firebaseAuth->signInWithEmailAndPassword(
            $credentials['email'],
            $credentials['password']
        );

        $firebaseUser = $signInResult->data();
        
        // Récupérer les claims personnalisés
        $userRecord = $this->firebaseAuth->getUser($firebaseUser['localId']);
        $customClaims = $userRecord->customClaims ?? [];
        
        // Créer l'utilisateur localement sans persister en SQLite
        $user = new User([
            'uid' => $firebaseUser['localId'],
            'email' => $firebaseUser['email'],
            'name' => $firebaseUser['displayName'] ?? $firebaseUser['email'],
            'role' => $customClaims['role'] ?? 'client', // Changé de 'user' à 'client'
            'gare_id' => $customClaims['gare_id'] ?? null,
        ]);

        Auth::login($user);

        return $this->redirectToDashboard($user);

    } catch (FirebaseException $e) {
        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ]);
    }
}

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'roles' => [
                'admin' => 'Admin',
                'client' => 'Client',
                'agent_de_voyage' => 'Agent de Voyage',
                'agent_de_suivis_colis' => 'Agent de Suivi Colis',
                'agent_de_transfert_argent' => 'Agent de Transfert Argent',
                'agent_d_hebergement' => "Agent d'Hébergement",
                'chauffeur' => 'Chauffeur',
                'emballeur' => 'Emballeur',
                'locateur' => 'Locateur',
                'syndicat' => 'Syndicat'
            ]
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'gare_id' => 'nullable|string|required_if:role,chauffeur,emballeur,locateur,syndicat'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Créer l'utilisateur dans Firebase
            $userProperties = [
                'email' => $request->email,
                'emailVerified' => false,
                'password' => $request->password,
                'displayName' => $request->name,
            ];

            $createdUser = $this->firebaseAuth->createUser($userProperties);

            // Définir les claims personnalisés (rôle et gare_id)
            $claims = ['role' => $request->role];
            if ($request->gare_id) {
                $claims['gare_id'] = $request->gare_id;
            }

            $this->firebaseAuth->setCustomUserClaims($createdUser->uid, $claims);

            // Créer l'utilisateur localement sans persister en SQLite
            $user = new User([
                'uid' => $createdUser->uid,
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'gare_id' => $request->gare_id,
                'statut' => 'actif',
            ]);

            event(new Registered($user));

            // Connecter l'utilisateur
            Auth::login($user);

            return $this->redirectToDashboard($user);

        } catch (FirebaseException $e) {
            return back()->withErrors([
                'email' => 'Erreur lors de la création du compte: '.$e->getMessage(),
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectToDashboard($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'agent_de_voyage':
                return redirect()->route('agent_voyage.dashboard');
            case 'agent_de_suivis_colis':
                return redirect()->route('agent_colis.dashboard');
            case 'agent_de_transfert_argent':
                return redirect()->route('agent_transfert.dashboard');
            case 'agent_d_hebergement':
                return redirect()->route('agent_hebergement.dashboard');
            case 'chauffeur':
                return redirect()->route('chauffeur.dashboard');
            case 'emballeur':
                return redirect()->route('emballeur.dashboard');
            case 'locateur':
                return redirect()->route('locateur.dashboard');
            case 'syndicat':
                return redirect()->route('syndicat.dashboard');
            default: // client
                return redirect()->route('home');
        }
    }
}