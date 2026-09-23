<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Page;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['category' => 'Booking', 'question' => 'How do I book a class or treatment?', 'answer' => 'You can book directly on our website — choose a service, pick a date and time, and confirm your details. You\'ll receive an email confirmation right away.'],
            ['category' => 'Booking', 'question' => 'What is your cancellation policy?', 'answer' => 'We ask for at least 12 hours\' notice to cancel or reschedule a booking so we can offer the slot to another client.'],
            ['category' => 'Pilates', 'question' => 'I\'ve never done Pilates before — where should I start?', 'answer' => 'Our Reformer Pilates — Beginner class is designed for exactly this. Our instructors will guide you through pacing, breath and alignment from your first session.'],
            ['category' => 'Membership', 'question' => 'Can I pause or cancel my membership?', 'answer' => 'Yes. Memberships can be paused or cancelled from your account, or by contacting our front desk team directly.'],
            ['category' => 'Visiting', 'question' => 'Is there parking at the studio?', 'answer' => 'Yes, on-site parking is available for all clients for the duration of their visit.'],
            ['category' => 'Visiting', 'question' => 'What should I wear or bring?', 'answer' => 'Comfortable activewear and grip socks for Pilates. Grip socks are available to purchase in-studio if you don\'t already own a pair.'],
        ];

        foreach ($faqs as $index => $data) {
            Faq::query()->updateOrCreate(
                ['question' => $data['question']],
                [
                    'category' => $data['category'],
                    'answer' => $data['answer'],
                    'is_active' => true,
                    'sort_order' => $index,
                ],
            );
        }

        $testimonials = [
            ['name' => 'Amaka O.', 'service' => 'Reformer Pilates', 'quote' => 'The studio feels like a retreat, not a gym. I leave every class calmer than when I arrived.'],
            ['name' => 'Tunde A.', 'service' => 'Deep Recovery Ritual', 'quote' => 'Genuinely the most attentive wellness team I\'ve worked with in Lagos. Every detail is considered.'],
            ['name' => 'Ifeoma N.', 'service' => 'Signature Hydrafacial', 'quote' => 'My skin has never looked better, and the space itself is so quiet and restorative.'],
            ['name' => 'David E.', 'service' => 'Private Reformer Session', 'quote' => 'Coming back from an injury, my instructor tailored every session perfectly to where I was that day.'],
        ];

        foreach ($testimonials as $index => $data) {
            Testimonial::query()->updateOrCreate(
                ['customer_name' => $data['name'], 'quote' => $data['quote']],
                [
                    'service_name' => $data['service'],
                    'rating' => 5,
                    'is_featured' => $index < 3,
                    'is_active' => true,
                    'sort_order' => $index,
                ],
            );
        }

        Page::query()->updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Body Sculpt Wellness',
                'content' => "Wellness is more than fitness — it is a lifestyle.\n\nBody Sculpt Wellness brings together Pilates, recovery, body sculpting and facial treatments in one calming, premium space in Lekki Phase 1, Lagos. We created a place where clients can strengthen their bodies, relax their minds, and recharge from daily stress.\n\nOur studio blends reformer and mat Pilates with a full menu of recovery rituals, sculpt treatments, Hydrafacials, sauna and steam — plus a café and studio shop, so the experience doesn't end when your session does.",
                'meta_title' => 'About Us — Body Sculpt Wellness',
                'meta_description' => 'Learn about Body Sculpt Wellness, a premium Pilates, recovery and beauty studio in Lekki Phase 1, Lagos.',
                'is_published' => true,
            ],
        );
    }
}
