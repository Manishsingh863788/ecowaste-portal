<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create or update the default admin user';

    public function handle(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@ecowaste.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $this->info('Admin user ready: admin@ecowaste.com / password');
        $this->info('is_admin = ' . ($admin->is_admin ? 'true' : 'false'));
    }
}
