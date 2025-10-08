<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
public function handle()
{
    $auth = app('firebase.auth');
    $users = $auth->listUsers();
    
    foreach ($users as $user) {
        $customClaims = $user->customClaims ?? [];
        
        if (!isset($customClaims['role']) || $customClaims['role'] === 'user') {
            $auth->setCustomUserClaims($user->uid, [
                'role' => 'client',
                'gare_id' => $customClaims['gare_id'] ?? null
            ]);
            $this->info("Updated user {$user->email} to role 'client'");
        }
    }
}
}
