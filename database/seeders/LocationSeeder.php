<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\OpeningHour;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $location = Location::query()->updateOrCreate(
            ['name' => 'Body Sculpt Wellness — Lekki Phase 1'],
            [
                'address_line1' => '25 Wumego Crescent',
                'address_line2' => 'Lekki Phase 1',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'country' => 'Nigeria',
                'phone' => '+234 813 996 0596',
                'email' => 'hello@bodysculptwellness.com',
                'is_primary' => true,
            ],
        );

        // Monday(1) - Friday(5): 8am - 9pm. Weekends closed until the studio confirms otherwise.
        foreach (range(0, 6) as $day) {
            $isWeekday = $day >= 1 && $day <= 5;

            OpeningHour::query()->updateOrCreate(
                ['location_id' => $location->id, 'day_of_week' => $day],
                [
                    'opens_at' => $isWeekday ? '08:00:00' : null,
                    'closes_at' => $isWeekday ? '21:00:00' : null,
                    'is_closed' => ! $isWeekday,
                ],
            );
        }
    }
}
