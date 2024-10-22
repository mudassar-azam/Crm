<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('leaves')->insert([
            [
                'type' => 'Sick Leave',
                'user_id' => 6,
                'duration' => '3 days',
                'start_date' => '2024-08-01',
                'end_date' => '2024-08-03',
                'status' => 'Pending',
                'comment' => 'Dil kar raha tha',
                'approved_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Vacation',
                'user_id' => 7,
                'duration' => '10 days',
                'start_date' => '2024-08-10',
                'end_date' => '2024-08-20',
                'status' => 'Pending',
                'comment' => 'Dil kar raha tha',
                'approved_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
