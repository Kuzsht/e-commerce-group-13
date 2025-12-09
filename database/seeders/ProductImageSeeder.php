<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $productImages = [
            // Product 10
            ['product_id' => 10, 'image' => '1765107411_332392170_165203106301963_2215697255051655438_n-1.jpg', 'is_thumbnail' => 1],
            ['product_id' => 10, 'image' => '1765107417_356269344_819210769620009_1518694801407782626_n.jpg', 'is_thumbnail' => 0],
            
            // Product 11
            ['product_id' => 11, 'image' => '1765127526_6935b566c64f1.jpg', 'is_thumbnail' => 1],
            ['product_id' => 11, 'image' => '1765127548_AW2.jpg', 'is_thumbnail' => 0],
            
            // Product 12
            ['product_id' => 12, 'image' => '1765151738_693613fa42c11.png', 'is_thumbnail' => 1],
            ['product_id' => 12, 'image' => '1765151738_693613fa46aa0.png', 'is_thumbnail' => 0],
            
            // Product 13
            ['product_id' => 13, 'image' => '1765152132_69361584602e3.png', 'is_thumbnail' => 1],
            ['product_id' => 13, 'image' => '1765152132_69361584635e7.png', 'is_thumbnail' => 0],
            
            // Product 14
            ['product_id' => 14, 'image' => '1765152405_6936169524a31.png', 'is_thumbnail' => 1],
            ['product_id' => 14, 'image' => '1765152405_69361695274bb.png', 'is_thumbnail' => 0],
            
            // Product 16
            ['product_id' => 16, 'image' => '1765153495_69361ad7d691a.png', 'is_thumbnail' => 1],
            ['product_id' => 16, 'image' => '1765153495_69361ad7d9e0c.png', 'is_thumbnail' => 0],
            
            // Product 17
            ['product_id' => 17, 'image' => '1765153795_69361c038e94b.jpg', 'is_thumbnail' => 1],
            ['product_id' => 17, 'image' => '1765153795_69361c039270c.jpg', 'is_thumbnail' => 0],
            
            // Product 18
            ['product_id' => 18, 'image' => '1765154124_69361d4cbb1e3.jpg', 'is_thumbnail' => 1],
            ['product_id' => 18, 'image' => '1765154124_69361d4cc009d.jpg', 'is_thumbnail' => 0],
            ['product_id' => 18, 'image' => '1765154124_69361d4cc3b81.jpg', 'is_thumbnail' => 0],
            
            // Product 19
            ['product_id' => 19, 'image' => '1765155411_69362253a2a90.png', 'is_thumbnail' => 1],
            ['product_id' => 19, 'image' => '1765155411_69362253a682d.png', 'is_thumbnail' => 0],
            
            // Product 20
            ['product_id' => 20, 'image' => '1765157056_693628c0c48ad.jpg', 'is_thumbnail' => 1],
            ['product_id' => 20, 'image' => '1765157056_693628c0c7bfb.jpg', 'is_thumbnail' => 0],
            ['product_id' => 20, 'image' => '1765157056_693628c0ca01c.jpg', 'is_thumbnail' => 0],
            
            // Product 21
            ['product_id' => 21, 'image' => '1765157488_69362a70f2c42.jpg', 'is_thumbnail' => 1],
            ['product_id' => 21, 'image' => '1765157489_69362a7101107.jpg', 'is_thumbnail' => 0],
            
            // Product 22
            ['product_id' => 22, 'image' => '1765157746_69362b727c7f1.jpg', 'is_thumbnail' => 1],
            ['product_id' => 22, 'image' => '1765157746_69362b727fe87.jpg', 'is_thumbnail' => 0],
            
            // Product 24
            ['product_id' => 24, 'image' => '1765158696_69362f28048dc.png', 'is_thumbnail' => 1],
            ['product_id' => 24, 'image' => '1765158696_69362f280702a.png', 'is_thumbnail' => 0],
            ['product_id' => 24, 'image' => '1765158696_69362f280972c.png', 'is_thumbnail' => 0],
            
            // Product 25
            ['product_id' => 25, 'image' => '1765158920_693630083b45e.png', 'is_thumbnail' => 1],
            ['product_id' => 25, 'image' => '1765158920_693630083d468.png', 'is_thumbnail' => 0],
            
            // Product 26
            ['product_id' => 26, 'image' => '1765178973_new-balance-574v3-nimbus-cloud-white-wl574evw-side.jpg', 'is_thumbnail' => 1],
            ['product_id' => 26, 'image' => '1765178981_924ff2899a7944a3b6ce0af97d07ff51.jpg', 'is_thumbnail' => 0],
            
            // Product 27
            ['product_id' => 27, 'image' => '1765180178_ZapatillasAsicsGel-Challenger15PadelL.EFreshIceBlack_2.png', 'is_thumbnail' => 1],
        ];

        foreach ($productImages as $image) {
            ProductImage::create($image);
        }
    }
}