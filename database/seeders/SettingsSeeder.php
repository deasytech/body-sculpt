<?php

namespace Database\Seeders;

use App\Filament\Pages\AboutContent;
use App\Filament\Pages\CafeContent;
use App\Filament\Pages\HomeContent;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Body Sculpt Wellness',
            'tagline' => 'Relax your body, mind & spirit.',
            'phone' => '+234 813 996 0596',
            'email' => 'hello@bodysculptwellness.com',
            'careers_email' => 'careers@hub.com',
            'instagram_handle' => '@bodysculpt.wellness',
            'instagram_url' => 'https://www.instagram.com/bodysculpt.wellness',
            'pilates_drop_in_price' => 1500000,
        ];

        // Seed the text defaults for the admin-editable Home/Café/About pages
        // too, skipping null image keys so a fresh install doesn't fake an
        // upload. About's image defaults point at real seeded photos already
        // committed to storage, so those are kept as-is.
        $settings = array_merge(
            $settings,
            array_filter(HomeContent::defaults(), fn ($value) => $value !== null),
            array_filter(CafeContent::defaults(), fn ($value) => $value !== null),
            AboutContent::defaults(),
        );

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
