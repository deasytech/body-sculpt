<?php

namespace Database\Seeders;

use App\Enums\ClassLevel;
use App\Enums\StaffType;
use App\Models\ClassSchedule;
use App\Models\PilatesClass;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PilatesSeeder extends Seeder
{
    public function run(): void
    {
        $instructors = [
            ['name' => 'Amara Okafor', 'bio' => 'Amara leads our Reformer program with over eight years of teaching experience across Lagos studios.'],
            ['name' => 'Zainab Bello', 'bio' => 'Zainab specialises in low-impact, alignment-focused Mat Pilates for every level.'],
            ['name' => 'Chidinma Eze', 'bio' => 'Chidinma brings a dance background to her high-energy Reformer classes.'],
            ['name' => 'Tomiwa Adeyemi', 'bio' => 'Tomiwa focuses on private, goal-driven sessions for clients recovering from injury.'],
        ];

        $instructorModels = collect($instructors)->map(
            fn (array $data) => Staff::query()->updateOrCreate(
                ['email' => Str::slug($data['name']).'@bodysculptwellness.com'],
                [
                    'type' => StaffType::Instructor,
                    'name' => $data['name'],
                    'bio' => $data['bio'],
                    'is_active' => true,
                ],
            )
        );

        foreach ([
            ['name' => 'Ngozi Umeh', 'bio' => 'Ngozi is a licensed massage therapist specialising in deep recovery work.'],
            ['name' => 'Fatima Yusuf', 'bio' => 'Fatima leads our facial and skin renewal treatments.'],
            ['name' => 'Kemi Alabi', 'bio' => 'Kemi specialises in lymphatic and body contouring rituals.'],
        ] as $data) {
            Staff::query()->updateOrCreate(
                ['email' => Str::slug($data['name']).'@bodysculptwellness.com'],
                [
                    'type' => StaffType::Therapist,
                    'name' => $data['name'],
                    'bio' => $data['bio'],
                    'is_active' => true,
                ],
            );
        }

        $classes = [
            [
                'name' => 'Reformer Pilates — Beginner',
                'level' => ClassLevel::Beginner,
                'instructor' => $instructorModels[0],
                'description' => 'An introduction to reformer work — pacing, breath and foundational alignment.',
                'image' => 'pilates-classes/reformer-beginner.jpg',
                'schedules' => [[1, '08:00'], [3, '08:00'], [5, '09:00']],
            ],
            [
                'name' => 'Reformer Pilates — Intermediate',
                'level' => ClassLevel::Intermediate,
                'instructor' => $instructorModels[2],
                'description' => 'A dynamic reformer flow building strength, control and flexibility.',
                'schedules' => [[2, '18:00'], [4, '18:00']],
            ],
            [
                'name' => 'Mat Pilates',
                'level' => ClassLevel::AllLevels,
                'instructor' => $instructorModels[1],
                'description' => 'Classic mat-based Pilates focused on core control and posture.',
                'schedules' => [[1, '17:30'], [3, '17:30'], [6, '10:00']],
            ],
            [
                'name' => 'Signature Group Class',
                'level' => ClassLevel::AllLevels,
                'instructor' => $instructorModels[2],
                'description' => 'Our boutique group class blending reformer and mat work in one session.',
                'schedules' => [[5, '18:30']],
            ],
            [
                'name' => 'Private Reformer Session',
                'level' => ClassLevel::AllLevels,
                'instructor' => $instructorModels[3],
                'description' => 'A fully personalised one-to-one reformer session tailored to your goals.',
                'capacity' => 1,
                'schedules' => [[2, '08:00'], [4, '08:00'], [6, '09:00']],
            ],
        ];

        foreach ($classes as $index => $data) {
            $class = PilatesClass::query()->updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'instructor_id' => $data['instructor']->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'level' => $data['level'],
                    'duration_minutes' => 50,
                    'capacity' => $data['capacity'] ?? 12,
                    'is_active' => true,
                    'sort_order' => $index,
                    'image_path' => $data['image'] ?? null,
                ],
            );

            foreach ($data['schedules'] as [$day, $start]) {
                $startTime = $start.':00';
                $endTime = date('H:i:s', strtotime($startTime.' +50 minutes'));

                ClassSchedule::query()->updateOrCreate(
                    [
                        'pilates_class_id' => $class->id,
                        'day_of_week' => $day,
                        'start_time' => $startTime,
                    ],
                    [
                        'end_time' => $endTime,
                        'is_active' => true,
                    ],
                );
            }
        }
    }
}
