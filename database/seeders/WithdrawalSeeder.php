<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Withdrawal;

class WithdrawalSeeder extends Seeder
{
    public function run()
    {
        $withdrawals = [
            [
                'store_balance_id' => 12,
                'amount' => 50000.00,
                'bank_account_name' => 'Raditya Kusuma Wardhana',
                'bank_account_number' => '321123456788765',
                'bank_name' => 'BRI',
                'status' => 'approved',
            ],
            [
                'store_balance_id' => 12,
                'amount' => 50000.00,
                'bank_account_name' => 'Raditya Kusuma Wardhana',
                'bank_account_number' => '321123456788765',
                'bank_name' => 'BRI',
                'status' => 'approved',
            ],
        ];

        foreach ($withdrawals as $withdrawal) {
            Withdrawal::create($withdrawal);
        }
    }
}