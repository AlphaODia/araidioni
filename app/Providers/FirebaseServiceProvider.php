<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Contract\Database as FirebaseDatabase;
use Illuminate\Support\Facades\Log;

class FirebaseServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->singleton(FirebaseAuth::class, function() {
            try {
                $config = config('firebase.projects.app');
                
                $factory = new Factory();
                
                // Utilise la configuration du fichier firebase.php
                if (!empty($config['credentials']['file']) && file_exists($config['credentials']['file'])) {
                    $factory = $factory->withServiceAccount($config['credentials']['file']);
                } else {
                    throw new \Exception('Firebase credentials file not found: ' . ($config['credentials']['file'] ?? 'Not configured'));
                }
                try {
    $factory = (new Factory)->withServiceAccount(config('firebase.projects.app.credentials.file'));
    $auth = $factory->createAuth();
    Log::info('Firebase Auth initialized successfully');
} catch (\Exception $e) {
    Log::error('Firebase Auth failed: ' . $e->getMessage());
}
                return $factory->createAuth();
                    
            } catch (\Exception $e) {
                Log::error('Firebase Auth initialization error: ' . $e->getMessage());
                throw new \RuntimeException('Failed to initialize Firebase Auth: ' . $e->getMessage());
            }
        });

        $this->app->singleton(FirebaseDatabase::class, function() {
            try {
                $config = config('firebase.projects.app');
                
                $factory = new Factory();
                
                if (!empty($config['credentials']['file']) && file_exists($config['credentials']['file'])) {
                    $factory = $factory->withServiceAccount($config['credentials']['file']);
                } else {
                    throw new \Exception('Firebase credentials file not found');
                }
                
                $databaseUrl = $config['database']['url'] ?? env('FIREBASE_DATABASE_URL');
                if (empty($databaseUrl)) {
                    throw new \Exception('FIREBASE_DATABASE_URL is not set');
                }
                
                return $factory->withDatabaseUri($databaseUrl)->createDatabase();
                    
            } catch (\Exception $e) {
                Log::error('Firebase Database initialization error: ' . $e->getMessage());
                throw new \RuntimeException('Failed to initialize Firebase Database: ' . $e->getMessage());
            }
        });
    }

    public function boot(): void
    {
        //
    }
}