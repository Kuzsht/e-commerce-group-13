<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run()
    {
        $stores = [
            [
                'user_id' => 2,
                'name' => 'Ventela Store',
                'logo' => 'images/stores/1765114811.jpg',
                'about' => 'Ventella adalah toko resmi yang menyediakan berbagai produk sepatu lokal berkualitas tinggi dengan desain modern dan nyaman dipakai sehari-hari. Kami berkomitmen menghadirkan sepatu dengan bahan terbaik, jahitan rapi, serta harga yang tetap terjangkau untuk semua kalangan.',
                'phone' => '089528004511',
                'city' => 'Malang',
                'address' => 'Jl. Soekarno Hatta',
                'postal_code' => '65148',
                'is_verified' => 1,
            ],
            [
                'user_id' => 5,
                'name' => 'Nike Store',
                'logo' => 'images/stores/1765117356.jpg',
                'about' => 'Nike merupakan toko resmi yang menghadirkan berbagai produk olahraga berkualitas tinggi, mulai dari sepatu lari, sneakers lifestyle, pakaian training, hingga perlengkapan sport performance. Dengan desain inovatif, teknologi terbaru, dan material premium, Nike berkomitmen memberikan kenyamanan serta performa maksimal bagi setiap pelanggan.',
                'phone' => '083114311116',
                'city' => 'Malang',
                'address' => 'Jl. Soekarno Hatta',
                'postal_code' => '65148',
                'is_verified' => 1,
            ],
            [
                'user_id' => 6,
                'name' => 'Adidas Store',
                'logo' => 'images/stores/1765117453.png',
                'about' => 'Toko Adidas adalah pusat penjualan resmi yang menyediakan beragam koleksi sepatu original dari Adidas. Mengusung kualitas premium dan desain modern, toko ini menghadirkan pilihan sepatu untuk berbagai kebutuhan.',
                'phone' => '085930137015',
                'city' => 'Malang',
                'address' => 'Jl. Soekarno Hatta',
                'postal_code' => '65148',
                'is_verified' => 1,
            ],
            [
                'user_id' => 7,
                'name' => 'The North Face',
                'logo' => 'images/stores/1765155071_the-north-face-seeklogo.png',
                'about' => 'The North Face adalah brand outdoor yang menghadirkan sepatu boots tahan cuaca. Setiap produknya dirancang untuk memberikan kenyamanan, kestabilan, dan daya tahan maksimal di segala medan.',
                'phone' => '089528004522',
                'city' => 'Malang',
                'address' => 'Jl. Pakisaji',
                'postal_code' => '65148',
                'is_verified' => 1,
            ],
            [
                'user_id' => 8,
                'name' => 'Puma Store',
                'logo' => 'images/stores/1765156474_download.png',
                'about' => 'Puma menghadirkan footwear sporty, biasa dikenal dengan desain dinamis dan teknologi inovatif.',
                'phone' => '089528004533',
                'city' => 'Malang',
                'address' => 'Jl. Dinoyo',
                'postal_code' => '65148',
                'is_verified' => 1,
            ],
            [
                'user_id' => 9,
                'name' => 'Vans Store',
                'logo' => 'images/stores/1765158236_26a2cb17-a469-43f6-b24a-011f1137af6f.jpg',
                'about' => 'Vans menawarkan koleksi sepatu bergaya street dan skate yang ikonik, dikenal dengan desain simple, nyaman, dan penuh karakter.',
                'phone' => '089528004544',
                'city' => 'Malang',
                'address' => 'Jl. Cemorokandang',
                'postal_code' => '65148',
                'is_verified' => 1,
            ],
            [
                'user_id' => 10,
                'name' => 'New Balance',
                'logo' => 'images/stores/1765159891_43045dfef0a42b4186bc128c85611a64.jpg',
                'about' => 'New Balance menghadirkan sepatu berkualitas dengan fokus pada kenyamanan, stabilitas, dan performa.',
                'phone' => '089528004555',
                'city' => 'Cikarang',
                'address' => 'Jl. Bandung',
                'postal_code' => '65148',
                'is_verified' => 1,
            ],
            [
                'user_id' => 11,
                'name' => 'ASICS',
                'logo' => 'images/stores/1765160134_asics-logo-png_seeklogo-11909.png',
                'about' => 'ASICS menawarkan sepatu performa tinggi yang dirancang untuk pelari dan atlet.',
                'phone' => '089528004512',
                'city' => 'Cirebon',
                'address' => 'Jl. Jakarta',
                'postal_code' => '65148',
                'is_verified' => 1,
            ],
        ];

        foreach ($stores as $store) {
            Store::create($store);
        }
    }
}