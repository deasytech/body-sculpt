<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = 'Body Sculpt '.fake()->unique()->words(2, true);

        return [
            'product_category_id' => ProductCategory::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(10000, 45000) * 100,
            'sku' => strtoupper(Str::random(8)),
            'stock_quantity' => fake()->numberBetween(5, 50),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
