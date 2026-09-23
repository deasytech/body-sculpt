<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $socks = ProductCategory::query()->updateOrCreate(['slug' => 'grip-socks'], ['name' => 'Grip Socks', 'sort_order' => 0]);
        $accessories = ProductCategory::query()->updateOrCreate(['slug' => 'accessories'], ['name' => 'Accessories', 'sort_order' => 1]);

        $products = [
            ['name' => 'Classic Socks', 'category' => $socks, 'price' => 25000, 'stock' => 40, 'image' => 'products/classic-socks.jpg'],
            ['name' => 'Luxe Grip Socks', 'category' => $socks, 'price' => 20000, 'stock' => 40, 'image' => 'products/luxe-grip-socks.jpg'],
            ['name' => 'S Grip Socks', 'category' => $socks, 'price' => 15000, 'stock' => 40, 'image' => 'products/s-grip-socks.jpg'],
            ['name' => 'Essential Bottle', 'category' => $accessories, 'price' => 40000, 'stock' => 25, 'image' => 'products/essential-bottle.jpg'],
            ['name' => 'Studio Headband', 'category' => $accessories, 'price' => 15000, 'stock' => 30, 'image' => 'products/studio-headband.jpg'],
            ['name' => 'Canvas Tote Collection', 'category' => $accessories, 'price' => 30000, 'stock' => 20, 'image' => 'products/canvas-tote.jpg'],
        ];

        foreach ($products as $index => $data) {
            $name = 'Body Sculpt '.$data['name'];

            Product::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'product_category_id' => $data['category']->id,
                    'name' => $name,
                    'description' => 'Studio essentials, made for movement and designed to last.',
                    'price' => $data['price'] * 100,
                    'sku' => 'BSW-'.strtoupper(Str::slug($data['name'], '')),
                    'stock_quantity' => $data['stock'],
                    'is_active' => true,
                    'sort_order' => $index,
                    'image_path' => $data['image'],
                ],
            );
        }
    }
}
