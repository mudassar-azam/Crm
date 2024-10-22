<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoosterSeeder extends Seeder
{
    public function run()
    {
        $roosters = [];
        $currentDate = Carbon::now();
        $types = ['present', 'absent'];

        for ($i = 2; $i <= 8; $i++) {
            $roosters[] = [
                'user_id'    => $i,
                'type'       => $types[array_rand($types)],
                'start_date' => $currentDate->subDays(rand(1, 10))->format('Y-m-d'),
                'end_date'   => $currentDate->addDays(rand(1, 10))->format('Y-m-d'),
                'override'   => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('roosters')->insert($roosters);
    }
}
