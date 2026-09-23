<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            if (app()->isProduction()) {
                throw new \RuntimeException('ADMIN_EMAIL and ADMIN_PASSWORD must be set in .env before seeding in production.');
            }

            $email ??= 'admin@example.com';
            $password ??= Str::random(16);

            $this->command?->warn("ADMIN_EMAIL/ADMIN_PASSWORD not set — using {$email} / {$password} for local dev.");
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Body Sculpt Admin',
                'password' => $password,
                'email_verified_at' => now(),
            ],
        );

        $user->forceFill(['is_admin' => true])->save();
    }
}
