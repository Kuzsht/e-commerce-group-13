<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductReview;

class ProductReviewSeeder extends Seeder
{
    public function run()
    {
        $reviews = [
            [
                'transaction_id' => 14,
                'product_id' => 10,
                'rating' => 5,
                'review' => 'kerenn',
            ],
            [
                'transaction_id' => 15,
                'product_id' => 16,
                'rating' => 1,
                'review' => 'elekk, penjuale cuek',
            ],
        ];

        foreach ($reviews as $review) {
            ProductReview::create($review);
        }
    }
}