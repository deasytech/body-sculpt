<?php

namespace Tests\Feature\Site;

use App\Models\BlogPost;
use App\Models\ClassSchedule;
use App\Models\Location;
use App\Models\MembershipPlan;
use App\Models\OpeningHour;
use App\Models\PilatesClass;
use App\Models\Product;
use App\Models\ServiceCategory;
use App\Models\Staff;
use App\Models\Treatment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $location = Location::factory()->create(['is_primary' => true]);

        foreach (range(0, 6) as $day) {
            OpeningHour::factory()->create(['location_id' => $location->id, 'day_of_week' => $day]);
        }

        MembershipPlan::factory()->count(2)->create();
    }

    #[DataProvider('routeProvider')]
    public function test_public_pages_return_200(string $route): void
    {
        $response = $this->get(route($route));

        $response->assertOk();
    }

    public static function routeProvider(): array
    {
        return [
            ['home'],
            ['about'],
            ['pilates'],
            ['wellness'],
            ['membership'],
            ['cafe'],
            ['shop'],
            ['contact'],
            ['blog'],
            ['sitemap'],
        ];
    }

    public function test_treatment_show_page_returns_200(): void
    {
        $treatment = Treatment::factory()->create(['service_category_id' => ServiceCategory::factory()]);

        $response = $this->get(route('treatments.show', $treatment));

        $response->assertOk()->assertSee($treatment->name);
    }

    public function test_product_show_page_returns_200(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('shop.show', $product));

        $response->assertOk()->assertSee($product->name);
    }

    public function test_published_blog_post_is_visible(): void
    {
        $post = BlogPost::factory()->create(['is_published' => true, 'published_at' => now()->subDay()]);

        $response = $this->get(route('blog.show', $post));

        $response->assertOk()->assertSee($post->title);
    }

    public function test_unpublished_blog_post_returns_404(): void
    {
        $post = BlogPost::factory()->create(['is_published' => false]);

        $response = $this->get(route('blog.show', $post));

        $response->assertNotFound();
    }

    public function test_pilates_page_lists_active_classes_with_schedules(): void
    {
        $instructor = Staff::factory()->instructor()->create();
        $class = PilatesClass::factory()->create(['instructor_id' => $instructor->id]);
        ClassSchedule::factory()->create(['pilates_class_id' => $class->id]);

        $response = $this->get(route('pilates'));

        $response->assertOk()->assertSee($class->name);
    }
}
