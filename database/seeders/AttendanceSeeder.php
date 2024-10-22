<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $startDate = Carbon::create(2024, 9, 20); 
        $userId = 6; 
    
        for ($i = 0; $i < 9; $i++) {

            DB::table('attendances')->insert([
                'date' => $startDate->format('Y-m-d'),
                'in' => "12:00 AM",
                'in2' => 'N/A',
                'out' => "12:00 PM",
                'out2' => 'N/A',
                'worked_hours' => '12 hours',
                'break' => null,
                'arrived_early' => null,
                'arrived_late' => null,
                'left_late' => null,
                'left_early' => null,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            $startDate->addDay();
        }

        $startDate = Carbon::create(2024, 9, 20); 

        for ($i = 0; $i < 9; $i++) {

            if ($startDate->isSameDay(Carbon::create(2024, 9, 22))) {
                $startDate->addDay();
                continue;
            }

            DB::table('attendances')->insert([
                'date' => $startDate->format('Y-m-d'),
                'in' => "10:00 AM",
                'in2' => 'N/A',
                'out' => "10:00 PM",
                'out2' => 'N/A',
                'worked_hours' => '12 hours',
                'break' => null,
                'arrived_early' => null,
                'arrived_late' => null,
                'left_late' => null,
                'left_early' => null,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            $startDate->addDay();
        }
    }
}
