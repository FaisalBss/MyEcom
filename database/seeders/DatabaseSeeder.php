<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Electronics',
                'description' => 'Gadgets and devices',
                'image' => 'electronics.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Books',
                'description' => 'Various kinds of books',
                'image' => 'books.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and accessories',
                'image' => 'clothing.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
