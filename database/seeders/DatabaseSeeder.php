<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {

        $categories =  [
                ['name' => 'Electronics',
                'description' => 'Gadgets and devices',
                'image' => 'assets\img\electronics.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Books',
                'description' => 'Various kinds of books',
                'image' => 'assets\img\books.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and accessories',
                'image' => 'assets\img\clothing.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]];

        DB::table('categories')->insert($categories);

            $product = [
    // Electronics
    [
        'name' => 'Apple iPhone 15 Pro Max',
        'description' => 'Latest iPhone with A17 chip and 256GB storage',
        'image' => 'assets\img\iphone15.jpg',
        'quantity' => 10,
        'price' => 4999.00,
        'category_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Samsung 55" 4K Smart TV',
        'description' => 'Ultra HD television with HDR support',
        'image' => 'assets\img\samsung_tv.jpg',
        'quantity' => 5,
        'price' => 2999.00,
        'category_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Sony WH-1000XM5 Headphones',
        'description' => 'Wireless noise-cancelling over-ear headphones',
        'image' => 'assets\img\sony_headphones.jpg',
        'quantity' => 15,
        'price' => 1299.00,
        'category_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Dell XPS 13 Laptop',
        'description' => 'Intel i7, 16GB RAM, 512GB SSD ultrabook',
        'image' => 'assets\img\dell_xps13.jpg',
        'quantity' => 7,
        'price' => 6499.00,
        'category_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Apple Watch Series 9',
        'description' => 'Smartwatch with fitness tracking and GPS',
        'image' => 'assets\img\apple_watch.jpg',
        'quantity' => 12,
        'price' => 1799.00,
        'category_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // Books
    [
        'name' => 'Atomic Habits',
        'description' => 'Self-improvement book by James Clear',
        'image' => 'assets\img\atomic_habits.jpg',
        'quantity' => 30,
        'price' => 99.00,
        'category_id' => 2,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Clean Code',
        'description' => 'A handbook of agile software craftsmanship by Robert C. Martin',
        'image' => 'assets\img\clean_code.jpg',
        'quantity' => 20,
        'price' => 129.00,
        'category_id' => 2,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Rich Dad Poor Dad',
        'description' => 'Finance classic by Robert Kiyosaki',
        'image' => 'assets\img\rich_dad.jpg',
        'quantity' => 25,
        'price' => 79.00,
        'category_id' => 2,
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // Clothing
    [
        'name' => 'Nike Air Max Sneakers',
        'description' => 'Comfortable and stylish sneakers',
        'image' => 'assets\img\nike_airmax.jpg',
        'quantity' => 18,
        'price' => 499.00,
        'category_id' => 3,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Levi’s 501 Jeans',
        'description' => 'Classic straight-fit denim jeans',
        'image' => 'assets\img\levis_501.jpg',
        'quantity' => 14,
        'price' => 299.00,
        'category_id' => 3,
        'created_at' => now(),
        'updated_at' => now(),
    ],
];
DB::table('products')->insert($product);
    }
}
