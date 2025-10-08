<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;


class User extends Authenticatable implements MustVerifyEmail
{
    // Liste des rôles disponibles
    public const ROLES = [
        'admin' => 'Administrateur',
        'client' => 'Client',
        'agent_de_voyage' => 'Agent de Voyage',
        'agent_de_suivis_colis' => 'Agent de Suivi Colis',
        'agent_de_transfert_argent' => 'Agent de Transfert Argent',
        'agent_d_hebergement' => "Agent d'Hébergement",
        'chauffeur' => 'Chauffeur',
        'emballeur' => 'Emballeur',
        'locateur' => 'Locateur',
        'syndicat' => 'Syndicat'
    ];

    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Implémentation de l'interface Authenticatable
     */
    public function getAuthIdentifierName()
    {
        return 'uid';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['uid'] ?? null;
    }

    public function getAuthPassword()
    {
        return ''; // Firebase gère le mot de passe
    }

    public function getRememberToken()
    {
        return null; // Non utilisé avec Firebase
    }

    public function setRememberToken($value) {}
    public function getRememberTokenName() {}

    /**
     * Méthodes d'accès aux attributs
     */
    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Implémentation de MustVerifyEmail
     */
    public function hasVerifiedEmail()
    {
        return !empty($this->attributes['email_verified_at']);
    }

    public function markEmailAsVerified()
    {
        $this->attributes['email_verified_at'] = now();
        return $this;
    }

    public function sendEmailVerificationNotification()
    {
        // Implémentation pour l'envoi de notification de vérification d'email
    }

    /**
     * Méthodes de vérification de rôles
     */
    public function hasRole($role)
    {
        return $this->attributes['role'] === $role;
    }

    public function hasAnyRole(array $roles)
    {
        return in_array($this->attributes['role'], $roles);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isClient()
    {
        return $this->hasRole('client');
    }

    public function isAgentVoyage()
    {
        return $this->hasRole('agent_de_voyage');
    }

    public function isAgentColis()
    {
        return $this->hasRole('agent_de_suivis_colis');
    }

    public function isAgentTransfert()
    {
        return $this->hasRole('agent_de_transfert_argent');
    }

    public function isAgentHebergement()
    {
        return $this->hasRole('agent_d_hebergement');
    }

    public function isChauffeur()
    {
        return $this->hasRole('chauffeur');
    }

    public function isEmballeur()
    {
        return $this->hasRole('emballeur');
    }

    public function isLocateur()
    {
        return $this->hasRole('locateur');
    }

    public function isSyndicat()
    {
        return $this->hasRole('syndicat');
    }

    public function isActeurGare()
    {
        return $this->hasAnyRole(['chauffeur', 'emballeur', 'locateur', 'syndicat']);
    }

    public function isPersonnel()
    {
        return $this->hasAnyRole([
            'agent_de_voyage',
            'agent_de_suivis_colis',
            'agent_de_transfert_argent',
            'agent_d_hebergement'
        ]);
    }

    /**
     * Méthodes utilitaires
     */
    public function getRoleNameAttribute()
    {
        return self::ROLES[$this->attributes['role']] ?? $this->attributes['role'];
    }

    public function recordLogin()
    {
        $this->attributes['last_login_at'] = now();
        $this->attributes['last_login_ip'] = request()->ip();
    }

    /**
     * Pour la compatibilité
     */
    public function getKey()
    {
        return $this->getAuthIdentifier();
    }

    public function getKeyName()
    {
        return 'uid';
    }

    /**
     * Conversion en tableau
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Pour la compatibilité avec les notifications
     */
    public function routeNotificationFor($driver, $notification = null)
    {
        if (method_exists($this, $method = 'routeNotificationFor'.Str::studly($driver))) {
            return $this->{$method}($notification);
        }

        switch ($driver) {
            case 'database':
                return $this->getKey();
            case 'mail':
                return $this->email;
            default:
                return null;
        }
    }

    /**
     * Éviter les méthodes de persistence Eloquent
     */
    public function save(array $options = []) 
    {
        // Ne rien faire - la persistence est gérée par Firebase
        return true;
    }

    public function delete()
    {
        // Ne rien faire - la suppression est gérée par Firebase
        return true;
    }

    public static function create(array $attributes = [])
    {
        // Retourner une nouvelle instance sans persister en base SQLite
        return new static($attributes);
    }

    public static function firstOrCreate(array $attributes, array $values = [])
    {
        // Retourner une nouvelle instance sans persister en base SQLite
        return new static(array_merge($attributes, $values));
    }
}