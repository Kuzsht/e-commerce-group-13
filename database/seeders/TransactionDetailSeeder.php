<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionDetail;

class TransactionDetailSeeder extends Seeder
{
    public function run()
    {
        $transactionDetails = [
            [
                'transaction_id' => 14,
                'product_id' => 10,
                'qty' => 1,
                'size' => '40',
                'color' => 'White',
                'subtotal' => 300000.00,
            ],
            [
                'transaction_id' => 15,
                'product_id' => 16,
                'qty' => 1,
                'size' => '38',
                'color' => 'Mushroom',
                'subtotal' => 3299000.00,
            ],
        ];

        foreach ($transactionDetails as $detail) {
            TransactionDetail::create($detail);
        }
    }
}