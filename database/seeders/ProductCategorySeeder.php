<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'parent_id' => null,
                'image' => 'images/categories/1765120598_69359a5693f90.jpg',
                'name' => 'Sneakers',
                'slug' => 'sneakers',
                'tagline' => 'Gaya Santai Setiap Hari.',
                'description' => 'Sepatu kasual serbaguna dengan desain modern. Nyaman dipakai untuk aktivitas harian, sekaligus melengkapi berbagai gaya outfit.',
            ],
            [
                'parent_id' => null,
                'image' => 'images/categories/1765120324_693599447a458.jpg',
                'name' => 'Running',
                'slug' => 'running-shoes',
                'tagline' => 'Ringan, Cepat, dan Nyaman.',
                'description' => 'Sepatu dengan cushioning superior dan bobot ringan untuk menunjang performa lari, baik jarak pendek maupun jauh.',
            ],
            [
                'parent_id' => null,
                'image' => 'images/categories/1765120302_6935992e3be53.jpg',
                'name' => 'Boots',
                'slug' => 'boots',
                'tagline' => 'Tangguh Setiap Langkah.',
                'description' => 'Sepatu bergaya kokoh untuk aktivitas berat maupun fashion. Memberikan perlindungan, kenyamanan, dan tampilan bold di segala situasi.',
            ],
            [
                'parent_id' => null,
                'image' => 'images/categories/1765120276_693599141d1e4.jpg',
                'name' => 'Skate',
                'slug' => 'skate-shoes',
                'tagline' => 'Grip Kuat, Trik Makin Mantap.',
                'description' => 'Sepatu dengan sol datar dan upper tahan gesekan, dirancang khusus untuk stabilitas saat bermain skateboard dan melakukan berbagai trik.',
            ],
            [
                'parent_id' => null,
                'image' => 'images/categories/1765120248_693598f8a144b.jpg',
                'name' => 'Hiking',
                'slug' => 'hiking-outdoor-shoes',
                'tagline' => 'Tantang Alam, Langkahkan Tanpa Ragu.',
                'description' => 'Sepatu tahan banting untuk petualangan outdoor. Hadir dengan daya tahan tinggi, outsole anti-selip, dan perlindungan ekstra untuk medan berat.',
            ],
            [
                'parent_id' => null,
                'image' => 'images/categories/1765120225_693598e1141ac.jpg',
                'name' => 'Football',
                'slug' => 'football-soccer-shoes',
                'tagline' => 'Kuasi Lapangan, Kendalikan Bola.',
                'description' => 'Sepatu cleat yang dibuat untuk daya cengkeram optimal di rumput, memberikan kontrol bola, kecepatan, dan stabilitas maksimal di berbagai kondisi lapangan.',
            ],
            [
                'parent_id' => null,
                'image' => 'images/categories/1765120198_693598c6a11c8.jpg',
                'name' => 'Basketball',
                'slug' => 'basketball-shoes',
                'tagline' => 'Lompat Lebih Tinggi, Kendalikan Permainan.',
                'description' => 'Sepatu dengan ankle support, cushioning tebal, dan daya cengkeram tinggi untuk mendukung lompatan, pivot, serta pergerakan cepat di lapangan basket.',
            ],
            [
                'parent_id' => null,
                'image' => 'images/categories/1765132517_6935c8e5c9492.jpg',
                'name' => 'Gym',
                'slug' => 'training-gym-shoes',
                'tagline' => 'Siap Latihan, Siap Maksimal.',
                'description' => 'Sepatu yang dirancang untuk latihan gym dan fitness, memberikan stabilitas, fleksibilitas, dan grip kuat untuk berbagai jenis gerakan latihan.',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}