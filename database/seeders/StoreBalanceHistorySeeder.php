<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreBalanceHistory;

class StoreBalanceHistorySeeder extends Seeder
{
    public function run()
    {
        $histories = [
            [
                'store_balance_id' => 12,
                'type' => 'income',
                'reference_id' => '14',
                'reference_type' => 'transaction',
                'amount' => 365000.00,
                'remarks' => 'Income from order TRX-GYT1CCXJ',
            ],
            [
                'store_balance_id' => 12,
                'type' => 'withdraw',
                'reference_id' => '6',
                'reference_type' => 'withdrawal',
                'amount' => 50000.00,
                'remarks' => 'Withdrawal approved (ID: 6)',
            ],
            [
                'store_balance_id' => 18,
                'type' => 'income',
                'reference_id' => '15',
                'reference_type' => 'transaction',
                'amount' => 3513950.00,
                'remarks' => 'Income from order TRX-LS966NJT',
            ],
            [
                'store_balance_id' => 12,
                'type' => 'withdraw',
                'reference_id' => '7',
                'reference_type' => 'withdrawal',
                'amount' => 50000.00,
                'remarks' => 'Withdrawal approved (ID: 7)',
            ],
        ];

        foreach ($histories as $history) {
            StoreBalanceHistory::create($history);
        }
    }
}