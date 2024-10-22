<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CityTableSeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'khushab', 'country_id' => 131],
            ['name' => 'sargodha', 'country_id' => 131],
            ['name' => 'lahore', 'country_id' => 131],
            ['name' => 'islamabad', 'country_id' => 131],
            ['name' => 'quetta', 'country_id' => 131],
            ['name' => 'chennai', 'country_id' => 75],
            ['name' => 'kolkata', 'country_id' => 75],
            ['name' => 'delhi', 'country_id' => 75],
            ['name' => 'bengluru', 'country_id' => 75],
            ['name' => 'hyderabad', 'country_id' => 75],
        ];

        foreach ($cities as $city) {
            $city['created_at'] = Carbon::now();
            $city['updated_at'] = Carbon::now();
            DB::table('cities')->insert($city);
        }
    }
}
