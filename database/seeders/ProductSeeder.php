<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'store_id' => 4,
                'product_category_id' => 1,
                'name' => 'Ventela New Public Low',
                'description' => 'Ventela New Public Low adalah sneakers canvas low-cut dengan desain simpel dan nyaman, cocok untuk dipakai sehari-hari dan mudah dipadukan dengan berbagai outfit.',
                'condition' => 'new',
                'price' => 300000.00,
                'weight' => 300,
                'stock' => 60,
            ],
            [
                'store_id' => 4,
                'product_category_id' => 5,
                'name' => 'Ventela Basic Low',
                'description' => 'Ventela Basic Low — sneakers low-cut minimalis dan ringan, dengan desain simple dan nyaman. Sangat cocok untuk gaya kasual sehari-hari, mudah dipadukan dengan jeans atau celana santai, dan ideal untuk jalan, kuliah, atau hangout.',
                'condition' => 'new',
                'price' => 300000.00,
                'weight' => 300,
                'stock' => 135,
            ],
            [
                'store_id' => 5,
                'product_category_id' => 8,
                'name' => 'Nike United Tiempo Legend 10 Elite',
                'description' => 'Nike United Tiempo Legend 10 Elite adalah sepatu sepakbola premium dari Nike yang dirancang untuk performa maksimal di lapangan. Dibuat dengan material kulit premium dan teknologi modern, menghasilkan kontrol bola superior, sentuhan halus, serta stabilitas dan traksi yang kuat. Cocok untuk pemain di semua level yang menginginkan kenyamanan, daya tahan, dan performa tinggi di setiap pertandingan.',
                'condition' => 'new',
                'price' => 3700000.00,
                'weight' => 500,
                'stock' => 120,
            ],
            [
                'store_id' => 5,
                'product_category_id' => 9,
                'name' => 'Luka 4 PF \'Gone Ranching\'',
                'description' => 'Nike Luka 4 PF \'Gone Ranching\' menggabungkan performa basket tinggi dengan gaya streetwear yang bold. Sepatu ini memiliki sol responsif untuk gerakan cepat, cushioning yang nyaman untuk lompatan dan pendaratan, serta desain unik dengan kombinasi warna dan detail khas "Gone Ranching" yang menarik perhatian. Ideal untuk pemain basket yang ingin performa maksimal di lapangan, sambil tetap tampil gaya saat off-court.',
                'condition' => 'new',
                'price' => 2199000.00,
                'weight' => 300,
                'stock' => 195,
            ],
            [
                'store_id' => 5,
                'product_category_id' => 10,
                'name' => 'Nike Metcon 10',
                'description' => 'Nike Metcon 10 adalah sepatu training/performance yang dirancang untuk latihan berat dan gim, menggabungkan stabilitas tinggi, sol super-tahan lama, dan responsivitas untuk latihan intens. Dengan struktur kokoh dan bantalan cukup empuk, sepatu ini ideal untuk angkat beban, circuit training, HIIT, atau gym harian serta memberikan kontrol maksimal dan fleksibilitas gerak.',
                'condition' => 'new',
                'price' => 2379000.00,
                'weight' => 300,
                'stock' => 120,
            ],
            [
                'store_id' => 5,
                'product_category_id' => 2,
                'name' => 'Nike Pegasus Premium SP',
                'description' => 'Nike Pegasus Premium SP adalah sepatu running & lifestyle yang menawarkan keseimbangan sempurna antara kenyamanan, performa, dan gaya. Dengan bantalan responsif, sol ringan, dan desain modern yang elegan, sepatu ini siap mendukung lari harian, jogging santai, maupun penggunaan kasual. Ideal bagi kamu yang menginginkan sepatu multifungsi: luwes di trek, nyaman di jalan, dan stylish dipakai sehari-hari.',
                'condition' => 'new',
                'price' => 3299000.00,
                'weight' => 250,
                'stock' => 149,
            ],
            [
                'store_id' => 6,
                'product_category_id' => 6,
                'name' => 'Sepatu Hiking Terrex Free Hiker 2.0 Gore-Tex',
                'description' => 'Mendaki lebih jauh. Jelajahi lebih jauh. Nikmati pemandangannya. Dari aktivitas pendakian hingga eksplorasi di akhir pekan, sepatu hiking yang ringan ini menawarkan kenyamanan dan topangan generasi masa depan untuk memperluas jarak tempuhmu di medan trail. Midsole BOOST memberikan energi pada setiap langkah untuk membuatmu tetap fokus dalam sesi hiking yang panjang dan pendek.',
                'condition' => 'new',
                'price' => 3300000.00,
                'weight' => 500,
                'stock' => 100,
            ],
            [
                'store_id' => 6,
                'product_category_id' => 8,
                'name' => 'Copa Mundial Boots',
                'description' => 'The greater the challenge, the brighter you shine. With a name that echoes through modern football history, these adidas Copa Mundial Boots are built for the big-time. Crafted to deliver a world-class fit and touch, they have a premium K-leather forefoot for step-in comfort and assured control. A foam midsole cushions every step.',
                'condition' => 'new',
                'price' => 3000000.00,
                'weight' => 350,
                'stock' => 150,
            ],
            [
                'store_id' => 7,
                'product_category_id' => 3,
                'name' => 'Men\'s VECTIV™ Fastpack Insulated Waterproof Shoes',
                'description' => 'Durable, insulated and feature-rich, the Men\'s VECTIV™ Fastpack Insulated Waterproof Boots features our innovative VECTIV™ platform for trail-tuned propulsion and stability. These rugged boots are ready for adventure. Our waterproof footwear incorporates a variety of advanced waterproofing materials, treatments, and processes. To help keep feet dry, we use internal waterproof membranes and/or adhesive and seam-seal constructions.',
                'condition' => 'new',
                'price' => 3099000.00,
                'weight' => 350,
                'stock' => 225,
            ],
            [
                'store_id' => 8,
                'product_category_id' => 2,
                'name' => 'Scend Pro 2',
                'description' => 'Perkenalkan Scend Pro 2, sepatu pilihan dengan teknologi sol tengah ProFoam yang ditingkatkan, dibuat pada karet ProTread untuk peningkatan cengkeraman dan durabilitas.',
                'condition' => 'new',
                'price' => 1099000.00,
                'weight' => 250,
                'stock' => 305,
            ],
            [
                'store_id' => 8,
                'product_category_id' => 8,
                'name' => 'FUTURE 8 MATCH FG/AG Unisex',
                'description' => 'Para pengatur permainan, lepaskan kreativitas Anda bersama FUTURE 8 MATCH. Bagian atas dari jaring yang lembut dan ringan meningkatkan kesesuaian dan stabilitas.',
                'condition' => 'new',
                'price' => 1299000.00,
                'weight' => 300,
                'stock' => 190,
            ],
            [
                'store_id' => 8,
                'product_category_id' => 10,
                'name' => 'PWR Hybrid',
                'description' => 'Melangkahlah menuju masa depan bersama sepatu training dinamis dari PUMA. Dengan PUMAGRIP untuk traksi di berbagai jenis permukaan, ProFoam untuk bantalan responsif.',
                'condition' => 'new',
                'price' => 1199000.00,
                'weight' => 250,
                'stock' => 115,
            ],
            [
                'store_id' => 9,
                'product_category_id' => 1,
                'name' => 'Authentic Shoe',
                'description' => 'The Authentic is the original Vans silhouette. First introduced in 1966 and driven forward by creative culture ever since, this time-honored shoe keeps the old school vibe alive with sturdy canvas uppers. With its classic low-top design and iconic rubber waffle outsole, the Authentic is a blank canvas for creativity that allows you to do your thing in your own unique way.',
                'condition' => 'new',
                'price' => 1000000.00,
                'weight' => 300,
                'stock' => 160,
            ],
            [
                'store_id' => 9,
                'product_category_id' => 1,
                'name' => 'Knu Skool Shoe',
                'description' => 'Born in \'98, the Knu Skool took inspiration from the iconic Old Skool to create something entirely its own. Oversized laces, a puffed tongue, and a plush collar captured unapologetic \'90s style, all grounded on Vans\' signature vulcanized sole.',
                'condition' => 'new',
                'price' => 1000000.00,
                'weight' => 300,
                'stock' => 110,
            ],
            [
                'store_id' => 10,
                'product_category_id' => 1,
                'name' => 'New Balance 574v3 Men\'s Sneakers - Nimbus Cloud with White',
                'description' => 'New Balance 574v3 "Nimbus Cloud / White" menawarkan tampilan klasik dan bersih dengan warna netral yang elegan. Nyaman, ringan, dan cocok untuk gaya kasual harian.',
                'condition' => 'new',
                'price' => 1799000.00,
                'weight' => 250,
                'stock' => 115,
            ],
            [
                'store_id' => 11,
                'product_category_id' => 2,
                'name' => 'ASICS Men Gel-Challenger 15 Padel L.E.',
                'description' => 'ASICS Gel-Challenger 15 Padel L.E. adalah sepatu performa tinggi untuk olahraga raket, dirancang dengan bantalan responsif dan outsole khusus untuk stabilitas maksimal di lapangan padel. Dengan konstruksi kokoh dan grip kuat, sepatu ini menjaga kontrol langkah dan kelincahan, sekaligus tetap nyaman untuk pemakaian intens. Ideal untuk pemain padel maupun tenis yang mencari kombinasi performa dan kenyamanan.',
                'condition' => 'new',
                'price' => 1799000.00,
                'weight' => 200,
                'stock' => 50,
            ],
        ];

        foreach ($products as $product) {
            $slug = Str::slug($product['name']) . '-' . time();
            Product::create(array_merge($product, ['slug' => $slug]));
        }
    }
}