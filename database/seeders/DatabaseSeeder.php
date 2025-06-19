<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Table;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =================================================================
        // 1. KOSONGKAN DAN BUAT DIREKTORI PENYIMPANAN PRODUK
        // =================================================================
        // Hapus direktori 'products' jika sudah ada untuk membersihkan gambar lama.
        $storagePath = storage_path('app/public/products');
        if (File::exists($storagePath)) {
            File::deleteDirectory($storagePath);
        }
        // Buat kembali direktori 'products'.
        File::makeDirectory($storagePath, 0755, true);


        // =================================================================
        // 2. SEED USER ADMIN
        // =================================================================
        User::create([
            'role' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);


        // =================================================================
        // 3. SEED CATEGORIES & PRODUCTS UNTUK COFFEE SHOP
        // =================================================================
        // Data coffee shop berdasarkan gambar yang tersedia
        $coffeeShopData = [
            'Coffee & Beverages' => [
                ['name' => 'Dalgona Coffee', 'price' => 25000, 'image' => 'dalgona.jpeg'],
                ['name' => 'Coffee Brown Sugar', 'price' => 23000, 'image' => 'coffe_brown_sugar.jpeg'],
                ['name' => 'Iced Vanilla Almond', 'price' => 26000, 'image' => 'iced_vanila_almond.jpeg'],
                ['name' => 'Caffe Latte', 'price' => 22000, 'image' => 'coffe_latte.jpeg'],
                ['name' => 'Americano', 'price' => 20000, 'image' => 'americano.jpeg'],
                ['name' => 'Butter Iced Coffee', 'price' => 24000, 'image' => 'butter_iced.jpeg'],
                ['name' => 'Valentine Coffee', 'price' => 28000, 'image' => 'valentine_coffe.jpeg'],
            ],
            'Specialty Drinks' => [
                ['name' => 'Ice Red Velvet', 'price' => 27000, 'image' => 'ice_redvelvet.jpeg'],
            ],
            'Cakes & Desserts' => [
                ['name' => 'Coklat Strawberry Cake', 'price' => 35000, 'image' => 'coklat_strawberry_cake.jpeg'],
                ['name' => 'Strawberry Cake', 'price' => 32000, 'image' => 'strawberry_cake.jpeg'],
            ],
            'Indonesian Food' => [
                ['name' => 'Nasi Goreng', 'price' => 18000, 'image' => 'nasi_goreng.jpeg'],
                ['name' => 'Rice Ball', 'price' => 12000, 'image' => 'rice_ball.jpeg'],
                ['name' => 'Kentang Goreng', 'price' => 15000, 'image' => 'kentang_goreng.jpeg'],
            ],
        ];

        foreach ($coffeeShopData as $categoryName => $products) {
            // Membuat kategori baru
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
            ]);

            // Membuat produk untuk setiap kategori
            foreach ($products as $productData) {
                // Path gambar akan disimpan di database, contoh: 'products/dalgona.jpeg'
                $imagePath = 'products/' . $productData['image'];

                // NOTE: Bagian ini hanya untuk development.
                // Membuat file gambar placeholder jika belum ada, agar tidak error.
                // Anda HARUS menggantinya dengan gambar asli.
                $fullImagePath = $storagePath . '/' . $productData['image'];
                if (!File::exists($fullImagePath)) {
                    // Buat file kosong sebagai penanda
                    // Nanti replace dengan gambar asli
                    File::put($fullImagePath, '');
                }

                Product::create([
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'description' => "Delicious {$productData['name']} made with premium ingredients.",
                    'price' => $productData['price'],
                    'image' => $imagePath, // Menyimpan path relatif ke storage publik
                    'is_available' => true,
                    'is_active' => true,
                ]);
            }
        }


        // =================================================================
        // 4. SEED TABLES (MEJA)
        // =================================================================
        for ($i = 1; $i <= 10; $i++) {
            Table::create([
                'name' => "Table $i",
                'status' => 'available',
                'qr_token' => Str::uuid()->toString(),
            ]);
        }
    }
}
