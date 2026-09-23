<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            LocationSeeder::class,
            SettingsSeeder::class,
            CatalogSeeder::class,
            PilatesSeeder::class,
            MembershipPlanSeeder::class,
            ShopSeeder::class,
            ContentSeeder::class,
            DemoActivitySeeder::class,
        ]);
    }
}
