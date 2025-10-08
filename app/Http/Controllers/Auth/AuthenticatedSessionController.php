<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActeurGare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class AuthenticatedSessionController extends Controller
{
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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirection en fonction du rôle
            return $this->redirectToDashboard($user);
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ]);
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'gare_id' => $request->gare_id,
            'statut' => 'actif',
        ]);

        // Si c'est un acteur de gare, créer aussi dans la table ActeurGare
        if (in_array($request->role, ['chauffeur', 'emballeur', 'locateur', 'syndicat'])) {
            ActeurGare::create([
                'user_id' => $user->id,
                'type' => $request->role,
                'gare_id' => $request->gare_id,
                'date_inscription' => now(),
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return $this->redirectToDashboard($user);
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
                return redirect()->route('client.dashboard');
        }
    }
}
