<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::truncate(); // optional: clears old products

        $products = [
            [
                'name' => 'Riding Helmet',
                'description' => 'Durable and safe riding helmet.',
                'price' => 49.99,
                'image' => '/images/products/helmet.jpg',
            ],
            [
                'name' => 'Saddle',
                'description' => 'Comfortable leather saddle.',
                'price' => 120.00,
                'image' => '/images/products/saddle.jpg',
            ],
            // Add at least 7 more products
            [
                'name' => 'Horse Brush',
                'description' => 'Soft brush for grooming your horse.',
                'price' => 9.99,
                'image' => '/images/products/brush.jpg',
            ],
            [
                'name' => 'Riding Gloves',
                'description' => 'Grip-enhancing riding gloves.',
                'price' => 15.00,
                'image' => '/images/products/gloves.jpg',
            ],
            [
                'name' => 'Boots',
                'description' => 'Waterproof and sturdy riding boots.',
                'price' => 79.99,
                'image' => '/images/products/boots.jpg',
            ],
            [
                'name' => 'Reins',
                'description' => 'Strong leather reins for control.',
                'price' => 25.00,
                'image' => '/images/products/reins.jpg',
            ],
            [
                'name' => 'Horse Treats',
                'description' => 'Healthy and delicious snacks.',
                'price' => 4.50,
                'image' => '/images/products/treats.jpg',
            ],
            [
                'name' => 'Riding Crop',
                'description' => 'Lightweight and effective crop.',
                'price' => 12.00,
                'image' => '/images/products/crop.jpg',
            ],
            [
                'name' => 'Horse Blanket',
                'description' => 'Warm blanket for winter use.',
                'price' => 39.90,
                'image' => '/images/products/blanket.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

