<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buyer;
use App\Models\User;

class BuyerSeeder extends Seeder
{
    public function run()
    {
        $buyers = [
            [
                'user_id' => 2,
                'profile_picture' => null,
                'phone_number' => null,
            ],
            [
                'user_id' => 3,
                'profile_picture' => null,
                'phone_number' => null,
            ],
            [
                'user_id' => 4,
                'profile_picture' => '1764774361_pp.jpg',
                'phone_number' => null,
            ],
            [
                'user_id' => 5,
                'profile_picture' => null,
                'phone_number' => null,
            ],
            [
                'user_id' => 6,
                'profile_picture' => null,
                'phone_number' => null,
            ],
            [
                'user_id' => 7,
                'profile_picture' => null,
                'phone_number' => null,
            ],
            [
                'user_id' => 8,
                'profile_picture' => null,
                'phone_number' => null,
            ],
            [
                'user_id' => 9,
                'profile_picture' => null,
                'phone_number' => null,
            ],
            [
                'user_id' => 10,
                'profile_picture' => null,
                'phone_number' => null,
            ],
            [
                'user_id' => 11,
                'profile_picture' => null,
                'phone_number' => null,
            ],
        ];

        foreach ($buyers as $buyer) {
            Buyer::create($buyer);
        }
    }
}