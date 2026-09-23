<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\Treatment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'recovery' => [
                'name' => 'Recovery',
                'description' => 'Massage, recovery and restoration rituals that bring the body back to balance.',
                'icon' => 'sparkles',
                'image' => 'treatments/recovery-massage.jpg',
                'treatments' => [
                    ['name' => 'Reset Ritual', 'duration' => 60, 'price' => 45000, 'short' => 'A full-body recovery ritual to release tension and restore calm.'],
                    ['name' => 'Deep Recovery Ritual', 'duration' => 75, 'price' => 60000, 'short' => 'An extended therapeutic massage for deep muscular recovery.'],
                    ['name' => 'Calm Ritual', 'duration' => 45, 'price' => 35000, 'short' => 'A gentle, grounding ritual designed to quiet the mind.'],
                    ['name' => 'Renewal Ritual', 'duration' => 60, 'price' => 48000, 'short' => 'Restorative bodywork that leaves you renewed, inside and out.'],
                    ['name' => 'Recovery Escape', 'duration' => 90, 'price' => 75000, 'short' => 'Our signature escape — movement, massage and stillness combined.'],
                    ['name' => 'Scalp Massage Add-on', 'duration' => 15, 'price' => 12000, 'short' => 'A soothing scalp ritual to add to any treatment.'],
                    ['name' => 'Foot Reflexology Add-on', 'duration' => 15, 'price' => 12000, 'short' => 'Pressure-point foot therapy to close out your session.'],
                ],
            ],
            'sculpt' => [
                'name' => 'Sculpt',
                'description' => 'Body sculpting, lymphatic and contouring treatments focused on wellness, not transformation claims.',
                'icon' => 'sparkles',
                'image' => 'treatments/sculpt-body-treatment.jpg',
                'treatments' => [
                    ['name' => 'Sculpt Ritual', 'duration' => 60, 'price' => 55000, 'short' => 'A contouring ritual combining massage and targeted techniques.'],
                    ['name' => 'Contour Wrap', 'duration' => 75, 'price' => 65000, 'short' => 'A warming body wrap designed to firm and smooth.'],
                    ['name' => 'Lymphatic Reset', 'duration' => 45, 'price' => 40000, 'short' => 'Gentle lymphatic drainage to reduce puffiness and refresh.'],
                    ['name' => 'Endosphere Sculpt', 'duration' => 60, 'price' => 60000, 'short' => 'Compression-roller therapy for skin tone and circulation.'],
                    ['name' => 'Sculpt & Tone Ritual', 'duration' => 75, 'price' => 68000, 'short' => 'A full-body sculpting ritual for tone and definition.'],
                ],
            ],
            'facials' => [
                'name' => 'Facials',
                'description' => 'Hydrafacial and skin renewal treatments for a natural, healthy glow.',
                'icon' => 'sun',
                'image' => 'treatments/facials-hydrafacial.jpg',
                'treatments' => [
                    ['name' => 'Signature Hydrafacial', 'duration' => 60, 'price' => 50000, 'short' => 'Deep cleanse, extract and hydrate for radiant skin.'],
                    ['name' => 'Deluxe Hydrafacial', 'duration' => 75, 'price' => 65000, 'short' => 'Our elevated Hydrafacial with an added booster serum.'],
                    ['name' => 'Tailored Facial', 'duration' => 45, 'price' => 38000, 'short' => 'A facial designed around your skin\'s specific needs.'],
                    ['name' => 'Skin Renewal Facial', 'duration' => 60, 'price' => 48000, 'short' => 'Gentle resurfacing for brighter, smoother skin.'],
                    ['name' => 'Glow Ritual', 'duration' => 60, 'price' => 52000, 'short' => 'A radiance-boosting facial finished with a face massage.'],
                ],
            ],
            'heat-recovery' => [
                'name' => 'Heat & Recovery',
                'description' => 'Sauna and steam experiences that round out the wellness journey.',
                'icon' => 'fire',
                'image' => 'treatments/heat-recovery-sauna.jpg',
                'treatments' => [
                    ['name' => 'Sauna Session', 'duration' => 45, 'price' => 20000, 'short' => 'A private sauna session to unwind and detoxify.'],
                    ['name' => 'Steam Experience', 'duration' => 30, 'price' => 15000, 'short' => 'A calming steam session for skin and breath.'],
                    ['name' => 'Sauna & Steam Combo', 'duration' => 60, 'price' => 30000, 'short' => 'The full heat experience — sauna followed by steam.'],
                ],
            ],
        ];

        foreach ($categories as $slug => $data) {
            $category = ServiceCategory::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'icon' => $data['icon'],
                    'is_active' => true,
                ],
            );

            foreach ($data['treatments'] as $index => $treatment) {
                Treatment::query()->updateOrCreate(
                    ['slug' => Str::slug($treatment['name'])],
                    [
                        'service_category_id' => $category->id,
                        'name' => $treatment['name'],
                        'short_description' => $treatment['short'],
                        'description' => $treatment['short'].' Speak with our team to tailor this ritual to your goals.',
                        'duration_minutes' => $treatment['duration'],
                        'price' => $treatment['price'] * 100,
                        'is_featured' => $index === 0,
                        'is_active' => true,
                        'sort_order' => $index,
                        'image_path' => $index === 0 ? $data['image'] : null,
                    ],
                );
            }
        }
    }
}
