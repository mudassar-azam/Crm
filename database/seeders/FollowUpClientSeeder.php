<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FollowUpClient;

class FollowUpClientSeeder extends Seeder
{
    public function run(): void
    {
        FollowUpClient::insert([
            [
                'user_id' => 1,
                'worth' => '10000',
                'company_name' => 'company 1',
                'sport_areas' => 'Football',
                'status' => 'chase1',
                'company_hq' => 'New York',
                'type' => 'followup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'company_name' => 'company 2',
                'worth' => '20000',
                'sport_areas' => 'Basketball',
                'status' => 'chase2',
                'company_hq' => 'Los Angeles',
                'type' => 'followup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

