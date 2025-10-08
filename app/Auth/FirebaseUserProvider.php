<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Kreait\Firebase\Contract\Auth;
use App\Models\User;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Illuminate\Support\Facades\Log;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseUserProvider implements UserProvider
{
    protected $auth;

    public function __construct()
    {
        $this->auth = Firebase::auth();
    }

    public function retrieveById($identifier): ?Authenticatable
    {
        try {
            $userRecord = $this->auth->getUser($identifier);
            return $this->mapFirebaseUserToUser($userRecord);
        } catch (UserNotFound $e) {
            return null;
        } catch (\Exception $e) {
            Log::error('Firebase retrieveById error: ' . $e->getMessage());
            return null;
        }
    }

    protected function mapFirebaseUserToUser(UserRecord $userRecord): User
    {
        $customClaims = $userRecord->customClaims ?? [];
        
        return new User([
            'uid' => $userRecord->uid,
            'email' => $userRecord->email,
            'name' => $userRecord->displayName ?? $userRecord->email,
            'role' => $customClaims['role'] ?? 'user',
            'email_verified_at' => $userRecord->emailVerified ? now() : null,
        ]);
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($token);
            $uid = $verifiedIdToken->claims()->get('sub');
            
            return $this->retrieveById($uid);
        } catch (\Exception $e) {
            Log::error('Firebase retrieveByToken error: ' . $e->getMessage());
            return null;
        }
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        // Non utilisé avec Firebase
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (!isset($credentials['email'])) {
            return null;
        }

        try {
            $userRecord = $this->auth->getUserByEmail($credentials['email']);
            return $this->mapFirebaseUserToUser($userRecord);
        } catch (UserNotFound $e) {
            return null;
        } catch (\Exception $e) {
            Log::error('Firebase retrieveByCredentials error: ' . $e->getMessage());
            return null;
        }
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        if (!isset($credentials['email']) || $user->email !== $credentials['email']) {
            return false;
        }

        return true;
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): void
    {
        // Aucune action nécessaire
    }

}