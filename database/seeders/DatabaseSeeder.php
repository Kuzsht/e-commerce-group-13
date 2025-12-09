<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            BuyerSeeder::class,
            StoreSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            ProductSizeSeeder::class,
            StoreBalanceSeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
            ProductReviewSeeder::class,
            WithdrawalSeeder::class,
            StoreBalanceHistorySeeder::class,
        ]);
    }
}