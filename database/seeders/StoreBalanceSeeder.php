<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreBalance;

class StoreBalanceSeeder extends Seeder
{
    public function run()
    {
        $storeBalances = [
            ['store_id' => 4, 'balance' => 215000.00],
            ['store_id' => 5, 'balance' => 3513950.00],
            ['store_id' => 6, 'balance' => 0.00],
            ['store_id' => 7, 'balance' => 0.00],
            ['store_id' => 8, 'balance' => 0.00],
            ['store_id' => 9, 'balance' => 0.00],
            ['store_id' => 10, 'balance' => 0.00],
            ['store_id' => 11, 'balance' => 0.00],
        ];

        foreach ($storeBalances as $balance) {
            StoreBalance::create($balance);
        }
    }
}