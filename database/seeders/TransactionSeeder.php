<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $transactions = [
            [
                'code' => 'TRX-GYT1CCXJ',
                'buyer_id' => 3,
                'store_id' => 4,
                'address' => 'Jl. Soekarno Hatta',
                'address_id' => '7671a886-55f0-4393-a8b5-be575a91634f',
                'city' => 'Malang',
                'postal_code' => '65148',
                'shipping' => 'standard',
                'shipping_type' => 'same-day',
                'shipping_cost' => 50000.00,
                'tracking_number' => 'KSP-20251207-PJGVDW8R',
                'tax' => 15000.00,
                'grand_total' => 365000.00,
                'payment_status' => 'paid',
            ],
            [
                'code' => 'TRX-LS966NJT',
                'buyer_id' => 3,
                'store_id' => 5,
                'address' => 'Jl. Dinoyo',
                'address_id' => '5474706c-6d11-42a4-aa26-1b27f0b5c3cf',
                'city' => 'Malang',
                'postal_code' => '65148',
                'shipping' => 'standard',
                'shipping_type' => 'same-day',
                'shipping_cost' => 50000.00,
                'tracking_number' => 'KSP-20251208-PD6YNT6L',
                'tax' => 164950.00,
                'grand_total' => 3513950.00,
                'payment_status' => 'paid',
            ],
        ];

        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }
    }
}