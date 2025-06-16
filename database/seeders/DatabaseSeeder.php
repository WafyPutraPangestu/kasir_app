<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Table;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Seed User
        User::create([
            'role' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // ✅ Seed Categories
        $categoryNames = ['Food', 'Beverage', 'Snack'];
        foreach ($categoryNames as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        // ✅ Seed Products
        $categories = Category::all();
        foreach ($categories as $category) {
            for ($i = 1; $i <= 5; $i++) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => "{$category->name} Item $i",
                    'description' => "Description for {$category->name} Item $i",
                    'price' => rand(10000, 50000),
                    'image' => null,
                    'is_available' => true,
                    'is_active' => true,
                ]);
            }
        }

        // ✅ Seed Tables (with QR Token)
        for ($i = 1; $i <= 5; $i++) {
            Table::create([
                'name' => "Table $i",
                'status' => 'available',
                'qr_token' => Str::uuid()->toString(),
            ]);
        }
    }
}
