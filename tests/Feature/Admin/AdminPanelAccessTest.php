<?php

namespace Tests\Feature\Admin;

use App\Models\ClassSchedule;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PilatesClass;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_users_cannot_access_the_panel(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertForbidden();
    }

    public function test_admin_users_can_access_the_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
    }

    public function test_admin_can_access_the_general_settings_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin/general-settings');

        $response->assertOk();
    }

    public function test_admin_can_access_the_home_content_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin/home-content');

        $response->assertOk();
    }

    public function test_admin_can_access_the_cafe_content_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin/cafe-content');

        $response->assertOk();
    }

    public function test_admin_can_access_the_about_content_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin/about-content');

        $response->assertOk();
    }

    #[DataProvider('resourceIndexProvider')]
    public function test_admin_can_view_resource_index(string $path): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get("/admin/{$path}");

        $response->assertOk();
    }

    public static function resourceIndexProvider(): array
    {
        return [
            ['service-categories'],
            ['treatments'],
            ['pilates-classes'],
            ['membership-plans'],
            ['staff'],
            ['instructors'],
            ['therapists'],
            ['customers'],
            ['bookings'],
            ['product-categories'],
            ['products'],
            ['promo-codes'],
            ['orders'],
            ['pages'],
            ['blog-posts'],
            ['testimonials'],
            ['faqs'],
            ['newsletter-subscribers'],
            ['contact-messages'],
            ['locations'],
        ];
    }

    /**
     * Create pages actually evaluate each form's field closures (e.g. dependent
     * selects), which the index/list pages never touch — this is what would
     * have caught the Filament\Forms\Get / Filament\Forms\Set namespace bug.
     */
    #[DataProvider('resourceIndexProvider')]
    public function test_admin_can_view_resource_create_page(string $path): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get("/admin/{$path}/create");

        $response->assertOk();
    }

    public function test_admin_can_view_an_order_edit_page_with_items(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::factory()->create();
        OrderItem::factory()->create(['order_id' => $order->id, 'product_id' => Product::factory()]);

        $response = $this->actingAs($admin)->get("/admin/orders/{$order->id}/edit");

        $response->assertOk();
    }

    public function test_admin_can_view_a_pilates_class_edit_page_with_schedules(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $class = PilatesClass::factory()->create();
        ClassSchedule::factory()->create(['pilates_class_id' => $class->id]);

        $response = $this->actingAs($admin)->get(route('filament.admin.resources.pilates-classes.edit', $class));

        $response->assertOk();
    }
}
