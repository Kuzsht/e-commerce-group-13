<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSize;

class ProductSizeSeeder extends Seeder
{
    public function run()
    {
        $productSizes = [
            // Product 10
            ['product_id' => 10, 'color' => 'Default', 'size' => '35', 'stock' => 10],
            ['product_id' => 10, 'color' => 'Default', 'size' => '40', 'stock' => 20],
            ['product_id' => 10, 'color' => 'White', 'size' => '40', 'stock' => 20],
            ['product_id' => 10, 'color' => 'White', 'size' => '41', 'stock' => 10],
            
            // Product 11
            ['product_id' => 11, 'color' => 'Default', 'size' => '36', 'stock' => 5],
            ['product_id' => 11, 'color' => 'Default', 'size' => '37', 'stock' => 5],
            ['product_id' => 11, 'color' => 'Default', 'size' => '38', 'stock' => 5],
            ['product_id' => 11, 'color' => 'Default', 'size' => '39', 'stock' => 20],
            ['product_id' => 11, 'color' => 'Default', 'size' => '40', 'stock' => 20],
            ['product_id' => 11, 'color' => 'Default', 'size' => '41', 'stock' => 10],
            ['product_id' => 11, 'color' => 'Default', 'size' => '42', 'stock' => 10],
            ['product_id' => 11, 'color' => 'White', 'size' => '38', 'stock' => 10],
            ['product_id' => 11, 'color' => 'White', 'size' => '39', 'stock' => 20],
            ['product_id' => 11, 'color' => 'White', 'size' => '40', 'stock' => 30],
            
            // Product 12
            ['product_id' => 12, 'color' => 'White', 'size' => '39', 'stock' => 10],
            ['product_id' => 12, 'color' => 'White', 'size' => '40', 'stock' => 20],
            ['product_id' => 12, 'color' => 'White', 'size' => '41', 'stock' => 20],
            ['product_id' => 12, 'color' => 'White', 'size' => '42', 'stock' => 30],
            ['product_id' => 12, 'color' => 'White', 'size' => '43', 'stock' => 30],
            ['product_id' => 12, 'color' => 'White', 'size' => '44', 'stock' => 10],
            
            // Product 13
            ['product_id' => 13, 'color' => 'Summit White', 'size' => '38', 'stock' => 10],
            ['product_id' => 13, 'color' => 'Summit White', 'size' => '39', 'stock' => 10],
            ['product_id' => 13, 'color' => 'Summit White', 'size' => '40', 'stock' => 15],
            ['product_id' => 13, 'color' => 'Summit White', 'size' => '41', 'stock' => 30],
            ['product_id' => 13, 'color' => 'Summit White', 'size' => '42', 'stock' => 30],
            ['product_id' => 13, 'color' => 'Summit White', 'size' => '43', 'stock' => 20],
            ['product_id' => 13, 'color' => 'Summit White', 'size' => '44', 'stock' => 30],
            ['product_id' => 13, 'color' => 'Summit White', 'size' => '45', 'stock' => 50],
            
            // Product 14
            ['product_id' => 14, 'color' => 'Blue Hero', 'size' => '39', 'stock' => 20],
            ['product_id' => 14, 'color' => 'Blue Hero', 'size' => '40', 'stock' => 30],
            ['product_id' => 14, 'color' => 'Blue Hero', 'size' => '41', 'stock' => 30],
            ['product_id' => 14, 'color' => 'Blue Hero', 'size' => '42', 'stock' => 20],
            ['product_id' => 14, 'color' => 'Blue Hero', 'size' => '43', 'stock' => 20],
            
            // Product 16
            ['product_id' => 16, 'color' => 'Mushroom', 'size' => '38', 'stock' => 9],
            ['product_id' => 16, 'color' => 'Mushroom', 'size' => '39', 'stock' => 20],
            ['product_id' => 16, 'color' => 'Mushroom', 'size' => '40', 'stock' => 20],
            ['product_id' => 16, 'color' => 'Mushroom', 'size' => '41', 'stock' => 30],
            ['product_id' => 16, 'color' => 'Mushroom', 'size' => '42', 'stock' => 30],
            ['product_id' => 16, 'color' => 'Mushroom', 'size' => '43', 'stock' => 20],
            ['product_id' => 16, 'color' => 'Mushroom', 'size' => '44', 'stock' => 20],
            
            // Product 17
            ['product_id' => 17, 'color' => 'Brown', 'size' => '39', 'stock' => 20],
            ['product_id' => 17, 'color' => 'Brown', 'size' => '40', 'stock' => 20],
            ['product_id' => 17, 'color' => 'Brown', 'size' => '41', 'stock' => 20],
            ['product_id' => 17, 'color' => 'Brown', 'size' => '42', 'stock' => 20],
            ['product_id' => 17, 'color' => 'Brown', 'size' => '43', 'stock' => 20],
            
            // Product 18
            ['product_id' => 18, 'color' => 'Black', 'size' => '38', 'stock' => 20],
            ['product_id' => 18, 'color' => 'Black', 'size' => '39', 'stock' => 20],
            ['product_id' => 18, 'color' => 'Black', 'size' => '40', 'stock' => 30],
            ['product_id' => 18, 'color' => 'Black', 'size' => '41', 'stock' => 30],
            ['product_id' => 18, 'color' => 'Black', 'size' => '42', 'stock' => 20],
            ['product_id' => 18, 'color' => 'Black', 'size' => '43', 'stock' => 30],
            
            // Product 19
            ['product_id' => 19, 'color' => 'Black', 'size' => '38', 'stock' => 20],
            ['product_id' => 19, 'color' => 'Black', 'size' => '39', 'stock' => 30],
            ['product_id' => 19, 'color' => 'Black', 'size' => '40', 'stock' => 20],
            ['product_id' => 19, 'color' => 'Black', 'size' => '41', 'stock' => 20],
            ['product_id' => 19, 'color' => 'Black', 'size' => '42', 'stock' => 10],
            ['product_id' => 19, 'color' => 'Black', 'size' => '43', 'stock' => 30],
            ['product_id' => 19, 'color' => 'Brown', 'size' => '39', 'stock' => 20],
            ['product_id' => 19, 'color' => 'Brown', 'size' => '40', 'stock' => 30],
            ['product_id' => 19, 'color' => 'Brown', 'size' => '41', 'stock' => 10],
            ['product_id' => 19, 'color' => 'Brown', 'size' => '42', 'stock' => 15],
            ['product_id' => 19, 'color' => 'Brown', 'size' => '43', 'stock' => 20],
            
            // Product 20
            ['product_id' => 20, 'color' => 'Cream', 'size' => '39', 'stock' => 10],
            ['product_id' => 20, 'color' => 'Cream', 'size' => '40', 'stock' => 20],
            ['product_id' => 20, 'color' => 'Cream', 'size' => '41', 'stock' => 20],
            ['product_id' => 20, 'color' => 'Cream', 'size' => '42', 'stock' => 30],
            ['product_id' => 20, 'color' => 'Cream', 'size' => '43', 'stock' => 20],
            ['product_id' => 20, 'color' => 'Cream', 'size' => '44', 'stock' => 10],
            ['product_id' => 20, 'color' => 'Cream', 'size' => '45', 'stock' => 20],
            ['product_id' => 20, 'color' => 'White', 'size' => '38', 'stock' => 20],
            ['product_id' => 20, 'color' => 'White', 'size' => '39', 'stock' => 30],
            ['product_id' => 20, 'color' => 'White', 'size' => '40', 'stock' => 20],
            ['product_id' => 20, 'color' => 'White', 'size' => '41', 'stock' => 30],
            ['product_id' => 20, 'color' => 'White', 'size' => '42', 'stock' => 10],
            ['product_id' => 20, 'color' => 'White Orange', 'size' => '38', 'stock' => 20],
            ['product_id' => 20, 'color' => 'White Orange', 'size' => '39', 'stock' => 10],
            ['product_id' => 20, 'color' => 'White Orange', 'size' => '40', 'stock' => 10],
            ['product_id' => 20, 'color' => 'White Orange', 'size' => '41', 'stock' => 20],
            ['product_id' => 20, 'color' => 'White Orange', 'size' => '42', 'stock' => 5],
            
            // Product 21
            ['product_id' => 21, 'color' => 'White', 'size' => '38', 'stock' => 20],
            ['product_id' => 21, 'color' => 'White', 'size' => '39', 'stock' => 10],
            ['product_id' => 21, 'color' => 'White', 'size' => '40', 'stock' => 10],
            ['product_id' => 21, 'color' => 'White', 'size' => '41', 'stock' => 10],
            ['product_id' => 21, 'color' => 'White', 'size' => '42', 'stock' => 5],
            ['product_id' => 21, 'color' => 'White', 'size' => '43', 'stock' => 30],
            ['product_id' => 21, 'color' => 'Orange', 'size' => '38', 'stock' => 5],
            ['product_id' => 21, 'color' => 'Orange', 'size' => '39', 'stock' => 20],
            ['product_id' => 21, 'color' => 'Orange', 'size' => '40', 'stock' => 20],
            ['product_id' => 21, 'color' => 'Orange', 'size' => '41', 'stock' => 30],
            ['product_id' => 21, 'color' => 'Orange', 'size' => '42', 'stock' => 30],
            
            // Product 22
            ['product_id' => 22, 'color' => 'Black', 'size' => '38', 'stock' => 5],
            ['product_id' => 22, 'color' => 'Black', 'size' => '39', 'stock' => 10],
            ['product_id' => 22, 'color' => 'Black', 'size' => '40', 'stock' => 20],
            ['product_id' => 22, 'color' => 'Black', 'size' => '41', 'stock' => 10],
            ['product_id' => 22, 'color' => 'Black', 'size' => '42', 'stock' => 5],
            ['product_id' => 22, 'color' => 'White', 'size' => '39', 'stock' => 5],
            ['product_id' => 22, 'color' => 'White', 'size' => '40', 'stock' => 20],
            ['product_id' => 22, 'color' => 'White', 'size' => '41', 'stock' => 10],
            ['product_id' => 22, 'color' => 'White', 'size' => '42', 'stock' => 20],
            ['product_id' => 22, 'color' => 'White', 'size' => '43', 'stock' => 10],
            
            // Product 24
            ['product_id' => 24, 'color' => 'Default', 'size' => '38', 'stock' => 5],
            ['product_id' => 24, 'color' => 'Default', 'size' => '39', 'stock' => 10],
            ['product_id' => 24, 'color' => 'Default', 'size' => '40', 'stock' => 30],
            ['product_id' => 24, 'color' => 'Default', 'size' => '41', 'stock' => 10],
            ['product_id' => 24, 'color' => 'Default', 'size' => '42', 'stock' => 20],
            ['product_id' => 24, 'color' => 'White', 'size' => '39', 'stock' => 5],
            ['product_id' => 24, 'color' => 'White', 'size' => '40', 'stock' => 10],
            ['product_id' => 24, 'color' => 'White', 'size' => '41', 'stock' => 20],
            ['product_id' => 24, 'color' => 'White', 'size' => '42', 'stock' => 5],
            ['product_id' => 24, 'color' => 'Red', 'size' => '40', 'stock' => 10],
            ['product_id' => 24, 'color' => 'Red', 'size' => '41', 'stock' => 20],
            ['product_id' => 24, 'color' => 'Red', 'size' => '42', 'stock' => 10],
            ['product_id' => 24, 'color' => 'Red', 'size' => '43', 'stock' => 5],
            
            // Product 25
            ['product_id' => 25, 'color' => 'Black', 'size' => '38', 'stock' => 20],
            ['product_id' => 25, 'color' => 'Black', 'size' => '39', 'stock' => 10],
            ['product_id' => 25, 'color' => 'Black', 'size' => '40', 'stock' => 5],
            ['product_id' => 25, 'color' => 'Black', 'size' => '41', 'stock' => 30],
            ['product_id' => 25, 'color' => 'Navy Blue', 'size' => '40', 'stock' => 10],
            ['product_id' => 25, 'color' => 'Navy Blue', 'size' => '41', 'stock' => 30],
            ['product_id' => 25, 'color' => 'Navy Blue', 'size' => '42', 'stock' => 5],
            
            // Product 26
            ['product_id' => 26, 'color' => 'White', 'size' => '37', 'stock' => 20],
            ['product_id' => 26, 'color' => 'White', 'size' => '38', 'stock' => 30],
            ['product_id' => 26, 'color' => 'White', 'size' => '39', 'stock' => 10],
            ['product_id' => 26, 'color' => 'White', 'size' => '40', 'stock' => 30],
            ['product_id' => 26, 'color' => 'White', 'size' => '41', 'stock' => 5],
            ['product_id' => 26, 'color' => 'White', 'size' => '42', 'stock' => 20],
            
            // Product 27
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '36', 'stock' => 5],
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '37', 'stock' => 5],
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '38', 'stock' => 5],
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '39', 'stock' => 5],
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '40', 'stock' => 5],
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '41', 'stock' => 5],
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '42', 'stock' => 5],
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '43', 'stock' => 5],
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '44', 'stock' => 5],
            ['product_id' => 27, 'color' => 'Limited Edition', 'size' => '45', 'stock' => 5],
        ];

        foreach ($productSizes as $size) {
            ProductSize::create($size);
        }
    }
}