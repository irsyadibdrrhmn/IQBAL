<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FurniturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // === 1️⃣ Tambahkan data kategori dulu ===
        $categories = [
            ['name' => 'Kursi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meja', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lemari', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sofa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tempat Tidur', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);

        // Ambil semua id kategori yang baru dimasukkan
        $categoryIds = DB::table('categories')->pluck('id');

        // === 2️⃣ Tambahkan data furnitur ===
        for ($i = 1; $i <= 30; $i++) {
            DB::table('products')->insert([
                'name' => 'Furnitur ' . $i,
                'description' => 'Deskripsi produk furnitur ke-' . $i . '. Terbuat dari bahan kayu berkualitas tinggi.',
                'price' => rand(500000, 5000000), // harga random 500 ribu - 5 juta
                'stock' => rand(5, 50),
                'image' => 'furnitur_' . $i . '.jpg',
                'category_id' => $categoryIds->random(), // kategori acak
                'is_premium' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
